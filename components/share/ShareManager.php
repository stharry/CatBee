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
        $this->customerManager->validateCustomer($customer);
    }

    private function loadShareTemplatePageContext($shareTemplate)
    {
        if (!$shareTemplate->templatePage->context)
        {
            $this->pageAdapter->loadPage($shareTemplate->templatePage);
        }

    }

    private function createShareLink($share)
    {
        //todo check branch url
        //todo ask store adapter to parameters set

        $url  = $share->deal->campaign->landingUrl
            ? $share->deal->campaign->landingUrl
            : $share->deal->order->branch->adaptor->landingUrl;

        $link = $url . '?ctx=' . $share->context->type
            . '&act=welcome&sid=' . $share->id;

        return $link;

    }

    private function createTemplate($shareTemplate)
    {
        $templateAdapter = new JsonTemplateAdapter();

        return $templateAdapter->fromArray(
            json_decode($shareTemplate->templatePage->context, true));
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
            case 1024:
                return new HtmlTemplateDecorator();
            default:
                die("Cannot find compatible share provider");
        }

    }

    private function createMessage($share, $shareTemplate)
    {
        $share->link = $this->createShareLink($share);

        $template = $this->createTemplate($shareTemplate);

        $templateDecorator = $this->getCompatibleTemplateDecorator($share->context);

        $templateBuilder = new TemplateBuilder();

        $share->message = $templateBuilder->buildTemplate($share, $template, $templateDecorator);
        $share->subject = $shareTemplate->message;
    }

    private function getCompatibleShareProvider($shareContext)
    {
        //todo: make something more solid (like a factory or something else...)
        switch ($shareContext->id)
        {
            case 1:
                return new EmailShareProvider();
            case 2:
                return new FacebookShareProvider(new PdoAuthorizationDao());
            case 1024:
                return new TribziShareProvider();
            default:
                die("Cannot find compatible share provider");
        }
    }

    private function fillShareProps($share)
    {
        RestLogger::log("ShareManager::fillShareProps ", $share);
        $shareFilter = new ShareFilter();

        RestLogger::log("ShareManager::fillShareProps campaign ", $share->deal->campaign);

        $shareFilter->campaign = $share->deal->campaign;
        $shareFilter->context  = $share->context;
        $shareFilter->targetId = $share->target->id;

        $shareTemplates = $this->getShareTemplates($shareFilter);

        //todo: put strategy class here
        if (count($shareTemplates) == 0) die ("There is no any share template for given store");
        $this->createMessage($share, $shareTemplates[ 0 ]);

        $this->validateCustomer($share->sendFrom);
        $this->validateCustomer($share->sendTo);

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
            $shareProvider = $this->getCompatibleShareProvider($share->context);

            $shareToFriends = $share->sendTo;

            foreach ($shareToFriends as $friend)
            {
                RestLogger::log('ShareManager::sendTo ', $friend);
                RestLogger::log('ShareManager::sendFrom ', $share->sendFrom);

                $share->sendTo = $friend;

                $this->fillShareProps($share);

                $shareProvider->share($share);

                RestLogger::log('ShareManager::sendTo Ok');
            }
            $share->sendTo = $shareToFriends;

            return true;
        } catch (Exception $e)
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

    private function getCompatibleShareApplication($share)
    {
        $share->context->application =
            $this->shareAppDao->getApplication($share->context);

        if ($share->context->application)
        {
            $url      = $share->context->application->redirectUrl;
            $parDelim = strpos($url, '?') === true ? '&' : '?';
            $url      = $url . $parDelim . 'sid=' . $share->id;

            $share->context->application->redirectUrl = $url;
        }
    }

    public function getAvailableShares($deal)
    {
        $shares = array();

        foreach ($this->predefinedContexts as $type => $id)
        {
            $share           = new Share();
            $share->campaign = $deal->campaign;
            $share->deal     = $deal;

            $context              = new ShareContext();
            $context->id          = $id;
            $context->type        = $type;
            $context->application = $this->shareAppDao->getApplication($context);

            $share->context = $context;

            $this->fillShareProps($share);

            $share->message = htmlentities($share->message);

            array_push($shares, $share);

            $share->campaign = null;
            $share->store    = null;
            $share->deal     = null;

        }

        return $shares;
    }

    public function addDealShare($share)
    {
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
