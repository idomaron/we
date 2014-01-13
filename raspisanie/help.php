<?php
include "config.php";?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Хелпник</title>
<link rel="stylesheet" href="css/jquery-ui-1.8.14.custom.css" type="text/css" />
<link rel="stylesheet" href="css/jquery.ui.timepicker.css" type="text/css" />

<link id="screenstyle" rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.tooltip.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.timepicker.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/verx_niz.js"></script>

<!-- Time __________________________________________________________________________________-->
<script type="text/javascript">
	function view_time(id) {
			$('#show_time'+id).timepicker({
				showNowButton: true,
				showDeselectButton: true,
				defaultTime: '',  // removes the highlighted time for when the input is empty.
				showCloseButton: true
			});
		}
	</script>
			<!-- Время второе -->
			<script type="text/javascript">
		function view_time_end(id) {

			$('#show_time_end'+id).timepicker({
				showNowButton: true,
				showDeselectButton: true,
				defaultTime: '',  // removes the highlighted time for when the input is empty.
				showCloseButton: true
			});
		}
	</script>
<!-- Time end_______________________________________________________________________________-->


<!-- Reset okna -->
<script type="text/javascript">
function reset()
{
$('.reset').val('');
$(".reset :contains('класс')").attr("selected", "selected");
$(".reset :contains('День')").attr("selected", "selected");
}
</script>

<!--Color-->
<script type="text/javascript" src="js/color.js"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
$('#demo').hide();
$('#picker').farbtastic('#color');
});
</script>

<!-- Переадресовка для SELECT chto-->
<script type="text/javascript">
$(document).ready(function(){

$('#chto').change(function() {
prefix=$("#chto option:selected").val();
$.getJSON('onclick.php',  {prefix_json: prefix},
function(data) {
		if (data)  {

//Color
$('#color').val(data.color);
var f = $.farbtastic('#picker');
$('#color')
  .each(function () { f.linkTo(this);})
  .focus(function() {
	f.linkTo(this);
});

if (data.color=='') alert ('0');//Для косяков, если в БД по умолчанию пустота
if (data.bold=='on') {$('#bold').attr('checked','checked');} else {$('#bold').attr('checked','');}
if (data.italic=='on') {$('#italic').attr('checked','checked');} else {$('#italic').attr('checked','');}
$('#font [value="'+data.font+'"]').attr("selected", "selected");
		}
	});
});
});
</script>


<style>
p {font-size:26px;}
img {
border-width: 5px;
border-color: #000;
border-style: inset;
}

.procent{
width:100%;
position:absolute;
}
 
.procent50{
width:50%;
}


.farbtastic {
position: relative;
left: 0px;
top: 0px;
}
.farbtastic * {
position: absolute;
cursor: crosshair;
}
.farbtastic, .farbtastic .wheel {
width: 195px;
height: 195px;
}

.farbtastic .color, .farbtastic .overlay {
top: 47px;/*Kvadrat niz*/
left: 47px;/*Kvadrat levo*/
width: 101px;
height: 101px;
}
/*Krug*/
.farbtastic .wheel {
background: url(images/wheel.png) no-repeat;
width: 195px;
height: 195px;
}
.farbtastic .overlay {
background: url(images/mask.png) no-repeat;
}
.farbtastic .marker {
width: 17px;
height: 17px;
margin: -8px 0 0 -8px;
overflow: hidden; 
background: url(images/marker.png) no-repeat;
}
a:link {font-size:16px;} 
</style>
</head>

<body>


<fieldset style="border: 2px solid #000000;">
<center><h1>Содержание</h1></center>
<table border="2" width="100%">
	<tr>
		<td>
			<a href="#obsh"><b>Общая таблица</b></a>
		</td>
		<td>
			<a href="#pravo"><b>Кнопка справа</b></a>
		</td>
		<td>
			<a href="#verx"><b>Верхнее меню</b></a>
		</td>
		<td>
			<a href="#prepod"><b>Преподаватели</b></a>
		</td>
		<td>
			<a href="#kabinet"><b>Кабинеты</b></a>
		</td>
		<td>
			<a href="#predmet"><b>Предметы</b></a>
		</td>
		<td>
			<a href="#dop_tabl"><b>Карта классов</b></a>
		</td>
		<td>
			<a href="#klass_dop"><b>Дополнительные классы</b></a>
		</td>
		<td>
			<a href="#gruppa"><b>Группы</b></a>
		</td>
		<td>
			<a href="#polezn"><b>Полезности</b></a>
		</td>
		<td>
			<a href="#yacheyka"><b>Ячейка</b></a>
		</td>
		<td>
			<a href="#site"><b>Сайты</b></a>
		</td>
	</tr>
</table>
</fieldset>

