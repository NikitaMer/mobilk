<?
$arResult["ORDERS"] = array();

if (is_array($arResult["ITEMS"]) && !empty($arResult["ITEMS"])) {
	foreach ($arResult["ITEMS"] as $item) {
		$arResult["ORDERS"][] = array(
			"date_create"   => ConvertDateTime($item['DATE_CREATE'], "DD.MM.YYYY", "s1"),
			"products"      => $item['PREVIEW_TEXT'],
			"comment"       => $item['DETAIL_TEXT'],
			"summ"          => $item['PROPERTIES']['ORDER_COST']['VALUE']
		);
	}
}
?>