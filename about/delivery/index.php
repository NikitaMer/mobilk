<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��������");
?><h1>��������</h1>
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"personal", 
	array(
		"COMPONENT_TEMPLATE" => "personal",
		"ROOT_MENU_TYPE" => "about",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
<div class="global-block-container">
	<div class="global-content-block">
		��������-������� ��������� �������� ������ ������ ����� ����������� ������� ��������.
		<h3 class="bold">��������� �������� ��������</h3>
		<p>��������� �������� ������ �� ������ �������� - 500 ���, ��� ������� ������ ��� ������ ������ � �������� ������� �������� ����� ��������.</p>
		<h3 class="bold">����� ��������</h3>
		<p>����� �������� ��������������� � ���������� ������ ��������, ������� ����������� �������� � ���� ����� ����� ����, ��� �� ���������� ���� �����. </p>
		<p><b>��������!</b> ����������� ��������� ����� ��������, �������� ��� �������� ����� ����� �������� � �������������� ��������! ����������, ����������� ���������� ���� ������������ ������ ��� ����������� � ���������� ������.������������������ ����� ��������������� ������ �������������.</p>
		<p>�������� ����������� ��������� � 10:00 �� 20:00 �����, � ������� � 10:00 �� 14:00, � ����������� �������� ���. ������, ���������� ���� � ������� � �����������, ������������ � �����������. ����� ������������� �������� ������� �� ������� ���������� ������ � ������� ������ �� ������:</p>
		<ul>
		  <li>���� ����� ����������� ���������� ������ �������� �� 12:00, ����� ����� ���� ��������� �� ��������� ������� ���� ����� 10:00 � 15:00 ��� ����� 15:00 � 20:00;</li>

		  <li>���� ����� ����������� ���������� ������ �������� ����� 12:00, ����� ����� ���� ��������� �� ��������� ������� ���� ����� 15:00 � 18:00.</li>
		 </ul>
		<p>�� ����� ������ ������� ����� ������ ������� ����� ��������, � ������� ����� ���������� � ������� ��� �����. ���� ����� ��������, � ����� ����� �������� � ���������� ������ ������� ������������ �� �������������� � ��������.</p>
		<h3 class="bold">����� ��������</h3>
		<p>�������� �������������� �� ������, ���������� ��� ���������� ������. ���� ���������� ��������� ����� �� ����� ������, ���������� �������� ����� ��������� ������ ��������, ������� �������� � ���� ��������������� ����� ���������� ������ �� �����.</p>
		<h3 class="bold">�������</h3>
		<p>��� �������� ��� ����� �������� ��� ����������� ��������� �� �������: ��������, �������� ����, � ����� ����������� �����.��� ���������� ������� �� �����������, ��� ����� �������� ����-�������, � ����� ���������, � ������� ���������� ��������� ������ ����� �����������.����, ��������� � ���������� ��� �������� ����������, �������� �������������, ������ �� �������� ������ ������������� ����.��������� �������� ���������� � ���������� �� ������� ��������� ������.</p>
		<p><b>��������!</b> ������ ��� �������, ��� ��� ����������� ��������� � ��������������� �������� �������������� ������ ��� ������� �������� � ������ ��������� �� ������� ������� ������. � ����������� ���������� ������ �������� �� ������ ������������� ������������ � ������������ ������������ ��������������� ������� ������. ��� ������������� ����������� �������������� � ����� �������� ������ ��� ���������� �������� �� ���� ������ ���������.��� �������� ��� ����������� ������ ���������� ������������� ������������� ������, ����������������� ������, ������������ ������������� ������ �������� �� ����� �����, ����� ��������� ����� �� ������� ������������ �����������. ��� �� ��������� ���� ��� ��������� ������ ��������� �� ������ ������������ �����������, � ���������� �������� ��������� �� ���������������. � ������ ��������, ��������� � ��������� ����������� � ��� �� ��������� �����������:</p>
		<p><b>������ ��������</b>: +7 (800) 900-00-00 (��������������).</p>
		<p><b>����������� �����</b>: <a href="mailto:sale@magazine.ru">sale@magazine.ru</a></p>
		<p><b>Skype</b>: <a href="skype:shipping.example.ru">shipping.example.ru</a></p>
	</div>
	<div class="global-information-block">
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include", 
			".default", 
			array(
				"COMPONENT_TEMPLATE" => ".default",
				"AREA_FILE_SHOW" => "sect",
				"AREA_FILE_SUFFIX" => "information_block",
				"AREA_FILE_RECURSIVE" => "Y",
				"EDIT_TEMPLATE" => ""
			),
			false
		);?>
	</div>
</div><br /><br />
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>