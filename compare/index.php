<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ñðàâíåíèå òîâàðîâ");
?><h1>Ñïèñîê ñðàâíåíèÿ</h1>
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