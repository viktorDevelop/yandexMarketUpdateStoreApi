<?php
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\EventManager;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Config\Option;


Loc::loadMessages(__FILE__);

class itg_ymStocks extends CModule
{
    public $MODULE_ID = 'itg.ymstocks';

    public function __construct()
    {
        $arModuleVersion = array();

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        $MODULE_ID = 'itg.ymstocks';
        $this->MODULE_ID = 'itg.ymstocks';
        $this->MODULE_NAME = 'обновление остатков яндекс маркет';
        $this->MODULE_DESCRIPTION = 'обновление остатков яндекс маркет по api';
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = 'itgrade';
        $this->PARTNER_URI = '';
    }

    public function InstallFiles()
    {

         
        CopyDirFiles(
            __DIR__."/admin",
            Application::getDocumentRoot()."/bitrix/admin/".$this->MODULE_ID."/",
            true,
            true
        );

        return false;
    }

    // Событие отрисовки
    public function InstallEvents()
    {


        return false;
    }

    public function doInstall()
    {
        if (CheckVersion(ModuleManager::getVersion("main"), "14.00.00")) {

            ModuleManager::registerModule($this->MODULE_ID);
            $this->InstallFiles();
            $this->installDB();
            $this->InstallEvents();
        } else {

            $APPLICATION->ThrowException(
                'ишибка при удалении'
            );
        }

    }

    public function doUninstall()
    {
        $this->uninstallDB();
        ModuleManager::unRegisterModule($this->MODULE_ID);

            COption::RemoveOption($this->MODULE_ID,"client_id");
            COption::RemoveOption($this->MODULE_ID,"token");
            COption::RemoveOption($this->MODULE_ID,"campaign_id");
            COption::RemoveOption($this->MODULE_ID,"warehouse_id");
            COption::RemoveOption($this->MODULE_ID,"store_id");
            COption::RemoveOption($this->MODULE_ID,"brend_id");

    }

    public function installDB()
    {
        // if (Loader::includeModule($this->MODULE_ID)){

        //     if (!MarkUpTable::getEntity()->getConnection()->isTableExists(MarkUpTable::getTableName())) {
        //         MarkUpTable::getEntity()->createDbTable();
        //     }

        // }

        return false;
    }

    public function uninstallDB()
    {
         // if (Loader::includeModule($this->MODULE_ID))
         // {
         //     $connection = Application::getInstance()->getConnection();
         //     if ($connection->isTableExists(MarkUpTable::getTableName())){

         //         $connection->dropTable(MarkUpTable::getTableName());
         //     }
         // }


        return false;
    }

    public function UnInstallFiles()
    {

       Directory::deleteDirectory(
           Application::getDocumentRoot() . "/bitrix/admin/" . $this->MODULE_ID
       );

 
        return false;
    }

    public function UnInstallEvents()
    {

        // EventManager::getInstance()->unRegisterEventHandler(
        // 	"main",
        // 	"OnBeforeEndBufferContent",
        // 	$this->MODULE_ID,
        // 	"itgrade.yandexmarkup\Main",
        // 	"appendScriptsToPage"
        // );

        return false;
    }
}
