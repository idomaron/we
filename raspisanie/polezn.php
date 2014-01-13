
<?php
include "config.php";

if ($_POST['smena_p']==true)
{
mysql_query ("UPDATE stroka SET id_p=999999 WHERE id_p='$_POST[sel_p1]'");
mysql_query ("UPDATE stroka SET id_p='$_POST[sel_p1]' WHERE id_p='$_POST[sel_p2]'");
mysql_query ("UPDATE stroka SET id_p='$_POST[sel_p2]' WHERE id_p=999999");}

if ($_POST['smena_k']==true)
{mysql_query ("UPDATE stroka SET id_k=999999 WHERE id_k='$_POST[sel_k1]'");
mysql_query ("UPDATE stroka SET id_k='$_POST[sel_k1]' WHERE id_k='$_POST[sel_k2]'");
mysql_query ("UPDATE stroka SET id_k='$_POST[sel_k2]' WHERE id_k=999999");}
 
if ($_POST['smena_pp']==true)
{mysql_query ("UPDATE stroka SET id_pp=999999 WHERE id_pp='$_POST[sel_pp1]'");
mysql_query ("UPDATE stroka SET id_pp='$_POST[sel_pp1]' WHERE id_pp='$_POST[sel_pp2]'");
mysql_query ("UPDATE stroka SET id_pp='$_POST[sel_pp2]' WHERE id_pp=999999");}




if ($_POST['polezn_post']=='yo')
{mysql_query("INSERT INTO polezn SELECT * FROM stroka WHERE id_str='$_POST[id_str]';");
}

if ($_POST['polezn_post']=='mag')
{mysql_query ("UPDATE klass SET mag='!!' WHERE id_klass='$_POST[id_klass]'");
}

if ($_POST['polezn_post']=='mag_no')
{mysql_query ("UPDATE klass SET mag='' WHERE id_klass='$_POST[id_klass]'");
}

if ($_POST['udal_post']=='udal')
{mysql_query("DELETE FROM polezn WHERE id_str='$_POST[id_str]'");
}

if ($_POST['udal_post']=='udal_time')
{mysql_query("DELETE FROM time_polezn WHERE id_time='$_POST[id_time]'");
}

if ($_POST['udal_dolg_post']=='udal_dolg')
{mysql_query("DELETE FROM dolgnost WHERE id_dolg='$_POST[id_dolg]'");
}

//Удаление класса
if ($_POST['udal_klass_post']=='udal_klass')
{mysql_query("DELETE FROM klass WHERE id_klass='$_POST[id_klass]'");
$kk=1;
$result=mysql_query("SELECT * FROM klass");
while($row=mysql_fetch_array($result))
{
mysql_query ("UPDATE klass SET ochered='$kk' WHERE id_klass='$row[id_klass]';");
$kk=$kk+1;
}

}

if ($_POST['ochist_post']=='ochist')
{mysql_query("TRUNCATE TABLE polezn;");
}


if ($_POST['vr_nach']==true)
{mysql_query ("UPDATE time_polezn SET vr_nach='$_POST[vr_nach]' WHERE id_time='$_POST[id_time]'");
}

if ($_POST['vr_end']==true)
{mysql_query ("UPDATE time_polezn SET vr_end='$_POST[vr_end]' WHERE id_time='$_POST[id_time]'");
}

if ($_POST['dolgnost']==true)
{mysql_query ("UPDATE dolgnost SET dolgnost='$_POST[dolgnost]' WHERE id_dolg='$_POST[id_dolg]'");
}

