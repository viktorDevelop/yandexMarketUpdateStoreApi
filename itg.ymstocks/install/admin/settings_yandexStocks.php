<?php
//$_SERVER["DOCUMENT_ROOT"] = __DIR__ . '/../..';
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
CModule::IncludeModule("iblock");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/iblock/prolog.php");

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

if (isset($_REQUEST["CUR_LOAD_SESS_ID"]) && strlen($_REQUEST["CUR_LOAD_SESS_ID"]) > 0)
    $CUR_LOAD_SESS_ID = $_REQUEST["CUR_LOAD_SESS_ID"];
else
    $CUR_LOAD_SESS_ID = "CL" . time();

 
$APPLICATION->SetTitle('передача остатков яндекс маркет');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");
?>
    <div id="tbl_iblock_extra_result_div">
        <?
        if($_POST['save_option']){

        }
             
        
        ?>
    </div>
 
    <form method="POST" action="<? echo($APPLICATION->GetCurPage()); ?>?mid=<? echo($module_id); ?>&lang=<? echo(LANG); ?>"
          ENCTYPE="multipart/form-data" name="dataload" id="dataload">
        <?
        $aTabs = [
            [
                "DIV" => "editSections",
                "TAB" => 'настройки',
                "ICON" => "iblock",
                "TITLE" => 'настройки',
                
            ],
 
        ];

        $tabControl = new CAdminTabControl("tabControl", $aTabs, false, true);
        $tabControl->Begin();
        $tabControl->BeginNextTab();

        ?>
            

            
             

    <?$tabControl->Buttons();?>
            
         <input type="submit" name="save_option" value="Сохранить" class="adm-btn-save">

                   
                
                <?$tabControl->End();?>
           
    </form>
<?
echo "<pre>";
print_r($_POST);
if ($_POST['save_option']) {

    // COption::SetOptionString("itg.ymStocks","iblock_id",$_POST['iblock_id']);
    // COption::SetOptionString("itg.ymStocks","price_id",$_POST['price_id']);
    // COption::SetOptionString("itg.ymStocks","token",$_POST['token']);
}
?>
 
<?require($DOCUMENT_ROOT . "/bitrix/modules/main/include/epilog_admin.php");

