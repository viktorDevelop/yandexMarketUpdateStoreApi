<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
CModule::IncludeModule("iblock");

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/iblock/prolog.php");

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

if (isset($_REQUEST["CUR_LOAD_SESS_ID"]) && strlen($_REQUEST["CUR_LOAD_SESS_ID"]) > 0)
    $CUR_LOAD_SESS_ID = $_REQUEST["CUR_LOAD_SESS_ID"];
else
    $CUR_LOAD_SESS_ID = "CL" . time();

use \Itg\YmStocks\UpdateStock;
CModule::IncludeModule("itg.ymstocks");

$UpdateStocks = new UpdateStock();

// echo $UpdateStocks->test();

$APPLICATION->SetTitle('передача остатков яндекс маркет');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

        $arBrandId =  ($_POST['brend_id']) ? $_POST['brend_id'] : unserialize( \COption::GetOptionString('itg.ymstocks','brend_id'));
         $campaign_id =  \COption::GetOptionString('itg.ymstocks','campaign_id');
         $warehouse_id =  \COption::GetOptionString('itg.ymstocks','warehouse_id');
         $client_id =  \COption::GetOptionString('itg.ymstocks','client_id');
         $store_id =  \COption::GetOptionString('itg.ymstocks','store_id');
         $token =  \COption::GetOptionString('itg.ymstocks','token');



?>
<?
// echo "<pre>";
 $rsStoreProduct = \Bitrix\Catalog\StoreTable::getList(array(
                'filter' => array(),           
                'select' => array('TITLE','ID'),
                // 'limit'=>200,
                'count_total'=>true

            ))->fetchAll();

        foreach ($rsStoreProduct as $key => $item) {
            
            foreach ($arBrandId as $k => $item_selected) {
                if ($item_selected == $item['ID']) {
                    // code...
                     $rsStoreProduct[$key]['SELECTED'] = 'Y';
                }
            }
        }

                     // print_r($rsStoreProduct);  
    

?>
     
 
    <form method="POST" action="<? echo($APPLICATION->GetCurPage()); ?>?lang=<? echo(LANG); ?>&mid=<? echo($module_id)?>"
          ENCTYPE="multipart/form-data" name="dataload" id="dataload">
        <?
        $aTabs = [
            [
                "DIV" => "editSections",
                "TAB" => 'обновить остатки',
                "ICON" => "iblock",
                "TITLE" => 'настройки',
                
            ],
 
        ];

        $tabControl = new CAdminTabControl("tabControl", $aTabs, false, true);
        $tabControl->Begin();
        $tabControl->BeginNextTab();

        ?>
            
            <div style="display: flex; justify-content: center;">
                <div class="wrap-options" style="display:flex; flex-direction: column; ">
                    
                    <div style="width: 325px; display:flex; margin-bottom:10px ;">
                        
                        <input type="checkbox" name="save_from_yandex_market" >
                        <label> получить окен из настроек модуля яндекс  маркет</label>
                    </div>
                   <div style="width: 325px; display:flex; margin-bottom:10px ;">
                        <input style="width:100%" type="text" placeholder="Идентификатор приложения" name="client_id" id="">
                    </div>
                    <div style="display:flex; width: 325px; margin-bottom:10px ;">
                        <input style="width:100%"  type="text" placeholder="OAuth-токен приложения" name="token" id="">
                    </div>
                    <div style="display:flex; margin-bottom:10px ; width: 325px;">
                        <input style="width:100%"  type="text" placeholder="Идентификатор кампании" name="campaign_id" id="">
                    </div>
                    <div style="display:flex; margin-bottom:10px ; width: 325px;">
                        <input type="text" placeholder="Идентификатор склада" name="warehouse_id" id="" style="width:100%" >
                    </div>
                    <div style="display:flex; flex-direction: column; margin-bottom:10px ; width: 325px;" >
                        <label>Склад</label>
                        <select name="store_id" id="store_id" style="width:100%" >
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>

                    <div style="flex-direction: column; display:flex; margin-bottom:10px ;width: 325px;">
                         <label>Бренд</label>
                         <select name="brend_id[]" id="brend_id" multiple style="width:100%" >

                            <?foreach($rsStoreProduct as $key => $item):?>
                                 
                                <option 
                                <?if($item['SELECTED'] == 'Y'){echo 'selected';}?>
                                

                                 value="<?=$item['ID']?>"><?=$item['TITLE']?></option>
 
                            <?endforeach?>

                        </select>
                    </div>
                </div>
            </div>
            
             

        <?$tabControl->Buttons();?>
                
        <input type="submit" name="save_option" value="Сохранить" class="adm-btn-save">
        <input type="submit" name="update_store" value="обновить вручную" class="adm-btn-save">


         <?$tabControl->End();?>

           
    </form>
<?
    
//  $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>58, "CODE"=>"PROIZVODITEL"));
// while($enum_fields = $property_enums->GetNext())
// {
//   echo $enum_fields["ID"]." - ".$enum_fields["VALUE"]."<br>";
// }
// echo "<pre>";

// print_r($_POST);
if ($_POST['save_option']) {

    COption::SetOptionString("itg.ymstocks","client_id",$_POST['client_id']);
    COption::SetOptionString("itg.ymstocks","token",$_POST['token']);
    COption::SetOptionString("itg.ymstocks","campaign_id",$_POST['campaign_id']);
    COption::SetOptionString("itg.ymstocks","warehouse_id",$_POST['warehouse_id']);
    COption::SetOptionString("itg.ymstocks","store_id",$_POST['store_id']);
    COption::SetOptionString("itg.ymstocks","brend_id",serialize($_POST['brend_id']));

    $arBrandId = $_POST['brend_id'];
}




if ($_POST['update_store']) {
    // code...

    // $UpdateStocks = \Itg\YmStocks\UpdateStocks();

    // $UpdateStocks->test();
}


?>
 
<?require($DOCUMENT_ROOT . "/bitrix/modules/main/include/epilog_admin.php");

