
<?php
include 'config.php';

mysql_query("TRUNCATE TABLE stroka_2;");



//Пришедшая переменная после выбора ячейки большой таблицы
$den=$_GET['den'];
$kurs=$_GET['kurs'];
$id_gr=$_GET['id_gr'];
$id_str2=$_POST['id_str'];

//Простое удаление
if ($_POST['prefix']=='udal') mysql_query("DELETE FROM stroka WHERE id_str=$id_str2")  or die("Query failed");
//Удаление выбранных строк 
if (!empty($_POST['udal_check']))
{
$ID=$row['id_str'];
foreach($_POST['delete_check'] as $ID) {
mysql_query("DELETE FROM `stroka` WHERE `id_str` = '".intval($ID)."';");
}
}

if ($_POST['sel_but']==true) 
{
mysql_query("INSERT INTO stroka 
(id_pp, id_k, id_p, den, vr_nach, vr_end, full,dop, kurs, id_gr, obyed, ochered, vibor) 
SELECT id_pp,id_k,id_p, '$den',vr_nach,vr_end,'false',dop,'$kurs', '$id_gr','false',ochered, vibor FROM polezn WHERE id_str='$_POST[id_str_post]';");
}


//Вставка шаблона времени
if ($_POST['standart']==TRUE)
{
	$result = mysql_query("SELECT * FROM time_polezn ORDER BY vr_nach");
	while($row = mysql_fetch_array($result))
	{
	mysql_query("INSERT INTO stroka (id_pp, id_k, id_p, den, vr_nach, vr_end, dop,full, kurs, id_gr,obyed,vibor) VALUES ('', '', '', '$den', '$row[vr_nach]', '$row[vr_end]', '','false', '$kurs', '$id_gr','false','false');");
	}
}
 
//Новая строка с пустыми значениями
 if ($_POST['new_str']==TRUE)
 {
mysql_query("INSERT INTO stroka (id_pp, id_k, id_p, den, vr_nach, vr_end, dop,full, kurs, id_gr,obyed,vibor) VALUES ('', '', '', '$den', '', '', '','false', '$kurs', '$id_gr','false','false');");
 }

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Ячейка <?echo zapros("SELECT nazvanie FROM gruppa WHERE id_gr='$id_gr'");?></title>

    <script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
  <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />

<!-- Time __________________________________________________________________________________-->
    <link rel="stylesheet" href="css/jquery-ui-1.8.14.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.ui.timepicker.css" type="text/css" />


    <script type="text/javascript" src="js/jquery.ui.core.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.timepicker.js"></script>
	
<script type="text/javascript">
function view_time(id) {

			        $('#show_time'+id).timepicker({
                    showNowButton: true,
                    showDeselectButton: true,
                    defaultTime: '',  // removes the highlighted time for when the input is empty.
                    showCloseButton: true
                }
				
				);
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


<!-- Udalenie-->
<script type="text/javascript">
function udal(id,den,kurs,id_gr) {

			if (confirm('Точно удалять '+$('#div_p'+id).text()+'?')) {
			$.post("yacheyka.php?den="+den+"&kurs="+kurs+"&id_gr="+id_gr, { prefix: 'udal', id_str: id} );
			$('#tab_'+id).fadeOut("slow");

		}
	}
</script>

<!-- Udalenie check-->
<script type="text/javascript">
function udal_check2(id)
{
	var che = document.getElementById("udal_check"+id).checked;
	if (che==true) {$("#che"+id).css({"background":"#d1ffdd"});$('#udal_check_div'+id).text('ЭТУ');}
	if (che==false) {$("#che"+id).css({"background":"#fef0f0"});$('#udal_check_div'+id).text('');}
}
</script>
	
<!--Soxr-->
<script Language="JavaScript">
function soxr(id_str,prefix){
if (prefix=='prepod') {kto='prepod';var V='pp';var vst='prepod';id=$('#id_prepod_select'+id_str).val()};
if (prefix=='predmet') {kto='predmet';var V='p';var vst='predmet';id=$('#id_predmet_select'+id_str).val()};
if (prefix=='kabinet') {kto='kabinet';var V='k';var vst='kabinet';id=$('#id_kabinet_select'+id_str).val()};
$.post("onclick.php", {id_str_post:id_str,prefix_post:kto,id_post: id},
   function(kto_new) {
	 $('#div_'+V+id_str).show();
	 $('#div_'+V+id_str).text(kto_new);
	 $('#id_'+vst+'_select'+id_str).hide();
   });
}
</script>

<!-- Soxr dop-->
<script Language="JavaScript">
function soxr_dop(id_str){
var dop_new = ($('#dop'+id_str).val());
$.post("onclick.php", {dop_post: dop_new,id_str_post:id_str});
}
</script>

<!--Ошибки-->
<script Language="JavaScript">
function full (id)
{
	var check = $("#id_full_select"+id).attr('checked');
	if (check==true) $("#iii"+id).css('background','#d1ffdd') && $('#full_view'+id).text('ДА');
	if (check==false) $('#iii'+id).css('background','#ffcccc') && $('#full_view'+id).text('НЕТ');
	$.get("onclick.php",{ id_str: id, check_get: check, prefix:'full' });
}
</script>

<!--Выбор-->
<script Language="JavaScript">
function vibor (id)
{
	var vib = $("#id_vibor_select"+id).attr('checked');
	if (vib==true) $("#vib"+id).css('background','#d1ffdd') && $('#vibor_view'+id).text('ДА');
	if (vib==false) $('#vib'+id).css('background','#ffcccc') && $('#vibor_view'+id).text('НЕТ');
	$.get("onclick.php",{ id_str: id, vib_get: vib, prefix:'vibor' });
}
</script>

<!--Отметить все чекбоксы-->
<script type="text/javascript">
$(document).ready( function() {
/*Удаление всех*/
$("#check_udal").click( function() {
	if($('#check_udal').attr('checked')){
		$('.check_udal:enabled').attr('checked', true);
		$(".udal_td").css({"background":"#d1ffdd"});$('.udal_div').text('ЭТУ');
	} else {
		$('.check_udal:enabled').attr('checked', false);
		$(".udal_td").css({"background":"#fef0f0"});$('.udal_div').text('');
	}
});

/*Отметить все ошибки*/
if ($(".check").attr('checked')==true) {$('#maincb').attr('checked','checked');}

	$("#maincb").click( function() {
		$(".check").each(function () {
		(/id_full_select(\d+)/.exec(this.id)); 
		id = RegExp.$1; 
		
		var check = $("#id_full_select"+id).attr('checked');

			if($('#maincb').attr('checked')){
			$(".check_color").css('background','#d1ffdd');
			$('#full_view'+id).text('ДА');
			$('.check:enabled').attr('checked', true);
			$.get("onclick.php",{ id_str: id, check_get: 'true', prefix:'full' });
			} else {
				$('.check:enabled').attr('checked', false);
				$('#iii'+id).css('background','#ffcccc');
				$('#full_view'+id).text('НЕТ');
				$.get("onclick.php",{ id_str: id, check_get: 'false', prefix:'full' });
			}	
		  });
	   });
    });
</script>

<!--Обобщённые предметы-->
<script Language="JavaScript">
function obyed (id)
{
	var obob = $("#id_obyed_select"+id).attr('checked');
	if (obob==true) $("#obob"+id).css('background','#d1ffdd') && $('#obyed_view'+id).text('ДА') && $("#blue"+id).show();
	if (obob==false) $('#obob'+id).css('background','#ffcccc') && $('#obyed_view'+id).text('НЕТ') && $("#blue"+id).hide();
	$.get("onclick.php",{ id_str: id, obob_get: obob, prefix:'obyed' });
}
</script>

<!--Перетаскивание ячеек-->
<script type="text/javascript">
function drag() {
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};

	$(".tab_yach tbody").sortable({helper: fixHelper,
	update: function() 
	{
		var order = $(this).sortable("serialize") + '&ochered_yach=!!';
		$.post("onclick.php",order);
	}
	}).disableSelection();
}
</script>

<!--Подсказки
<script type="text/javascript" src="js/jquery.tooltip.js"></script>-->
<script type="text/javascript">
function tool()
{
$.getScript('js/jquery.tooltip.js', function(){alert('script loaded');});
$(function() {
$('[title]').tooltip({
	track: true,
	delay: 0,
	showURL: false,
	fade: 200
});
});
}
</script>

<script type="text/javascript">
$(document).ready( function() {
	$('.time').change(function(){
	(/show_time(\d+)/.exec(this.id)); 
	//(/show_time_end(\d+)/.exec(this.id)); 
	id = RegExp.$1; 
		$.post("onclick.php", {id_str_post:id,prodolg_post:'prodolg'},
	   function(prodolg_new) {
		 $('#prodolg'+id).text(prodolg_new);
	   });
	});
	
	$('.time_end').change(function(){
	(/show_time_end(\d+)/.exec(this.id)); 
	id = RegExp.$1; 
		$.post("onclick.php", {id_str_post:id,prodolg_post:'prodolg'},
	   function(prodolg_new) {
		 $('#prodolg'+id).text(prodolg_new);
		 //alert (prodolg_new+id);
	   });
	});
  });
  </script>
</head>

<body>

<a href="help.php" target="_blank"><img src="images/help.png" style="width:50px;position:absolute;right:0px;" title="Открыть файл помощи"></a>

<a href="prepod_redact.php"> <img src="images/prepod.png" width=50px >Препод</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="kabinet_redact.php"><img src="images/kabinet.png" width=50px >Кабинет</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="predmet_redact.php"><img src="images/predmet.png" width=50px >Предмет</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<center><a href="table.php?id_gr=<?=$id_gr?>"><h3>К большой таблице</h3></a></center>


 <form method=POST>
<input type=submit value=Новая_строка name=new_str id=new_str style=display:none>
</form>
 
<?
//Вывести название группы
$result2 = mysql_query("SELECT * FROM gruppa WHERE id_gr='$id_gr'");
while($row2 = mysql_fetch_array($result2))
{
echo '<center><h2>';
echo zapros("SELECT nazvanie FROM klass WHERE ochered='$kurs'")."<br>";
if ($den==1) {echo "Понедельник";}
if ($den==2) {echo "Вторник";}
if ($den==3) {echo "Среда";}
if ($den==4) {echo "Четверг";}
if ($den==5) {echo "Пятница";}
if ($den==6) {echo "Суббота";}
echo '<br>'.$row2['nazvanie'].'</h2></center>';
}
?>
 
 <center> 
 <a href="yacheyka.php?den=<?=$den?>&kurs=<?=$kurs?>&id_gr=<?=$id_gr?>" title="Обновить"><img src="images/reload.png" width="70px"></a> 
 <a href="#" onclick="document.getElementById('new_str').click();" title="Новая строка"><img src="images/new_str.png" width="80px"></a> 
 </center>

<form method="POST" >
<div id="polezn">
<a href="polezn.php" class=standart style=display:none>Настройка полезностей</a>
<img src="images/move.png" width="50px" onclick="drag();" class=standart style="display:none;cursor:pointer;" title="Перетаскивание ячеек">
<input type=submit value="Время" name=standart class=standart style=display:none title="Вставить шаблон времени">
<input type=submit name=plus_show id=plus_drag value="Плюсики" class=standart style=display:none title="Добавляет плюсы, для удобства копирования ячеек (сверху вниз)">
<select class=standart style="display:none;" name=sel onchange="$.post('yacheyka.php?den=<?=$den?>&kurs=<?=$kurs?>&id_gr=<?=$id_gr?>',{sel_but:'true',id_str_post:$(this).val()});location.href='yacheyka.php?den=<?=$den?>&kurs=<?=$kurs?>&id_gr=<?=$id_gr?>';">
<option disabled selected>Шаблонный список</option>
<?php
$result4 = mysql_query("SELECT * FROM polezn");
	while($row4 = mysql_fetch_array($result4))
	{
	$id_str4=$row4['id_str'];
	$id_pp4=$row4['id_pp'];
	$id_k4=$row4['id_k'];
	$id_p4=$row4['id_p'];
	$vr_nach4=$row4['vr_nach'];
	$vr_end4=$row4['vr_end'];
	$dop4=$row4['dop'];
		?>
		<option value="<?=$id_str4?>">
		<?
		echo zapros("SELECT fio FROM prepod WHERE id_pp='$id_pp4'").'&nbsp;&nbsp;&nbsp;';
		echo zapros("SELECT nomer FROM kabinet WHERE id_k='$id_k4'").'&nbsp;&nbsp;&nbsp;';
		echo zapros("SELECT nazvanie FROM predmet WHERE id_p='$id_p4'").'&nbsp;&nbsp;&nbsp;';
		echo $vr_nach4.'&nbsp;&nbsp;&nbsp;';
		echo $vr_end4.'&nbsp;&nbsp;&nbsp;';
		echo $dop4;

		?></option> 
		<?
	}
?>
</select>
</div>

<br>
<div id=tooltiper>
<img src="images/redact.png" onclick="$('.standart').toggle();$('#polezn').toggleClass('polezn');" style="cursor:pointer;width:30px;" title="Полезная кнопка">
</div>


<table border="1" class=tab_yach>
<thead>
<tr>
<td>
<font size="3"><b>
Преподаватель
</b></font>
</td>

<td >
<font size="3"><b>
Кабинет
</b></font>
</td>

<td >
<font size="3"><b>
Предмет
</b></font>
</td>

<td>
<font size="3"><b>
Начало пары
</b></font>
</td>

<td >
<font size="3"><b>
Конец пары
</b></font>
</td>

<td >
<font size="3"><b>
Продолжительность
</b></font>
</td>

<td >
<font size="3"><b>
Что-то дополнительное
</b></font>
</td>

<td onmouseover="$('#label_full').show().css('margin-top','-30px');" >
	<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor='';$(this).hide();" id=label_full style="display:none;position:absolute">Все:<input type="checkbox" name="cbname3[]" id="maincb" /></label>
<font size="3"><b>
Ошибки <br>разрешены
</b></font>
</td>

<td >
<font size="3"><b>
Объед.
</b></font>
</td>

<td >
<font size="3"><b>
Выбрать
</b></font>
</td>

<td >
<font size="3"><b>
Удалить строку
</b></font>
</td>
  
        <td width=50px onmouseover="$('#label_udal').show().css('margin-top','-30px');">
		<label onmouseover="this.style.backgroundColor='#f9fd30'" onmouseout="this.style.backgroundColor='';$(this).hide();" id=label_udal style="display:none;position:absolute">Все:<input type="checkbox" name="udal[]" id="check_udal" /></label>
		<input type="submit" name="udal_check" value="Удалить &#10; выбранные?" onClick="return confirm('Удалить выбранные строки?');">
  </td>
  </tr>
</thead>
<tbody>  
  	<?
//Общий цикл, перечисляющий строки
$result = mysql_query("SELECT * FROM stroka WHERE den='$den' and kurs='$kurs' and id_gr='$id_gr' ORDER by vr_nach,ochered");
while($row = mysql_fetch_array($result))
{

$plus++;
//mysql_query ("UPDATE stroka SET ochered='$plus' WHERE id_str='$row[id_str]'");


//Копирование строк
if ($_POST['plus_show']==true)
{
$plus_predmet="onmouseover=\"$('#img_predmet".$plus."').show();\" onmouseout=\"$('#img_predmet".$plus."').hide();\"";
$plus_kabinet="onmouseover=\"$('#img_kabinet".$plus."').show();\" onmouseout=\"$('#img_kabinet".$plus."').hide();\"";
$plus_prepod="onmouseover=\"$('#img_prepod".$plus."').show();\" onmouseout=\"$('#img_prepod".$plus."').hide();\"";
}
else {$plus_predmet='';$plus_kabinet='';$plus_prepod='';}


//Чтоб не повторялись в дивах
$fio='';
$nazvanie='';
$nomer='';

$id_str=$row['id_str'];
$id_gr=$row['id_gr'];
$id_pp2=$row['id_pp'];
$id_k2=$row['id_k'];
$id_p2=$row['id_p'];
$dop2=$row['dop'];

if ($row['obyed']=='true') 
{
$obyed='checked';
$obob_color='#d1ffdd';
$non='';
}
else 
{
$obyed='';$obob_color='#ffcccc';
$non='style=display:none';
}

echo '<tr id=blue'.$id_str.' '.$non.'><td colspan=10 bgcolor=blue height="2"></td></tr>';
?>


<tr id="tab_<?=$id_str?>" onmouseover="this.style.backgroundColor='#e3e3e3';time_nagruzka(<?=$id_str?>);" onmouseout="this.style.backgroundColor=''">

<!-- Prepod -->

<td <?=$plus_prepod?>>
<img src="images/plus.png" width=20px align=right onclick="$('#id_prepod_select<?=$id_str?>').val($('.sel_prep<?echo $plus-1;?>').val());$('#div_pp<?=$id_str?>').text($('.plus_prep<?echo $plus-1;?>').text());soxr('<?=$id_str?>','prepod');" id=img_prepod<?=$plus?> style="display:none;" class=proo>
<select style="display:none;position:absolute;" id="id_prepod_select<?=$id_str?>" onchange="soxr('<?=$id_str?>','prepod')" class=sel_prep<?=$plus?>>
<option></option>
<?
	$result3 = mysql_query("SELECT * FROM prepod ORDER BY fio");
	while($row3 = mysql_fetch_array($result3))
	{
		($row3['id_pp']==$id_pp2)?$sel='selected' and $fio=$row3['fio']:$sel='';
		echo '<option '.$sel.' value='.$row3["id_pp"].'>'.$row3['fio'].'</option>';
	}
?>
</select>
<div onclick='$("#id_prepod_select<?=$id_str?>").show("fast");$(this).hide();' id="div_pp<?=$id_str?>" class=plus_prep<?=$plus?> style="display: block; width: 100%; height: 100%;" ><?=$fio?>&nbsp;</div>
</td>


<!-- Kabinet -->
<td <?=$plus_kabinet?>>
<img src="images/plus.png" width=20px align=right onclick="$('#id_kabinet_select<?=$id_str?>').val($('.sel_kab<?echo $plus-1;?>').val());$('#div_k<?=$id_str?>').text($('.plus_kab<?echo $plus-1;?>').text());soxr('<?=$id_str?>','kabinet');" id=img_kabinet<?=$plus?> style=display:none>
<select style="display:none;position:absolute;" id="id_kabinet_select<?=$id_str?>" onchange="soxr('<?=$id_str?>','kabinet')" class=sel_kab<?=$plus?>>
<option></option>
<?
	$result3 = mysql_query("SELECT * FROM kabinet ORDER BY nomer");
	while($row3 = mysql_fetch_array($result3))
	{
		($row3['id_k']==$id_k2)?$sel='selected' and $nomer=$row3['nomer']:$sel='';
		echo '<option '.$sel.' value='.$row3["id_k"].'>'.$row3['nomer'].'</option>';
	}
?>
</select>
<div onclick='$("#id_kabinet_select<?=$id_str?>").show("fast");$(this).hide();'  id="div_k<?=$id_str?>" class=plus_kab<?=$plus?> style="display: block; width: 100%; height: 100%;"><?=$nomer?>&nbsp;</div>
</td>

<!-- Predmet -->
<td <?=$plus_predmet?> width="20%">
<img src="images/plus.png" width=20px align=right onclick="$('#id_predmet_select<?=$id_str?>').val($('.sel_pred<?echo $plus-1;?>').val());$('#div_p<?=$id_str?>').text($('.plus_pred<?echo $plus-1;?>').text());soxr('<?=$id_str?>','predmet');" id=img_predmet<?=$plus?> style=display:none>
<select style="display:none;width:300px;position:absolute;" id="id_predmet_select<?=$id_str?>" onchange="soxr('<?=$id_str?>','predmet')" class=sel_pred<?=$plus?>>
<option></option>
<?
	$result3 = mysql_query("SELECT * FROM predmet ORDER BY nazvanie");
	while($row3 = mysql_fetch_array($result3))
	{
		($row3['id_p']==$id_p2)?$sel='selected' and $nazvanie=$row3['nazvanie']:$sel='';
		echo '<option '.$sel.' value='.$row3["id_p"].'>'.$row3['nazvanie'].'</option>';
	}
?>
</select>
<div onclick='$("#id_predmet_select<?=$id_str?>").show("fast");$(this).hide();'  id="div_p<?=$id_str?>" class=plus_pred<?=$plus?> style="display: block; width: 100%; height: 100%;"><?=$nazvanie?>&nbsp;</div>
</td>

<td align="center" >
<!-- Начало занятия -->
<?$vr_nach=$row['vr_nach'];?>
<input type="text" style="width: 70px" id="show_time<?=$id_str?>" onmouseover="view_time(<?=$id_str?>),yacheyka_time(<?=$id_str?>);" value="<?=$vr_nach?>" class=time>
</td>
  

<td align="center">
<!-- Конец занятия -->
<?$vr_end=$row['vr_end'];?>
<input type="text" style="width: 70px" id="show_time_end<?=$id_str?>" onmouseover="view_time_end(<?=$id_str?>),yacheyka_time_end(<?=$id_str?>);" value="<?=$vr_end?>" class=time_end>
</td>


<!-- Продолжительность -->
<td>
<div id=prodolg<?=$id_str?>>
<?
//Вычитание времени. Результат в секундах и в чч:мм:сс. В ячейке
$result8 = mysql_query("SELECT vr_nach, vr_end,TIME_TO_SEC(vr_end) - TIME_TO_SEC(vr_nach) AS 'secundi',SEC_TO_TIME(TIME_TO_SEC(vr_end) - TIME_TO_SEC(vr_nach)) AS 'kon' FROM stroka WHERE id_str='$id_str'");
while($row8 = mysql_fetch_array($result8))
{
	$kon=$row8['kon'];
	$secundi=$row8['secundi'];
	if ($secundi<=0) echo "Проверь время";
	$result9 = mysql_query("SELECT TIME_FORMAT('$kon', '%H') AS 'hour',TIME_FORMAT('$kon', '%i') AS 'minuta' FROM stroka WHERE id_str='$id_str'");
	while($row9 = mysql_fetch_array($result9))
	{
		$hour=$row9['hour'];
		$minuta=$row9['minuta'];
		echo (isset($row9['hour'])&&isset($row9['minuta']))?$row9['hour'].' часов '.$row9['minuta'].' минут':'';
	}
}

?>
</div>
</td>


<td>
<input type=text value="<?=$dop2?>" style="width:150px" onblur="soxr_dop('<?=$id_str?>');" id=dop<?=$id_str?>>
</td>


<?php
$result9 = mysql_query("SELECT * FROM stroka WHERE id_str='$id_str'");
while($row9 = mysql_fetch_array($result9))
{
if ($row9['full']=='true') {$full='checked';$full_color='#d1ffdd';} else {$full='';$full_color='#ffcccc';}
if ($row9['vibor']=='true') {$vibor='checked';$vibor_color='#d1ffdd';} else {$vibor='';$vibor_color='#ffcccc';}
}
?>

<!--Ошибки -->
<td id=iii<?=$id_str?> bgcolor=<?=$full_color?> class=check_color valign="center">
<label style="display: block; width: 100%; height: 100%;">
<center>
<div id="full_view<?=$id_str?>" nowrap><?echo ($full=='checked')?'ДА':'НЕТ';?></div>
</center>
<input type="checkbox" <?=$full?> id="id_full_select<?=$id_str?>"  onchange="javascript:full(<?=$id_str?>)" style="display:none" class="check"> </label>
</td>

<!--Объединить -->
<td id=obob<?=$id_str?> bgcolor=<?=$obob_color?>>
<label style="display: block; width: 100%; height: 100%;" >
<center>
<div id="obyed_view<?=$id_str?>" nowrap><? echo ($obyed=='checked')?'ДА':'НЕТ';?></div>
</center>
<input type="checkbox" <?=$obyed?> id="id_obyed_select<?=$id_str?>"  onchange="javascript:obyed(<?=$id_str?>,'obyed')" onclick="blue_check(<?=$id_str?>)" style="display:none"></label>
</td>

<!--Выбрать -->
<td id=vib<?=$id_str?> bgcolor=<?=$vibor_color?>  valign="center">
<label style="display: block; width: 100%; height: 100%;">
<center>
<div id="vibor_view<?=$id_str?>" nowrap><?echo ($vibor=='checked')?'ДА':'НЕТ';?></div>
</center>
<input type="checkbox" <?=$vibor?> id="id_vibor_select<?=$id_str?>"  onchange="javascript:vibor(<?=$id_str?>)" style="display:none" class="check"> </label>
</td>

<!--Удаление -->
	<td align="center" onmouseover="this.style.backgroundColor='#ff1a1a'" onmouseout="this.style.backgroundColor='#ffffff'">
<div style="display: block; width: 100%; height: 100%;text-decoration: none;" onClick="udal(<?=$id_str?>,<?=$den?>,<?=$kurs?>,<?=$id_gr?>);" id=udal<?=$id_str?>,<?=$den?>,<?=$kurs?>,<?=$id_gr?>><font color=red> &nbsp;</font></div>
	</td>

	<!--Удаление выбранных-->
<td id=che<?=$id_str?> style="background:#fef0f0;" class=udal_td height="100%">
<label style="display: block; width: 100%; height: 100%;" >
<div id="udal_check_div<?=$id_str?>" nowrap class="udal_div" align=center></div>
<input type="checkbox" id="udal_check<?=$id_str?>" value="<?=$id_str?>" name="delete_check[]"   class="check_udal" onclick="udal_check2('<?=$id_str?>')" style="display:none;"></label>

</td>


	</td>

</tr>


  <?

}

// Конец вывода списка таблиц по den из табл. stroka
  ?>
</tbody> 
</table>
</form>

</body>
</html>
