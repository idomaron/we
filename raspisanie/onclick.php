<?php

include ('config.php');


//Вычитание времени. Результат в секундах и в чч:мм:сс. В ячейке
if ($_POST['prodolg_post']=='prodolg')
{
$id_str=$_POST['id_str_post'];
	
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
}


//Столбцы в дополнительной таблице
if (isset($_POST['id_kab_post']))
{
	mysql_query ("UPDATE dop_tabl SET id_k_dop='$_POST[id_kab_post]' WHERE ochered='$_POST[ochered_post]'") or die (mysql_error ());
	echo zapros("SELECT nomer FROM kabinet WHERE id_k=$_POST[id_kab_post]");
}

//Время в дополнительной таблице
if (isset($_POST['id_left_post']))
{
	mysql_query ("UPDATE para SET vr_nach='$_POST[vr_lev_new_post]' WHERE id='$_POST[id_left_post]'") or die (mysql_error ());
	echo zapros("SELECT vr_nach FROM para WHERE id=$_POST[id_left_post]");
}

if (isset($_REQUEST['prefix_json']))
{
	$prefix_json=$_REQUEST['prefix_json'];
	$result55 = mysql_query("SELECT * FROM redact WHERE chto='$prefix_json'");
	while($row55 = mysql_fetch_array($result55))
	{
		$json=array('color'=>$row55['color'],'bold'=>$row55['bold'],'italic'=>$row55['italic'],'font'=>$row55['font']);
		echo json_encode( $json );
	}
}

//Prepod
if ($_POST['prefix_post']=='prepod')
{mysql_query ("UPDATE stroka SET id_pp='$_POST[id_post]' WHERE id_str='$_POST[id_str_post]'");
echo zapros("SELECT fio FROM prepod WHERE id_pp='$_POST[id_post]'");
}

//Predmet
if ($_POST['prefix_post']=='predmet')
{mysql_query ("UPDATE stroka SET id_p='$_POST[id_post]' WHERE id_str='$_POST[id_str_post]'");
echo zapros("SELECT nazvanie FROM predmet WHERE id_p='$_POST[id_post]'");
}

//Kabinet
if ($_POST['prefix_post']=='kabinet')
{mysql_query ("UPDATE stroka SET id_k='$_POST[id_post]' WHERE id_str='$_POST[id_str_post]'");
echo zapros("SELECT nomer FROM kabinet WHERE id_k='$_POST[id_post]'");
}

//vr_nach
if ($_GET['prefix']=='time_nach') {
mysql_query ("UPDATE stroka SET vr_nach='$_GET[vr_nach]' WHERE id_str='$_GET[id_str]'");
//Внесение секунд в нагрузку
$id_pp2=zapros("SELECT * FROM stroka WHERE id_str='$id_str'");
$r=zapros("SELECT *,TIME_TO_SEC(vr_end) - TIME_TO_SEC(vr_nach) AS 'secundi' FROM stroka WHERE id_pp='$id_pp2'");
mysql_query ("UPDATE prepod SET nagruzka_tru='$r' WHERE id_pp='$id_pp2'") or die (mysql_error ());
}

//vr_end
if ($_GET['prefix']=='time_end') {
mysql_query ("UPDATE stroka SET vr_end='$_GET[vr_end]' WHERE id_str='$_GET[id_str]'");
//Внесение секунд в нагрузку
$id_pp2=zapros("SELECT * FROM stroka WHERE id_str='$id_str'");
$r=zapros("SELECT *,TIME_TO_SEC(vr_end) - TIME_TO_SEC(vr_nach) AS 'secundi' FROM stroka WHERE id_pp='$id_pp2'");
mysql_query ("UPDATE prepod SET nagruzka_tru='$r' WHERE id_pp='$id_pp2'") or die (mysql_error ());
}

//Дополнительно
(isset($_POST['dop_post']))?mysql_query ("UPDATE stroka SET dop='$_POST[dop_post]' WHERE id_str='$_POST[id_str_post]'"):'';

//Ошибки
($_GET['prefix']=='full')?mysql_query ("UPDATE stroka SET full='$_GET[check_get]' WHERE id_str='$_GET[id_str]'"):'';

