<?php

class ShareManager implements IShareManager
{
    private $shareDao;
    private $campaignDao;
    private $storeBranchDao;
    private $customerManager;
    private $shareAppDao;
    private $pageAdapter;
    private $dealShareDao;
    private $landingRewardDao;
    private $predefinedContexts;

    private function validateCustomer($customer)
    {
        try
        {
            $this->customerManager->validateCustomer($customer);
        }
        catch (Exception $e)
        {
            RestLogger::log('ERROR on customer validation', $e);
        }
    }

    private function loadShareTemplatePageContext($shareTemplate)
    {
        if (!$shareTemplate->templatePage->context)
        {
            $this->pageAdapter->loadPage($shareTemplate->templatePage);
        }

    }

    private function shortenLink($link)
    {
        $url = 'https://api-ssl.bitly.com/v3/shorten?' .
            'access_token=57973b2f6a137f2c5f0f4d1b852032c2d3993bcd&longUrl=' .
            urlencode($link);

        $response = RestUtils::SendAnyGetRequest($url);

        if ($response)
        {
            $responseParams = json_decode($response, true);
            if (isset($responseParams['data']['url']))
            {
                return $responseParams['data']['url'];
            }
        }

        return $link;
    }

    private function createShareLink($deal, $context)
    {
        //todo check branch url
        //todo ask store adapter to parameters set

        $url = $deal->campaign->landingUrl
            ? $deal->campaign->landingUrl
            : $deal->order->branch->adaptor->landingUrl;

        if ($context->application)
        {
            $link = $this->shortenLink($url . '?tribzisid=' . $context->uid);
        }
        else
        {
            $link = $url . '?tribzisid=' . $context->uid;
        }

        RestLogger::log('ShareManager create link', $link);

        return $link;

    }

    private function createTemplate($shareTemplate)
    {
        $templateAdapter = new JsonTemplateAdapter();

        $templateProps = $templateAdapter->fromArray(
            json_decode($shareTemplate->templatePage->context, true));

        return $templateProps;
    }

    private function getCompatibleTemplateDecorator($shareContext)
    {
        //todo: make something more solid (like a factory or something else...)
        switch ($shareContext->id)
        {
            case 1:
                return new HtmlTemplateDecorator();
            case 2:
                return new PlainTextTemplateDecorator();
            case 3:
                return new PlainTextTemplateDecorator();
            case 4:
                return new PlainTextTemplateDecorator();
            case 5:
                return new PlainTextTemplateDecorator();
            case 1024:
                return new HtmlTemplateDecorator();
            default:
                RestLogger::log('ERROR Cannot find compatible template decorator for ', $shareContext->id);
                die("Cannot find compatible share provider");
        }

    }

    private function createMessage($share, $shareTemplate)
    {

        try
        {
            RestLogger::log('Create message begin');
            $share->subject = $shareTemplate->message;

            if (isset($shareTemplate) &&
                isset($shareTemplate->templatePage->context) &&
                !empty($shareTemplate->templatePage->context)
            )
            {
                $template = $this->createTemplate($shareTemplate);

                $templateDecorator = $this->getCompatibleTemplateDecorator($share->currentTarget->context);

                $templateBuilder = new TemplateBuilder();

                $share->message = $templateBuilder->buildTemplate($share, $template, $templateDecorator);

                RestLogger::log('Create message end');
            }
            else
            {
                RestLogger::log('ERROR NO available template for message');
            }
        }
        catch (Exception $e)
        {
            RestLogger::log('ERROR ON message creation', $e);
        }

    }

    private function getCompatibleShareProvider($shareContext)
    {
        RestLogger::log("ShareManager::getCompatibleShareProvider ", $shareContext->type);
        //todo: make something more solid (like a factory or something else...)
        switch ($shareContext->id)
        {
            case 1:
                return new EmailShareProvider();
            case 2:
                return new FacebookShareProvider(new PdoAuthorizationDao());
            case 3:
                return new TwitterShareProvider();
            case 4:
                return new PinterestShareProvider();
            case 5:
                return new UrlShareProvider();
            case 1024:
                return new TribziShareProvider();
            default:
                RestLogger::log("ERROR: Cannot find compatible share provider", $shareContext->id);
                die("Cannot find compatible share provider");
        }
    }

    private function fillShareProps($share)
    {
        RestLogger::log("ShareManager::fillShareProps ", $share);
        $shareFilter = new ShareFilter();

        $shareFilter->campaign = $share->deal->campaign;
        $shareFilter->context  = $share->currentTarget->context;
        $shareFilter->targetId = $share->currentTarget->id;

        $shareTemplates = $this->getShareTemplates($shareFilter);

        $share->context->link = $this->createShareLink($share->deal, $share->context);

        //todo: put strategy class here
        if (count($shareTemplates) == 0)
        {
            RestLogger::log('ERROR', "There is no any share template for given store");
        }
        else
        {
            $this->createMessage($share, $shareTemplates[0]);
        }

        $this->validateCustomer($share->currentTarget->from);
        $this->validateCustomer($share->currentTarget->to);


        $this->landingRewardDao->fillLandingRewardById($share->reward);

        if (!$this->storeBranchDao->isStoreBranchExists($share->deal->order->branch))
        {
            RestLogger::log('fillShareProps ERROR: branch not exist');
        }

    }

