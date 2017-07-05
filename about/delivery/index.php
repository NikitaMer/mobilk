<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��������");
?><h1>��������</h1>
 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"personal",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"COMPONENT_TEMPLATE" => "personal",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(),
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "about",
		"USE_EXT" => "N"
	)
);?>
<div class="global-block-container">
	<div class="global-content-block">
		<h3 class="bold">�������� �� ������ � ���������� �������</h3>
		<p>
			�������� �� ������ � ������� ������������ ������ ����������� ���������� ������, � ����� � ������� ��������� ����� ��������.
		</p>
		<h3 class="bold">��������� ��������</h3>
		<p>
		</p>
		<table border="1" style="border: solid; text-align: center;">
		<tbody>
		<tr>
			<td style="width: 120px;">
				��������
			</td>
			<td style="width: 100px;">
				�� 999 ���.
			</td>
			<td style="width: 110px;">
				�� 1000 �� 4999 ���.
			</td>
			<td style="width: 110px;">
				�� 5000 �� 9999 ���.
			</td>
			<td style="width: 110px;">
				�� 10000 �� 19999 ���.
			</td>
			<td style="width: 110px;">
				�� 20000 �� 49999 ���.
			</td>
			<td style="width: 110px;">
				�� 50000 ���.
			</td>
		</tr>
		<tr>
			<td>
				������ � �������� ����
			</td>
			<td rowspan="6">
				��������<br>
				 �� ������������
			</td>
			<td rowspan="4">
				�� ������������&nbsp;
			</td>
			<td>
				300 ���.
			</td>
			<td colspan="3" style="font-weight: bold; color: red;">
				���������
			</td>
		</tr>
		<tr>
			<td>
				�� 20 �� �� ����
			</td>
			<td>
				300 ���. + 250 ���./10 ��
			</td>
			<td>
				250 ���./10 ��
			</td>
			<td rowspan="2" colspan="2">
				250 ���./10 ��
			</td>
		</tr>
		<tr>
			<td>
				21 - 50 �� �� ����
			</td>
			<td rowspan="2" colspan="2">
				�� ������������&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				51 - 100 �� �� ����
			</td>
			<td>
				�� ������������&nbsp;
			</td>
			<td>
				250 ���./10 �� (�� ������������)*
			</td>
		</tr>
		<tr>
			<td>
				� ������������ �������� � ������
			</td>
			<td>
				500 ���.
			</td>
			<td>
				300 ���.
			</td>
			<td colspan="3" style="font-weight: bold; color: red;">
				���������
			</td>
		</tr>
		<tr>
			<td>
				�������� ������ ������
			</td>
			<td colspan="5">
				500 �. (������ ��� ������� ������ �� 3 �� � ���������� �� 40�25�35��)
			</td>
		</tr>
		</tbody>
		</table>
		<p>
		</p>
		<h3 class="bold">����� � ����� ��������</h3>
		<ul>
			<li>�������� �������������� 7 ���� � ������ (� �.�. � �������� � ����������� ���).</li>
			<li>���� �������� ������� �� ������� ������ �� �������, � ����� ������ ���������� � ����������, ��� �������, �� 1 �� 3 ������� ����.</li>
			<li>�� ������ � �������� ���� ����� ������� �������� ��������: � 9:00 �� 16:00 ��� � 16:00 �� 23:00.</li>
			<li>�� ���������� ������� �������� ���������� �� ������ �������� ��� � 14:00 �� 23:00. ����� �������� ����� ���� ��������� � ����������� �� ����������� �� ����.</li>
			<li>����� ��� ������ �� ������ ������� ����� ������ �������������� ��������� �������� �������� (������� � 9.00). � ���� ������ ������ �������� ����������� ������ ���� ���������. ����������� �������� � �������������� �������� �������������� ����� � ���� ��������.</li>
			<li>����� � ���� �������� � ���� �������� ��������� ������������� ������, ���������� ���������� �� ��������. �� ��� �� �������� � ���� �������� ��� ��������.</li>
		</ul>
		<h3 class="bold">������� �������� � ���� ������</h3>
		<ul>
			<li>��� ������� ������ �� ������ � �. ������ � ������� ���������� �������������� �������� ������� �������� � ���� ������.</li>
			<li>��������� ������: ����������� ��������� �������� + 500 ���.</li>
			<li>��������! ������� �������� �� �������� ��������������� �������.</li>
		</ul>
	</div>
	<div class="global-information-block">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	".default",
	Array(
		"AREA_FILE_RECURSIVE" => "Y",
		"AREA_FILE_SHOW" => "sect",
		"AREA_FILE_SUFFIX" => "information_block",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => ""
	)
);?>
	</div>
</div>
<br>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>