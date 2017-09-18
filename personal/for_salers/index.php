<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��� ���������");
?>
<h1>��� ���������</h1>
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
	<? // ������� ���� � �������� ?>
	<?$APPLICATION->IncludeComponent(
		"webgk:saler.profile.status.info",
		"",
		Array(),
		false
	);?>
	
	<?$APPLICATION->IncludeComponent("bitrix:iblock.element.add.form", "add_sale", array(
	"COMPONENT_TEMPLATE" => "add_sale",
		"IBLOCK_TYPE" => "for_sellers",
		"IBLOCK_ID" => "22",
		"STATUS_NEW" => "N",
		"LIST_URL" => "",
		"USE_CAPTCHA" => "N",
		"USER_MESSAGE_EDIT" => "",
		"USER_MESSAGE_ADD" => "������ ������� ���������",
		"DEFAULT_INPUT_SIZE" => "30",
		"RESIZE_IMAGES" => "N",
		"PROPERTY_CODES" => array(
			0 => "126",
			1 => "128",
			2 => "129",
			3 => "NAME",
		),
		"PROPERTY_CODES_REQUIRED" => array(
			0 => "126",
			1 => "128",
			2 => "129",
			3 => "NAME",
		),
		"GROUPS" => array(
			0 => "7",
		),
		"STATUS" => "ANY",
		"ELEMENT_ASSOC" => "CREATED_BY",
		"MAX_USER_ENTRIES" => "100000",
		"MAX_LEVELS" => "100000",
		"LEVEL_LAST" => "Y",
		"MAX_FILE_SIZE" => "0",
		"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
		"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
		"SEF_MODE" => "N",
		"CUSTOM_TITLE_NAME" => "",
		"CUSTOM_TITLE_TAGS" => "",
		"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
		"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
		"CUSTOM_TITLE_IBLOCK_SECTION" => "",
		"CUSTOM_TITLE_PREVIEW_TEXT" => "",
		"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
		"CUSTOM_TITLE_DETAIL_TEXT" => "",
		"CUSTOM_TITLE_DETAIL_PICTURE" => ""
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
<? } else { ?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:iblock.element.add.form", 
		"salers_requests", 
		array(
			"COMPONENT_TEMPLATE" => ".default",
			"IBLOCK_TYPE" => "for_sellers",
			"IBLOCK_ID" => "21",
			"STATUS_NEW" => "N",
			"LIST_URL" => "",
			"USE_CAPTCHA" => "N",
			"USER_MESSAGE_EDIT" => "",
			"USER_MESSAGE_ADD" => "",
			"DEFAULT_INPUT_SIZE" => "30",
			"RESIZE_IMAGES" => "N",
			"PROPERTY_CODES" => array(
				0 => "122",
				1 => "123",
				2 => "124",
				3 => "125",
				4 => "NAME",
			),
			"PROPERTY_CODES_REQUIRED" => array(
				0 => "122",
				1 => "123",
				2 => "124",
				3 => "125",
				4 => "NAME",
			),
			"GROUPS" => array(
				0 => "7",
			),
			"STATUS" => "ANY",
			"ELEMENT_ASSOC" => "CREATED_BY",
			"MAX_USER_ENTRIES" => "100000",
			"MAX_LEVELS" => "100000",
			"LEVEL_LAST" => "Y",
			"MAX_FILE_SIZE" => "0",
			"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
			"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
			"SEF_MODE" => "N",
			"CUSTOM_TITLE_NAME" => "",
			"CUSTOM_TITLE_TAGS" => "",
			"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
			"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
			"CUSTOM_TITLE_IBLOCK_SECTION" => "",
			"CUSTOM_TITLE_PREVIEW_TEXT" => "",
			"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
			"CUSTOM_TITLE_DETAIL_TEXT" => "",
			"CUSTOM_TITLE_DETAIL_PICTURE" => ""
		),
		false
	);?>
<? } ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>