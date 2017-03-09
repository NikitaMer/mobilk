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
			"id"    => $arItem['ID'],
			"title" => $arItem['NAME']
		);
	}
}
?>