<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сравнение товаров");
?><h1>Список сравнения</h1>
 <?$APPLICATION->IncludeComponent("dresscode:catalog.compare", "compare", Array(
	"CACHE_TIME" => "360000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"IBLOCK_ID" => "14",	// Инфоблок
		"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
		"PRODUCT_PRICE_CODE" => "",	// Тип цены
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>