<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
global $USER;
$aMenuNativeExt = array();

// ���� ������������ ��������, �� ��� ���� ������������ �������������� ������ ����
if (isUserSaler()) {
	$aMenuLinks = Array(
		Array(
			"��� ���������", 
			"/personal/for_salers/", 
			Array(), 
			Array(), 
			"" 
		),
		Array(
			"��� �������",
			SITE_DIR."personal/for_salers/my_sales/",
			Array(),
			Array(),
			""
		),
		Array(
			"�����-���� ������",
			SITE_DIR."personal/for_salers/points_price_list/",
			Array(),
			Array(),
			""
		),
		Array(
			"������ ������",
			SITE_DIR."personal/for_salers/ask_question/",
			Array(),
			Array(),
			""
		),
		Array(
			"�������� �������",
			SITE_DIR."personal/for_salers/bonus_catalog/",
			Array(),
			Array(),
			""
		),
		Array(
			"�������� ����������",
			SITE_DIR."personal/for_salers/bonus_statistic/",
			Array(),
			Array(),
			""
		),
		Array(
			"������������ ������", 
			"/personal/", 
			Array(), 
			Array(), 
			"" 
		)
	);
}
?>