<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сравнение товаров");
?><h1>Сравнение товаров</h1>
 <?$APPLICATION->IncludeComponent(
	"dresscode:catalog.compare", 
	"compare", 
	array(
		"CACHE_TIME" => "360000",
		"CACHE_TYPE" => "A",
		"IBLOCK_ID" => "14",
		"IBLOCK_TYPE" => "catalog",
		"PRODUCT_PRICE_CODE" => array(
		),
		"COMPONENT_TEMPLATE" => "compare"
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>