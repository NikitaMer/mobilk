<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

CModule::IncludeModule('highloadblock');
$OPTION_ADD_CART  = COption::GetOptionString("catalog", "default_can_buy_zero");
$OPTION_PRICE_TAB = COption::GetOptionString("catalog", "show_catalog_tab_with_offers");
$OPTION_CURRENCY  = CCurrency::GetBaseCurrency();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

$templateLibrary = array('popup');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_SPG_TPL_ELEMENT_DELETE_CONFIRM'));

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$arParams['~MESS_BTN_BUY'] = $arParams['~MESS_BTN_BUY'] ?: Loc::getMessage('CT_SPG_TPL_MESS_BTN_CHOOSE');
$arParams['~MESS_BTN_DETAIL'] = $arParams['~MESS_BTN_DETAIL'] ?: Loc::getMessage('CT_SPG_TPL_MESS_BTN_DETAIL');
$arParams['~MESS_BTN_COMPARE'] = $arParams['~MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_SPG_TPL_MESS_BTN_COMPARE');
$arParams['~MESS_BTN_SUBSCRIBE'] = $arParams['~MESS_BTN_SUBSCRIBE'] ?: Loc::getMessage('CT_SPG_TPL_MESS_BTN_SUBSCRIBE');
$arParams['~MESS_BTN_ADD_TO_BASKET'] = $arParams['~MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_SPG_TPL_MESS_BTN_CHOOSE');
$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_SPG_TPL_MESS_PRODUCT_NOT_AVAILABLE');
$arParams['~MESS_SHOW_MAX_QUANTITY'] = $arParams['~MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_SPG_CATALOG_SHOW_MAX_QUANTITY');
$arParams['~MESS_RELATIVE_QUANTITY_MANY'] = $arParams['~MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_SPG_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['~MESS_RELATIVE_QUANTITY_FEW'] = $arParams['~MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_SPG_CATALOG_RELATIVE_QUANTITY_FEW');

$generalParams = array(
	'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
	'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
	'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
	'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
	'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
	'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
	'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
	'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
	'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
	'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
	'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
	'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
	'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
	'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'],
	'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
	'COMPARE_PATH' => $arParams['COMPARE_PATH'],
	'COMPARE_NAME' => $arParams['COMPARE_NAME'],
	'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
	'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
	'LABEL_POSITION_CLASS' => $labelPositionClass,
	'DISCOUNT_POSITION_CLASS' => $discountPositionClass,
	'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
	'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],
	'~ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
	'~BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
	'~COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
	'~COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
	'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
	'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
	'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
	'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
	'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
	'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
	'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE']
);

$obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($this->randString()));
$containerName = 'sale-products-gift-container';
?>

