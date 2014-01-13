<?php session_start();?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Расписание</title>

<link id="screenstyle" rel="stylesheet" type="text/css" href="css/style.css" media="screen" />

</head>
	

<body style="font-size:12pt;">


<?
include "config.php";


// Таблица, имя строки, WHERE
function zapros1($table,$name,$id_str)
{
$result = mysql_query("SELECT $name FROM $table WHERE id_str='$id_str'");
$row = mysql_fetch_array($result);
return $row[$name];
}

function zapros1_2($table,$name,$new,$id)
{
($new=='pp')?$result = mysql_query("SELECT $name FROM $table WHERE id_pp='$id'"):$result = mysql_query("SELECT $name FROM $table WHERE id_k='$id'");
$row = mysql_fetch_array($result);
return $row[$name];
}


$array_per=$_SESSION['array_per'];
$array_per2=$_SESSION['array_per2'];
$nn=$_SESSION['nn'];
$id_str_smen=$_SESSION['id_str_smen'];
$id_str_smen2=$_SESSION['id_str_smen2'];
$kto=$_SESSION['kto'];
		for ($kk=1;$kk<=$nn;$kk++)
		{

		$den=zapros1('stroka','den',$id_str_smen[$kk]);
		$kurs1=zapros1('stroka','kurs',$id_str_smen[$kk]);
		$kurs2=zapros1('stroka','kurs',$id_str_smen2[$kk]);
		$id_gr1=zapros1('stroka','id_gr',$id_str_smen[$kk]);
		$id_gr2=zapros1('stroka','id_gr',$id_str_smen2[$kk]);
		$id_pp=zapros1('stroka','id_pp',$id_str_smen[$kk]);
		$id_pp2=zapros1('stroka','id_pp',$id_str_smen2[$kk]);
		$id_k=zapros1('stroka','id_k',$id_str_smen[$kk]);
		$id_k2=zapros1('stroka','id_k',$id_str_smen2[$kk]);
		
		$prepod=($kto=='kabinet')?zapros1_2('prepod','fio','pp',$id_pp):'';
		$prepod2=($kto=='kabinet')?zapros1_2('prepod','fio','pp',$id_pp2):'';
		$kto_echo_p=($kto=='kabinet')?'<td>'.$prepod.'</td>':'';
		$kto_echo_p2=($kto=='kabinet')?'<td>'.$prepod2.'</td>':'';
		
		$kabinet=($kto=='prepod')?zapros1_2('kabinet','nomer','kk',$id_k):'';
		$kabinet2=($kto=='prepod')?zapros1_2('kabinet','nomer','kk',$id_k2):'';
		$kto_echo_k=($kto=='prepod')?'<td>'.$kabinet.'</td>':'';
		$kto_echo_k2=($kto=='prepod')?'<td>'.$kabinet2.'</td>':'';


// $search = array("6й класс","7й класс");
// $replace = array("Магистр.1","Магистр.2");
// $array_per[$kk] = str_replace($search, $replace, $array_per[$kk]);

// $search2 = array("6м классом","7м классом");
// $replace2 = array("Магистр-й.1","Магистр-й.2");
// $array_per2[$kk] = str_replace($search2, $replace2, $array_per2[$kk]);
		
		$array[$kk]='<tr>'.$array_per[$kk].$kto_echo_p.$kto_echo_k.'<td bgcolor=#fed2d2 nowrap><a href=javascript:window.opener.location="yacheyka.php?den='.$den.'&kurs='.$kurs1.'&id_gr='.$id_gr1.'";window.close();> <img src=images/aleft.png width=40px></a>Пересеклись с<a href=javascript:window.opener.location="yacheyka.php?den='.$den.'&kurs='.$kurs2.'&id_gr='.$id_gr2.'";window.close();><img src=images/aright.png width=40px></a></td>'.$kto_echo_p2.$kto_echo_k2.$array_per2[$kk].'</tr>';
		}
		if ($nn!==0 and $nn!==1)sort ($array);
		($kto=='prepod')?$kto_td='Фамилия И.О.':$kto_td='Кабинет';
		($kto=='prepod')?$kto_td2='Кабинет':$kto_td2='Фамилия И.О.';
		echo '<table id=uuu width="1000px" border=2px>';
		echo '<tr>
    <td><b> '.$kto_td.' </b></td>
    <td><b> День </b></td>
    <td><b> Буква </b></td>
    <td><b> Время </b></td>
    <td><b> Класс </b></td>
    <td><b> '.$kto_td2.'</b></td>
    <td></td>
    <td><b> '.$kto_td2.'</b></td>
    <td><b> Буква </b></td>
    <td><b> Время </b></td>
	<td><b> Класс </b></td>
	<tr>
	';
		
		
		
		for ($kk=1;$kk<=$nn;$kk++)
		{
		echo $array[$kk];
		}
		echo '</table>';
unset($_SESSION); 
?>

<script type="text/javascript">
	var width = document.getElementById ("uuu").offsetWidth;
	var height = document.getElementById ("uuu").offsetHeight;
	window.resizeTo(width+50,height+100);
</script>



<!-- Скрыть loading -->
<script type="text/javascript">
if (window.addEventListener) {
	window.addEventListener('load', hideLoading, false);
} else if (window.attachEvent) {
	var r = window.attachEvent("onload", hideLoading);
} else {
	hideLoading();
}
</script>
</body>
</html>