    function __construct(
        $storeBranchDao, $shareDao, $customerManager,
        $shareAppDao, $dealShareDao,
        $landingRewardDao,
        $campaignDao,
        $pageAdapter)
    {
        $this->storeBranchDao   = $storeBranchDao;
        $this->shareDao         = $shareDao;
        $this->customerManager  = $customerManager;
        $this->shareAppDao      = $shareAppDao;
        $this->dealShareDao     = $dealShareDao;
        $this->landingRewardDao = $landingRewardDao;
        $this->campaignDao      = $campaignDao;
        $this->pageAdapter      = $pageAdapter;

        $this->predefinedContexts =
            array('email' => 1, 'facebook' => 2, 'tribzi' => 1024);

        RestLogger::log("Share manager created...");
    }

    public function share($share)
    {
        try
        {
            RestLogger::log('ShareManager::share begin for targets', $share->targets);

            foreach ($share->targets as $target)
            {
                $shareToFriends = $target->to;
                RestLogger::log('ShareManager::share begin for single target', $target);

                foreach ($shareToFriends as $friend)
                {
                    RestLogger::log('ShareManager::share for single friend', $friend);

                    $share->currentTarget          = new ShareTarget($target->name);
                    $share->currentTarget->from    = $target->from;
                    $share->currentTarget->to      = $friend;
                    $share->currentTarget->context = $target->context;

                    $this->fillShareProps($share);

                    $shareProvider = $this->getCompatibleShareProvider($target->context);

                    $shareProvider->share($share);

                    RestLogger::log('ShareManager::sendTo Ok');
                }
            }

            return true;
        }
        catch (Exception $e)
        {
            RestLogger::log('ERROR: ', $e->getMessage());

            return false;
        }
    }

    public function setShareTemplate($shareTemplate)
    {
        if (!$this->campaignDao->isCampaignExists($shareTemplate->campaign))
        {
            RestLogger::log('ERROR: Campaign does not exist ', $shareTemplate->campaign);
            die('Campaign does not exist');
        }
        else
        {
            RestLogger::log('Share template campaign ', $shareTemplate->campaign);
        }

        $this->loadShareTemplatePageContext($shareTemplate);

        $this->shareDao->insertOrUpdateShareTemplate($shareTemplate);
    }

    public function getShareTemplates($shareFilter)
    {
        RestLogger::log('get Share Templates', $shareFilter);

        return $this->shareDao->getShareTemplates($shareFilter);
    }

    public function getContacts($shareNode)
    {
        $this->validateCustomer($shareNode->leader);

        $shareProvider = $this->getCompatibleShareProvider($shareNode->context);

        $shareNode->friends = $shareProvider->getContacts($shareNode->leader);
    }

    public function requiresAuthentication($shareNode)
    {
        $this->validateCustomer($shareNode->leader);

        $shareProvider = $this->getCompatibleShareProvider($shareNode->context);

        $result = $shareProvider->requiresAuthentication($shareNode);

        RestLogger::log("ShareManager::requiresAuthentication " . $result);

        return $result;
    }

    public function getAuthenticationUrl($shareNode, $params)
    {
        $this->validateCustomer($shareNode->leader);

        $shareProvider = $this->getCompatibleShareProvider($shareNode->context);

        $result = $shareProvider->getAuthenticationUrl($shareNode, $params);

        RestLogger::log("ShareManager::getAuthenticationUrl " . $result);

        return $result;
    }

    public function fillShare($share)
    {
        RestLogger::log('ShareManager::fillshare begin', $share->deal->order->branch);
        if (!$this->storeBranchDao->isStoreBranchExists($share->deal->order->branch))
        {
            RestLogger::log('Error: share template store branch does not exists');
            die ("share template store branch does not exists");
        }

        $this->fillShareProps($share);

        $this->getCompatibleShareApplication($share);

        RestLogger::log('ShareManager::fillshare end');

    }

    public function getCurrentSharedCustomer($context)
    {
        $shareProvider = $this->getCompatibleShareProvider($context);

        return $shareProvider->getCurrentSharedCustomer();
    }

    public function addShareApplication($context)
    {
        $context->application->authorizationUrl =
            CatBeeExpressions::validateString($context->application->authorizationUrl);
        $context->application->redirectUrl      =
            CatBeeExpressions::validateString($context->application->redirectUrl);

        $this->shareAppDao->setApplication($context);
    }

    private function setCompatibleShareApplication($context)
    {
        $context->application =
            $this->shareAppDao->getApplication($context);

    }

    public function fillShareContext($deal, $context)
    {
        $this->setCompatibleShareApplication($context);

        $shareFilter = new ShareFilter();

        $shareFilter->campaign = $deal->campaign;
        $shareFilter->context  = $context;

        $target                = new ShareTarget('friend');
        $shareFilter->targetId = $target->id;

        $shareTemplates = $this->getShareTemplates($shareFilter);

        //todo: put strategy class here
        if (count($shareTemplates) == 0)
        {
            RestLogger::log("WARNING!. There is no any share template for given store");
        }
        else
        {

            $shareTemplate          = $shareTemplates[0];
            $context->message       = $shareTemplate->message;
            $context->customMessage = $shareTemplate->customMessage;
        }
        $context->link = $this->createShareLink($deal, $context);
    }

    public function addDealShare($share)
    {
        $recipients = array();

        foreach ($share->targets as $target)
        {
            foreach ($target->to as $to)
            {
                array_push($recipients, $to);
            }
        }

        $share->currentTarget     = new ShareTarget();
        $share->currentTarget->to = $recipients;

        $this->dealShareDao->addDealShare($share);
    }

    public function updateDealShare($share)
    {
        $this->dealShareDao->updateDealShare($share);
    }

    public function FillActiveSharesForDeal($deals, $FillLeadData)
    {
        //Go to PDODealShareDao and retrive the ActiveShare according to DealID
        $this->dealShareDao->GetDealsShares($deals, $FillLeadData);

    }
}