<div class="sale-products-gift bx-<?=$arParams['TEMPLATE_THEME']?>" data-entity="<?=$containerName?>">
	<?
	if (!empty($arResult['ITEMS']) && !empty($arResult['ITEM_ROWS']))
	{
		$areaIds = array();

		foreach ($arResult['ITEMS'] as &$item)
		{
			$uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
			$areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
			$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
			$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);

			// custom gift labels
			$item['LABEL_VALUE'] = $arParams['TEXT_LABEL_GIFT'] ?: Loc::getMessage('CT_SPG_TPL_TEXT_LABEL_GIFT_DEFAULT');
			$item['LABEL_ARRAY_VALUE'] = array('gift' => $item['LABEL_VALUE']);
			$item['LABEL_PROP_MOBILE'] = array('gift' => true);
			$item['LABEL'] = !empty($item['LABEL_VALUE']);
		}
		unset($item);
		?>
		<!-- items-container -->
		<div class="row" data-entity="items-row">
			<div class="items productList">
				<?
				//result_modifier not available for whis component :(
				if(!empty($arResult["ITEMS"])){

					$COLOR_PROPERTY_NANE = "COLOR";
					$SKU_INFO = CCatalogSKU::GetInfoByProductIBlock($arResult["POTENTIAL_PRODUCT_TO_BUY"]["IBLOCK_ID"]);

					$arResult["PRODUCT_PRICE_ALLOW"] = array();
					$arResult["PRODUCT_PRICE_ALLOW_FILTER"] = array();

					if(!empty($arParams["PRICE_CODE"])){
						$dbPriceType = CCatalogGroup::GetList(
					        array("SORT" => "ASC"),
					        array("NAME" => $arParams["PRICE_CODE"])
					    );
						while ($arPriceType = $dbPriceType->Fetch()){
							if($arPriceType["CAN_BUY"] == "Y"){
						    	$arResult["PRODUCT_PRICE_ALLOW"][] = $arPriceType;
							}
						    $arResult["PRODUCT_PRICE_ALLOW_FILTER"][] = $arPriceType["ID"];
						}
					}

					if(is_array($SKU_INFO)){
						$properties = CIBlockProperty::GetList(Array("sort" => "asc", "name" => "asc"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $SKU_INFO["IBLOCK_ID"]));
						while ($prop_fields = $properties->GetNext()){
							if($prop_fields["SORT"] <= 100 && $prop_fields["PROPERTY_TYPE"] == "L"){
								$propValues = array();
								$prop_fields["HIGHLOAD"] = "N";
								$property_enums = CIBlockPropertyEnum::GetList(Array("SORT" => "ASC", "DEF" => "DESC"), Array("IBLOCK_ID" => $SKU_INFO["IBLOCK_ID"], "CODE" => $prop_fields["CODE"]));
								while($enum_fields = $property_enums->GetNext()){
									$propValues[$enum_fields["EXTERNAL_ID"]] = array(
										"VALUE"  => $enum_fields["VALUE"],
										"DISPLAY_VALUE"  => $enum_fields["VALUE"],
										"SELECTED"  => "N",
										"DISABLED"  => "N",
										"HIGHLOAD" => "N",
										"TYPE" => "L",
									);
								}
								$prop_fields["TYPE"] = "L";
								$arResult["PROPERTIES"][$prop_fields["CODE"]] = array_merge(
									$prop_fields, array("VALUES" => $propValues)
								);
							}elseif($prop_fields["SORT"] <= 100 && $prop_fields["PROPERTY_TYPE"] == "S" && !empty($prop_fields["USER_TYPE_SETTINGS"]["TABLE_NAME"])){
								$propValues = array();
								$prop_fields["HIGHLOAD"] = "Y";
								$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(
							        array("filter" => array(
							            "TABLE_NAME" => $prop_fields["USER_TYPE_SETTINGS"]["TABLE_NAME"]
							        ))
							    )->fetch();

							    if(!empty($hlblock)){

									$hlblock_requests = HL\HighloadBlockTable::getById($hlblock["ID"])->fetch();
									$entity_requests = HL\HighloadBlockTable::compileEntity($hlblock_requests);
									$entity_requests_data_class = $entity_requests->getDataClass();

									$main_query_requests = new Entity\Query($entity_requests_data_class);
									$main_query_requests->setSelect(array("*"));
									$result_requests = $main_query_requests->exec();
									$result_requests = new CDBResult($result_requests);

									while ($row_requests = $result_requests->Fetch()) {

										if(!empty($row_requests["UF_FILE"])){
				 							$row_requests["UF_FILE"] = CFile::ResizeImageGet($row_requests["UF_FILE"], array("width" => 30, "height" => 30), BX_RESIZE_IMAGE_PROPORTIONAL, false); 
											$hasPicture = true;
										}

										$propValues[$row_requests["UF_XML_ID"]] = array(
											"VALUE" => $row_requests["UF_XML_ID"],
											"DISPLAY_VALUE"  => $row_requests["UF_NAME"],
											"SELECTED" => "N",
											"DISABLED" => "N",
											"TYPE" => "H",
											"UF_XML_ID" => $row_requests["UF_XML_ID"],
											"IMAGE" => $row_requests["UF_FILE"],
											"NAME" => $row_requests["UF_NAME"],
											"HIGHLOAD" => "Y"
										);

									}

									$prop_fields["HIGHLOAD"] = "Y";
									$prop_fields["TYPE"] = "H";
									$arResult["PROPERTIES"][$prop_fields["CODE"]] = array_merge(
										$prop_fields, array("VALUES" => $propValues)
									);

									// print_r($requests);

								}
							}elseif($prop_fields["SORT"] <= 100 && $prop_fields["PROPERTY_TYPE"] == "E" && !empty($prop_fields["LINK_IBLOCK_ID"])){
								$rsLinkElements = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $prop_fields["LINK_IBLOCK_ID"], "ACTIVE" => "Y"), false, false, array("ID", "NAME", "DETAIL_PICTURE"));
								while ($arNextLinkElement = $rsLinkElements->GetNext()){
									if(!empty($arNextLinkElement["DETAIL_PICTURE"])){
			 							$arNextLinkElement["UF_FILE"] = CFile::ResizeImageGet($arNextLinkElement["DETAIL_PICTURE"], array("width" => 30, "height" => 30), BX_RESIZE_IMAGE_PROPORTIONAL, false);
									}
									$propValues[$arNextLinkElement["ID"]] = array(
										"VALUE" => $arNextLinkElement["ID"],
										"VALUE_XML_ID" => $arNextLinkElement["ID"],
										"DISPLAY_VALUE" => $arNextLinkElement["NAME"],
										"UF_XML_ID" => $arNextLinkElement["ID"],
										"IMAGE" => $arNextLinkElement["UF_FILE"],
										"NAME" => $arNextLinkElement["NAME"],
										"TYPE" => "E",
										"HIGHLOAD" => "N",
										"SELECTED" => "N",
										"DISABLED" => "N",
									);
								}
								$prop_fields["TYPE"] = "E";
								$arResult["PROPERTIES"][$prop_fields["CODE"]] = array_merge(
									$prop_fields, array("VALUES" => $propValues)
								);
							}
						}
					}


					foreach ($arResult["ITEMS"] as $index => $arElement){

						$arButtons = CIBlock::GetPanelButtons(
							$arElement["IBLOCK_ID"],
							$arElement["ID"],
							$arElement["ID"],
							array("SECTION_BUTTONS" => false, 
								  "SESSID" => false, 
								  "CATALOG" => true
							)
						);

						$arElement["SKU"] = CCatalogSKU::IsExistOffers($arElement["ID"]);
						if($arElement["SKU"]){
							if(empty($SKU_INFO)){
								$SKU_INFO = CCatalogSKU::GetInfoByProductIBlock($arElement["IBLOCK_ID"]);
							}
							if (is_array($SKU_INFO)){
								$rsOffers = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $SKU_INFO["IBLOCK_ID"], "PROPERTY_".$SKU_INFO["SKU_PROPERTY_ID"] => $arElement["ID"], "ACTIVE" => "Y"), false, false, array("ID", "IBLOCK_ID", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "NAME", "CATALOG_QUANTITY")); 
								while($arSku = $rsOffers->GetNextElement()){

									$arSkuFields = $arSku->GetFields();
									$arSkuProperties = $arSku->GetProperties();

									if(!empty($arResult["PRODUCT_PRICE_ALLOW"])){
										$arPriceCodes = array();
										foreach($arResult["PRODUCT_PRICE_ALLOW"] as $ipc => $arNextAllowPrice){
											$dbPrice = CPrice::GetList(
										        array(),
										        array(
										            "PRODUCT_ID" => $arSkuFields["ID"],
										            "CATALOG_GROUP_ID" => $arNextAllowPrice["ID"]
										        )
										    );
											if($arPriceValues = $dbPrice->Fetch()){
												$arPriceCodes[] = array(
													"ID" => $arNextAllowPrice["ID"],
													"PRICE" => $arPriceValues["PRICE"],
													"CURRENCY" => $arPriceValues["CURRENCY"],
													"CATALOG_GROUP_ID" => $arNextAllowPrice["ID"]
												);
											}
										}
									}

									if(!empty($arResult["PRODUCT_PRICE_ALLOW"]) && !empty($arPriceCodes) || empty($arParams["PRICE_CODE"]))
										$arSkuFields["PRICE"] = CCatalogProduct::GetOptimalPrice($arSkuFields["ID"], 1, $USER->GetUserGroupArray(), "N", $arPriceCodes);

									$arElement["SKU_PRODUCT"][] = array_merge($arSkuFields, array("PROPERTIES" => $arSkuProperties));

									$arElement["SKU_PRICES"][] = $arSkuPrice["DISCOUNT_PRICE"];
								}

								$arElement["ADDSKU"] = $OPTION_ADD_CART === "Y" ? true : $arElement["CATALOG_QUANTITY"] > 0;
								$arElement["SKU_INFO"] = $SKU_INFO;
							}
						}

						$arResult["ITEMS"][$index]["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
						$arResult["ITEMS"][$index]["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

						if(!empty($arElement["SKU_PRODUCT"]) && !empty($arResult["PROPERTIES"])){
							$arElement["SKU_PROPERTIES"] = $arResult["PROPERTIES"];
							foreach ($arElement["SKU_PROPERTIES"] as $ip => $arProp) {
								foreach ($arProp["VALUES"] as $ipv => $arPropValue) {
									$find = false;;
									foreach ($arElement["OFFERS"] as $ipo => $arOffer) {
										if(!empty($arPropValue["VALUE"])){
											if($arOffer["PROPERTIES"][$arProp["CODE"]]["VALUE"] == $arPropValue["VALUE"]){
												$find = true;
												break(1);
											}
										}
									}
									if(!$find){
										unset($arElement["SKU_PROPERTIES"][$ip]["VALUES"][$ipv]);
									}
								}
							}

							// first display

							$arPropClean = array();
							$iter = 0;

							foreach ($arElement["SKU_PROPERTIES"] as $ip => $arProp) {
								if(!empty($arProp["VALUES"])){
									$arKeys = array_keys($arProp["VALUES"]);
									$selectedUse = false;
									if($iter === 0){
										$arElement["SKU_PROPERTIES"][$ip]["VALUES"][$arKeys[0]]["SELECTED"] = Y;
										$arPropClean[$ip] = array(
											"PROPERTY" => $ip,
											"VALUE"    => $arKeys[0],
											"HIGHLOAD" => $arProp["HIGHLOAD"]
										);
									}else{
										foreach ($arKeys as $key => $keyValue) {
											$disabled = true;
											$checkValue = $arElement["SKU_PROPERTIES"][$ip]["VALUES"][$keyValue]["VALUE"];

											foreach ($arElement["OFFERS"] as $io => $arOffer) {
												if($arOffer["PROPERTIES"][$ip]["VALUE"] == $checkValue){
													$disabled = false; $selected = true;
													foreach ($arPropClean as $ic => $arNextClean) {
														if($arNextClean["HIGHLOAD"] == "Y" && $arOffer["PROPERTIES"][$arNextClean["PROPERTY"]]["VALUE"] != $arNextClean["VALUE"] || $arNextClean["HIGHLOAD"] != "Y" && $arOffer["PROPERTIES"][$arNextClean["PROPERTY"]]["VALUE_XML_ID"] != $arNextClean["VALUE"]){
															if($ic == $ip){
																break(2);
															}
															$disabled = true;
															$selected = false;
															break(1);
														}
													}
													if($selected && !$selectedUse){
														$selectedUse = true;
														$arElement["SKU_PROPERTIES"][$ip]["VALUES"][$keyValue]["SELECTED"] = Y;
														$arPropClean[$ip] = array(
															"PROPERTY" => $ip,
															"VALUE"    => $keyValue,
															"HIGHLOAD" => $arProp["HIGHLOAD"]
														);
														break(1);
													}
												}
											}
											if($disabled){
												$arElement["SKU_PROPERTIES"][$ip]["VALUES"][$keyValue]["DISABLED"] = "Y";
											}
										}
									}
									$iter++;
								}
							}

							if(!empty($arElement["SKU_PROPERTIES"][$COLOR_PROPERTY_NANE])){
								foreach ($arElement["SKU_PROPERTIES"][$COLOR_PROPERTY_NANE]["VALUES"] as $ic => $arProperty) {
									foreach ($arElement["SKU_PRODUCT"] as $io => $arOffer) {
										if($arOffer["PROPERTIES"][$COLOR_PROPERTY_NANE]["VALUE"] == $arProperty["VALUE"]){
											if(!empty($arOffer["DETAIL_PICTURE"])){
												$arPropertyFile = CFile::GetFileArray($arOffer["DETAIL_PICTURE"]);
												$arPropertyImage = CFile::ResizeImageGet($arPropertyFile, array('width' => 30, 'height' => 30), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 80);
												$arElement["SKU_PROPERTIES"][$COLOR_PROPERTY_NANE]["VALUES"][$ic]["IMAGE"] = $arPropertyImage;
												break(1);
											}
										}
									}
								}
							}

							foreach ($arElement["SKU_PRODUCT"] as $ir => $arOffer) {
								$active = true;
								foreach ($arPropClean as $ic => $arNextClean) {
									if($arNextClean["HIGHLOAD"] == "Y" || $arResult["PROPERTIES"][$ic]["TYPE"] == "E"){
										if($arOffer["PROPERTIES"][$arNextClean["PROPERTY"]]["VALUE"] != $arNextClean["VALUE"]){
											$active = false;
											break(1);
										}
									}else{
										if($arOffer["PROPERTIES"][$arNextClean["PROPERTY"]]["VALUE_XML_ID"] != $arNextClean["VALUE"]){
											$active = false;
											break(1);
										}
									}
								}
								if($active){

									if(!empty($arOffer["DETAIL_PICTURE"])){
										$arElement["DETAIL_PICTURE"] = $arOffer["DETAIL_PICTURE"];
									}

									if(!empty($arOffer["NAME"])){
										$arElement["NAME"] = $arOffer["NAME"];
									}

									if(!empty($arOffer["PROPERTIES"]["MORE_PHOTO"]["VALUE"])){
										foreach ($arOffer["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $impr => $arMorePhoto) {
											$arElement["MORE_PHOTO"][] = CFile::ResizeImageGet($arMorePhoto, array("width" => 40, "height" => 50), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 80);
										}
									}

									$arElement["~ID"] = $arElement["ID"];
									$arElement["ID"] = $arOffer["ID"];

									if(!empty($arResult["PRODUCT_PRICE_ALLOW"])){
										$arPriceCodes = array();
										foreach($arResult["PRODUCT_PRICE_ALLOW"] as $ipc => $arNextAllowPrice){
											$dbPrice = CPrice::GetList(
										        array(),
										        array(
										            "PRODUCT_ID" => $arOffer["ID"],
										            "CATALOG_GROUP_ID" => $arNextAllowPrice["ID"]
										        )
										    );
											if($arPriceValues = $dbPrice->Fetch()){
												$arPriceCodes[] = array(
													"ID" => $arNextAllowPrice["ID"],
													"PRICE" => $arPriceValues["PRICE"],
													"CURRENCY" => $arPriceValues["CURRENCY"],
													"CATALOG_GROUP_ID" => $arNextAllowPrice["ID"]
												);
											}
										}
									}

									if(!empty($arResult["PRODUCT_PRICE_ALLOW"]) && !empty($arPriceCodes) || empty($arParams["PRICE_CODE"])){
										$arElement["TMP_PRICE"] = CCatalogProduct::GetOptimalPrice($arOffer["ID"], 1, $USER->GetUserGroupArray(), "N", $arPriceCodes);
										$arElement["ITEM_PRICES"][0]["PRINT_DISCOUNT"] = CurrencyFormat($arElement["TMP_PRICE"]["RESULT_PRICE"]["DISCOUNT_PRICE"], $OPTION_CURRENCY);
									}

									$arElement["IBLOCK_ID"] = $arOffer["IBLOCK_ID"];

								}
							}

						}

						$arResult["ITEMS"][$index] = $arElement;

					}
				}?>
				<?foreach ($arResult["ITEMS"] as $inx => $arNextElement):?>
					<?
						$arNextElement["IMAGE"] = CFile::ResizeImageGet($arNextElement["DETAIL_PICTURE"], array("width" => 220, "height" => 200), BX_RESIZE_IMAGE_PROPORTIONAL, false);
						if(empty($arNextElement["IMAGE"])){
							$arNextElement["IMAGE"]["src"] = SITE_TEMPLATE_PATH."/images/empty.png";
						}
					?>
					<div class="item product">
						<div class="tabloid">

							<a href="#" class="removeFromWishlist" data-id="<?=$arNextElement["ID"]?>"></a>
							<div class="markerContainer">
								<div class="marker" style="background-color: #ff045d"><?=getMessage("CT_SPG_GIFT_MARKER_LABEL")?></div>
							</div>
							<?if(isset($arNextElement["PROPERTIES"]["RATING"]["VALUE"])):?>
							    <div class="rating">
							      <i class="m" style="width:<?=($arNextElement["PROPERTIES"]["RATING"]["VALUE"] * 100 / 5)?>%"></i>
							      <i class="h"></i>
							    </div>
						    <?endif;?>
							<a href="<?=$arNextElement["DETAIL_PAGE_URL"]?>" class="picture">
								<img src="<?=$arNextElement["IMAGE"]["src"]?>" alt="Конфеты Fazer Ликер 150г" title="Конфеты Fazer Ликер 150г">
								<span class="getFastView" data-id="<?=$arNextElement["ID"]?>"><?=GetMessage("CT_SPG_FAST_VIEW_PRODUCT_LABEL")?></span>
							</a>
							<a href="<?=$arNextElement["DETAIL_PAGE_URL"]?>" class="name"><span class="middle"><?=$arNextElement["NAME"]?></span></a>
							<a class="price"><?=getMessage("CT_SPG_NO_PRICE")?> <s class="discount"><?=$arNextElement["ITEM_PRICES"][0]["PRINT_DISCOUNT"]?></s></a>
							<a href="#" class="addCart" data-id="<?=$arNextElement["ID"]?>"><img src="/bitrix/templates/dresscode/images/incart.png" alt="" class="icon"><?=GetMessage("CT_SPG_ADDCART_LABEL")?></a>
							<div class="optional">
								<div class="row">
									<a href="#" class="fastBack label<?if(empty($arNextElement["MIN_PRICE"]) || $arNextElement["CAN_BUY"] === "N" || $arNextElement["CAN_BUY"] === false):?> disabled<?endif;?>" data-id="<?=$arNextElement["ID"]?>"><img src="<?=SITE_TEMPLATE_PATH?>/images/fastBack.png" alt="" class="icon"><?=GetMessage("CT_SPG_FASTBACK_LABEL")?></a>
									<a href="#" class="addCompare label" data-id="<?=$arNextElement["ID"]?>"><img src="<?=SITE_TEMPLATE_PATH?>/images/compare.png" alt="" class="icon"><?=GetMessage("CT_SPG_COMPARE_LABEL")?></a>
								</div>
								<div class="row">
									<a href="#" class="addWishlist label" data-id="<?=$arNextElement["~ID"]?>"><img src="<?=SITE_TEMPLATE_PATH?>/images/wishlist.png" alt="" class="icon"><?=GetMessage("CT_SPG_WISHLIST_LABEL")?></a>
									<?if($arNextElement["CATALOG_QUANTITY"] > 0):?>
										<?if(!empty($arNextElement["STORES"])):?>
											<a href="#" data-id="<?=$arNextElement["ID"]?>" class="inStock label changeAvailable getStoresWindow"><img src="<?=SITE_TEMPLATE_PATH?>/images/inStock.png" alt="<?=GetMessage("CT_SPG_AVAILABLE")?>" class="icon"><span><?=GetMessage("CT_SPG_AVAILABLE")?></span></a>
										<?else:?>
											<span class="inStock label changeAvailable"><img src="<?=SITE_TEMPLATE_PATH?>/images/inStock.png" alt="<?=GetMessage("AVAILABLE")?>" class="icon"><span><?=GetMessage("CT_SPG_AVAILABLE")?></span></span>
										<?endif;?>
									<?else:?>
										<?if($arNextElement["CAN_BUY"] === true || $arNextElement["CAN_BUY"] === "Y"):?>
											<a class="onOrder label changeAvailable"><img src="<?=SITE_TEMPLATE_PATH?>/images/onOrder.png" alt="" class="icon"><?=GetMessage("CT_SPG_ON_ORDER")?></a>
										<?else:?>
											<a class="outOfStock label changeAvailable"><img src="<?=SITE_TEMPLATE_PATH?>/images/outOfStock.png" alt="" class="icon"><?=GetMessage("CT_SPG_NOAVAILABLE")?></a>
										<?endif;?>
									<?endif;?>
								</div>
							</div>
						</div>
					</div>
				<?endforeach;?>
			</div>
		</div>
		<?
		unset($generalParams, $rowItems);
		?>
		<!-- items-container -->
		<?
	}

	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedTemplate = $signer->sign($templateName, 'sale.products.gift');
	$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'sale.products.gift');
	?>
