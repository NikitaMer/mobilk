<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��������� �������");
?><h1>������ ���������</h1>
<?$APPLICATION->IncludeComponent("dresscode:catalog.compare", ".default", Array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "14",
		"CACHE_TYPE" => "A",	// ��� �����������
		"CACHE_TIME" => "360000",	// ����� ����������� (���.)
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>