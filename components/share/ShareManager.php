<?php

class ShareManager implements IShareManager
{
    private $shareDao;
    private $storeDao;
    private $customerDao;
    private $shareAppDao;
    private $pageAdapter;
    private $dealShareDao;
    private $predefinedContexts;

    private function validateCustomer($customer)
    {
        if ($customer->id > 0)
        {
            return;
        }
        if (!$this->customerDao->isCustomerExists($customer))
        {
            $this->customerDao->insertCustomer($customer);
        }
    }

    private function loadShareTemplatePageContext($shareTemplate)
    {
        $this->pageAdapter->loadPage($shareTemplate->templatePage);

    }

    private function createShareLink($share)
    {
        //todo check branch url
        //todo ask store adapter to parameters set
        $link = $share->store->url . '?ctx=' . $share->context->type
            . '&act=welcome&sid=' . $share->id;

        return $link;

    }

    private function createMessage($share, $shareTemplate)
    {
        $share->link = $this->createShareLink($share);

        $share->message = str_replace('[message]', $share->message, $shareTemplate->templatePage->context);
        $share->message = str_replace('[link]', $share->link, $share->message);
        $share->message = str_replace('[reward.value]', $share->reward->value, $share->message);
        $share->message = str_replace('[reward.type]', $share->reward->type, $share->message);
        $share->message = str_replace('[reward.typeDescription]', $share->reward->typeDescription, $share->message);

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

        if (!$this->storeDao->loadStore($share->store))
        {
            RestLogger::log("share template store does not exists ", $share->store);
            die ("share template store does not exists");
        }

        $shareFilter = new ShareFilter();
        $shareFilter->store = $share->store;
        $shareFilter->campaign = $share->campaign;
        $shareFilter->context = $share->context;

        $shareTemplates = $this->getShareTemplates($shareFilter);

        //todo: put strategy class here
        if (count($shareTemplates) == 0) die ("There is no any share template for given store");

        $this->createMessage($share, $shareTemplates[ 0 ]);

    }

    function __construct(
        $storeDao, $shareDao, $customerDao,
        $shareAppDao, $dealShareDao,
        $pageAdapter)
    {
        $this->storeDao = $storeDao;
        $this->shareDao = $shareDao;
        $this->customerDao = $customerDao;
        $this->shareAppDao = $shareAppDao;
        $this->dealShareDao = $dealShareDao;
        $this->pageAdapter = $pageAdapter;

        $this->predefinedContexts =
            array('email' => 1, 'facebook' => 2, 'tribzi' => 1024);
    }

    public function share($share)
    {
        $this->fillShareProps($share);

        $shareProvider = $this->getCompatibleShareProvider($share->context);

        return $shareProvider->share($share);
    }

    public function setShareTemplate($shareTemplate)
    {
        if (!$this->storeDao->isStoreExists($shareTemplate->store))
        {
            die ("share template store does not exists");
        }

        //todo: think about campaign share template
        $shareTemplate->campaign->id = -1;

        $this->loadShareTemplatePageContext($shareTemplate);

        $this->shareDao->insertShareTemplate($shareTemplate);
    }

    public function getShareTemplates($shareFilter)
    {
        if (!$this->storeDao->isStoreExists($shareFilter->store))
        {
            die ("share template store does not exists");
        }

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
        RestLogger::log('ShareManager::fillshare begin');
        if (!$this->storeDao->loadStore($share->store))
        {
            RestLogger::log('Error: share template store does not exists');
            die ("share template store does not exists");
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
        $context->application->redirectUrl =
            CatBeeExpressions::validateString($context->application->redirectUrl);

        $this->shareAppDao->setApplication($context);
    }

    private function getCompatibleShareApplication($share)
    {
        $share->context->application =
            $this->shareAppDao->getApplication($share->context);

        if ($share->context->application)
        {
            $url = $share->context->application->redirectUrl;
            $parDelim = strpos($url, '?') === true ? '&' : '?';
            $url = $url . $parDelim . 'sid=' . $share->id;

            $share->context->application->redirectUrl = $url;
        }
    }

    public function getAvailableShares($deal)
    {
        $shares = array();

        foreach ($this->predefinedContexts as $type => $id)
        {
            $share = new Share();
            $share->campaign = $deal->campaign;
            $share->store = $deal->order->store;
            $share->deal = $deal;

            $context = new ShareContext();
            $context->id = $id;
            $context->type = $type;
            $context->application = $this->shareAppDao->getApplication($context);

            $share->context = $context;

            $this->fillShareProps($share);

            $share->message = htmlentities($share->message);

            array_push($shares, $share);

            $share->campaign = null;
            $share->store = null;
            $share->deal = null;

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
}