<br><br><br>
<fieldset style="border: 2px solid #000000;">
<legend>Общее</legend>
<a href="#prepod"> <img src="images/prepod.png" width=30px style="border-width:0px;">Препод</a>
&nbsp;&nbsp;&nbsp;
<a href="#kabinet"><img src="images/kabinet.png" width=30px style="border-width:0px;">Кабинет</a>
&nbsp;&nbsp;&nbsp;
<a href="#predmet"><img src="images/predmet.png" width=30px style="border-width:0px;">Предмет</a>
&nbsp;&nbsp;&nbsp;
<center><a href="table.php"><h4>К большой таблице</h4></a></center>
&#8593;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8593;
<br>
Почти в каждой странице есть удобные кнопки быстрого перемещения к редактированию преподов, кабинетов или предметов. "К большой таблице" - возвращает нас назад к общей таблице со всеми группами.
<br><br><br>
Значки, встречающиеся на каждой странице
<br>
<img src="images/reload.png" width=40px style="border-width:0px;" >
- Обновить данную страницу
<br>
<img src="images/new_str.png" width=40px style="border-width:0px;">
- Добавить новую строку
<br><br>
Знак ▼ или ▲ сортирует таблицу по выбранному столбцу. Знаки выводятся при наведении курсора на название столбца. В Преподавателях, Кабинетах и Предметах.
<br><br>
Удалить базу данных можно сочетанием клавиш "ctrl+~"  &nbsp;&nbsp;&nbsp;    ~ это где Ё.
<br>
Очистить базу данных можно сочетанием клавиш "ctrl+*"  &nbsp;&nbsp;&nbsp;    * на правой клавиатуре (Numpad).
<br><br>
Внимание, при нажатии на картинку в этой странице, она увеличивается на весь экран. Обратно уменьшается при повторном нажатии.
</fieldset>
<br><br>


<a name=obsh></a>
<br><br>
<hr noshade size="5">
<center><h2><b>Общая таблица</b></h2></center>

<p>В ней отображаются все группы по заданной очереди. При обновлении страницы выводится полоса загрузки.
<br>
Отдельно в каждую группу можно зайти, нажав на её название.</p>
<p><img src="images/vso.png" style="border-width:0px;width:50px;"> - Вывести все таблицы по щелчку</p><br>
<img src="images/help/01_tabl.png" width="50%" onclick="$(this).toggleClass('procent');" >
<br><br>
<div>
<img src="images/help/10_prav_knopka.jpg" style="border-width:0px;width:234px;" hspace="5" onclick="$(this).toggleClass('procent');" align=left>
<p><b>Меню на правую кнопку</b> - Появляется при нажатии правой кнопки мыши на любой из ячеек таблицы.
<br>
<img src="images/edit.png" style="border-width:0px;width:30px; ">
<b>Редактировать</b> - открывает ячейку в этом же окне для последующего редактирования.

<br>
<img src="images/copy.png" style="border-width:0px;width:30px; ">
<b>Копировать</b> - Копирует выделенную ячейку. Вставлять копируемое можно хоть сколько раз. Держится в памяти, до следующего копирования или до нажатия любой из других кнопок.

<br>
<img src="images/cut.png" style="border-width:0px;width:30px; ">
<b>Вырезать</b> - Вырезает содержимое ячейки. Вставлять вырезаемое можно хоть сколько раз. Держится в памяти, до следующего вырезания или до нажатия любой из других кнопок.

<br>
<img src="images/paste.png" style="border-width:0px;width:30px; ">
<b>Вставить</b> - Вставляет вырезанное или скопированное содержимое ячейки. Можно вырезать или скопировать содержимое определённой ячейки в одной группе, потом перейти в другую группу и вставить туда.

<br>
<img src="images/delete.png" style="border-width:0px;width:30px; ">
<b>Очистить</b> - Удаляет безвозвратно содержимое ячейки.
<br><br>
В большой общей таблице все пять кнопок действуют между группами также как и в отдельных группах.
<br>
<img src="images/ochist.png" style="border-width:0px;width:30px;"> - Кнопка в левом углу таблицы. Удаляет безвозвратно все данные из выбранной таблицы.
<br>
<img src="images/grafik.png" style="border-width:0px;width:40px;"> - Поворачивает таблицу наоборот. Дни и классы меняются местами.
</p>
</div>

<a name=pravo></a>
<br><br>
<hr noshade size="5">
<center><h2>Кнопка справа</h2></center>
<p>Нужна для печати, экспорта базы данных в Excel, сохранения и восстановления базы данных </p>

<img src="images/help/02_pravo.jpg" width="50%" onclick="$(this).toggleClass('procent');">
<br><br>


<img src="images/print_vers.png" width=50px style="border-width:0px;" align=left>
<p>
- Версия для печати. При нажатии меняется стиль страницы, все лишние элементы убираются, оставляя только расписание и две кнопки.
<img src="images/back.png" width=40px style="border-width:0px;">
, чтоб вернуться к обычному виду. И  
<img src="images/print.png" width=40px style="border-width:0px;">
- вывод на печать
</p>
<hr noshade size="2">

<img src="images/print.png" width=50px style="border-width:0px;" align=left>
<p>
- Печать документа сразу при нажатии
</p>
<hr noshade size="2">

<img src="images/excel.png" width=50px style="border-width:0px;" align=left>
<p>
- Экспорт в Excel (по умолчанию сохраняет в папку загрузок браузера). Если в Excel проблема с импортом цвета, то нажмите в нём "Сервис"->"Параметры"->"Цвет"->"Сброс".
</p>
<hr noshade size="2">

