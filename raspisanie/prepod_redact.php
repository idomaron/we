
<?php
include "config.php";
include "nagruzka.php";

	function format_time($time,$prefix)
	{
		if ($time!==0)
			{
				$hour=intval($time/3600);
				$min= intval($time/60)%60;
				($time >= 3600)?$ret=$hour.' ч. '.$min.' мин.':$ret=$min.' мин.';
				($min==0)?$ret=$hour.' ч.':'';
				return $prefix.$ret;
			}
	}


	
  if ($_POST['prefix2']==TRUE) mysql_query("UPDATE prepod SET $_POST[prefix2]=''")  or die("Query failed");

  $id_pp = $_POST['id_pp'];
  if ($_POST['prefix']=='udal') {
  mysql_query("DELETE FROM prepod WHERE id_pp=$id_pp")  or die("Query failed");
  mysql_query("DELETE FROM stroka WHERE id_pp=$id_pp")  or die("Query failed");
  }
  $fio = $_POST['fio'];
  $id_dolg = $_POST['id_dolg'];
  $fio_sokr = $_POST['fio_sokr'];
  $nagruzka = $_POST['nagruzka'];
  $prim = $_POST['prim'];
  mysql_query("UPDATE prepod SET fio='$fio', id_dolg='$id_dolg', nagruzka='$nagruzka', prim='$prim',fio_sokr='$fio_sokr' WHERE id_pp='$id_pp'") or die(mysql_error()); 


  
  
if ($_POST['submit_post']==true) 
{
$header1=$_POST['header1']; 
$header2=$_POST['header2']; 
$header3=$_POST['header3']; 
$header4=$_POST['header4']; 
$header5=$_POST['header5']; 
$header6=$_POST['header6']; 
$header7=$_POST['header7']; 
mysql_query ("UPDATE table_head_prepod SET header1='$header1',header2='$header2',header3='$header3',header4='$header4',header5='$header5',header6='$header6',header7='$header7'");
}


$result4 = mysql_query("SELECT * FROM table_head_prepod");
while($row4 = mysql_fetch_array($result4))
{
$header1=$row4['header1'];
$header2=$row4['header2'];
$header3=$row4['header3'];
$header4=$row4['header4'];
$header5=$row4['header5']; 
$header6=$row4['header6']; 
$header7=$row4['header7']; 
}


(empty($sort))?$sort='DESC':'';
	

$result4 = mysql_query("SELECT * FROM prepod ORDER by fio");
if (isset($_GET['name']) or isset($_GET['sort']))
{
$name=$_GET['name']; 
$sort=$_GET['sort']; 
if ($sort=="DESC")
{
$result4 = mysql_query("SELECT * FROM prepod ORDER BY $name DESC ");
$sort="ASC";
}
else
{
$result4 = mysql_query("SELECT * FROM prepod ORDER BY $name ASC ");
$sort="DESC";
}
}



	//Функция для сортировки столбцов
	function a_sort($name2)
	{
	global $sort;
	($sort=='DESC')?$znak='▲':'';
	($sort=='ASC')?$znak='▼':'';
	echo '<a href=prepod_redact.php?name='.$name2.'&sort='.$sort.' style=text-decoration:none;display:none id='.$name2.' title=Сортировка>'.$znak.'</a>';
	}

	  


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Преподаватели</title>
<link id="screenstyle" rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<link id="screenstyle" rel="stylesheet" type="text/css" href="css/ikSelect.css" media="screen" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.color.js"></script>
<script type="text/javascript" src="js/jquery.tooltip.js"></script>
<script type="text/javascript" src="js/verx_niz.js"></script>

