<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������");
?><h1>�������</h1><?$APPLICATION->IncludeComponent("dresscode:sale.basket.basket", "basket_with_bonus", Array(
	
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>