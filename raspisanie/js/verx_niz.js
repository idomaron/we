$(document).ready(function(){
//��������� ������� �� ������ "�����"
$("#up").click(function(){
//���������� ���������� � ������ ��������
$("body,html").animate({"scrollTop":0},600);
});

//��������� ������� �� ������ "����"
$("#down").click(function(){
$('html, body').animate({scrollTop:$(document).height()}, 600);
});
});
