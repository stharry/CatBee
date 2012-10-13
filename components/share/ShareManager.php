<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/ShareFilter.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/FriendDealTemplate.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Customer.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Store.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/Reward.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/components/IShareManager.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/components/adapters/json/JsonFriendDealTemplateAdapter.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/share/email/EmailShareProvider.php");
include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/components/share/facebook/FacebookShareProvider.php");

class ShareManager implements IShareManager
{
    private $shareDao;
    private $storeDao;
    private $pageAdapter;

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

        $link = "http://".$_SERVER['HTTP_HOST']."/CatBee/api/deal/?".http_build_query($friendTemplateProps);

        return $link;

    }

    private function createMessage($share, $shareTemplate)
    {
//        $share->message = <<<EOF
//        <html>
//<body>
//<a href="http://127.0.0.1:8887/CatBee/api/deal/?action=friendDeal&context%5Bleader%5D%5Bemail%5D=regev147%40013.net&context%5Bfriend%5D%5Bemail%5D=spidernah%40gmail.com&context%5Breward%5D%5Bvalue%5D=10&context%5Breward%5D%5Bcode%5D=ABCD1234_10&context%5Breward%5D%5Btype%5D=coupon&context%5Bstore%5D%5BauthCode%5D=19FB6C0C-3943-44D0-A40F-3DC401CB3703">Click Here!!!</a>
//</body>
//</html>
//EOF;
//
//        return;

        $share->message = str_replace('[message]', $share->message, $shareTemplate->templatePage->context);
        $share->message = str_replace('[link]', $this->createShareLink($share), $share->message);
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
                return new FacebookShareProvider();
            default:
                die("Cannot find compatible share provider");
        }
    }

    function __construct($storeDao, $shareDao, $pageAdapter)
    {
        $this->storeDao = $storeDao;
        $this->shareDao = $shareDao;
        $this->pageAdapter = $pageAdapter;
    }

    public function share($share)
    {
        echo "share--------";
        var_dump($share);

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

    public function getContacts($customer)
    {

    }
}
