<?php session_start();

include "config.php";
//include "nagruzka.php";


//Для поворота таблицы
if (isset($_POST['povorot']))
{
	$pov=zapros("SELECT povorot FROM checked;");
	($pov=='1')?mysql_query("UPDATE checked SET povorot=2;"):mysql_query("UPDATE checked SET povorot=1;");
}
$pov=zapros("SELECT povorot FROM checked;");
($pov==1)?$grafik='grafik':$grafik='grafik2';


//Для лоадинга
$kolvo=zapros("SELECT COUNT(*) FROM gruppa");
$load=@floor(100/$kolvo);

//Окна. Запись в БД введённых значений
if(isset($_POST['but_okna']))
{
	mysql_query("UPDATE checked SET okno_check='$_POST[okno_check]',okno_den='$_POST[okno_den]',okno_kurs='$_POST[okno_kurs]',okno_chas='$_POST[okno_chas]',okno_min='$_POST[okno_min]'") or die(mysql_error());
}


// Перезаписать галочки
if(isset($_POST['mag']) or isset($_POST['pechat']) or isset($_POST['nowrap_check']) or isset($_POST['fio_sokrat']) or isset($_POST['predmet_sokrat']) or isset($_POST['dop']) or isset($_POST['vibor_check']))
{
	mysql_query("UPDATE checked SET mag='$_POST[mag]',pechat='$_POST[pechat]',nowrap_check='$_POST[nowrap_check]',fio_sokrat='$_POST[fio_sokrat]',predmet_sokrat='$_POST[predmet_sokrat]',dop='$_POST[dop]',vibor_check='$_POST[vibor_check]'") or die(mysql_error());
}


//Переписать значения шрифтов и цветов
if(isset($_POST['chto']) or isset($_POST['color']) or isset($_POST['italic']) or isset($_POST['bold']) or isset($_POST['font']))
{
	mysql_query("UPDATE redact SET chto='$_POST[chto]', color='$_POST[color]', bold='$_POST[bold]', italic='$_POST[italic]', font='$_POST[font]' WHERE chto='$_POST[chto]'") or die(mysql_error());
}


//Проверка checked общая, для преподов и предметов.Также линия границы между строками
$result=mysql_query("SELECT * FROM checked");
while($row=mysql_fetch_array($result))
{
	($row['mag']=='on')?$mag='checked':$none='style=display:none';
	($row['pechat']=='on')?$pechat='checked':$pechat='';
	($row['okno_check']=='on')?$okno_check='checked':$okno_check='';
	$okno_den=$row['okno_den'];
	$okno_kurs=$row['okno_kurs'];
	$okno_chas=$row['okno_chas'];
	$okno_min=$row['okno_min'];
	if($row['nowrap_check']=='on') {$nowrap_check='checked'; $nowrap='nowrap';} else {$nowrap='';}
	if($row['fio_sokrat']=='on') $fio_sokrat='checked';
	if($row['predmet_sokrat']=='on')$predmet_sokrat='checked';
	if($row['dop']=='on')$dop='checked';
	if($row['vibor_check']=='on')$vibor_check='checked';
}


//Для вывода шрифта и цвета
if(isset($_GET['chto']))
{
  $id_gr=$_GET['id_gr'];
  $chto=$_GET['chto'];
  $result=mysql_query("SELECT * FROM redact WHERE chto='$chto'");
  while($row=mysql_fetch_array($result))
  {
    $color=$row['color'];
    $font=$row['font'];
    if($row['bold']=='on')   $bold='checked';
    if($row['italic']=='on') $italic='checked';
  }
}


//$id_gr берётся из GET потом в таблицу третим значением в каждую строку, и при клике на строку запускается функция
if(isset($_GET['id_gr']))
{
	$id_gr=$_GET['id_gr'];
	$and_id_gr="and id_gr='$id_gr' ";
}