</div>

<script>
	BX.message({
		BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_SPG_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
		BASKET_URL: '<?=$arParams['BASKET_URL']?>',
		ADD_TO_BASKET_OK: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
		TITLE_ERROR: '<?=GetMessageJS('CT_SPG_CATALOG_TITLE_ERROR')?>',
		TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_SPG_CATALOG_TITLE_BASKET_PROPS')?>',
		TITLE_SUCCESSFUL: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
		BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_SPG_CATALOG_BASKET_UNKNOWN_ERROR')?>',
		BTN_MESSAGE_SEND_PROPS: '<?=GetMessageJS('CT_SPG_CATALOG_BTN_MESSAGE_SEND_PROPS')?>',
		BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_SPG_CATALOG_BTN_MESSAGE_CLOSE')?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_SPG_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
		COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_SPG_CATALOG_MESS_COMPARE_OK')?>',
		COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_SPG_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
		COMPARE_TITLE: '<?=GetMessageJS('CT_SPG_CATALOG_MESS_COMPARE_TITLE')?>',
		PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_SPG_CATALOG_PRICE_TOTAL_PREFIX')?>',
		RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
		RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_SPG_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
		BTN_MESSAGE_LAZY_LOAD: '<?=$arParams['MESS_BTN_LAZY_LOAD']?>',
		BTN_MESSAGE_LAZY_LOAD_WAITER: '<?=GetMessageJS('CT_SPG_CATALOG_BTN_MESSAGE_LAZY_LOAD_WAITER')?>',
		SITE_ID: '<?=SITE_ID?>'
	});

	var <?=$obName?> = new JCSaleProductsGiftComponent({
		siteId: '<?=CUtil::JSEscape(SITE_ID)?>',
		componentPath: '<?=CUtil::JSEscape($componentPath)?>',
		deferredLoad: true,
		initiallyShowHeader: '<?=!empty($arResult['ITEM_ROWS'])?>',
	   currentProductId: <?=CUtil::JSEscape((int)$arResult['POTENTIAL_PRODUCT_TO_BUY']['ID'])?>,
		template: '<?=CUtil::JSEscape($signedTemplate)?>',
		parameters: '<?=CUtil::JSEscape($signedParams)?>',
		container: '<?=$containerName?>'
	});
</script>