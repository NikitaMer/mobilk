<?
$arResult["REQUESTS"] = array();
$arResult["PRODUCTS_TITLES"] = array();
$products_ids = array();

if (is_array($arResult["ITEMS"]) && !empty($arResult["ITEMS"])) {
	foreach ($arResult["ITEMS"] as $item) {
		array_push($products_ids, $item['PROPERTIES']['product']['VALUE']);
		$arResult["REQUESTS"][] = array(
			"date_create"   => ConvertDateTime($item['DATE_CREATE'], "DD.MM.YYYY", "s1"),
			"sale_date"     => $item['PROPERTIES']['sale_date']['VALUE'],
			"product"       => $item['PROPERTIES']['product']['VALUE'],
			"serial_number" => $item['PROPERTIES']['serial_number']['VALUE'],
			"price"         => $item['PROPERTIES']['sale_price']['VALUE'],
			"status"        => $item['PROPERTIES']['status']['VALUE'],
			"text_note"     => $item['PROPERTIES']['text_note']['VALUE']['TEXT'],
			"status_id"     => $item['PROPERTIES']['status']['VALUE_XML_ID']
		);
	}
	
	// получаем все товары, которые участвуют в завках
	$products = CIBlockElement::GetList(
		Array(),
		Array(
			"IBLOCK_ID" => CATALOG_IBLOCK_ID,
			"ACTIVE"    => "Y",
			"ID"        => $products_ids
		), 
		false, 
		false,
		array("ID", "NAME")
	);
	while ($product = $products->Fetch()) {
		$arResult["PRODUCTS_TITLES"][$product['ID']] = $product['NAME'];
	}
}
?>