<!-- Save-->
<script type="text/javascript">
function soxr(id) {
var fio_ajax = $('#fio'+id).val();
var id_dolg_ajax = $('#dolgnost'+id).val();
var fio_sokr_ajax = $('#fio_sokr'+id).val();
var nagruzka_ajax = $('#nagruzka'+id).val();
var prim_ajax = $('#prim'+id).val();
$.post("prepod_redact.php", { fio: fio_ajax, id_dolg: id_dolg_ajax, fio_sokr: fio_sokr_ajax , nagruzka: nagruzka_ajax, prim: prim_ajax, id_pp: id, metka:'metka'} );
}
</script>

<!-- Udalenie-->
<script type="text/javascript">
function udal(id) {
			if (confirm('Точно удалять '+$('#fio'+id).val()+'?')) {
			$.post("prepod_redact.php", { prefix: 'udal', id_pp: id} );
			$('#tab'+id).animate({ backgroundColor: "#ff1a1a" }, "fast");
			$('#tab'+id).fadeOut("slow");
			}
			}
</script>


<!--Подсказки при наведении-->
<script type="text/javascript" src="js/podsk.js"></script>

<!--ESC-->
<script language="JavaScript">
document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
$('#prepod_show').hide();
    }
};
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
 <br />

 
 
<center>
<a href="#" onClick="document.getElementById('new_prepod').click();" title="Новая строка"><img src="images/new_str.png" width="80px"></a> &nbsp; <a href=prepod_redact.php><img src="images/reload.png" width=50px></a>
</center>

 <form method=POST action="prepod_redact.php">
<input type=submit name=new_prepod value="" id=new_prepod style=display:none>
</form>


 <? 
 //Новый препод
 if(isset($_POST['new_prepod']))
{
  mysql_query("INSERT INTO prepod (fio, id_dolg, fio_sokr, nagruzka, nagruzka_tru,prim) VALUES ('', '', '', '', '', '');");
  //echo '<script type="text/javascript">window.location = "prepod_redact.php#niz"</script>';
} ?>


<form method=POST action="prepod_redact.php">
<center><input type=submit name=submit_post value="Сменить названия столбцов" style=display:none class=show_redact></center>

<table border="1" class=tab_obsh>
  <thead>
  <th onmouseover="$('#fio').show();" onmouseout="$('#fio').hide();">
	<?=a_sort('fio')?>
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header1?>   </b></font>
<input type=text value="<?=$header1?>" style="height:30px; width:100px;display:none;" name=header1 class=show_redact>
  </th>
  
    <th onmouseover="$('#id_dolg').show();" onmouseout="$('#id_dolg').hide();">
	<?=a_sort('id_dolg')?>
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header2?> </b></font>
<input type=text value="<?=$header2?>" style="height:30px; width:100px;display:none;" name=header2 class=show_redact>
<a href="polezn.php"><img src="images/redact.png" width=40px  style=display:none class=show_redact title="Редактировать должности в полезностях" ></a>
  </th>
  
    <th onmouseover="$('#fio_sokr').show();" onmouseout="$('#fio_sokr').hide();">
	<?=a_sort('fio_sokr')?>
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header3?>  </b></font>
<input type=text value="<?=$header3?>" style="height:30px; width:100px;display:none;" name=header3 class=show_redact>
  
  </th>
  
    <th onmouseover="$('#nagruzka').show();" onmouseout="$('#nagruzka').hide();">
	<?=a_sort('nagruzka')?>
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header4?> </b></font>
<input type=text value="<?=$header4?>" style="height:30px; width:100px;display:none;" name=header4 class=show_redact>
   
  </th>
  
    <th onmouseover="$('#nagruzka_tru').show();" onmouseout="$('#nagruzka_tru').hide();">
	<?=a_sort('nagruzka_tru')?>
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header5?></b></font>
<input type=text value="<?=$header5?>" style="height:30px; width:100px;display:none;" name=header5 class=show_redact>
    
  </th>
  
      <th onmouseover="$('#prim').show();" onmouseout="$('#prim').hide();">
	<?=a_sort('prim')?>
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header6?></b></font>
<input type=text value="<?=$header6?>" style="height:30px; width:100px;display:none;" name=header6 class=show_redact>
    
  </th>

      <th>
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header7?></b></font>
<input type=text value="<?=$header7?>" style="height:30px; width:100px;display:none;" name=header7  class=show_redact>
  </th>
  
  </thead>
