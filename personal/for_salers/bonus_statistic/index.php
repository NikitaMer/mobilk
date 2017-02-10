<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������� ����������");
?>
<h1>�������� ����������</h1>
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
	<?
		global $orders_filter;
		$orders_filter = array(
			"CREATED_BY" => $USER->GetID()
		);
	?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"orders_list", 
		Array(
			"ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
			"ADD_SECTIONS_CHAIN" => "N",	// �������� ������ � ������� ���������
			"AJAX_MODE" => "N",	// �������� ����� AJAX
			"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
			"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
			"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
			"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
			"CACHE_FILTER" => "N",	// ���������� ��� ������������� �������
			"CACHE_GROUPS" => "Y",	// ��������� ����� �������
			"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
			"CACHE_TYPE" => "A",	// ��� �����������
			"CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
			"DETAIL_URL" => "",	// URL �������� ���������� ��������� (�� ��������� - �� �������� ���������)
			"DISPLAY_BOTTOM_PAGER" => "N",	// �������� ��� �������
			"DISPLAY_DATE" => "N",	// �������� ���� ��������
			"DISPLAY_NAME" => "N",	// �������� �������� ��������
			"DISPLAY_PICTURE" => "N",	// �������� ����������� ��� ������
			"DISPLAY_PREVIEW_TEXT" => "Y",	// �������� ����� ������
			"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
			"FIELD_CODE" => array(	// ����
				0 => "PREVIEW_TEXT",
				1 => "DETAIL_TEXT",
				2 => "DATE_CREATE",
				3 => "",
			),
			"FILTER_NAME" => "orders_filter",	// ������
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// �������� ������, ���� ��� ���������� ��������
			"IBLOCK_ID" => "25",	// ��� ��������������� �����
			"IBLOCK_TYPE" => "for_sellers",	// ��� ��������������� ����� (������������ ������ ��� ��������)
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// �������� �������� � ������� ���������
			"INCLUDE_SUBSECTIONS" => "Y",	// ���������� �������� ����������� �������
			"MESSAGE_404" => "",	// ��������� ��� ������ (�� ��������� �� ����������)
			"NEWS_COUNT" => "",	// ���������� �������� �� ��������
			"PAGER_BASE_LINK_ENABLE" => "N",	// �������� ��������� ������
			"PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
			"PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
			"PAGER_SHOW_ALWAYS" => "N",	// �������� ������
			"PAGER_TEMPLATE" => ".default",	// ������ ������������ ���������
			"PAGER_TITLE" => "�������",	// �������� ���������
			"PARENT_SECTION" => "",	// ID �������
			"PARENT_SECTION_CODE" => "",	// ��� �������
			"PREVIEW_TRUNCATE_LEN" => "",	// ������������ ����� ������ ��� ������ (������ ��� ���� �����)
			"PROPERTY_CODE" => array(	// ��������
				0 => "ORDER_COST",
				1 => "",
			),
			"SET_BROWSER_TITLE" => "N",	// ������������� ��������� ���� ��������
			"SET_LAST_MODIFIED" => "N",	// ������������� � ���������� ������ ����� ����������� ��������
			"SET_META_DESCRIPTION" => "N",	// ������������� �������� ��������
			"SET_META_KEYWORDS" => "N",	// ������������� �������� ����� ��������
			"SET_STATUS_404" => "N",	// ������������� ������ 404
			"SET_TITLE" => "N",	// ������������� ��������� ��������
			"SHOW_404" => "N",	// ����� ����������� ��������
			"SORT_BY1" => "ACTIVE_FROM",	// ���� ��� ������ ���������� ��������
			"SORT_BY2" => "SORT",	// ���� ��� ������ ���������� ��������
			"SORT_ORDER1" => "DESC",	// ����������� ��� ������ ���������� ��������
			"SORT_ORDER2" => "ASC",	// ����������� ��� ������ ���������� ��������
		),
		false
	);?>
<? } ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>