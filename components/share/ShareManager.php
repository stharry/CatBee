<?php

include_once($_SERVER['DOCUMENT_ROOT']."/CatBee/model/ShareFilter.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/model/components/IShareManager.php");
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

    private function createMessage($share, $shareTemplate)
    {
        $share->message = str_replace('[Message]', $share->message, $shareTemplate->templatePage->context);
    }

    private function getCompatibleShareProvider($shareContext)
    {
        //todo: make something more solid (like a factory or something else...)
        switch ($shareContext->id)
        {
            case 1:
                return new EmailShareProvider();
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

        $shareProvider->share($share);
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
}