//Обобщить занятия
($_GET['prefix']=='obyed')?mysql_query ("UPDATE stroka SET obyed='$_GET[obob_get]' WHERE id_str='$_GET[id_str]'"):'';

//Выбрать
($_GET['prefix']=='vibor')?mysql_query ("UPDATE stroka SET vibor='$_GET[vib_get]' WHERE id_str='$_GET[id_str]'"):'';

//Копировать
if ($_GET['copy']==TRUE)
{
mysql_query("TRUNCATE TABLE stroka_2;");
$id_gr=$_GET['id_gr']; 
$den=$_GET['den']; 
$kurs=$_GET['kurs'];
	$plus=0;
	$result = mysql_query("SELECT * FROM stroka WHERE den='$den' and kurs='$kurs' and id_gr='$id_gr' ORDER by vr_nach,ochered");
	while($row = mysql_fetch_array($result))
	{
		$plus++;
		mysql_query ("UPDATE stroka SET ochered='$plus' WHERE id_str='$row[id_str]'");
	}
mysql_query("INSERT INTO stroka_2 SELECT * FROM stroka WHERE kurs='$kurs' and id_gr='$id_gr' and den='$den' ORDER BY ochered;");
}


//Вырезать
if ($_GET['cut']==TRUE)
{
mysql_query("TRUNCATE TABLE stroka_2;");
$id_gr=$_GET['id_gr']; 
$den=$_GET['den']; 
$kurs=$_GET['kurs'];
	$plus=0;
	$result = mysql_query("SELECT * FROM stroka WHERE den='$den' and kurs='$kurs' and id_gr='$id_gr' ORDER by vr_nach,ochered");
	while($row = mysql_fetch_array($result))
	{
		$plus++;
		mysql_query ("UPDATE stroka SET ochered='$plus' WHERE id_str='$row[id_str]'");
	}
mysql_query("INSERT INTO stroka_2 SELECT * FROM stroka WHERE kurs='$kurs' and id_gr='$id_gr' and den='$den' ORDER BY ochered;");
$query = mysql_query("DELETE FROM stroka WHERE id_gr='$id_gr' and den='$den' and kurs='$kurs'")  or die("Query failed");
}

//Вставить
if ($_GET['paste']==TRUE)
{
$id_gr=$_GET['id_gr']; 
$den=$_GET['den']; 
$kurs=$_GET['kurs'];

$result2 = mysql_query ("SELECT id_pp,id_k,id_p,vr_nach,vr_end,full,dop,obyed,ochered,vibor FROM stroka_2;");
while($row2 = mysql_fetch_array($result2))
{
$id_pp=$row2['id_pp']; 
$id_k=$row2['id_k']; 
$id_p=$row2['id_p']; 
$vr_nach=$row2['vr_nach']; 
$vr_end=$row2['vr_end']; 
$full=$row2['full']; 
$dop=$row2['dop']; 
$obyed=$row2['obyed']; 
$ochered=$row2['ochered']; 
$vibor=$row2['vibor']; 

mysql_query ("INSERT INTO stroka (id_pp, id_k, id_p, den, vr_nach, vr_end, full,dop, kurs, id_gr, obyed, ochered, vibor)VALUES('$id_pp', '$id_k', '$id_p', '$den', '$vr_nach', '$vr_end', '$full', '$dop', '$kurs', '$id_gr', '$obyed', '$ochered', '$vibor');");  
}
//echo '<script type="text/javascript">window.location = "table.php?id_gr='.$id_gr.'"</script>';
//echo zapros("SELECT fio FROM prepod WHERE id_pp='$id_pp';");
$truu='ochered';
include ('function_table.php');
table($den,$kurs,$id_gr);
}


//Очистка ячейки в большой таблице
if ($_GET['ochist']==TRUE) 
{
$id_gr=$_GET['id_gr']; 
$den=$_GET['den']; 
$kurs=$_GET['kurs']; 
$query = mysql_query("DELETE FROM stroka WHERE id_gr='$id_gr' and den='$den' and kurs='$kurs'") or die("Query failed");
}


//Очистка большой таблицы
if ($_POST['ochist_table']=='!!') 
{
$query = mysql_query("DELETE FROM stroka WHERE id_gr='$_POST[id_gr]'") or die("Query failed");
}