<img src="images/save.png" width=50px style="border-width:0px;" align=left>
<p>
- Сохранить базу данных. Выводится диалоговое окно. 
<img src="images/help/03_dumper.jpg" width=100px style="border-width:0px;"  onclick="$(this).toggleClass('procent50');">
Если поставить точку на верхней половине, то можно настроить сохранение БД. Можно сжимать, можно не сжимать. По умолчанию хранится 4 последних копии баз данных.
<br>
В нижней половине идёт восстановление БД из ранее-сохранённых копий.
</p>
<hr noshade size="2">

<img src="images/pomosh.png" width=50px style="border-width:0px;" align=left>
<p>
- Включить отображение подсказок. (Подсказки отключаются после перезагрузки страницы)
</p>
<hr noshade size="2">

<img src="images/help.png" width=50px style="border-width:0px;" align=left>
<p>
- Открыть файл помощи
</p>
<hr noshade size="2">

<p>
<b>Группы</b> - Выводится список групп. При выборе группы сразу перескакиваем на страницу этой группы.
</p>
<hr noshade size="2">

<p><input type="submit" value="Все_таблицы"> - Вывести все таблицы при нажатии</p>
<hr noshade size="2">
<br>


<a name=verx></a>
<br><br>
<hr noshade size="5">
<center><h2>Верхнее меню</h2></center>
<p>При движении мышки к верхнему краю экрана выводится <b>главное меню.</b>
Закрывается меню щелчком по любой области экрана вне меню.<br>
Наведи курсор на надпись или кнопку внизу, чтобы увидеть описание
</p>
<br>