//ФУНКЦИЯ определения ошибок в один день  (совпадение кабинетов или преподов, зависит от галочки)
/*---------------------------------------------------------------------------------------------*/
function kto($kto1)
{

$alert=1;//Если циклбыл хоть один раз, вывести отчёт
global $id_gr;
global $and_id_gr;
global $fio_sokrat;
($id_gr=='')?$and_id_gr='':'';

//Пересечение дней
if (isset($_POST['peresek_dni']))
{
($kto1=='kabinet')?$table='kabinet':$table='prepod';
($kto1=='kabinet')?$order='nomer':$order='fio';
		for ($den=1;$den<=6;$den++)
		{
		$kto2='';
		($kto1=='kabinet')?$kto2=$nomer2:$kto2=$fio2;
			$result2=mysql_query("SELECT * FROM $table ORDER BY $order ");
			while($row2=mysql_fetch_array($result2))
			{
				($fio_sokrat=='checked')?$fio_ne_sokr=$row2['fio_sokr']:$fio_ne_sokr=$row2['fio'];
				($kto1=='kabinet')?$kto=$row2['nomer']:$kto=$fio_ne_sokr;
				($kto1=='kabinet')?$result=mysql_query("SELECT * FROM stroka WHERE id_k=$row2[id_k] $and_id_gr and den='$den' ORDER BY vr_nach"):'';
				($kto1=='prepod')?$result=mysql_query("SELECT * FROM stroka WHERE id_pp=$row2[id_pp] $and_id_gr and den='$den' ORDER BY vr_nach"):'';
				while($row=mysql_fetch_array($result))
				{
						if ($row['full']=='true' or $full_2=='true') {$tru='1';} else {$tru='2';}
					    if ($vr_end_2>$row['vr_nach'] and $kto2==$kto and $row['full']!=='true' and $tru!=='1' and $row['kurs']!==$kurs_2 ) 
						{
							$alert=0;
								if ($den==1) {$den2="Понедельник";}
								if ($den==2) {$den2="Вторник";}
								if ($den==3) {$den2="Среда";}
								if ($den==4) {$den2="Четверг";}
								if ($den==5) {$den2="Пятница";}
								if ($den==6) {$den2="Суббота";}
							$vr_nach_per=$row['vr_nach'];
							$vr_end_per=$row['vr_end'];
							$kto_per=$kto;
							$den_per=$den2;
							//$kurs_per=$row['kurs'];
							$kurs_per=zapros("SELECT nazvanie FROM klass WHERE ochered='$row[kurs]'");
							//$vibor_per=$kto;
							//if ($kurs_per==6 or $kurs_per==7){ if ($mag!=='checked'){$kurs_per='';}}
							$nn=$nn+1;
							//Названия групп, сокращённые
							$sokr_gr=zapros("SELECT sokr_gr FROM gruppa WHERE id_gr=$row[id_gr]");
							$vso_per='<td nowrap><b>'.$kto_per.'</b></td><td nowrap>'.$den_per.'</td><td nowrap>'.$sokr_gr.'</td><td nowrap>'.$vr_nach_per.'-'.$vr_end_per.'</td><td nowrap>'.$kurs_per.'</td>';
							//echo $kto_per.'----';
							$array_per[$nn]=$vso_per;
							$array_per2[$nn]='<td nowrap>'.$sokr_gr2.'</td><td nowrap>'.$vr_nach_2.'-'.$vr_end_2.'</td><td nowrap>'.$kurs_2.'</td><div class=redact>'.$den.$kto2.'</div>';
							$id_str_smen[$nn]=$row['id_str'];
							$id_str_smen2[$nn]=$id_str_smen_o_2;
						}
						$id_str_smen_o_2=$row['id_str'];
						$full_2=$row['full'];
						$vr_nach_2=$row['vr_nach'];
						$vr_end_2=$row['vr_end'];
						$kto2=$kto;
						$obyed2=$row['obyed'];
						$kurs_2=zapros("SELECT nazvanie FROM klass WHERE ochered='$row[kurs]'");
						//Для названий групп в конце предложения
						$sokr_gr2=zapros("SELECT sokr_gr FROM gruppa WHERE id_gr=$row[id_gr]");
				}
			}
		}

//К Циклу вывода на экран отчёта об ошибках
$_SESSION['array_per']=$array_per;
$_SESSION['array_per2']=$array_per2;
$_SESSION['nn']=$nn;
$_SESSION['id_str_smen']=$id_str_smen;
$_SESSION['id_str_smen2']=$id_str_smen2;
($kto1=='kabinet')?$_SESSION['kto']='kabinet':$_SESSION['kto']='prepod';
$den='';
}
return array($array_per,$array_per2,$nn);
} //Конец функции kto

