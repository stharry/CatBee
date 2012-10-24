<?php

includeModel('ShareFilter');
includeModel('FriendDealTemplate');
includeModel('Customer');
includeModel('Store');
includeModel('Reward');
includeModel('components/IShareManager');

IncludeComponent('adapters/json', 'JsonFriendDealTemplateAdapter');
IncludeComponent('share/email', 'EmailShareProvider');
IncludeComponent('share/facebook', 'FacebookShareProvider');
IncludeComponent('dao/PDO', 'PdoAuthorizationDao');
IncludeComponent('rest', 'RestLogger');


class ShareManager implements IShareManager
{
    private $shareDao;
    private $storeDao;
    private $customerDao;
    private $pageAdapter;

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
        $friendDealTemplate = new FriendDealTemplate();
        $friendDealTemplate->friend = new Customer();
        $friendDealTemplate->friend->email = $share->sendTo;

        $friendDealTemplate->leader = new Customer();
        $friendDealTemplate->leader->email = $share->sendFrom;

        $friendDealTemplate->store = new Store();
        $friendDealTemplate->store->authCode = $share->store->authCode;

        $friendDealTemplate->reward = new Reward();
        $friendDealTemplate->reward->code = $share->reward->code;
        $friendDealTemplate->reward->value = $share->reward->value;
        $friendDealTemplate->reward->type = $share->reward->type;

        $friendDealTemplateAdapter = new JsonFriendDealTemplateAdapter();

        $friendTemplateProps = array("action" =>"friendDeal",
            "context" =>$friendDealTemplateAdapter->toArray($friendDealTemplate));

        $link = $GLOBALS["restURL"].'/CatBee/api/deal/?'.http_build_query($friendTemplateProps);

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
            default:
                die("Cannot find compatible share provider");
        }
    }

    function __construct($storeDao, $shareDao, $customerDao, $pageAdapter)
    {
        $this->storeDao = $storeDao;
        $this->shareDao = $shareDao;
        $this->customerDao = $customerDao;
        $this->pageAdapter = $pageAdapter;
    }

    public function share($share)
    {
        $this->fillShare($share);

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

        RestLogger::log("ShareManager::requiresAuthentication ".$result);

        return $result;
    }

    public function getAuthenticationUrl($shareNode, $params)
    {
        $this->validateCustomer($shareNode->leader);

        $shareProvider = $this->getCompatibleShareProvider($shareNode->context);

        $result = $shareProvider->getAuthenticationUrl($shareNode, $params);

        RestLogger::log("ShareManager::getAuthenticationUrl ".$result);

        return $result;
    }

    public function fillShare($share)
    {
        RestLogger::log("ShareManager::share ", $share);

        if (!$this->storeDao->isStoreExists($share->store))
        {
            die ("share template store does not exists");
        }

        $shareFilter = new ShareFilter();
        $shareFilter->store = $share->store;
        $shareFilter->campaign = $share->campaign;

        $shareTemplates = $this->getShareTemplates($shareFilter);

        //todo: put strategy class here
        if (count($shareTemplates) == 0) die ("There is no any share template for given store");

        $this->createMessage($share, $shareTemplates[0]);
    }

    public function getCurrentSharedCustomer($context)
    {
        $shareProvider = $this->getCompatibleShareProvider($context);

        return $shareProvider->getCurrentSharedCustomer();
    }
}