<table border="1" >
		<tr>
			<td  title="Редактировать выбранное.">
				<b>Редактировать</center></b>
			</td>
			<td title="Дополнительные ссылки">
				<b><center>Дополнительно</center></b>
			</td>
			<td title="После выбора галочки жми 'Жать'. Всё автоматически заносится в память базы данных">
				<b><center>Галочки
			</center></b>
			</td>
			<td title="Если хочешь найти строчку в ячейке по определённому критерию, просто выбери один или несколько критериев и жми 'Искать'">
				<b><center>Сортировка<br>Поиск</center></b>
			</td>
			<td title="Как будет отображаться строчка в ячейках. Какой цвет, шрифт и т.д. Для каждого наименования всё настраивается отдельно. Наименование выбирается в 'Что?'">
				<b><center>Стиль в ячейках</center></b>
			</td>
			<td title="Поиск и показ ошибок. Ошибки, это когда пересекается время в один день во всех группах. Если выбрана одна группа, то ошибки ищутся только в ней. Если в каких то строчках разрешены ошибки, то высвечивается специальный знак  <img src=images/full.png style=border-width:0px;width:20px;>">
				<b><center>Ошибки</center></b>
			</td>
			<td >
				<label title="Вывод окон между ячейками. Окна отображаются пока включена галочка. Часы и минуты вводятся отдельно. Допустим в часы вводим '2', в минуты '25', то есть будет искать окна, промежутком в 2 часа 25 минут."><b><center>ОКНА
				</center></b></label><img src="images/ochist.png" width="30px" style="cursor:pointer;border-width:0px;" title="Сбросить дни и классы" align=right>
			</td>
		</tr>
		<tr>
		<td>
			<a href="prepod_redact.php" title="Редактировать преподавателей"> <img src="images/prepod.png" width=40px style="border-width:0px;"><br>Препод</a><br><br>
			<a href="kabinet_redact.php" title="Редактировать кабинеты"><img src="images/kabinet.png" width=40px style="border-width:0px;"><br>Кабинет</a><br><br>
			<a href="predmet_redact.php" title="Редактировать предметы"><img src="images/predmet.png" width=40px style="border-width:0px;"><br>Предмет</a>
		</td>
		<td>
			<a href="gruppa.php" title="Редактировать группы">Группы</a><br><br>
			<a href="magistr.php" title="Открыть таблицу с дополнительными классами">Дополнительные классы</a><br><br>
			<a href="dop_tabl.php" title="Карта классов, в которой между парами ставится стрелка">Карта классов</a><br><br>
			<a href="polezn.php" title="Настройка полезных мелочей">Настройка полезностей</a>
		</td>
		<!--Вывести только выбранное -->
			<td nowrap align=left>
				<table>
					<tr>
						<td >
							<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''"  title="Отображать сокращённые предметы, когда стоит галочка"><input type=checkbox name=predmet_sokrat >Сокращ.предмет</label>
						</td>
					</tr>
					<tr>
						<td>
							<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Отображать сокращённые имена и фамилии преподавателей, когда стоит галочка"><input type=checkbox name=fio_sokrat >Сокращ.(ФИО)</label>
						</td>
					</tr>
					<tr>
						<td>
							<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Отображать информацию, введённую в строку 'Дополнительно'"><input type="checkbox" name=dop >Доп-но</label>
						</td>
					</tr>
					<tr>
						<td>
							<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Выделить важные строки. Строки отмечаются при редактировании ячейки в столбце 'Выбрать'. Цвет можно поменять в файле function_table.php в 161 строке."><input type="checkbox" name=dop >Выделить</label>
						</td>
					</tr>
					<tr>
						<td>
							<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Сбрасывает все цвета и размеры шрифта в ячейках. Удобно для печати. Если галочка не нажата, то стили отображаются как обычно."><input type=checkbox name=pechat >Сброс стилей</label>
						</td>
					</tr>
					<tr>
						<td>
							<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title=" Строки в ячейках отображаются во всю длину"><input type=checkbox name=nowrap_check >Без переноса строк</label>
						</td>
					</tr>
					<tr>
						<td>
							<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Показать/скрыть дополнительные классы. Показывается в конце таблицы."><input type=checkbox name=mag >Дополнительные классы</label>
						</td>
					</tr>
				</table>

				<br>
				<input type="submit" value=Жать name=vibor2 id=but title="Подтвердить">
			</td>



		<td align=left>

			
			<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Выделить цветом выбранное из нижнего. Если галочка не стоит, то в таблице показывается только выбранное, остальное не показывается."><input type=checkbox name="videl" >Просто выделить</label>
			<br><br>
				<!-- Начало занятия -->
				<input type="text" style="width: 70px" id="show_time1233" onmouseover="view_time(1233),yacheyka_time(1233);" name=change_vr_nach placeholder="Врем.нач." title="Поиск по времени начала пары">
				
				<!-- Конец занятия -->
				<input type="text" style="width: 70px" id="show_time_end2341" onmouseover="view_time_end(2341),yacheyka_time_end(2341);" name=change_vr_end placeholder="Врем.кон."  title="Поиск по времени конца пары">
				<br><br>
				<!-- Предмет -->
				<select name="change_predmet" style="width: 100px" title="Найти выбранный предмет">
					<option disabled selected class=opt>Предмет</option>
					<?php 
					$result89=mysql_query("SELECT * FROM predmet ORDER BY nazvanie");
					while($row89=mysql_fetch_array($result89))
					{?>
					<option value="<?=$row89['id_p']?>">
					<?=$row89['nazvanie']?></option>
					<?}?>
				</select>

				<!-- Кабинет -->
				<select name="change_kabinet" title="Найти выбранный кабинет">
					<option disabled selected class=opt>Каб.</option>
					<?php $result89=mysql_query("SELECT * FROM kabinet");
					while($row89=mysql_fetch_array($result89))
					{?>
					<option value="<?=$row89['id_k']?>"><?=$row89['nomer']?></option>
					<? }?>
				</select>

				<!-- Преподаватель -->
				<select name="change_prepod" style="width:100px" title="Найти выбранного преподавателя">
					<option disabled selected class=opt>Препод</option>
						<?php $result89=mysql_query("SELECT * FROM prepod ORDER by fio");
					while($row89=mysql_fetch_array($result89))
					{?>
					<option value="<?=$row89['id_pp']?>"><?=$row89['fio']?></option>
					<? }?>
				</select>
				<br><br>
				<input type="submit"  id=but2 style=visibility:visible name="change" value=Искать>
		</td>

		<td nowrap align=left width="150px">
				<select name="chto" id="chto" style="width:100px" title="Выбрать, что редактировать в ячейке">
					<option disabled selected>Что?</option>
					<option value="vr_nach" <?echo ($chto=='vr_nach')?'selected':'';?>>Начало пары</option>
					<option value="vr_end"  <?echo ($chto=='vr_end')?'selected':'';?>>Конец пары</option>
					<option value="predmet" <?echo ($chto=='predmet')?'selected':'';?>>Предмет</option>
					<option value="kabinet" <?echo ($chto=='kabinet')?'selected':'';?>>Кабинет</option>
					<option value="prepod"  <?echo ($chto=='prepod')?'selected':'';?>>Преподаватель</option>
				</select>
				<br>
				<div id="empty">&nbsp;</div>

				<!--Цвет -->
				<div class="form-item" title="Выбрать цвет"><label for="color"></label>
				<input type="text" id="color" name="color" value="<?=$color?>" onclick="$('#picker').show(300);" placeholder="Цвет" style="width:100px" />
				</div>
				<div id="picker" style="display:none" ondblclick="$(this).hide(300);" title="Нажми два раза, когда выберешь. Нажимай один раз или просто зажми и веди, чтобы выбрать цвет"></div>
				<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''"><input type=checkbox name="italic" <?=$italic?> id=italic><i>Наклонный</i></label>
				<br><br>
				<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''"><input type=checkbox name="bold" <?=$bold?> id=bold ><b>Жирный</b></label>
				<br><br>
				
				<select name="font" style="width:100px" id=font title="Размер текста в ячейке">
					<option class=opt>Размер текста</option>
					<option value=1 <?echo ($font==1)?'selected':'';?>>1</option>
					<option value=2 <?echo ($font==2)?'selected':'';?>>2</option>
					<option value=3 <?echo ($font==3)?'selected':'';?>>3</option>
					<option value=4 <?echo ($font==4)?'selected':'';?>>4</option>
					<option value=5 <?echo ($font==5)?'selected':'';?>>5</option>
					<option value=6 <?echo ($font==6)?'selected':'';?>>6</option>
					<option value=7 <?echo ($font==7)?'selected':'';?>>7</option>
				</select>
				<br>
				<input type="submit" value=Жать id=but4 name=vibor3 title="Подтверждение для каждого выбранного из 'Что?' в отдельности">
		</td>

		<td align=left>
			
			<!--Пересечение времени-->
			<input type="submit"  name=peresek name=peresek id=but3 value="Пересечение в ячейке" title="Показать линию между строками, если эти строки пересекаются по времени в один день и в одном классе.">
			<br>
		<fieldset style="border: 2px solid #000000;">
			<label onmouseover="this.style.backgroundColor='#fcfcc9'" onmouseout="this.style.backgroundColor='#ffffff'" title="Поиск пересечения в один день только по кабинетам">Кабинет<input type="radio"  name=radio value=peresek_kabinet></label>
			<br>
			<label onmouseover="this.style.backgroundColor='#fcfcc9'" onmouseout="this.style.backgroundColor='#ffffff'" title="Поиск пересечения в один день только по преподавателям">&nbsp;&nbsp;Препод<input type="radio"  name=radio value=peresek_prepod></label>
			<table>
				<tr>
					<td nowrap>
						<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Нарисовать для наглядности линии пересечения"><input type=checkbox name=line_view>Рис. линии?</label>
					</td>
				</tr>
				<tr>
					<td nowrap>
						<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Открыть в новом окне отчёт по ошибкам. В нём можно перейти на страницу, в которой присутствует ошибка"><input type="checkbox"  name=peresek_check>Вывести отчёт?</label>
					</td>
				</tr>
			</table>
			<br>
			<input type="submit" name=peresek_dni value="Пересечение дней" title="Жми для поиска ошибок">
		</fieldset>
		</td>

		<td align=left>
		
		<!-- Селектор дней-->
		<select name=okno_den style="width:100px" class=reset title="Показать окна в определённый день">
			<option class=opt disabled selected>День</option>
			<option value=1 <?if ($okno_den==1) echo 'selected';?>>Понедельник</option>
			<option value=2 <?if ($okno_den==2) echo 'selected';?>>Вторник</option>
			<option value=3 <?if ($okno_den==3) echo 'selected';?>>Среда</option>
			<option value=4 <?if ($okno_den==4) echo 'selected';?>>Четверг</option>
			<option value=5 <?if ($okno_den==5) echo 'selected';?>>Пятница</option>
			<option value=6 <?if ($okno_den==6) echo 'selected';?>>Суббота</option>
		</select>

			<!-- Селектор классов-->
			<select name=okno_kurs class=reset  style="width:100px" title="Показать окна определённого класса">
			
				<option class=opt disabled selected>Классы</option>
				<?
				$result=mysql_query("SELECT * FROM klass ORDER by ochered");
				while($row=mysql_fetch_array($result))
				{extract ($row);
				?>
				<option value="<?=$ochered?>" <?if ($okno_kurs==$ochered) echo 'selected';?>><?=$nazvanie?></option>
				<?}?>
			</select>
		<br>
		<input type=text value="<?=$okno_chas?>" name=okno_chas placeholder="Часы" class=reset  style="width:100px" title="Введите количество часов для окна (Промежуток между парами)">
		<input type=text value="<?=$okno_min?>" name=okno_min placeholder="Минуты" class=reset  style="width:100px" title="Введите количество минут для окна">
		<br>
		<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Включить отображение окон (Действует всегда, пока стоит галочка)"><input type=checkbox name=okno_check <?=$okno_check?> id=okno_check >Окна</label>
		<br><br>
		<input type=submit value=Жать>
		</td>
		</tr>
	</table>
	<br>
	<p>Пример отчёта после проверки на ошибки</p>
