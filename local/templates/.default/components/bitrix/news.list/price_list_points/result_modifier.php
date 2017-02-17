<?
$arResult['PRODUCTS'] = array();
foreach($arResult["ITEMS"] as $arItem) {
	$arResult['PRODUCTS'][] = array(
		"title"         => $arItem['NAME'],
		"article"       => $arItem['PROPERTIES']['ARTICLE']['VALUE'],
		"picture"       => $arItem['DETAIL_PICTURE']['ID'] ? getResizedImage($arItem['DETAIL_PICTURE']['ID'], 80, 60) : "/bitrix/templates/dresscode/images/empty.png",
		"silver_points" => array(
			"title" => $arItem['PROPERTIES']['SILVER_LVL_POINTS']['NAME'],
			"value" => $arItem['PROPERTIES']['SILVER_LVL_POINTS']['VALUE']
		),
		"golden_points" => array(
			"title" => $arItem['PROPERTIES']['GOLDEN_LVL_POINTS']['NAME'],
			"value" => $arItem['PROPERTIES']['GOLDEN_LVL_POINTS']['VALUE']
		),
		"actions"       => array(
			"is_action_product" => $arItem['PROPERTIES']['ACTION_PRODUCT']['VALUE'],
			"additional_points" => $arItem['PROPERTIES']['ADDITIONAL_POINTS']['VALUE'],
			"action_logo"       => $arItem['PROPERTIES']['ACTION_LOGO']['VALUE'] ? getResizedImage($arItem['PROPERTIES']['ACTION_LOGO']['VALUE'], ACTION_PRODUCT_LOGO_WIDTH, ACTION_PRODUCT_LOGO_HEIGHT, BX_RESIZE_IMAGE_PROPORTIONAL_ALT ) : ""
		)
	);
}
?>