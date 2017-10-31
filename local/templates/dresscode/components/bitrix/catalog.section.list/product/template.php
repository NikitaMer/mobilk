<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

	$this->setFrameMode(true);

	foreach($arResult["SECTIONS"] as $arElement){
        
		if($arElement["DEPTH_LEVEL"] == 2 && in_array($arElement["ID"], $arParams["FILTER"])){
			$result[] = array(
                "ID" => $arElement["ID"],
				"NAME" => $arElement["NAME"],
				"SECTION_PAGE_URL" => $arElement["SECTION_PAGE_URL"],
				"PICTURE" => CFile::ResizeImageGet($arElement["PICTURE"], array("width" => 25, "height" => 20), BX_RESIZE_IMAGE_PROPORTIONAL, false)
			);
		}
	}
    
	?>

    <div class="tabs_el">
        <?
        foreach($result as $key=>$nextElement){
        ?>
            <div class="tab-link" data-tab="tab-<?=$key?>"><span><?=$nextElement["NAME"]?></span></div>
        <?
        }
        ?>
    </div>
    <?
    foreach($result as $key=>$nextElement){
    ?>
    <div id="tab-<?=$key?>" class="tab-content">
        <?$APPLICATION->IncludeComponent(
            "dresscode:offers.product", 
            ".default", 
            array(
                "CACHE_TYPE" => "Y",
                "CACHE_TIME" => "3600000",
                "PROP_NAME" => "OFFERS",
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "14",
                "SECTION_ID" => $nextElement["ID"],
                "ID" => $arParams["ID_PRODUCTS"],
                "PICTURE_WIDTH" => "220",
                "PICTURE_HEIGHT" => "200",
                "PROP_VALUE" => array(0 => "13",1 => "14",2 => "15",3 => "16",4 => "17",),
                "ELEMENTS_COUNT" => "8",
                "SORT_PROPERTY_NAME" => "SORT",
                "SORT_VALUE" => "ASC",
                "COMPONENT_TEMPLATE" => ".default"
            ),
            false,
            array(
                "ACTIVE_COMPONENT" => "Y"
            )
        );?>        
    </div>
    <?
    }
    ?>
    
 