//Очередь в ячейке
if ($_POST['ochered_yach']==TRUE) 
{
	$updat 	= $_POST['tab'];
	$nomer = 1;
	foreach ($updat as $rec) {
		$query = "UPDATE stroka SET ochered = " . $nomer . " WHERE id_str = " . $rec;
		mysql_query($query) or die('Error, insert query failed');
		$nomer=$nomer + 1;	
	}
}



//Новая строка в должности преподавателя
if(isset($_POST['new_dolg']))
{mysql_query("INSERT INTO dolgnost (dolgnost) VALUES ('');");
echo zapros("SELECT id_dolg FROM dolgnost ORDER by id_dolg desc LIMIT 1;");
}

//Новая строка в должности преподавателя
if(isset($_POST['new_klass']))
{mysql_query("INSERT INTO klass (nazvanie) VALUES ('');");
echo zapros("SELECT id_klass FROM klass ORDER by id_klass desc LIMIT 1;");
}

//Новая строка времени в полезностях
if(isset($_POST['new_time3']))
{mysql_query("INSERT INTO time_polezn (vr_nach, vr_end) VALUES ('00:00', '00:00');");
echo zapros("SELECT id_time FROM time_polezn ORDER by id_time desc LIMIT 1;");
}


//Удалить базу данных
if ($_POST['udal_basa']=='!!')
{mysql_query ("DROP DATABASE `$db_name`");}

//Очистить базу данных
if ($_POST['ochist_basa']=='!!')
{
mysql_query ("TRUNCATE `dolgnost`;");
mysql_query ("TRUNCATE `dop_tabl`;");
mysql_query ("TRUNCATE `gruppa`;");
mysql_query ("TRUNCATE `kabinet`;");
mysql_query ("TRUNCATE `klass`;");
mysql_query ("TRUNCATE `polezn`;");
mysql_query ("TRUNCATE `predmet`;");
mysql_query ("TRUNCATE `prepod`;");
mysql_query ("TRUNCATE `stroka`;");
mysql_query ("TRUNCATE `time_polezn`;");
mysql_query ("INSERT INTO `gruppa` (`id_gr` ,`nazvanie` ,`sokr_gr` ,`ochered`)VALUES (NULL , 'Буква А, одна', ':(', '1');");
mysql_query ("INSERT INTO `klass` (`id_klass` ,`nazvanie` ,`mag` ,`ochered`)VALUES (NULL , 'Пустой класс', '', '1');");
mysql_query ("INSERT INTO `raspisanie`.`stroka` (`id_str`, `id_pp`, `id_k`, `id_p`, `den`, `vr_nach`, `vr_end`, `dop`, `full`, `kurs`, `id_gr`, `obyed`, `ochered`, `vibor`) VALUES (NULL, '0', '0', '0', '1', '', '', '', 'false', '1', '1', 'false', NULL, 'false');");
}