//Массивы ошибок
($_POST['radio']=='peresek_kabinet')?$array_obsh=kto('kabinet'):'';
($_POST['radio']=='peresek_prepod')?$array_obsh=kto('prepod'):'';
$array_per=$array_obsh[0];
$array_per2=$array_obsh[1];
$nn=$array_obsh[2];


 //Функция повторения ячеек таблицы
 /*------------------------------------ Повторяется внизу в каждой ячейке таблицы -----------------------------*/
include ('function_table.php');

//Это для вывода всех таблиц, и чтоб checked работал, метка ЯЯ1
//tt для отображения границ между таблицами
$where='WHERE id_gr='.$id_gr;
$rasp_nazvanie=zapros("SELECT nazvanie FROM gruppa WHERE id_gr='$id_gr'");
if($_GET['all']==true or $_GET['id_gr']==0)
{
	$where="";
	$tt=1;
	$rasp_nazvanie='Расписание';
}?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title><?echo $rasp_nazvanie;?></title>
	<link rel="stylesheet" href="css/jquery-ui-1.8.14.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.ui.timepicker.css" type="text/css" />
	
	<link id="screenstyle" rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <script type="text/javascript" src="js/jquery.js"></script>
	
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

<!-- Пересчёт ячеек таблицы-->
<script type="text/javascript">
     function id_gr(id) {
     table=document.getElementById('table'+id), tr=table.rows, den=tr.length;
     while(den--) {
         td=tr[den].cells, kurs=td.length;
         while(kurs--) {
			td[kurs].onmouseover=(function(den, kurs) {
				return function () {
				
					$(".redact").hide();
					$("#redact_mal"+den+kurs+id).show();
                 };
             }
			 )
             }
			 

			 (den, kurs);
         }
     }
 }
 
</script>

