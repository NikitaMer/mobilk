<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Context; 

global $USER;

$request = Context::getCurrent()->getRequest();
// ������� ����� ������� � �������
$summary = 0;
$products = array();
$basket_products = CSaleBasket::GetList(
	array(
		"ID" => "ASC"
	),
	array(
		"FUSER_ID" => CSaleBasket::GetBasketUserID()
	),
	false,
	false,
	array("ID", "NAME", "QUANTITY", "PRICE")
);

while ($basket_product = $basket_products->Fetch()) {
	array_push($products, $basket_product["NAME"] . " x" . $basket_product['QUANTITY']);
	$summary += $basket_product['PRICE'] * $basket_product['QUANTITY'];
}
// ���� ��� ������ �����
if ($request->get("form_submitted") == "Y") {
	$comment = $request->get("comment");
	// ������ ���������� ������
	$element_object = new CIBlockElement;
	
	$iblock_properties = array(
		'ORDER_COST' => $summary
	);
	
	$iblock_fields = Array(
	    "MODIFIED_BY"       => $USER->GetID(),
	    "IBLOCK_ID"         => BONUS_ORDERS_IBLOCK_ID,
	    "PROPERTY_VALUES"   => $iblock_properties,
	    "NAME"              => $USER->GetFullName(),
	    "PREVIEW_TEXT"      => implode("\n", $products), // ������
	    "DETAIL_TEXT"       => $comment
	);
	
	$element_id = $element_object->Add($iblock_fields);
	
	if ($element_id > 0) {
		$arResult["SUCCESS"] = True;
		$arResult["MESSAGE"] = GetMessage("ORDER_ADDED");
		// ������ � ����������� �����
		CSaleUserAccount::Pay(
	        $USER->GetID(),
	        $summary,
	        "RUB"
    	);
		// ������� �������
		CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
	}
} else {
	// �������� ���� � ����� ������ ������������
	$user_points = getUserPoints($USER->GetID());
	
	if ($user_points < $summary) {
		// ���� ������ ������������, �� ���������� ������
		$arResult["ERROR"] = True;
		$arResult["MESSAGE"] = GetMessage("POINTS_NOT_ENOUGH");
	} else {
		$arResult["ERROR"] = False;
		$arResult["POINTS_SUM"] = $summary;
	}
}

$this->IncludeComponentTemplate();
?>