<table id=uuu width="1000px" border=2px><tr>
    <td><b> Фамилия И.О. </b></td>
    <td><b> День </b></td>
    <td><b> Буква </b></td>

    <td><b> Время </b></td>
    <td><b> Класс </b></td>
    <td><b> Кабинет</b></td>
    <td></td>
    <td><b> Кабинет</b></td>

    <td><b> Буква </b></td>
    <td><b> Время </b></td>
	<td><b> Класс </b></td>
	<tr>
	<tr><td nowrap><b>Иванова Ю.В.</b></td><td nowrap>Четверг</td><td nowrap>Б</td><td nowrap>12:00-13:35</td><td nowrap>4й класс</td><td>102</td><td bgcolor=#fed2d2 nowrap><img src=images/aleft.png width=40px style=border-width:0px>Пересеклись с<img src=images/aright.png width=40px style=border-width:0px></td><td></td><td nowrap>В</td><td nowrap>07:00-22:00</td><td nowrap>1м класс</td><div class=redact>4Иванова Ю.В.</div></tr><tr><td nowrap><b>Петров П.П.</b></td><td nowrap>Среда</td><td nowrap>Б</td><td nowrap>13:00-14:35</td><td nowrap>2й класс</td><td>101</td><td bgcolor=#fed2d2 nowrap><img src=images/aleft.png width=40px style=border-width:0px>Пересеклись с<img src=images/aright.png width=40px style=border-width:0px></td><td>103</td><td nowrap>А</td><td nowrap>13:00-15:00</td><td nowrap>Подготовишка 1</td><div class=redact>3Петров П.П.</div></tr><tr><td nowrap><b>Петров П.П.</b></td><td nowrap>Четверг</td><td nowrap>В</td><td nowrap>13:00-14:35</td><td nowrap>1й класс</td><td>101</td><td bgcolor=#fed2d2 nowrap><img src=images/aleft.png width=40px style=border-width:0px>Пересеклись с<img src=images/aright.png width=40px style=border-width:0px></td><td>102</td><td nowrap>Б</td><td nowrap>12:00-13:35</td><td nowrap>4м класс</td><div class=redact>4Петров П.П.</div></tr></table>

	<br>
	<p>
	<img src="images/aleft.png" style=border-width:0px width=40px><img src="images/aright.png" style=border-width:0px width=40px>
	Эти стрелки - ссылки, нажимая на которые вы переходите на страницу с ячейкой, в которой ошибка. Страница открывается там же, откуда пришёл отчёт.
	</p>
	
	
	
