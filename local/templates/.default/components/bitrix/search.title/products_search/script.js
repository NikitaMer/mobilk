$(document).ready(function(){
	// ��� ����� �� ��������� ����������� ������ ��������� �������� ������ �������, � ID ��������� � ����� product
	$(".title-search-result").on("click", ".product_popup li", function() {
		var product_link = $(this).children();
		// �������� �� ������ <b>, �������� ������� �������� ���������� � ����
		$("#title-search-input").val(product_link.text().replace(/(<([^>]+)>)|(\t)/ig,""));
		$("input[name='PROPERTY[127][0]']").val(product_link.data("item-id"));
	})
})