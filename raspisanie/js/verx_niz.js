$(document).ready(function(){
//Обработка нажатия на кнопку "Вверх"
$("#up").click(function(){
//Необходимо прокрутить в начало страницы
$("body,html").animate({"scrollTop":0},600);
});

//Обработка нажатия на кнопку "Вниз"
$("#down").click(function(){
$('html, body').animate({scrollTop:$(document).height()}, 600);
});
});
