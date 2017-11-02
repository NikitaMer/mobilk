<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Магазины дилеров");?>
<h1><?$APPLICATION->ShowTitle(true)?></h1>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.store",
	".default",
	Array(
		"CACHE_NOTES" => "",
		"CACHE_TIME" => "360000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"EMAIL" => "Y",
		"MAP_TYPE" => "0",
		"PHONE" => "Y",
		"SCHEDULE" => "Y",
		"SEF_FOLDER" => "/stores/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => array("liststores"=>"","element"=>"#store_id#/",),
		"SET_TITLE" => "N",
		"TITLE" => "Список складов с подробной информацией"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>