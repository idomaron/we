<?php

include "config.php";


$mag=zapros("SELECT ochered FROM klass WHERE id_klass='$_GET[magg]';");
include ('function_table.php');

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Дополнительные классы</title>
	<link rel="stylesheet" href="css/jquery-ui-1.8.14.custom.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.ui.timepicker.css" type="text/css" />
	
	<link id="screenstyle" rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <script type="text/javascript" src="js/jquery.js"></script>
	
	<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.timepicker.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>


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


<!-- Печать документа-->
<script type="text/javascript" src="js/print.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<base href="table.php" />
<link id="printstyle" rel="stylesheet" type="text/css" href="css/print.css" media="print" />


<!--skroll-->
<script Language="JavaScript">
function jumpup()
{for (I=100; I>=1; I--)
{self.scroll(1,I)}}
function jumpdown() {
   	window.scroll(0,1000000); // horizontal and vertical scroll targets
}
</script>

<!--Открыть в новом окне по центру-->
<script type="text/javascript">
	function _open( url, width, height ) {
		window.open( url,'', 'width=' + width + ',height=' + height + ',left=' + ((window.innerWidth - width)/2) + ',top=' + ((window.innerHeight - height)/2)+',scrollbars=1');
	}	
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

<!--Подсказки-->
<script type="text/javascript">
function tool()
{$.getScript('js/jquery.tooltip.js');}
</script>


</head>

<body style="font-size:10pt;">


<a href="prepod_redact.php" class=skrit> <img src="images/prepod.png" width=50px >Препод</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="kabinet_redact.php" class=skrit><img src="images/kabinet.png" width=50px >Кабинет</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="predmet_redact.php" class=skrit><img src="images/predmet.png" width=50px >Предмет</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<center><a href="table.php" class=skrit>К большой таблице</a>
 <br />
 <a href="magistr.php?<?=$mag?>=on" class=skrit><img src="images/reload.png" width=50px></a>
 </center>
 
<center>
<form method=GET action="magistr.php" class=skrit>


<?
$result=mysql_query("SELECT * FROM klass WHERE mag='!!' ORDER by ochered");
while($row=mysql_fetch_array($result))
{
	echo '<label onmouseover="this.style.backgroundColor=\'#f9fd30\'" onmouseout="this.style.backgroundColor=\'\'"><input type=radio name="magg" value="'.$row['id_klass'].'">'.$row['nazvanie'].'</label><br>';
}
?>
<input type=submit value="Выбрать"  class=skrit>
</form>
 </center>
 
 
<div class="panel" nowrap><!--Панелька справа-->

	<!-- Печать, эксель и сохр.-->
	<div id="printversion">
		<a id="togglestyle" href="#" onclick="toggleStylesheet('<img src=images/print_vers.png width=50px>','<img src=images/back.png width=50px style=position:absolute;right:0px;>'); return false; "><img src="images/print_vers.png" width=50px title="Версия для печати"></a>
		<a href="javascript:print();"  id="printdocument"><img src="images/print.png" width=50px title="Печать"></a>
		<img src="images/excel.png" onclick="document.getElementById('datatodisplay2').click();" width=50px style="cursor:pointer;" class=skrit title="Экспорт в EXCEL">
		<img src="images/save.png" title="Сохранить базу данных" width=50px class=skrit onclick="_open( 'dumper.php', 400 , 350 );" style="cursor:pointer;">
	</div>
<img src="images/help.png" onclick="tool();$('#pomosh').show();" style="cursor:pointer;" width=50px class=skrit title="Включить отображение подсказок при наведении (Действует пока не перезагрузилась страница)">
<a href="help.php" target="_blank"  title="Открыть общую подсказку"><img src="images/pomosh.png" style="display:none;cursor:pointer;" width=50px id="pomosh"></a>
	<div class=content style="float:right">
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




<center>
<?echo zapros("SELECT nazvanie FROM klass WHERE id_klass='$_GET[magg]';");?>
</center>
<div id="mytable"  >