<a name=prepod></a>
<br><br>
<hr noshade size="5">
<center><h2>Преподаватели</h2></center>

<br><br>
<img src="images/help/05_prepod.png" width="50%" onclick="$(this).toggleClass('procent');" >

<p>
Все данные сохраняются автоматически при вводе.
<br>
Изменить название столбца можно нажав два раза на название столбца, затем подтвердив кнопкой <input type=submit value="Сменить названия столбцов">
<br>
<b>Фио</b> - Фамилия имя отчество преподавателя полностью
<br>
<b>Должность</b> - Выбрать должность преподавателя. Редактировать список должностей можно в полезностях щёлкнув по надписи "Должность" два раза, затем по картинке <img src="images/redact.png" width="30px" style="border-width:0px;">
<br>
<b>Ф.И.О.</b> - Фамилия имя отчество преподавателя сокращённые.
<br>
<b>Нагрузка должна быть</b> - Количество часов нагрузки в неделю
<br>
<b>Нагрузка есть</b> - Реальная нагрузка. Считается автоматически по всем дням и всем группам у определённого препода. При наведении курсора на время, высвечивается разница между нагрузкой, которая есть и нагрузкой, которая должна быть.
<br>
<b>Примечание</b> - Можно вписать дополнительную информацию. Либо переименовать столбец под свои нужды, допустим пол или возраст препода.
<br>
<b>Удалить</b> - При нажатии удаляется строка с преподавателем. Также он удаляется автоматически из всех ячеек общей таблицы, где был.
<br>
</p>
<br><br>



<a name=kabinet></a>
<br><br>
<hr noshade size="5">
<center><h2>Кабинеты</h2></center>

<br><br>
<img src="images/help/06_kabinet.png" width="50%" onclick="$(this).toggleClass('procent');" >
<p>
Все данные сохраняются автоматически при вводе.
<br>
Изменить название столбца можно нажав два раза на название столбца, затем подтвердив кнопкой <input type=submit value="Сменить названия столбцов">
<br>
<b>Номер кабинета</b> - Номер или название кабинета
<br>
<b>Вместимость</b> - Можно сменить название на любое.
<br>
<b>Примечание</b> - Можно вписать дополнительную информацию.
<br>
<b>Удалить</b> - При нажатии удаляется строка с этим кабинетом. Также он удаляется автоматически из всех ячеек общей таблицы, где был.
<br>
</p>


<br><br>

<a name=predmet></a>
<br><br>
<hr noshade size="5">
<center><h2>Предметы</h2></center>

<br><br>
<img src="images/help/07_predmet.png" width="50%" onclick="$(this).toggleClass('procent');" >
<p>
Все данные сохраняются автоматически при вводе.
<br>
Изменить название столбца можно нажав два раза на название столбца, затем подтвердив кнопкой <input type=submit value="Сменить названия столбцов">
<br>
<b>Предмет</b> - Название предмета
<br>
<b>Сокращённый</b> - Сокращённое название предмета.
<br>
<b>Примечание</b> - Можно вписать дополнительную информацию.
<br>
<b>Удалить</b> - При нажатии удаляется строка с этим предметом. Также он удаляется автоматически из всех ячеек общей таблицы, где был.
<br>
</p>




<br><br>

<a name=dop_tabl></a>
<br><br>
<hr noshade size="5">
<center><h2>Карта классов</h2></center>

<br><br>
<img src="images/help/08_dop_tabl.png" width="50%" onclick="$(this).toggleClass('procent');" >
<p>