if ($_POST['klass']==true)
{mysql_query ("UPDATE klass SET nazvanie='$_POST[klass]' WHERE id_klass='$_POST[id_klass]'");
$kk=1;
$result=mysql_query("SELECT * FROM klass");
while($row=mysql_fetch_array($result))
{
mysql_query ("UPDATE klass SET ochered='$kk' WHERE id_klass='$row[id_klass]';");
$kk=$kk+1;
}
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Полезности</title>
<link id="screenstyle" rel="stylesheet" type="text/css" href="css/style.css" media="screen" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/verx_niz.js"></script>
<!-- Udalenie-->
<script type="text/javascript">
function udal(id) {
$.post("polezn.php", { udal_post: 'udal', id_str: id} );
$('#imgg'+id).hide(400);
}

<!-- Udalenie time-->
function udal_time(id) {
$.post("polezn.php", { udal_post: 'udal_time', id_time: id} );
$('#tr_time'+id).hide(400);
}

<!-- Udalenie dolgnost-->
function udal_dolg(id) {
$.post("polezn.php", { udal_dolg_post: 'udal_dolg', id_dolg: id} );
$('#tr_dolg'+id).hide(400);
}

<!-- Udalenie klass-->
function udal_klass(id) {
$.post("polezn.php", { udal_klass_post: 'udal_klass', id_klass: id} );
$('#tr_klass'+id).hide(400);
}
</script>

<!--Подсказки-->
<script type="text/javascript" src="js/jquery.tooltip.js"></script>
<script type="text/javascript">
$(function() {
$('[title]').tooltip({
	track: true,
	delay: 0,
	showURL: false,
	fade: 200
});
});
</script>

<!--Добавить пустое время-->
<script type="text/javascript">
function new_time2(){
   $.post("onclick.php", {new_time3: '!!'},
   function(new_time) {
$('#table_time').prepend('<tr id="tr_time'+new_time+'"><td><input type=text placeholder="Начальное время"  onclick="$(this).val(\'00:00\');" onblur="$.post(\'polezn.php\', { vr_nach: $(this).val(), id_time: '+new_time+'});"><input type=text placeholder="Конечное время"  onclick="$(this).val(\'00:00\');" onblur="$.post(\'polezn.php\', { vr_end: $(this).val(), id_time: '+new_time+'});"><img src="images/delete.png" width=20px onclick="udal_time('+new_time+');"></td></tr>');
   });
   }
</script>

<!--Добавить новую должность.Пустую.-->
<script type="text/javascript">
function new_dolg(){
$.post("onclick.php", {new_dolg: '!!'},
   function(new_dolg) {
$('#table_dolg').append('<tr id="tr_dolg'+new_dolg+'"><td><input type=text value="" onblur="$.post(\'polezn.php\', { dolgnost: $(this).val(), id_dolg: '+new_dolg+'});"><img src="images/delete.png" width=20px onclick="udal_dolg('+new_dolg+');"></td></tr>');
   });
   }
</script>

<!--Добавить класс-->
<script type="text/javascript">
function new_klass(){
$.post("onclick.php", {new_klass: '!!'},
   function(new_klass) {
$('#table_klass').append('<tr id="tr_klass'+new_klass+'"><td><img src="images/delete.png" width=20px onclick="udal_klass('+new_klass+');"><input type=text value="" onblur="$.post(\'polezn.php\', { klass: $(this).val(), id_klass: '+new_klass+'});"><img src="images/plus2.png" width=20px onclick="$.post(\'polezn.php\',{polezn_post:\'mag\',id_klass: \''+new_klass+'\'});$(\'#mag'+new_klass+'\').show();"><img src="images/galka.png" width=20px <?if ($mag!=="!!") echo "style=display:none";?>  onclick="$.post(\'polezn.php\',{polezn_post:\'mag_no\',id_klass: \''+new_klass+'\'});$(this).hide();" id="mag'+new_klass+'"></td></tr>');
   });
   }
   
   

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
<center><a href="table.php"><h3>К большой таблице</h3></a></center>
<center>
	<a href=polezn.php><img src="images/reload.png" width=50px></a>
	<img src="images/time.png" width=50px onclick="$('.time_show').toggle();" title="Показать/скрыть редактируемый шаблон времени">
	<img src="images/dolgnost.png" width=50px onclick="$('.dolgnost_show').toggle();" title="Показать/скрыть должности">
	<img src="images/kabinet.png" width=50px onclick="$('.klass_show').toggle();" title="Показать/скрыть список классов">
	<img src="images/smena.png" width=50px onclick="$('#smena').toggle();" title="Сменить местами в общей таблице во всех ячейках преподов либо кабинеты либо предметы">
</center>
 <br />

<table>
<tr>
<td>

<table border="1" class=time_show style="display:none;width:300px;" id=table_time> 
<tr><td><b>Шаблон времени</b></td></tr>
<?
$result2=mysql_query("SELECT * FROM time_polezn ORDER BY vr_nach");
while($row2=mysql_fetch_array($result2))
{
extract($row2);
?>
<tr id="tr_time<?=$id_time?>">
<td>
<input type=text value="<?=$vr_nach?>" onblur="$.post('polezn.php', { vr_nach: $(this).val(), id_time: <?=$id_time?>});" placeholder="Начало">
<input type=text value="<?=$vr_end?>" onblur="$.post('polezn.php', { vr_end: $(this).val(), id_time: <?=$id_time?>});" >
<img src="images/delete.png" width=20px onclick="udal_time(<?=$id_time?>);">
</td>
</tr>
<?}?>
<img src="images/new_str.png" width=50px onclick="new_time2();" class=time_show style=display:none title="Добавить время">
</table>
</td>

<td align=left>
<table border="1" class="dolgnost_show" style="display:none;width:20%;" id=table_dolg> 
<tr><td><b>Должности</b></td></tr>
<?
$result3=mysql_query("SELECT * FROM dolgnost");
while($row3=mysql_fetch_array($result3))
{
extract($row3);
?>
<tr id="tr_dolg<?=$id_dolg?>">
<td>
<input type=text value="<?=$dolgnost?>" onblur="$.post('polezn.php', { dolgnost: $(this).val(), id_dolg: <?=$id_dolg?>});">
<img src="images/delete.png" width=20px onclick="udal_dolg(<?=$id_dolg?>);">
</td>
</tr>
<?}?>
<img src="images/new_str.png" width=50px onclick="new_dolg();" class=dolgnost_show style=display:none title="Добавить должность">
</table>
</td>
<td>
<table border="1" class=klass_show style="display:none;width:400px;" id=table_klass> 
<tr><td><b>Список классов</b></td></tr>
<?
$result4=mysql_query("SELECT * FROM klass");
while($row4=mysql_fetch_array($result4))
{
extract($row4);
?>
<tr id="tr_klass<?=$id_klass?>">
<td>
<img src="images/delete.png" width=20px onclick="udal_klass(<?=$id_klass?>);">
<input type=text value="<?=$nazvanie?>" onblur="$.post('polezn.php', { klass: $(this).val(), id_klass: <?=$id_klass?>});">
<img src="images/plus2.png" width=20px onclick="$.post('polezn.php',{polezn_post:'mag',id_klass: '<?=$id_klass?>'});$('#mag<?=$id_klass?>').show();">
<img src="images/galka.png" width=20px <?if ($mag!=='!!') echo 'style=display:none';?> onclick="$.post('polezn.php',{polezn_post:'mag_no',id_klass: '<?=$id_klass?>'});$(this).hide();" id="mag<?=$id_klass?>">

</td>
</tr>
<?}?>
<img src="images/new_str.png" width=50px onclick="new_klass();" class=klass_show style=display:none title="Добавить класс">
</table>
</td>
</tr>
</table>
<br>

<form action="polezn.php" method=POST>
<table id="smena" style="display:none;width:300px;" border=3>
<tr>
<td>
<select name=sel_p1 id=sel_p1 onchange="$('#sel_p2 [value='+$(this).val()+']').remove();">
<option disabled selected>Предмет1</option>
<?
	$result3 = mysql_query("SELECT * FROM predmet ORDER BY nazvanie");
	while($row3 = mysql_fetch_array($result3))
	{
		echo '<option value='.$row3["id_p"].'>'.$row3['nazvanie'].'</option>';
	}
?>
</select>
</td>
<td>
<select name=sel_p2 id=sel_p2 onchange="$('#sel_p1 [value='+$(this).val()+']').remove();">
<option disabled selected>Предмет2</option>
<?
	$result3 = mysql_query("SELECT * FROM predmet ORDER BY nazvanie");
	while($row3 = mysql_fetch_array($result3))
	{
		echo '<option value='.$row3["id_p"].'>'.$row3['nazvanie'].'</option>';
	}
?>
</select>
</td>
<td>
<input type=submit name=smena_p value="Поменять местами предметы">
</td>
</tr>
<tr>
<td>
<select name=sel_k1 id=sel_k1 onchange="$('#sel_k2 [value='+$(this).val()+']').remove();">
<option disabled selected>Кабинет1</option>
<?
	$result2 = mysql_query("SELECT * FROM kabinet ORDER BY nomer");
	while($row2 = mysql_fetch_array($result2))
	{
		echo '<option value='.$row2["id_k"].'>'.$row2['nomer'].'</option>';
	}
?>
</select>
</td>
<td>

<select name=sel_k2 onchange="$('#sel_k1 [value='+$(this).val()+']').remove();" id=sel_k2>
<option disabled selected>Кабинет2</option>
<?
	$result2 = mysql_query("SELECT * FROM kabinet ORDER BY nomer");
	while($row2 = mysql_fetch_array($result2))
	{
		echo '<option value='.$row2["id_k"].'>'.$row2['nomer'].'</option>';
	}
?>
</select>
</td>
<td>
<input type=submit name=smena_k value="Поменять местами кабинеты">
</td>
</tr>
<tr>
<td>
<select name=sel_pp1 id=sel_pp1 onchange="$('#sel_pp2 [value='+$(this).val()+']').remove();">
<option disabled selected>Препод1</option>
<?
	$result2 = mysql_query("SELECT * FROM prepod ORDER BY fio");
	while($row2 = mysql_fetch_array($result2))
	{
		echo '<option value='.$row2["id_pp"].'>'.$row2['fio'].'</option>';
	}
?>
</select>
</td>
<td>
<select name=sel_pp2 id=sel_pp2 onchange="$('#sel_pp1 [value='+$(this).val()+']').remove();">
<option disabled selected>Препод2</option>
<?
	$result2 = mysql_query("SELECT * FROM prepod ORDER BY fio");
	while($row2 = mysql_fetch_array($result2))
	{
		echo '<option value='.$row2["id_pp"].'>'.$row2['fio'].'</option>';
	}
?>
</select>
</td>
<td>
<input type=submit name=smena_pp value="Поменять местами преподов">
</td>
</tr>
</table>
</form>


<br>
<form action="polezn.php" method=POST>
<input type=submit name=prepod value=Препод>
<input type=submit name=kabinet value=Кабинет>
<input type=submit name=predmet value=Предмет>
</form>



<table border="1" width="100%">

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
Что-то дополнительное
</b></font>
</td>
  
<td >
<font size="3"><b>
Добавить/удалить
<br>строку
<img src="images/ochist.png" width=20px onclick="if (confirm('Точно очистить?')) {$.post('polezn.php',{ochist_post:'ochist'});$('.imgg').hide(400);}">
</b></font>
</td>
  </tr>
  
<? 
if ($_POST['prepod']==true) $result6=mysql_query("SELECT id_pp FROM prepod ORDER BY fio");
if ($_POST['kabinet']==true) $result6=mysql_query("SELECT id_k FROM kabinet ORDER BY nomer");
if ($_POST['predmet']==true) $result6=mysql_query("SELECT id_p FROM predmet ORDER BY nazvanie");

if (isset($result6))
{
	while($row6=mysql_fetch_array($result6))
	{
	if ($_POST['prepod']==true) $where="WHERE id_pp='$row6[id_pp]'";
	if ($_POST['kabinet']==true) $where="WHERE id_k='$row6[id_k]'";
	if ($_POST['predmet']==true) $where="WHERE id_p='$row6[id_p]'";

	$result=mysql_query("SELECT * FROM stroka $where");
	while($row=mysql_fetch_array($result))
	{

		extract($row);
		$prepod=zapros("SELECT fio FROM prepod WHERE id_pp='$row[id_pp]'");
		$kabinet=zapros("SELECT nomer FROM kabinet WHERE id_k='$row[id_k]'");
		$predmet=zapros("SELECT nazvanie FROM predmet WHERE id_p='$row[id_p]'");
		if (($prepod==$prepod2 && $kabinet==$kabinet2 && $predmet==$predmet2 && $vr_nach==$vr_nach2 && $vr_end==$vr_end2 && $dop==$dop2 && $full==$full2 && $obyed==$obyed2)==false)
		//if ($prepod!==$prepod2 && $kabinet!==$kabinet2 && $predmet!==$predmet2 && $vr_nach!==$vr_nach2 && $vr_end!==$vr_end2 && $dop!==$dop2 && $full!==$full2 && $obyed!==$obyed2)
		{
		?>

		<?
		$id_str3=zapros("SELECT id_str FROM polezn WHERE id_str='$id_str'");
		$none='none';
		if ($id_str3==$id_str) {$none='';}
		?>

		<tr <?if ($none!=='none') echo 'style=background:#ade6bc';?> id="tab<?=$id_str?>">

		<td>
		<?echo $prepod;?>
		</td>

		<td>
		<?echo $kabinet;?>
		</td>

		<td>
		<?echo $predmet;?>
		</td>

		<td>
		<?echo $vr_nach;?>
		</td>

		<td>
		<?echo $vr_end;?>
		</td>

		<td>
		<?echo $dop;?>
		</td>

		<td>
		<img src="images/plus.png" width=20px onclick="$.post('polezn.php',{polezn_post:'yo',id_str: '<?=$id_str?>'});$('#imgg<?=$id_str?>').show();$('#tab<?=$id_str?>').css({'background':'#ade6bc'});">
		<img src="images/delete.png" width=20px onclick="udal(<?=$id_str?>);$('#tab<?=$id_str?>').css({'background':''});" id=imgg<?=$id_str?> style=display:<?=$none?> class=imgg>
		</td>
		</tr>

		<?
		}
		$prepod2=$prepod;
		$kabinet2=$kabinet;
		$predmet2=$predmet;
		$vr_nach2=$vr_nach;
		$vr_end2=$vr_end;
		$dop2=$dop;
	}
	}
}
else {echo 'Выбери что-нибудь';}
?>
</table>




<!-- Скролл вверх вниз -->
<img src="images/up.png" alt="вверх"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 0%;" class=skrit id=up>
<img src="images/down.png" alt="вниз"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 95%;" id=down class=skrit>

</body>
</html>


