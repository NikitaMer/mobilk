$(document).ready(function(){
	// ��� ����� �� ���� � ���������� ��������� ������� ����������� ���������
	$(".date-range input").on("click", function() {
		$(this).next("img").click();
	})
})