<img src="images/down_black.gif" style="border-width:0px;width:30px"> - Показывает продолжительность занятия
<br>
<select>
<option value=7>Все дни</option>
<option value=1>Понедельник</option>
<option value=2>Вторник</option>
<option value=3>Среда</option>
<option value=4>Четверг</option>
<option value=5>Пятница</option>
<option value=6>Суббота</option>
</select>
- Выбрать день. Если ничего не выбрано, то по умолчанию показываются все дни сверху вниз, начиная с понедельника.
<br>
<label onmouseover="this.style.backgroundColor='#fcfcc9'" onmouseout="this.style.backgroundColor='#ffffff'"><b>Предмет</b><input type=checkbox></label>
- Показывает предмет, если стоит галочка.
<br>
<b>Разделитель</b> - Символы, стоящие между факультетами. По умолчанию |||
<br><br>
Можно перейти в ячейку определённого факультета, нажав на название этого факультета. Ссылка откроется в этом же окне.
<br>
Редактировать названия столбцов можно нажав на название столбца два раза. Удалить или добавить столбец можно нажав кнопку <img src="images/vkl.png" style="border-width:0px;width:30px">, затем в выбранном столбце нажать <input type=submit value=Удал.> или <input type=submit value="Новый столбец">
<br>
Редактировать время начала пары можно просто изменив его значение. Сохраняется автоматически.

</p>



<br><br>



<br><br>

<a name=klass_dop></a>
<br><br>
<hr noshade size="5">
<center><h2>Дополнительные классы</h2></center>

<br><br>
<img src="images/help/13_klass_dop.png" width="50%" onclick="$(this).toggleClass('procent');" >
<p>

В принципе тоже самое, что и общая таблица, только отсортированная по буквам (группам) и выводящая только дополнительные классы.
Редактирование такое же как и в общей таблице.
</p>



<br><br>




<a name=gruppa></a>
<br><br>
<hr noshade size="5">
<center><h2>Группы</h2></center>

<br><br>
<img src="images/help/09_gruppa.png" width="50%" onclick="$(this).toggleClass('procent');" >
<p>
Все данные сохраняются автоматически при вводе.
<br>
<b>Название</b> - Название группы
<br>
<b>Порядк.номер</b> - Порядковый номер. Нужен для очерёдности отображения в списках и в общей таблице
<br>
<b>Сокращ.</b> - Сокращённое название группы
<br>
<b>Удалить</b> - При нажатии удаляется группа. Также удаляются все данные введённые ранее в группу.
<br>
</p>


<br><br>

<a name=polezn></a>
<br><br>
<hr noshade size="5">
<center><h2>Полезности</h2></center>
<br>
<p>
Большая таблица снизу выводит все записи (строки), которые хранятся в базе данных. Повторяющиеся записи немного сгруппированы.
</p>
<br><br>
<img src="images/help/11_polezn.png" width="50%" onclick="$(this).toggleClass('procent');" >
<p>
<img src="images/new_str.png" style="border-width:0px;width:40px">
- добавляет строку в таблицу
<br>
<img src="images/time.png" style="border-width:0px;width:40px">
- Скрыть/показать таблицу редактирования шаблона времени. Шаблон нужен, чтоб удобно было вставлять в ячейку сразу несколько пустых строчек с заданным в шаблоне временем.
<br>
<img src="images/delete.png" style="border-width:0px;width:40px">
- Удаляет из таблицы ("Шаблон времени","Должности","Список классов") строку. А в большой нижней таблице убирает галочку. (Если есть этот знак, значит строка выбрана)
<br>
<img src="images/dolgnost.png" style="border-width:0px;width:40px">
-  Скрыть/показать таблицу редактирования должностей.
<br>
<img src="images/kabinet.png" style="border-width:0px;width:40px">
-  Скрыть/показать таблицу редактирования классов. При нажатии в списке классов на <img src="images/plus2.png" style="border-width:0px;width:40px"> данный класс становится дополнительным, то есть в общей таблице он будет отображаться справа в конце, либо не будет отображаться, если в верхнем меню не стоит галочка "Дополнительные классы". Если стоит значок <img src="images/galka.png" style="border-width:0px;width:40px">, значит класс Дополнительный. При нажатии на этот значок, класс становится обычным.
<br>
<img src="images/smena.png" style="border-width:0px;width:40px">
-  Скрыть/показать таблицу редактирования смены мест. Выбираешь допустим "Предмет1" и "Предмет2", жмёшь "Поменять местами предметы" и в базе данных эти предметы меняются местами. Меняются не полностью строки, а лишь название предмета в данных строках.
<br>
<br>
<input type=submit value=Препод>
<input type=submit value=Кабинет>
<input type=submit value=Предмет>

- Сортируют общую таблицу снизу по нажатой кнопке.

<br>
<img src="images/plus.png" style="border-width:0px;width:40px">
- Отмечает строку. Она добавляется в список, который вызывается в ячейке при нажатии кнопки <img src="images/redact.png" style="border-width:0px;width:30px">
</p>





<a name=yacheyka></a>
<br><br>
<hr noshade size="5">
<center><h2>Ячейка</h2></center>

