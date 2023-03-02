<?php
AddEventHandler("main", "OnBuildGlobalMenu", "ymstocksMenu");

function ymstocksMenu(&$arGlobalMenu, &$arModuleMenu)
{
    
    $moduleName = "itg.ymstocks";

    global $APPLICATION;
    if($GLOBALS['APPLICATION']->GetGroupRight($moduleID) >= 'R'){

        $arMenu = array(
                'menu_id' => 'global_menu_ymstocks',
                 'text' => 'обновление остатков по api',
                'title' => 'обновление остатков по api',
                'sort' => 5000,
                'items_id' => 'global_menu_ymstocks_items',
                'icon' => 'imi_next',
                'items' => array(
                    array(
                         
                        'sort' => 10,                         
                        'items_id' => 'control_center',
                        'text' => 'обновление остатков вручную',
                        "url" => "/bitrix/admin/settings.php?lang=".LANGUAGE_ID."&mid=".$moduleName,
                        'title' => 'Наценки прайс листа'
                    ),
                    array(
                         'sort' => 20,  
                        'text' => 'настройки',
                        "url" => "/bitrix/admin/".$moduleName."/settings_yandexStocks.php",
                        'title' => 'настройки'
                    ),
                )
            );

        if(!isset($arGlobalMenu['global_menu_ymstocks'])){
                $arGlobalMenu['global_menu_ymstocks'] = array(
                    'menu_id' => 'global_menu_ymstocks',
                    'text' => "Остатки яндекс маркет",
                    'title' => 'Остатки яндекс маркет',
                    'sort' => 5000,
                    'items_id' => 'global_menu_ymstocks_items',
                );
            }

            $arGlobalMenu['global_menu_ymstocks']['items'][$moduleID] = $arMenu;
    }

}

