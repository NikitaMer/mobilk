<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("������ ������");
?>
<style>
.questions_list input[name="BuyButton"], .questions_list input[type="submit"] {
	align-items: flex-start;
    text-align: center;
    cursor: default;
    color: buttontext;
    background-color: buttonface !important;
    box-sizing: border-box;
    padding: 2px 6px 3px;
    border-width: 2px;
    border-style: outset;
    border-color: buttonface;
    border-image: initial;
}
</style>
<h1>������ ������</h1>
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
	<div class="questions_list">
	<?$APPLICATION->IncludeComponent(
		"bitrix:support.ticket",
		"salers_support",
		Array(
			"MESSAGES_PER_PAGE" => "20",	// ���������� ��������� �� ����� ��������
			"MESSAGE_MAX_LENGTH" => "70",	// ������������ ����� ����������� ������
			"MESSAGE_SORT_ORDER" => "asc",	// ����������� ��� ���������� ��������� � ���������
			"SEF_MODE" => "N",	// �������� ��������� ���
			"SET_PAGE_TITLE" => "Y",	// ������������� ��������� ��������
			"SET_SHOW_USER_FIELD" => "",	// ���������� ���������������� ����
			"SHOW_COUPON_FIELD" => "N",	// ���������� ���� ����� ������
			"TICKETS_PER_PAGE" => "50",	// ���������� ��������� �� ����� ��������
			"VARIABLE_ALIASES" => array(
				"ID" => "ID",
			)
		),
		false
	);?>
	</div>
<? } ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>