/*
// какую строку редактируем?
$id_str = $_GET['id_str']; //Номер редактируемой строки
$id = $_GET['id_k']; //Номер редактируемого элемента строки
$prefix=$_GET['prefix'];  //Тип элемента строки
$id_p=$_POST['id_p'];
$nazvanie=$_POST['nazvanie'];
$sokrash=$_POST['sokrash'];
$prim=$_POST['prim'];
mysql_query ("UPDATE predmet SET nazvanie='$nazvanie', sokrash='$sokrash',prim='$prim' WHERE id_p='$id_p'") or die (mysql_error ());


if ($prefix=="kabinet") {
	// записываем в БД
	mysql_query ("UPDATE stroka SET id_k='$id' WHERE id_str='$id_str'") 
		or die (mysql_error ());
		$result4 = mysql_query("SELECT * FROM kabinet WHERE id_k='$id'");
while($row4 = mysql_fetch_array($result4))
{
	$echo=$row4['nomer'];
	// отправляем ответ на запрос, типо то что будет после нажатия селекта
	echo stripslashes ($echo);
}
}

if ($prefix=="prepod") {
	// записываем в БД
	mysql_query ("UPDATE stroka SET id_pp='$id' WHERE id_str='$id_str'") 
		or die (mysql_error ());
		
		$result4 = mysql_query("SELECT * FROM prepod WHERE id_pp='$id'");
while($row4 = mysql_fetch_array($result4))
{

	$echo=$row4['fio'];
	// отправляем ответ на запрос, типо то что будет после нажатия селекта
	echo stripslashes ($echo);
}
}


if ($prefix=="predmet") {
	// записываем в БД
	mysql_query ("UPDATE stroka SET id_p='$id' WHERE id_str='$id_str'") 
		or die (mysql_error ());
		
		$result4 = mysql_query("SELECT * FROM predmet WHERE id_p='$id'");
while($row4 = mysql_fetch_array($result4))
{

	$echo=$row4['nazvanie'];
	// отправляем ответ на запрос, типо то что будет после нажатия селекта
	echo stripslashes ($echo);
}
}






if ($prefix=="time_end") {

	// записываем в БД 
	mysql_query ("UPDATE stroka SET vr_end='$id' WHERE id_str='$id_str'") 
		or die (mysql_error ());

$result4 = mysql_query("SELECT * FROM stroka WHERE id_str='$id_str'");
while($row4 = mysql_fetch_array($result4))
{


	$echo=$row4['vr_end'];
	//if ($id==0) {echo "!!";}
	// отправляем ответ на запрос, типо то что будет после нажатия селекта
	echo stripslashes ($echo);

}
/*
//Внесение секунд в нагрузку
$result2 = mysql_query("SELECT * FROM stroka WHERE id_str='$id_str'");
while($row2 = mysql_fetch_array($result2))
{
$id_pp3=$row2['id_pp'];


$result8 = mysql_query("SELECT *,TIME_TO_SEC(vr_end) - TIME_TO_SEC(vr_nach) AS 'secundi' FROM stroka WHERE id_pp='$id_pp3'");
while($row8 = mysql_fetch_array($result8))
{
$sec=$row8['secundi'];
mysql_query ("UPDATE prepod SET nagruzka_tru='$sec' WHERE id_pp='$id_pp3'") or die (mysql_error ());
}
}


}








if ($prefix=="full") 
{
// записываем в БД 
mysql_query ("UPDATE stroka SET full='$id' WHERE id_str='$id_str'") 
or die (mysql_error ());
		
$result4 = mysql_query("SELECT * FROM stroka WHERE id_str='$id_str'");
while($row4 = mysql_fetch_array($result4))
{

	$echo=$row4['full'];
	// отправляем ответ на запрос, типо то что будет после нажатия селекта
	echo stripslashes ($echo);
}
}



if ($prefix=="obyed") 
{

// записываем в БД 
mysql_query ("UPDATE stroka SET obyed='$id' WHERE id_str='$id_str'") 
or die (mysql_error ());
		
$result5 = mysql_query("SELECT * FROM stroka WHERE id_str='$id_str'");
while($row5 = mysql_fetch_array($result5))
{

	$echo=$row5['obyed'];
	// отправляем ответ на запрос, типо то что будет после нажатия селекта
	echo stripslashes ($echo);

}
}




/*
if ($_GET['random']==TRUE)
{

$id_gr=$_GET['id_gr']; 
$den=$_GET['den']; 
$kurs=$_GET['kurs']; 

$id_pp = rand(1,130);
$id_k = rand(1,600);
$id_p = rand(1,200);
$dop = rand(1000001,9999999);

//Для рандома времени nachalo
$time = rand( 0, time() );
$chas=date("H", $time);
//Из даты вывести минуту, после целочисленного деления на 5 снова *5
$minut=(round((date("i", $time))/5))*5;
//if ($minut==5 or $minut==0) $nol=0;//Для вывода ноля
$vr_nach=$chas.':'.$nol.$minut;

//Для рандома времени end
$time = rand( 0, time() );
$chas=date("H", $time);
//Из даты вывести минуту, после целочисленного деления на 5 снова *5
$minut=(round((date("i", $time))/5))*5;
//if ($minut==5 or $minut==0) $nol=0;//Для вывода ноля
$vr_end=$chas.':'.$nol.$minut;


mysql_query("INSERT INTO stroka (id_pp, id_k, id_p, den, vr_nach, vr_end, dop, kurs, id_gr) VALUES ('$id_pp', '$id_k', '$id_p', '$den', '$vr_nach', '$vr_end', '$dop', '$kurs', '$id_gr');");

echo '<script type="text/javascript">window.location = "table.php?id_gr='.$id_gr.'"</script>';
}
*/

?>