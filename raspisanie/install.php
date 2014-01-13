<?php
header('Content-Type: text/html; charset=utf-8');
if($_POST['button'] == "Создать")
{
    // Подключаемся к серверу, 
	$db_host = htmlspecialchars($_POST['name_server']); 
	// пользователь базы данных MySQL 
	$db_user = htmlspecialchars($_POST['login']);
	// пароль для доступа к серверу MySQL
	$db_pass = htmlspecialchars($_POST['db_pass']);
	// название создаваемой базы данных
	$db_name = htmlspecialchars($_POST['name_db']); 
	
	$kolvo_soxr2=$_POST['kolvo_soxr2'];
	}
if ($_POST['default']==true)
{
$connect = mysql_connect('localhost','root','') or die("Ошибка соединения с сервером");
$query = "CREATE DATABASE IF NOT EXISTS raspisanie";
$result = mysql_query ($query) or die ("Ошибка создания БД");
$db = mysql_select_db("raspisanie",$connect)  or die ("База данных не выбрана");

$db_host='localhost';
$db_user='root';
$db_pass='';
$db_name='raspisanie';
$kolvo_soxr2=4;
}
	

	
	
	
if($_POST['button'] == true or $_POST['default']==true)
{
    if(!empty($db_host) && !empty($db_user) && !empty($db_name))
	{
		if(@!mysql_connect("$db_host", "$db_user", "$db_pass"))
		{
			echo "<strong>Невозможно подключение к серверу.</strong><br> <br>
                   <p align=left><b> Возможные причины:</b><br>
					1. Не правильно введён пароль. (по умолчанию пороль отсутствует)<br>
                    2. Имя сервера введено не верно.<br>
                    3. Логин доступа к серверу базы данных MySQL не идентифицирован.</p>";
		}
		$r = mysql_query("CREATE DATABASE IF NOT EXISTS $db_name");
		if(!$r)
		{
			echo "<strong>Невозможно создать базу данных.</strong><br> <br>
                   <p align=left><b> Возможные причины:</b><br>
					База данных уже существует, создана ранее.</p>";
		}

		
		if (!mysql_select_db($db_name))
		{
			echo mysql_error();
		}
		mysql_query('SET NAMES utf-8;');
		
// Создаём конфигурационный файл		
$data = "<?
\$db_host = '".$db_host."'; //имя MySQL-сервера
\$db_user = '".$db_user."'; // имя пользователя
\$db_pass = '".$db_pass."'; // пароль
\$db_name = '".$db_name."'; // имя БАЗЫ
\$kolvo_soxr = '".$kolvo_soxr2."'; //Количество сохранений БД
// устанавливаем соединение с БД
mysql_connect(\$db_host,\$db_user,\$db_pass) or die('Отсутствует подключение к MySQL-серверу.<br />'.mysql_error());
mysql_select_db(\$db_name) or die('Ne podkluchaetsa k .'.\$db_name .'<br />'.mysql_error().'<br><a href=\"install.php\">install</a>');
mysql_query(\"set character_set_client='utf8'\");
mysql_query(\"set character_set_results='utf8'\");
mysql_query(\"set collation_connection='utf8_unicode_ci'\");

function zapros(\$select) {
 \$result = mysql_query(\$select);
 \$row = mysql_fetch_array(\$result);
 return(\$row[0]);
}
\$dni_arr=array(\"\",\"Понедельник\",\"Вторник\",\"Среда\",\"Четверг\",\"Пятница\",\"Суббота\");
?>";
		$hd = fopen('config.php',"w");
		$e = fwrite($hd, $data);
		if($e == -1)
		{
		   echo "Ошибка. Конфигурационный файл не создан.";	
		}
		$echo="<center><div>База данных<b> \"$db_name\" </b>успешно создана.<br>
        <a href='index.php'>Далее</a></div></center>";
	
mysql_query ("SET NAMES utf8;");


mysql_query (" CREATE TABLE IF NOT EXISTS `checked` (
  `fio_sokrat` text COLLATE utf8_unicode_ci NOT NULL,
  `predmet_sokrat` text COLLATE utf8_unicode_ci NOT NULL,
  `dop` text COLLATE utf8_unicode_ci NOT NULL,
  `okno_den` text COLLATE utf8_unicode_ci NOT NULL,
  `okno_kurs` text COLLATE utf8_unicode_ci NOT NULL,
  `okno_chas` text COLLATE utf8_unicode_ci NOT NULL,
  `okno_min` text COLLATE utf8_unicode_ci NOT NULL,
  `pechat` text COLLATE utf8_unicode_ci NOT NULL,
  `nowrap_check` text COLLATE utf8_unicode_ci NOT NULL,
  `poloska` text COLLATE utf8_unicode_ci NOT NULL,
  `mag` text COLLATE utf8_unicode_ci NOT NULL,
  `okno_check` text COLLATE utf8_unicode_ci NOT NULL,
  `vibor_check` text COLLATE utf8_unicode_ci NOT NULL,
  `povorot` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

mysql_query (" INSERT INTO `checked` (`fio_sokrat`, `predmet_sokrat`, `dop`, `okno_den`, `okno_kurs`, `okno_chas`, `okno_min`, `pechat`, `nowrap_check`, `poloska`, `mag`, `okno_check`, `vibor_check`) VALUES
('on', 'on', 'on', '', '', '', '', '', '', '|||', 'on', '', '');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `dolgnost` (
  `id_dolg` int(5) NOT NULL AUTO_INCREMENT,
  `dolgnost` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_dolg`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

");

mysql_query (" INSERT INTO `dolgnost` (`id_dolg`, `dolgnost`) VALUES
(1, 'Профессор'),
(2, 'Старший преподаватель'),
(3, 'Преподаватель');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `dop_tabl` (
  `id_k_dop` text COLLATE utf8_unicode_ci NOT NULL,
  `ochered` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

mysql_query (" INSERT INTO `dop_tabl` (`id_k_dop`, `ochered`) VALUES
('10', '1'),
('8', '3'),
('11', '4'),
('9', '6'),
('12', '8');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `gruppa` (
  `id_gr` int(5) NOT NULL AUTO_INCREMENT,
  `nazvanie` text COLLATE utf8_unicode_ci NOT NULL,
  `sokr_gr` text COLLATE utf8_unicode_ci NOT NULL,
  `ochered` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_gr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

");

mysql_query (" INSERT INTO `gruppa` (`id_gr`, `nazvanie`, `sokr_gr`, `ochered`) VALUES
(1, 'Буква А', 'А', 1),
(2, 'Буква Б', 'Б', 2),
(11, 'Индивидуально', 'Инд.', 4),
(10, 'Буква В', 'В', 3);

");

mysql_query (" CREATE TABLE IF NOT EXISTS `kabinet` (
  `id_k` int(5) NOT NULL AUTO_INCREMENT,
  `nomer` text COLLATE utf8_unicode_ci NOT NULL,
  `mesta` text COLLATE utf8_unicode_ci NOT NULL,
  `prim` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_k`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

");

mysql_query (" INSERT INTO `kabinet` (`id_k`, `nomer`, `mesta`, `prim`) VALUES
(10, '103', '', ''),
(8, '101', '', ''),
(11, 'Спортзал', '', ''),
(9, '102', '', ''),
(12, 'Актовый зал', '', '');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `klass` (
  `id_klass` int(5) NOT NULL AUTO_INCREMENT,
  `nazvanie` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mag` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ochered` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_klass`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

");

mysql_query (" INSERT INTO `klass` (`id_klass`, `nazvanie`, `mag`, `ochered`) VALUES
(1, '1й класс', '', '1'),
(2, '2й класс', '', '2'),
(3, '3й класс', '', '3'),
(4, '4й класс', '', '4'),
(5, 'Подготовишка 1', '!!', '5'),
(6, 'Подготовишка 2', '!!', '6');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `para` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `vr_nach` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

");

mysql_query (" INSERT INTO `para` (`id`, `vr_nach`) VALUES
(1, '09:00'),
(2, '09:50'),
(3, '10:45'),
(5, '11:35'),
(6, '13:00'),
(7, '13:50'),
(8, '14:45'),
(9, '15:35'),
(10, '16:30'),
(11, '17:15'),
(12, '18:00');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `polezn` (
  `id_str` int(5) NOT NULL AUTO_INCREMENT,
  `id_pp` int(5) NOT NULL,
  `id_k` int(5) NOT NULL,
  `id_p` int(5) NOT NULL,
  `den` int(5) NOT NULL,
  `vr_nach` text COLLATE utf8_unicode_ci NOT NULL,
  `vr_end` text COLLATE utf8_unicode_ci NOT NULL,
  `dop` text COLLATE utf8_unicode_ci NOT NULL,
  `full` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `kurs` int(4) NOT NULL,
  `id_gr` int(5) NOT NULL,
  `obyed` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `ochered` int(5) DEFAULT NULL,
  `vibor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id_str`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=74 ;

");

mysql_query (" INSERT INTO `polezn` (`id_str`, `id_pp`, `id_k`, `id_p`, `den`, `vr_nach`, `vr_end`, `dop`, `full`, `kurs`, `id_gr`, `obyed`, `ochered`, `vibor`) VALUES
(20, 2, 9, 3, 3, '07:00', '08:00', '', 'false', 6, 1, 'false', NULL, 'true'),
(14, 5, 11, 1, 1, '09:00', '10:35', '', 'false', 1, 1, 'false', NULL, 'false');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `predmet` (
  `id_p` int(5) NOT NULL AUTO_INCREMENT,
  `nazvanie` text COLLATE utf8_unicode_ci NOT NULL,
  `sokrash` text COLLATE utf8_unicode_ci NOT NULL,
  `prim` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_p`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

");

mysql_query (" INSERT INTO `predmet` (`id_p`, `nazvanie`, `sokrash`, `prim`) VALUES
(1, 'Физкультура', 'Физ-ра', ''),
(2, 'Математика', 'Мат-ика', ''),
(3, 'Русский язык', 'Рус.яз.', ''),
(4, 'Труды', 'Труд', '');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `prepod` (
  `id_pp` int(11) NOT NULL AUTO_INCREMENT,
  `fio` text COLLATE utf8_unicode_ci NOT NULL,
  `id_dolg` text COLLATE utf8_unicode_ci NOT NULL,
  `nagruzka` text COLLATE utf8_unicode_ci NOT NULL,
  `nagruzka_tru` text COLLATE utf8_unicode_ci NOT NULL,
  `prim` text COLLATE utf8_unicode_ci NOT NULL,
  `fio_sokr` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_pp`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

");

mysql_query (" INSERT INTO `prepod` (`id_pp`, `fio`, `id_dolg`, `nagruzka`, `nagruzka_tru`, `prim`, `fio_sokr`) VALUES
(3, 'Иванова Юлия Владимировна', '2', '', '54000', '', 'Иванова Ю.В.'),
(1, 'Петров Петр Петрович', '1', '145', '28800', '', 'Петров П.П.'),
(2, 'Сидоров Сидр Спиридонович', '3', '', '80400', '', 'Сидоров С.С.'),
(5, 'Главный Юрий Какойнович', '1', '', '', 'Дополнительная инфа', 'Главный Ю.К.');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `redact` (
  `chto` text COLLATE utf8_unicode_ci,
  `color` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#000000',
  `bold` text COLLATE utf8_unicode_ci,
  `italic` text COLLATE utf8_unicode_ci,
  `font` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

mysql_query (" INSERT INTO `redact` (`chto`, `color`, `bold`, `italic`, `font`) VALUES
('kabinet', '#4252cd', 'on', 'on', '3'),
('predmet', '#3d6f39', 'on', 'on', '3'),
('vr_nach', '#0d0c0d', 'on', '', '2'),
('vr_end', '#2c2d20', 'on', '', '2'),
('prepod', '#6f2f65', 'on', '', '3');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `stroka` (
  `id_str` int(5) NOT NULL AUTO_INCREMENT,
  `id_pp` int(5) NOT NULL,
  `id_k` int(5) NOT NULL,
  `id_p` int(5) NOT NULL,
  `den` int(5) NOT NULL,
  `vr_nach` text COLLATE utf8_unicode_ci NOT NULL,
  `vr_end` text COLLATE utf8_unicode_ci NOT NULL,
  `dop` text COLLATE utf8_unicode_ci NOT NULL,
  `full` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `kurs` int(4) NOT NULL,
  `id_gr` int(5) NOT NULL,
  `obyed` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `ochered` int(5) DEFAULT NULL,
  `vibor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id_str`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

");

mysql_query (" INSERT INTO `stroka` (`id_str`, `id_pp`, `id_k`, `id_p`, `den`, `vr_nach`, `vr_end`, `dop`, `full`, `kurs`, `id_gr`, `obyed`, `ochered`, `vibor`) VALUES
(23, 3, 2, 2, 5, '07:00', '22:00', '', 'false', 5, 10, 'false', 1, 'false'),
(24, 1, 8, 2, 5, '13:00', '14:35', '', 'false', 5, 10, 'false', 2, 'false'),
(22, 3, 2, 2, 3, '07:00', '22:00', '', 'false', 2, 2, 'false', 1, 'false'),
(20, 2, 9, 3, 3, '07:00', '08:00', '', 'false', 6, 1, 'false', 1, 'true'),
(19, 1, 10, 4, 3, '13:00', '15:00', '', 'false', 6, 1, 'false', 2, 'false'),
(18, 3, 8, 3, 1, '16:30', '18:05', '', 'false', 1, 1, 'false', 4, 'false'),
(21, 1, 8, 2, 3, '13:00', '14:35', '', 'false', 2, 2, 'false', 2, 'false'),
(14, 5, 11, 1, 1, '09:00', '10:35', '', 'false', 1, 1, 'false', 1, 'false'),
(15, 5, 11, 1, 1, '10:45', '12:20', '', 'false', 1, 1, 'false', 2, 'false'),
(16, 0, 10, 2, 1, '13:00', '14:35', 'Семинар', 'false', 1, 1, 'false', 3, 'false'),
(25, 3, 2, 2, 4, '07:00', '22:00', '', 'false', 1, 10, 'false', 1, 'false'),
(26, 1, 8, 2, 4, '13:00', '14:35', '', 'false', 1, 10, 'false', 2, 'false'),
(27, 2, 9, 3, 4, '07:00', '08:00', '', 'false', 1, 10, 'false', NULL, 'true'),
(28, 5, 11, 1, 6, '14:00', '19:00', '', 'true', 1, 11, 'false', 1, 'false'),
(29, 5, 11, 1, 6, '14:00', '19:00', '', 'true', 2, 11, 'false', 1, 'false'),
(30, 5, 11, 1, 6, '14:00', '19:00', '', 'true', 3, 11, 'false', 1, 'false'),
(31, 5, 11, 1, 6, '14:00', '19:00', '', 'false', 4, 11, 'false', 1, 'false'),
(32, 5, 11, 1, 1, '14:00', '19:00', '', 'false', 5, 11, 'false', 1, 'false'),
(33, 5, 11, 1, 2, '09:00', '10:35', '', 'false', 1, 1, 'false', 1, 'false'),
(34, 5, 11, 1, 2, '10:45', '12:20', '', 'false', 1, 1, 'false', 2, 'false'),
(35, 0, 10, 2, 2, '13:00', '14:35', 'Семинар', 'false', 1, 1, 'false', 3, 'false'),
(36, 3, 8, 3, 2, '16:30', '18:05', '', 'false', 1, 1, 'false', 4, 'false'),
(37, 2, 9, 3, 2, '07:00', '08:00', '', 'false', 3, 1, 'false', 1, 'true'),
(38, 1, 10, 4, 2, '13:00', '15:00', '', 'false', 3, 1, 'false', 2, 'false'),
(39, 2, 9, 3, 2, '07:00', '08:00', '', 'true', 4, 1, 'false', 1, 'true'),
(40, 1, 10, 4, 2, '13:00', '15:00', '', 'true', 4, 1, 'false', 2, 'false'),
(41, 1, 9, 4, 4, '12:00', '13:35', '', 'false', 4, 2, 'false', NULL, 'false'),
(42, 3, 9, 4, 4, '12:00', '13:35', '', 'false', 4, 2, 'true', NULL, 'false'),
(43, 2, 10, 1, 4, '15:00', '17:30', '', 'false', 4, 2, 'false', NULL, 'false'),
(46, 5, 11, 3, 4, '06:00', '08:00', '', 'false', 4, 2, 'false', NULL, 'false'),
(47, 3, 2, 2, 2, '07:00', '22:00', '', 'false', 5, 1, 'false', 1, 'false'),
(48, 1, 8, 2, 2, '13:00', '14:35', '', 'false', 5, 1, 'false', 2, 'false');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `stroka_2` (
  `id_str` int(5) NOT NULL,
  `id_pp` int(5) NOT NULL,
  `id_k` int(5) NOT NULL,
  `id_p` int(5) NOT NULL,
  `den` int(5) NOT NULL,
  `vr_nach` text COLLATE utf8_unicode_ci NOT NULL,
  `vr_end` text COLLATE utf8_unicode_ci NOT NULL,
  `dop` text COLLATE utf8_unicode_ci NOT NULL,
  `full` text COLLATE utf8_unicode_ci NOT NULL,
  `kurs` int(4) NOT NULL,
  `id_gr` int(5) NOT NULL,
  `obyed` text COLLATE utf8_unicode_ci NOT NULL,
  `ochered` int(5) DEFAULT NULL,
  `vibor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

mysql_query (" CREATE TABLE IF NOT EXISTS `table_head_kabinet` (
  `header1` text COLLATE utf8_unicode_ci NOT NULL,
  `header2` text COLLATE utf8_unicode_ci NOT NULL,
  `header3` text COLLATE utf8_unicode_ci NOT NULL,
  `header4` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

mysql_query (" INSERT INTO `table_head_kabinet` (`header1`, `header2`, `header3`, `header4`) VALUES
('Номер кабинета', 'Вместимость', 'Примечание', 'Удалить'),
('Номер кабинета', 'Вместимость', 'Примечание', 'Удалить'),
('Номер кабинета', 'Вместимость', 'Примечание', 'Удалить'),
('Номер кабинета', 'Вместимость', 'Примечание', 'Удалить');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `table_head_predmet` (
  `header1` text COLLATE utf8_unicode_ci NOT NULL,
  `header2` text COLLATE utf8_unicode_ci NOT NULL,
  `header3` text COLLATE utf8_unicode_ci NOT NULL,
  `header4` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

mysql_query (" INSERT INTO `table_head_predmet` (`header1`, `header2`, `header3`, `header4`) VALUES
('Предмет', 'Сокращённый', 'Примечание', 'Удалить'),
('Предмет', 'Сокращённый', 'Примечание', 'Удалить'),
('Предмет', 'Сокращённый', 'Примечание', 'Удалить'),
('Предмет', 'Сокращённый', 'Примечание', 'Удалить');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `table_head_prepod` (
  `header1` text COLLATE utf8_unicode_ci,
  `header2` text COLLATE utf8_unicode_ci,
  `header3` text COLLATE utf8_unicode_ci,
  `header4` text COLLATE utf8_unicode_ci,
  `header5` text COLLATE utf8_unicode_ci,
  `header6` text COLLATE utf8_unicode_ci,
  `header7` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

mysql_query (" INSERT INTO `table_head_prepod` (`header1`, `header2`, `header3`, `header4`, `header5`, `header6`, `header7`) VALUES
('Фио', 'Должность', 'Ф.И.О.', 'Нагрузка (должна быть)', 'Нагрузка есть', 'Примечание', 'Удалить'),
('Фио', 'Должность', 'Ф.И.О.', 'Нагрузка (должна быть)', 'Нагрузка есть', 'Примечание', 'Удалить'),
('Фио', 'Должность', 'Ф.И.О.', 'Нагрузка (должна быть)', 'Нагрузка есть', 'Примечание', 'Удалить'),
('Фио', 'Должность', 'Ф.И.О.', 'Нагрузка (должна быть)', 'Нагрузка есть', 'Примечание', 'Удалить');

");

mysql_query (" CREATE TABLE IF NOT EXISTS `time_polezn` (
  `id_time` int(11) NOT NULL AUTO_INCREMENT,
  `vr_nach` text COLLATE utf8_unicode_ci NOT NULL,
  `vr_end` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

");

mysql_query (" INSERT INTO `time_polezn` (`id_time`, `vr_nach`, `vr_end`) VALUES
(1, '09:00', '10:35'),
(2, '10:45', '12:20'),
(3, '13:00', '14:35'),
(4, '14:45', '16:20'),
(5, '16:30', '18:05');");
mysql_query ("SET FOREIGN_KEY_CHECKS=1;");
mysql_query ("COMMIT;");
//mysql_close($connect);


//$rus=iconv('utf-8', 'cp1251', 'Удалите эту папку, если всё нормально установилось');
//mkdir($rus, 0777); 
//copy("install.php", $rus.'/install.php');
//unlink("install.php");
//rename('instal.php','333.php');

	}
	else
	{
		$oshibka='<center>Не все поля заполнены.</center>';
	}

}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Установка</title>
</head>

<body>

<form method="post" action="install.php">
  <div class="centers">
    <!--<p align="left">Поля отмеченные звёздочкой (<span class='red'></span>), обязательны к заполнению.</p>--><br>
    <br>
     <table align="center" width="483" border="0" cellpadding="5" cellspacing="5">
      <tr>
        <td colspan="2" align="center"><strong> СОЗДАТЬ БАЗУ ДАННЫХ </strong></td>
      </tr>
      <tr>
        <td width="224" align="right"><span class='red'></span>Имя сервера:</td>
        <td width="227" align="left"><input name="name_server" type="text" placeholder="localhost" size="30" maxlength="45"></td>
      </tr>
      <tr>
        <td align="right"><span class='red'></span>Логин :</td>
        <td><input name="login" type="text" placeholder="root"  size="20" maxlength="25"></td>
      </tr>
      <tr>
        <td align="right">Пароль:</td>
        <td><input name="db_pass" type="text" size="20" maxlength="20"></td>
      </tr>
      <tr>
        <td align="right"><span class='red'></span>Имя БД:</td>
        <td><input name="name_db" type="text" value="<?php echo $db_name; ?>" size="30" maxlength="30" placeholder="raspisanie"></td>
      </tr>
	  <tr>
        <td align="right"><span class='red'></span>Количество максимальных сохранений БД, при максимальном сжатии.</td>
        <td><input name="kolvo_soxr2" type="text" placeholder="4" size="30" maxlength="30"></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td><label>
          <input type="submit" name="button" id="button" value="Создать" class="buts">
        </label>
		<input type=submit value="Если лень думать &#xa; жми сюда" name=default title="По умолчанию.Создаётся маленькое расписание, чтобы его потом очистить жми ctrl+*">
		</td>
      </tr>
    </table>
  </div>
</form>
<?=$echo?>
<?=$oshibka?>
</body>
</html>