<!-- Reset okna -->
<script type="text/javascript">
function reset()
{
	$('.reset').val('');
	$(".reset :contains('Классы')").attr("selected", "selected");
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

<!-- Печать документа-->
<script type="text/javascript" src="js/print.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<base href="table.php" />
<link id="printstyle" rel="stylesheet" type="text/css" href="css/print.css" media="print" />

<!--Открыть в новом окне по центру отчёт-->
<script type="text/javascript">
	function _open( url, width, height ) {
		window.open( url,'', 'width=' + width + ',height=' + height + ',left=' + ((window.innerWidth - width)/2) + ',top=' + ((window.innerHeight - height)/2)+',scrollbars=1');
	}	
</script>

<!--Линия-->
<script type="text/javascript" src="js/wz_jsgraphics.js"></script>
<script type="text/javascript" src="js/position.js"></script>
<script type="text/javascript">
function line(id) {

var ar=new Array();
ar[0]="#000000";
ar[1]="#3bfcec";
ar[2]="#bf883b";
ar[3]="#16e91a";
ar[4]="#e8d711";
ar[5]="#b13bbf";
ar[6]="#0d38f8";
ar[7]="#62f80d";
ar[8]="#f80d9a";
ar[9]="#73883f";
ar[10]="#70047c";

rand_color=(ar[Math.round(Math.random()*10)]);
var random=Math.floor( Math.random( ) * (70) );//Для случайных координат линий
var elm1=document.getElementById('perviy'+id);
var coords1=getOffset(elm1);
var elm2=document.getElementById('vtoroy'+id);
var coords2=getOffset(elm2);
var jg=new jsGraphics("perviy"+id);    // Use the "Canvas" div for drawing 
jg.setColor(rand_color);//цвет линии
jg.setStroke (3);
jg.drawLine(coords1.left+random, coords1.top-80, coords2.left+random, coords2.top-75);
//jg.fillEllipse (coords2.left+random, coords2.top, 10, 20);
jg.paint();
}
</script>




<!-- Menu верх -->
<script>
$(document).ready(function() {
	var top='-' + $('#slidedown_content .content').css('height');
	var easing='easeInSine';
	$('#slidedown_top').mouseover(function() {
		$('#slidedown_content').animate({'top' : 0}, {queue:false, duration:300, easing: easing});
	});
	$('#slidedown_bottom').click(function() {
		$('#slidedown_content').animate({'top' : top}, {queue:false, duration:100, easing: easing});
	});
});
</script>

<!-- Меню на правую кнопку -->
<script src="js/jquery.contextMenu.js" type="text/javascript"></script>
<script type="text/javascript">
function right_click(id){
	//Show menu when #myDiv is clicked
	$("#myDiv"+id).contextMenu({
		menu: 'myMenu'+id
	},
		function(action, el, pos) {
	});

	//Show menu when a list item is clicked
	$("#myList UL LI").contextMenu({
		menu: 'myMenu'+id
	}, function(action, el, pos) {
	});
	}
</script>

<!-- Панелька справа -->
<script type="text/javascript">
$(document).ready(function(){
	$(".trigger").click(function(){
		$(".panel").toggle("fast");
		$(this).toggleClass("active");
		return false;
	});
});
</script>

<!--Удалить всю базу данных-->
<script type="text/javascript">
$(document).ready(function(){

   $(window).keydown(function(e) {
      if (e.which == 192) {
         if (e.ctrlKey){ if (confirm('Точно удалить всю базу данных??')) $.post('onclick.php', {udal_basa: '!!'}); }
      location.href='index.php';
	  }
   });
   
      $(window).keydown(function(e) {
      if (e.which == 106) {
         if (e.ctrlKey){ if (confirm('Точно очистить почти всё??')) $.post('onclick.php', {ochist_basa: '!!'}); }
		location.href='table.php';
      } 
   });

});
</script>

</head>

<body style="font-size:10pt;">


<div id="slidedown_top"></div> <!-- slidedown_top -->
<div id="slidedown_content">

	<!-- Начало тела таблицы верхней-->
	<div class="content">
		<table border="1" class=tab_verx>
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
				<td>
					<b title="Вывод окон между ячейками. Окна отображаются пока включена галочка. Часы и минуты вводятся отдельно. Допустим в часы вводим '2', в минуты '25', то есть будет искать окна, промежутком в 2 часа 25 минут.">ОКНА
					</b>
					<img src="images/ochist.png" width="30px" onclick="reset();" style="cursor:pointer;" title="Сбросить дни и классы" align=right>
				</td>
			</tr>
			<tr>
			<td>
				<a href="prepod_redact.php"> <img src="images/prepod.png" width=40px ><br>Препод</a><br><br>
				<a href="kabinet_redact.php"><img src="images/kabinet.png" width=40px ><br>Кабинет</a><br><br>
				<a href="predmet_redact.php"><img src="images/predmet.png" width=40px ><br>Предмет</a>
			</td>
			<td>
				<a href="gruppa.php" title="Редактировать группы">Группы</a><br><br>
				<a href="magistr.php">Дополнительные классы</a><br><br>
				<a href="dop_tabl.php">Карта классов</a><br><br>
				<a href="polezn.php">Настройка полезностей</a>
			</td>
			<!--Вывести только выбранное -->
			<form method=POST action="table.php?id_gr=<?=$id_gr?>">
				<td nowrap align=left>
					<table>
						<tr>
							<td >
								<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''"  title="Отображать сокращённые предметы, когда стоит галочка"><input type=checkbox name=predmet_sokrat <?=$predmet_sokrat?> >Сокращ.предмет</label>
							</td>
						</tr>
						<tr>
							<td>
								<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Отображать сокращённые имена и фамилии преподавателей, когда стоит галочка"><input type=checkbox name=fio_sokrat <?=$fio_sokrat?>>Сокращ.(ФИО)</label>
							</td>
						</tr>
						<tr>
							<td>
								<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Отображать информацию, введённую в строку 'Дополнительно'"><input type="checkbox" name=dop <?=$dop?>>Доп-но</label>
							</td>
						</tr>
						<tr>
							<td>
								<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Выделить важные, выбранные строки, когда стоит галочка"><input type=checkbox name=vibor_check <?=$vibor_check?>>Выделить</label>
							</td>
						</tr>
						<tr>
							<td>
								<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Сбрасывает все цвета и размеры шрифта в ячейках. Удобно для печати"><input type=checkbox name=pechat <?=$pechat?>>Сброс стилей</label>
							</td>
						</tr>
						<tr>
							<td>
								<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title=" Строки в ячейках отображаются во всю длину"><input type=checkbox name=nowrap_check <?=$nowrap_check?>>Без переноса строк</label>
							</td>
						</tr>
						<tr>
							<td>
								<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Показать/скрыть дополнительные классы"><input type=checkbox name=mag <?=$mag?>>Дополнительные классы</label>
							</td>
						</tr>
					</table>

					<br>
					<input type="submit" value=Жать name=vibor2 id=but title="Подтвердить">
				</td>
			</form>


			<td align=left>
				<form method=POST action="table.php?id_gr=<?=$id_gr?>">
				
				<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Выделить цветом выбранное из нижнего. Если галочка не стоит, то в таблице показывается только выбранное, остальное не показывается."><input type=checkbox name="videl" >Просто выделить</label>
				
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
				</form>
			</td>

			<td nowrap align=left width="150px">
				<form method=POST >
					<select name="chto" id="chto" style="width:100px" title="Выбрать, что редактировать в ячейке">
						<option disabled selected>Что?</option>
						<option value="vr_nach" <?echo ($chto=='vr_nach')?'selected':'';?>>Начало пары</option>
						<option value="vr_end"  <?echo ($chto=='vr_end')?'selected':'';?>>Конец пары</option>
						<option value="predmet" <?echo ($chto=='predmet')?'selected':'';?>>Предмет</option>
						<option value="kabinet" <?echo ($chto=='kabinet')?'selected':'';?>>Кабинет</option>
						<option value="prepod"  <?echo ($chto=='prepod')?'selected':'';?>>Преподаватель</option>
					</select>
					<br>

					<!--Цвет -->
					<div class="form-item" title="Выбрать цвет"><label for="color"></label>
					<input type="text" id="color" name="color" value="<?=$color?>" onclick="$('#picker').show(300);" placeholder="Цвет" style="width:100px" />
					</div>
					<div id="picker" style="display:none" ondblclick="$(this).hide(300);"></div>
					<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''"><input type=checkbox name="italic" <?=$italic?> id=italic><i>Наклонный</i></label>
					<br><br>
					<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''"><input type=checkbox name="bold" <?=$bold?> id=bold ><b>Жирный</b></label>
					<br><br>
					
					<select name="font" style="width:100px" id=font title="Размер текста в ячейке">
						<option class=opt disabled selected>Размер текста</option>
						<option value=1 <?echo ($font==1)?'selected':'';?>>1</option>
						<option value=2 <?echo ($font==2)?'selected':'';?>>2</option>
						<option value=3 <?echo ($font==3)?'selected':'';?>>3</option>
						<option value=4 <?echo ($font==4)?'selected':'';?>>4</option>
						<option value=5 <?echo ($font==5)?'selected':'';?>>5</option>
						<option value=6 <?echo ($font==6)?'selected':'';?>>6</option>
						<option value=7 <?echo ($font==7)?'selected':'';?>>7</option>
					</select>
					<br>
					<input type="submit" value=Жать id=but4 name=vibor3>
				</form>
			</td>

			<td align=left>
				<form method=POST action="table.php?id_gr=<?=$id_gr?>">
				
				<!--Пересечение времени-->
				<input type="submit"  name=peresek name=peresek id=but3 value="Пересечение в ячейке" title="Показать линию между строками, если эти строки пересекаются по времени в один день и в одном классе.">
				<br>

				<label onmouseover="this.style.backgroundColor='#fcfcc9'" onmouseout="this.style.backgroundColor='#ffffff'" title="Поиск пересечения в один день по кабинетам">Кабинет<input type="radio"  name=radio value=peresek_kabinet></label>
				<br>
				<label onmouseover="this.style.backgroundColor='#fcfcc9'" onmouseout="this.style.backgroundColor='#ffffff'" title="Поиск пересечения в один день по преподавателям">&nbsp;&nbsp;Препод<input type="radio"  name=radio value=peresek_prepod></label>
				<table class=tab_obsh>
					<tr>
						<td>
							<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Нарисовать для наглядности линии пересечения"><input type=checkbox name=line_view>Рис. линии?</label>
						</td>
					</tr>
					<tr>
						<td>
							<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor=''" title="Открыть в новом окне отчёт по ошибкам. В нём можно перейти на страницу, в которой присутствует ошибка"><input type="checkbox"  name=peresek_check>Вывести отчёт?</label>
						</td>
					</tr>
				</table>
				<br>
				<input type="submit" name=peresek_dni value="Пересечение дней ">
				</form>
			</td>

			<td align=left>
			<form method=POST>
			
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
			<input type=submit name=but_okna value=Жать id=but_okna>
			
			</form>
			</td>
			
			</tr>
		</table>
	  <div class="clear"></div>
	</div> <!-- content -->
  <div class="footer"></div> <!-- footer -->
</div> <!-- slidedown_content -->

<div id="slidedown_bottom">
<!-- Website Content Start Here -->

<!--Панелька слева-->
<div class=skrit style="float:left" title="Показать все таблицы">
<img src="images/vso.png" onclick="location.href=('table.php');" onmouseover="$(this).animate({opacity:'1'},100);" onmouseout="$(this).animate({opacity:'0.7'});" style="width:50px;opacity:0.7;">
</div>

<div class="panel" nowrap><!--Панелька справа-->

	<!-- Печать, эксель и сохр.-->
	<div id="printversion">
		<a id="togglestyle" href="#" onclick="toggleStylesheet('<img src=images/print_vers.png width=50px>','<img src=images/back.png width=50px style=position:absolute;right:0px;>'); return false; "><img src="images/print_vers.png" width=50px title="Версия для печати"></a>
		<a href="javascript:print();"  id="printdocument"><img src="images/print.png" width=50px title="Печать"></a>
		<img src="images/excel.png" onclick="document.getElementById('datatodisplay2').click();" width=50px style="cursor:pointer;" class=skrit title="Экспорт в EXCEL">
		<img src="images/save.png" title="Сохранить базу данных" width=50px class=skrit onclick="_open( 'dumper.php', 400 , 350 );" style="cursor:pointer;">
	</div>
<img src="images/pomosh.png" onclick="$.getScript('js/jquery.tooltip.js');$('#help').show();" style="cursor:pointer;" width=50px class=skrit title="Включить отображение подсказок при наведении (Действует пока не перезагрузилась страница)">
<a href="help.php" target="_blank"  title="Открыть общую подсказку"><img src="images/help.png" style="display:none;cursor:pointer;" width=50px id="help"></a>
	<div class=skrit style="float:right">
		<!-- Кнопка вывода всех таблиц -->
		<form method=GET action="table.php">
		<input type="submit"  name=all value="Все_таблицы" id=all title="Вывести все таблицы">
		</form>  

		 <!-- Селектор групп -->
		<select ONCHANGE="location=this.options[this.selectedIndex].value;" style="width:100px;display:none;" dir=rtl id=sel_show title="Выбрать группу">
			<option class=opt disabled selected>Группы</option>
			<!--Перечисление групп-->
			<? 
			$result=mysql_query("SELECT * FROM gruppa ORDER by ochered");
			while($row=mysql_fetch_array($result))
			{?>
			<option value="table.php?id_gr=<?=$row['id_gr']?>"  <? if($_GET['id_gr']==$row['id_gr']){
			echo "selected";$nazv_gr=$row['sokr_gr'];} if(!isset($_GET['id_gr'])){$nazv_gr='Все группы';}?> ><?=$row['nazvanie']?>
			<? }?>
			</option>
		</select>
		<div id="sel_gr" onmouseover="$('#sel_show').show();$(this).hide();"><font color=white><b><?=$nazv_gr?></b></font></div>
	</div>

</div>
<a class="trigger" id=trigg href="#"></a>


<!--Скрипт формы для отправки Excel-->
<form action="table_to_excel.php" method="post"   
onsubmit='$(".contextMenu").html("");$("#datatodisplay").val( $("<div>").append( $("#mytable").eq(0).clone() ).html() );'>  
  <table width="600px" cellpadding="2" cellspacing="2" border="0">  
    <tr>  
      <td align="center"><input type="hidden" id="datatodisplay" name="datatodisplay">  
        <input type="submit" value="Export to Excel" id=datatodisplay2 name=datatodisplay2 style="visibility:hidden;" >  
      </td>  
    </tr>  
  </table>  
</form>

<?
//ЯЯ1
$result=mysql_query("SELECT * FROM gruppa $where ORDER BY ochered");
while($row=mysql_fetch_array($result))
{
	$id_gr=$row['id_gr'];
	$kolvo=$kolvo+$load;
	
?>

<div id="mytable" align=center>

<!--Loading-->
<div id="progressbar"></div>
<script type="text/javascript">$( "#progressbar" ).progressbar({value: <?=$kolvo?>});</script>
<?if ($kolvo>100 or $tt!==1) {echo '<script>$("#progressbar").hide();</script>';}?>

<form action="table.php<?if ($tt!==1) echo '?id_gr='.$id_gr;?>" method="post" style="display:none;">
<input type=submit name=povorot id=povorot>
</form>

<h1 title="Название группы. При нажатии просто перезагружается страница"><a href="table.php?id_gr=<?=$id_gr?>"><? echo $row['nazvanie'];?> </a></h1>
<!--Главная таблица-->
<table border="2" id="table<?=$id_gr?>" width="100%" onmouseover="id_gr(<?=$id_gr?>)" class=tab_obsh>
<tr>
<td width="10%" >
<div id=tooltiper  style="width:99%"><img src="images/ochist.png" onmouseover="$(this).animate({backgroundColor:'#000',opacity:'1'}, 200 );" onmouseout="$(this).animate({backgroundColor:'#FFF',opacity:'0.5'}, 200 );" title="Очистить всю таблицу <?=$row['nazvanie']?>??" onclick="$('#tooltip').hide();if (confirm('Точно очистить <?=$row['nazvanie']?>??')) $.post('onclick.php', {ochist_table: '!!',id_gr:'<?=$id_gr?>'});window.location='table.php?id_gr=<?=$id_gr?>';" style="cursor:pointer;width:30px;opacity:0.5;" id="imgg<?=$id_gr?>" class=skrit>
<img src="images/<?=$grafik?>.png" title="Повернуть таблицу <?if ($tt!==1) echo $row['nazvanie'];?>??" class=skrit onclick="$('#povorot').click();" onmouseover="$(this).animate({backgroundColor:'#000',opacity:'1'}, 200 );" onmouseout="$(this).animate({backgroundColor:'#FFF',opacity:'0.5'}, 200 );" id=img_povorot style="width:30px;opacity:0.5;">
</div>
</td>

<?
//Общая таблица. Два варианта, для разворота.
$kolvo_klass=zapros("SELECT COUNT(*) FROM klass;");
if ($pov==2)
{
//Перечисление дней в названиях столбцов
for ($d=1;$d<=6;$d++) {echo '<td  bgcolor=#e8e8e8><b>'.$dni_arr[$d].'</b></td>';}
for ($dva=1;$dva<=6;$dva++)
{
	?>
	<tr>
	<?
	if (zapros("SELECT mag FROM klass WHERE ochered='$dva';")=='!!') {$none2=$none;}else {$none2='';}
	echo '<td bgcolor="#e8e8e8" '.$none2.' ><b>'.zapros("SELECT nazvanie FROM klass WHERE ochered='$dva';").'</b></td>';
	for ($odin=1;$odin<=6;$odin++)
	{
		echo '<td class=tab '.$none2.' valign=top '.$nowrap.'  id="myDiv'.$odin.$dva.$id_gr.'">';
		table($odin,$dva,$id_gr);
		echo '</td>';
	}
	?>
	</tr>
<?}

}
if ($pov==1)
{
	$result22=mysql_query("SELECT * FROM klass");
	while($row22=mysql_fetch_array($result22))
	{
	echo '<td  bgcolor=#e8e8e8 ';
	if ($row22['mag']=='!!') echo $none;
	echo '><b> '.$row22['nazvanie'].'</b></td>';
	}

for ($dva=1;$dva<=6;$dva++)
{
	echo '<tr><td bgcolor="#e8e8e8" ><b>'.$dni_arr[$dva].'</b></td>';
	for ($odin=1;$odin<=$kolvo_klass;$odin++)
	{
		if (zapros("SELECT mag FROM klass WHERE ochered='$odin';")=='!!') {$none2=$none;}else {$none2='';}
		echo '<td class=tab '.$none2.' valign=top '.$nowrap.'  id="myDiv'.$dva.$odin.$id_gr.'">';
		table($dva,$odin,$id_gr);
		echo '</td>';
	}
?></tr>
<?}
}
?>
</table>

<? 
	//Граница между таблицами (all)
	if($tt==1)
    echo '<br><HR NOSHADE WIDTH=80% COLOR=gray SIZE=8><br><br><br>';
}

//Высветить если ошибок нет при пересечении в один день
if ($_POST['radio']=='peresek_kabinet' or $_POST['radio']=='peresek_prepod') { if ($array_per[1]==null) echo '<script type="text/javascript">alert("Ошибок нет");</script>';}

if($_GET['all']==true or $_GET['id_gr']==0)
{
	echo '<img src="images/up.png" alt="вверх"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 0%;" class=skrit id=up>';
	echo '<img src="images/down.png" alt="вниз"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 95%;" id=down class=skrit>';
}


//Рисование ошибочных линий
	if (isset($_POST['line_view']))
	{
		for ($oo=1;$oo<=$nn;$oo++)
		{
			echo '<script type="text/javascript">line('.$oo.');</script>';
		}
	}
	if ($_POST['but_okna']==true)
		{
		?>
			<script type="text/javascript">
				$(window).load(function(е) {
				if ($('div').is('#okno')!==true && $('input[name=okno_check]').is(':checked')==true) alert ('Окон нету!');
				}); 
			</script>
		<?
		}
		
//Само новое окно (отчёт)
if ($alert!==1 and isset($_POST['peresek_check'])) echo '<script type="text/javascript">window.open( "new_window.php","", "width=" + 100 + ",height=" + 100 + ",left=" + ((window.innerWidth - 100)/2) + ",top=" + ((window.innerHeight - 100)/2)+",scrollbars=1");</script>';
?>

</div><!--Конец дива в котором таблица-->

</div><!--Конец сайта-->




</body>
</html>

