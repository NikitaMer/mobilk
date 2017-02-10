<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������� �������");
?>
<h1>�������� �������</h1>
<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"personal",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"ROOT_MENU_TYPE" => "salers",	// ��� ���� ��� ������� ������
		"MENU_CACHE_TYPE" => "A",	// ��� �����������
		"MENU_CACHE_TIME" => "3600000",	// ����� ����������� (���.)
		"MENU_CACHE_USE_GROUPS" => "Y",	// ��������� ����� �������
		"MENU_CACHE_GET_VARS" => "",	// �������� ���������� �������
		"MAX_LEVEL" => "1",	// ������� ����������� ����
		"CHILD_MENU_TYPE" => "",	// ��� ���� ��� ��������� �������
		"USE_EXT" => "Y",	// ���������� ����� � ������� ���� .���_����.menu_ext.php
		"DELAY" => "N",	// ����������� ���������� ������� ����
		"ALLOW_MULTI_SELECT" => "N",	// ��������� ��������� �������� ������� ������������
	),
	false
);?>

<? if (isUserSaler()) { ?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"bonus_catalog",
		Array(
			"ACTION_VARIABLE" => "action",	// �������� ����������, � ������� ���������� ��������
			"ADD_PICT_PROP" => "-",
			"ADD_PROPERTIES_TO_BASKET" => "Y",	// ��������� � ������� �������� ������� � �����������
			"ADD_SECTIONS_CHAIN" => "N",	// �������� ������ � ������� ���������
			"ADD_TO_BASKET_ACTION" => "ADD",
			"AJAX_MODE" => "N",	// �������� ����� AJAX
			"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
			"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
			"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
			"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
			"BACKGROUND_IMAGE" => "-",	// ���������� ������� �������� ��� ������� �� ��������
			"BASKET_URL" => "/personal/basket.php",	// URL, ������� �� �������� � �������� ����������
			"BROWSER_TITLE" => "-",	// ���������� ��������� ���� �������� �� ��������
			"CACHE_FILTER" => "N",	// ���������� ��� ������������� �������
			"CACHE_GROUPS" => "Y",	// ��������� ����� �������
			"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
			"CACHE_TYPE" => "A",	// ��� �����������
			"CONVERT_CURRENCY" => "N",	// ���������� ���� � ����� ������
			"DETAIL_URL" => "",	// URL, ������� �� �������� � ���������� �������� �������
			"DISABLE_INIT_JS_IN_COMPONENT" => "N",	// �� ���������� js-���������� � ����������
			"DISPLAY_BOTTOM_PAGER" => "N",	// �������� ��� �������
			"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
			"ELEMENT_SORT_FIELD" => "sort",	// �� ������ ���� ��������� ��������
			"ELEMENT_SORT_FIELD2" => "id",	// ���� ��� ������ ���������� ���������
			"ELEMENT_SORT_ORDER" => "asc",	// ������� ���������� ���������
			"ELEMENT_SORT_ORDER2" => "desc",	// ������� ������ ���������� ���������
			"FILTER_NAME" => "arrFilter",	// ��� ������� �� ���������� ������� ��� ���������� ���������
			"HIDE_NOT_AVAILABLE" => "N",	// ������, �� ��������� ��� �������
			"IBLOCK_ID" => "24",	// ��������
			"IBLOCK_TYPE" => "for_sellers",	// ��� ���������
			"INCLUDE_SUBSECTIONS" => "Y",	// ���������� �������� ����������� �������
			"LABEL_PROP" => "-",
			"LINE_ELEMENT_COUNT" => "3",	// ���������� ��������� ��������� � ����� ������ �������
			"MESSAGE_404" => "",	// ��������� ��� ������ (�� ��������� �� ����������)
			"MESS_BTN_ADD_TO_BASKET" => "� �������",
			"MESS_BTN_BUY" => "������",
			"MESS_BTN_DETAIL" => "���������",
			"MESS_BTN_SUBSCRIBE" => "�����������",
			"MESS_NOT_AVAILABLE" => "��� � �������",
			"META_DESCRIPTION" => "-",	// ���������� �������� �������� �� ��������
			"META_KEYWORDS" => "-",	// ���������� �������� ����� �������� �� ��������
			"OFFERS_LIMIT" => "5",	// ������������ ���������� ����������� ��� ������ (0 - ���)
			"PAGER_BASE_LINK_ENABLE" => "N",	// �������� ��������� ������
			"PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
			"PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
			"PAGER_SHOW_ALWAYS" => "N",	// �������� ������
			"PAGER_TEMPLATE" => ".default",	// ������ ������������ ���������
			"PAGER_TITLE" => "������",	// �������� ���������
			"PAGE_ELEMENT_COUNT" => "100",	// ���������� ��������� �� ��������
			"PARTIAL_PRODUCT_PROPERTIES" => "N",	// ��������� ��������� � ������� ������, � ������� ��������� �� ��� ��������������
			"PRICE_CODE" => array(	// ��� ����
				0 => "BASE",
			),
			"PRICE_VAT_INCLUDE" => "Y",	// �������� ��� � ����
			"PRODUCT_ID_VARIABLE" => "id",	// �������� ����������, � ������� ���������� ��� ������ ��� �������
			"PRODUCT_PROPERTIES" => "",	// �������������� ������
			"PRODUCT_PROPS_VARIABLE" => "prop",	// �������� ����������, � ������� ���������� �������������� ������
			"PRODUCT_QUANTITY_VARIABLE" => "",	// �������� ����������, � ������� ���������� ���������� ������
			"PRODUCT_SUBSCRIPTION" => "N",
			"PROPERTY_CODE" => array(	// ��������
				0 => "",
				1 => "",
			),
			"SECTION_CODE" => "",	// ��� �������
			"SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID �������
			"SECTION_ID_VARIABLE" => "SECTION_ID",	// �������� ����������, � ������� ���������� ��� ������
			"SECTION_URL" => "",	// URL, ������� �� �������� � ���������� �������
			"SECTION_USER_FIELDS" => array(	// �������� �������
				0 => "",
				1 => "",
			),
			"SEF_MODE" => "N",	// �������� ��������� ���
			"SET_BROWSER_TITLE" => "N",	// ������������� ��������� ���� ��������
			"SET_LAST_MODIFIED" => "N",	// ������������� � ���������� ������ ����� ����������� ��������
			"SET_META_DESCRIPTION" => "N",	// ������������� �������� ��������
			"SET_META_KEYWORDS" => "N",	// ������������� �������� ����� ��������
			"SET_STATUS_404" => "N",	// ������������� ������ 404
			"SET_TITLE" => "N",	// ������������� ��������� ��������
			"SHOW_404" => "N",	// ����� ����������� ��������
			"SHOW_ALL_WO_SECTION" => "N",	// ���������� ��� ��������, ���� �� ������ ������
			"SHOW_CLOSE_POPUP" => "N",
			"SHOW_DISCOUNT_PERCENT" => "N",
			"SHOW_OLD_PRICE" => "N",
			"SHOW_PRICE_COUNT" => "1",	// �������� ���� ��� ����������
			"TEMPLATE_THEME" => "blue",
			"USE_MAIN_ELEMENT_SECTION" => "N",	// ������������ �������� ������ ��� ������ ��������
			"USE_PRICE_COUNT" => "N",	// ������������ ����� ��� � �����������
			"USE_PRODUCT_QUANTITY" => "N",	// ��������� �������� ���������� ������
			"COMPONENT_TEMPLATE" => "squares",
			"HIDE_MEASURES" => "N",	// �� ���������� ������� ��������� � �������
		),
		false
	);?>
<? } ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>