</form>
  <tbody>
<? 



//Общий цикл, выводящий преподов

while($row4 = mysql_fetch_array($result4))
{
	$id_pp=$row4['id_pp'];
  ?>


<form method="POST" action="prepod_redact.php" >
  <tr id="tab<?=$id_pp?>" class=bgcolor>

  <td>
<input type="text" value="<?=$row4['fio']?>" name="fio" style="width:300px"  onblur="soxr(<?=$id_pp?>);" id=fio<?=$id_pp?>>
</td>

  <td>
<!--Препод-->
<select name="id_dolg" onblur="soxr(<?=$id_pp?>);" id=dolgnost<?=$id_pp?> >
<option ></option>
<?php
$result89 = mysql_query("SELECT * FROM dolgnost");
	while($row89 = mysql_fetch_array($result89))
	{
		?>
		<option value="<?=$row89['id_dolg']?>"<?
		if ($row89['id_dolg']==$row4['id_dolg']) {echo "selected";$dolg=$row89['dolgnost'];}
		?>
		>
		<?=$row89['dolgnost']?></option> 
		<?
	}
?>
</select>


  </td>
  
  <td>
<input type="text" value="<? echo $row4['fio_sokr']; ?>" name="fio_sokr" style="width:100%"  onblur="soxr(<?=$id_pp?>);" id=fio_sokr<?=$id_pp?>>
  </td>
  
<td >
<input type=text style="width:100%" name=nagruzka value="<?=$row4['nagruzka']?>" onblur="soxr(<?=$id_pp?>);" id=nagruzka<?=$id_pp?>>
</td>

	<td>
	
<? 
	$nagruzka=abs($row4['nagruzka']*3600);
  $raznica=$row4['nagruzka_tru']-$nagruzka;
  ?>
  <div onmouseover="tooltip.show('<?
  
  if ($row4['nagruzka']=='' and $row4['nagruzka']==0) 
  {
  echo 'Нет часов нагрузки';
  } 
  else
  {
  if ($nagruzka<$row4['nagruzka_tru']) 
  {
  echo format_time(abs($raznica),'Превышает на ');
  }
  else {echo format_time(abs($raznica),'Не хватает ');}
  }
  if ($nagruzka==$row4['nagruzka_tru']) echo 'Нормалёк';
  $raznica='';
  $nagruzka='';
  ?>'); " onmouseout="tooltip.hide();"><? if ($row4['nagruzka_tru']!=='' and $row4['nagruzka_tru']!=='0')echo format_time($row4['nagruzka_tru'],'');?></div>

	</td>
<?




	?>
<td>
<input type="text" value="<?echo $row4['prim'];?>" name="prim" style="width:100%" onblur="soxr(<?=$id_pp?>);" id=prim<?=$id_pp?>>
</td>

	<td align="center" onmouseover="this.style.backgroundColor='#ff1a1a'" onmouseout="this.style.backgroundColor='#ffffff'">
<div style="display: block; width: 100%; height: 100%;text-decoration: none;" onClick="udal(<?=$id_pp?>);" id=udal<?=$id_pp?>><font color=red> &nbsp;</font></div>
	</td>


</td>
</tr>


</form>
<?}?>
</tbody>
</table>

<center>
<a href="#" onClick="document.getElementById('new_prepod').click();" title="Новая строка"><img src="images/new_str.png" width="80px"></a> 
</center>


<!-- Скролл вверх вниз -->
<img src="images/up.png" alt="вверх"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 0%;" class=skrit id=up>
<img src="images/down.png" alt="вниз"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 95%;" id=down class=skrit>

</body>
</html>


