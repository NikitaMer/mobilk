<?
$arResult['PRODUCTS'] = array();

$parent_items_id = array();
$allowed_products = array();
$allowed_sections = array(MOTOBLOCKS, TILLERS, SNOWBLOWERS, BUILDING_TECH);
// выберем родительские элементы для товаров
foreach ($arResult["ITEMS"] as $arItem) {
	!in_array($arItem['PROPERTIES']['CML2_LINK']['VALUE'], $parent_items_id) ? array_push($parent_items_id, $arItem['PROPERTIES']['CML2_LINK']['VALUE']) : "";
}

$parent_items_id = array_filter($parent_items_id);

// выбираем элементы
$parent_products = CIBlockElement::GetList(
	Array(),
	Array(
		"IBLOCK_ID" => CATALOG_IBLOCK_ID,
		"ID"        => $parent_items_id
	),
	false,
	false,
	Array("ID", "IBLOCK_SECTION_ID")
);
while ($parent_product = $parent_products->Fetch()) {
	in_array($parent_product['IBLOCK_SECTION_ID'], $allowed_sections) ? array_push($allowed_products, $parent_product['ID']) : "";
}

foreach($arResult["ITEMS"] as $arItem) {
	if ($arItem['PROPERTIES']['CML2_LINK']['VALUE'] && in_array($arItem['PROPERTIES']['CML2_LINK']['VALUE'], $allowed_products)) {
		$arResult['PRODUCTS'][] = array(
			"title"         => $arItem['NAME'],
			"article"       => $arItem['PROPERTIES']['ARTICLE']['VALUE'],
			"picture"       => $arItem['DETAIL_PICTURE']['ID'] ? getResizedImage($arItem['DETAIL_PICTURE']['ID'], 80, 60) : "/bitrix/templates/dresscode/images/empty.png",
			"silver_points" => array(
				"title" => GetMessage("SILVER_LVL"),
				"value" => $arItem['PROPERTIES']['SILVER_LVL_POINTS']['VALUE']
			),
			"golden_points" => array(
				"title" => GetMessage("GOLDEN_LVL"),
				"value" => $arItem['PROPERTIES']['GOLDEN_LVL_POINTS']['VALUE']
			),
			"actions"       => array(
				"is_action_product" => $arItem['PROPERTIES']['ACTION_PRODUCT']['VALUE'],
				"additional_points" => $arItem['PROPERTIES']['ADDITIONAL_POINTS']['VALUE'],
				"action_logo"       => $arItem['PROPERTIES']['ACTION_LOGO']['VALUE'] ? getResizedImage($arItem['PROPERTIES']['ACTION_LOGO']['VALUE'], ACTION_PRODUCT_LOGO_WIDTH, ACTION_PRODUCT_LOGO_HEIGHT, BX_RESIZE_IMAGE_PROPORTIONAL_ALT ) : "",
				"action_text"       => $arItem['PROPERTIES']['ACTION_TEXT']['VALUE']
			)
		);
	}
}
?>