<table border="2" id="table" width="100%" onmouseover="id_gr(<?=$id_gr?>)">

<tr>
<td>&nbsp;</td>

<?

$result = mysql_query("SELECT * FROM gruppa ORDER BY id_gr");
while($row = mysql_fetch_array($result))
{
$id_gr = $row['id_gr'];
$nazvanie = $row['nazvanie'];

?>
<td><a href=table.php?id_gr=<?=$id_gr?> style="font-size:16px;" ><?=$nazvanie?></a></td>
<? 

}

?>
  
  
</tr>
<tr >
<td bgcolor="#e8e8e8"><b> Понедельник </b></td>
<?
$result6 = mysql_query("SELECT * FROM gruppa ORDER BY id_gr");
while($row6 = mysql_fetch_array($result6))
{
$id_gr6=$row6['id_gr'];
echo '<td valign=top class=tab id="myDiv1'.$mag.$id_gr6.'">';
table (1,$mag,$row6['id_gr']);
echo '</td>';
}
?>

</tr>
<tr>
<td bgcolor="#e8e8e8"><b> Вторник </b></td>

<?
$result = mysql_query("SELECT * FROM gruppa ORDER BY id_gr");
while($row = mysql_fetch_array($result))
{
$id_gr = $row['id_gr'];
echo '<td valign=top class=tab id="myDiv2'.$mag.$id_gr.'">';
table (2,$mag,$id_gr);
echo '</td>';
}
?>

</tr>
<tr>
<td bgcolor="#e8e8e8"><b> Среда </b></td>
<?
$result6 = mysql_query("SELECT * FROM gruppa ORDER BY id_gr");
while($row6 = mysql_fetch_array($result6))
{
$id_gr6=$row6['id_gr'];
echo '<td valign=top class=tab id="myDiv3'.$mag.$id_gr6.'">';
table (3,$mag,$row6['id_gr']);
echo '</td>';
}
?>
</tr>
<tr>
<td bgcolor="#e8e8e8"><b> Четверг </b></td>
<?
$result6 = mysql_query("SELECT * FROM gruppa ORDER BY id_gr");
while($row6 = mysql_fetch_array($result6))
{
$id_gr6=$row6['id_gr'];
echo '<td valign=top class=tab id="myDiv4'.$mag.$id_gr6.'">';
table (4,$mag,$row6['id_gr']);
echo '</td>';
}
?>
</tr>
<tr>
<td bgcolor="#e8e8e8"><b> Пятница </b></td>
<?
$result6 = mysql_query("SELECT * FROM gruppa ORDER BY id_gr");
while($row6 = mysql_fetch_array($result6))
{
$id_gr6=$row6['id_gr'];
echo '<td valign=top class=tab id="myDiv5'.$mag.$id_gr6.'">';
table (5,$mag,$row6['id_gr']);
echo '</td>';
}
?>
</tr>
<tr>
<td bgcolor="#e8e8e8"><b> Суббота </b></td>
<?
$result6 = mysql_query("SELECT * FROM gruppa ORDER BY id_gr");
while($row6 = mysql_fetch_array($result6))
{
$id_gr6=$row6['id_gr'];
echo '<td valign=top class=tab id="myDiv6'.$mag.$id_gr6.'">';
table (6,$mag,$row6['id_gr']);
echo '</td>';
}
?>
</tr>
</table>



</div><!--Конец дива в котором таблица-->




	<!-- Скролл вверх вниз -->
	<a href="javascript:jumpup()">
	<img src="images/up.png" alt="вверх"  border="0" width="60" height="40" style="position: fixed; left: 60%; top: 0%;">
	</a>

	<a href="javascript:jumpdown()">
	<img src="images/down.png" alt="вниз"  border="0" width="60" height="40" style="position: fixed; left: 60%; top: 95%;">
	</a>

</body>
</html>