<br><br>
<img src="images/help/12_yacheyka.png" width="50%" onclick="$(this).toggleClass('procent');" >
<p>
<b>Преподаватель, Кабинет, Предмет</b> - Нажми один раз, выведется список. Выбери в списке нужное, и оно автоматически сохранится.
<br>
<b>Начало пары и конец пары</b> - Выводится табличка для ввода времени. Она закрывается если выбрать час, потом минуту или наоборот. Также можно нажать на час или минуту два раза. 
<br>
<b>Продолжительность</b> - Считается после перезагрузки страницы, а иногда и автоматически при вводе времени.
<br>
<b>Дополнительно</b> - Дополнительная информация. Потом может отображаться в общей таблице, если стоит соответствующая галочка.
<br>
<b>Ошибки разрешены</b> - Если разрешить ошибку определённой строчке, то при проверке на ошибки в таблице эта строчка не бует считаться ошибочной. Высветится специальный символ, что ошибка разрешена.<img src="images/full.png" style="border-width:0px;width:20px;">
<br>
При наведении на название столбца "Ошибки разрешены", появляется надпись "Все:<input type="checkbox"/>" , нажав на которую можно разом поставить или снять галочки со всех строк сразу.
<br>
<b>Объед.</b> - Объединение строчек. Делается, если парные предметы. Жать нужно на нижнюю из двух, тогда между ними будет синяя линия, означающая, что эти две строчки объединены. В таблице между ними появляется символ /// , а если время разное, то такой |||. 
<br>
<b>Выбрать</b> - Впоследствии в общей таблице, (при стоящей галочке в верхнем меню), помечает выбранную строчку цветом. Цвет можно поменять в файле function_table.php в 161 строке.
<br>
<b>Удалить</b> - При нажатии удаляется строка.
<br>
<b>Удалить выбранные</b> - Сначала нужно выбрать, какие мы хотим строки удалить. Те, на которых появится надпись <label style="background:#d1ffdd;width:60px;white-space: nowrap;" >ЭТУ</label>, будут удалены после нажатия на кнопку <input type="submit" value="Удалить &#10; выбранные?">

<br><br>

<b>Настройка полезностей</b> - Вызывается при нажатии на кнопку <img src="images/redact.png" style="border-width:0px;width:40px;">
<br>
<img src="images/move.png" style="border-width:0px;width:50px;"> - После нажатия можно перетаскивать ячейки мышкой. Полезно если идут подряд допустим три пары с одним временем и нужно их выставить в определённом порядке.
<br>
<input value="Время" type=submit> - Кнопка, после нажатия которой выводится шаблон пустых строчек с заданным временем. Шаблон меняется в "Настройках полезностей".
<br>
<input value="Плюсики" type=submit> - После нажатия в ячейках появляются плюсы, которые отображаютсяя при наведении на Преподавателя, Кабинет, Предмет в определённой строке. При нажатии на плюс, который находится в пустой строке под нужной строкой, информация из нужной копируется в пустую. Копируется не вся строка, а именно то, что мы выбрали, допустим только кабинет №200. 
<br>
<b>Шаблонный список</b> - При выборе строчки из списка в таблицу запишется эта строчка. С первого раза может не пройти, там косяк какой-то, нужно обновить страницу. Список редактируется в "Настройках полезностей". Удобный настраиваемый список, облегчающий впоследствие работу с повторяющимися сочетаниями Преподов, Кабинетов и Предметов, а также времени и информации в "Дополнительно". 
</p>

<br>
<hr noshade size="5">
<br><br>


<a name=site></a>
<br><br>
<hr noshade size="5">
<center><h2>Сайты, которые помогли это создать</h2></center>
<br>
<center>
<a href="http://jquery.page2page.ru/tags/ifr.html" target="_blank"><font size=8px>http://jquery.page2page.ru/tags/ifr.html</font></a><br>
<a href="http://ruseller.com/" target="_blank"><font size=8px>http://ruseller.com/</font></a><br>
<a href="http://ru2.php.net/" target="_blank"><font size=8px>http://ru2.php.net/</font></a><br>
<a href="http://htmlbook.ru/" target="_blank"><font size=8px>http://htmlbook.ru/</font></a><br>
<a href="http://www.w3schools.com/" target="_blank"><font size=8px>http://www.w3schools.com/</font></a><br>
<a href="http://www.w3resource.com/" target="_blank"><font size=8px>http://www.w3resource.com/</font></a><br>
<a href="http://sypex.net/products/dumper/" target="_blank"><font size=8px>http://sypex.net/products/dumper/</font></a><br>
<a href="http://www.php.su/" target="_blank"><font size=8px>http://www.php.su/</font></a><br>
<a href="http://www.mysql.ru/" target="_blank"><font size=8px>http://www.mysql.ru/</font></a><br>
<a href="http://www.tizag.com/" target="_blank"><font size=8px>http://www.tizag.com/</font></a><br>
<a href="http://stackoverflow.com/" target="_blank"><font size=8px>http://stackoverflow.com/</font></a>

</center>

<br><br><br><br><br><br>
<!-- Скролл вверх вниз -->
<img src="images/up.png" alt="вверх"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 0%;border-width:0px;" class=skrit id=up>
<img src="images/down.png" alt="вниз"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 95%;border-width:0px;" id=down class=skrit>


</body>
</html>
