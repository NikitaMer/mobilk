<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��������� �������");
?><h1>������ ���������</h1>
 <?$APPLICATION->IncludeComponent("dresscode:catalog.compare", "compare", Array(
	"CACHE_TIME" => "360000",	// ����� ����������� (���.)
		"CACHE_TYPE" => "A",	// ��� �����������
		"IBLOCK_ID" => "14",	// ��������
		"IBLOCK_TYPE" => "catalog",	// ��� ���������
		"PRODUCT_PRICE_CODE" => "",	// ��� ����
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>