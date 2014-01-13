
<?
include ('config.php');

if ($_POST['submit_post']==true) 
{
$header1=$_POST['header1']; 
$header2=$_POST['header2']; 
$header3=$_POST['header3']; 
$header4=$_POST['header4']; 
mysql_query ("UPDATE table_head_kabinet SET header1='$header1',header2='$header2',header3='$header3',header4='$header4'");
}

$result4 = mysql_query("SELECT * FROM table_head_kabinet");
while($row4 = mysql_fetch_array($result4))
{
$header1=$row4['header1'];
$header2=$row4['header2'];
$header3=$row4['header3'];
$header4=$row4['header4'];
}


//Сохранение изменений в данной строке
$id_k=$_POST['id_k'];
$nomer=$_POST['nomer'];
$mesta=$_POST['mesta'];
$prim=$_POST['prim'];
mysql_query ("UPDATE kabinet SET nomer='$nomer', mesta='$mesta',prim='$prim' WHERE id_k='$id_k'") or die (mysql_error ());

//Удаление кабинета (также из общей таблицы)
if ($_POST['prefix']=='udal') 
{
mysql_query("DELETE FROM kabinet WHERE id_k=$id_k")  or die("Query failed");
mysql_query("DELETE FROM stroka WHERE id_k=$id_k")  or die("Query failed");
}

//Новая строка с пустыми значениями
 if(isset($_POST['new_kabinet']))
 {
mysql_query("INSERT INTO kabinet (nomer, mesta, prim) VALUES ('', '', '');");
 }
 

(empty($sort))?$sort='DESC':'';

$result4 = mysql_query("SELECT * FROM kabinet ORDER by nomer");
if (isset($_GET['name']) or isset($_GET['sort']))
{
$name=$_GET['name']; 
$sort=$_GET['sort']; 
if ($sort=="DESC")
{
$result4 = mysql_query("SELECT * FROM kabinet ORDER BY $name DESC ");
$sort="ASC";
}
else
{
$result4 = mysql_query("SELECT * FROM kabinet ORDER BY $name ASC ");
$sort="DESC";
}
}



	//Функция для сортировки столбцов
	function a_sort($name2)
	{
	global $sort;
	($sort=='DESC')?$znak='▲':'';
	($sort=='ASC')?$znak='▼':'';
	echo '<a href=kabinet_redact.php?name='.$name2.'&sort='.$sort.' style=text-decoration:none;display:none; id='.$name2.' title=Сортировка>'.$znak.'</a>';
	}



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Кабинеты</title>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.color.js"></script>
<script type="text/javascript" src="js/dop.js"></script>
<!-- Подсвечивание строки таблицы-->
<script type="text/javascript" src="js/table.js"></script>
<link rel="stylesheet" href="css/style.css" type="text/css">
<script type="text/javascript" src="js/verx_niz.js"></script>

<!-- Save-->
<script type="text/javascript">
function soxr(id) {
var nomer_ajax = $('#nomer'+id).val();
var mesta_ajax = $('#mesta'+id).val();
var prim_ajax = $('#prim'+id).val();
$.post("kabinet_redact.php", { prim: prim_ajax, nomer: nomer_ajax, mesta: mesta_ajax , id_k: id} );
}
</script>

<!-- Udalenie-->
<script type="text/javascript">
function udal(id) {
			if (confirm('Точно удалять '+$('#nomer'+id).val()+'?')) {
			$.post("kabinet_redact.php", { prefix: 'udal', id_k: id} );
			$('#tab'+id).animate({ backgroundColor: "#ff1a1a" }, "fast");
			$('#tab'+id).fadeOut("slow");
		}
	}
</script>

<!--ESC-->
<script language="JavaScript">
document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
$('#kabinet_show').hide();
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
<a href="#" onClick="document.getElementById('new_kabinet').click();" title="Новая строка"><img src="images/new_str.png" width="80px"></a> &nbsp; <a href=kabinet_redact.php><img src="images/reload.png" width=50px></a>
</center>

<form method=POST action="kabinet_redact.php">
<input type=submit name=new_kabinet value="" id=new_kabinet style=display:none>
</form>

<form method=POST action="kabinet_redact.php">
<center><input type=submit name=submit_post value="Сменить названия столбцов" style=display:none class=show_redact></center>

<table border="1" class=tab_obsh >
<thead>


    <th onmouseover="$('#nomer').show();" onmouseout="$('#nomer').hide();" width="500px">
	<?=a_sort('nomer')?>
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header1?>   </b></font>
<input type=text value="<?=$header1?>" style="height:30px; width:100px;display:none;" name=header1 class=show_redact>
  </th>

      <th onmouseover="$('#mesta').show();" onmouseout="$('#mesta').hide();" width="50px">
	<?=a_sort('mesta')?>
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header2?>   </b></font>
<input type=text value="<?=$header2?>" style="height:30px; width:100px;display:none;" name=header2 class=show_redact>
  </th>


        <th onmouseover="$('#prim').show();" onmouseout="$('#prim').hide();" width="50px">
	<?=a_sort('prim')?>
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header3?>   </b></font>
<input type=text value="<?=$header3?>" style="height:30px; width:100px;display:none;" name=header3 class=show_redact>
  </th>

  
        <th width="50px">
    <font size="3" class=hide_redact ondblclick="$('.show_redact').show();$('.hide_redact').hide();"><b>
<?=$header4?></b></font>
<input type=text value="<?=$header4?>" style="height:30px; width:100px;display:none;" name=header4  class=show_redact>
  </th>
  
</thead>
</form>

<tbody>

<?

while($row4 = mysql_fetch_array($result4))
{
$id_k1=$row4['id_k'];
//Для якоря
$i++;
?>



<form method="POST" action="kabinet_redact.php#yak<?echo $i-10;?>">

    <tr id="tab<?=$id_k1?>" class=bgcolor>

 


  <td>
<input type="text" value="<?echo $row4['nomer'];?>" name="nomer" style="width:100%" id=nomer<?=$id_k1?> onblur="soxr(<?=$id_k1?>);">
</td>

    <td>
<input type="text" value="<?echo $row4['mesta'];?>" name="mesta" style="width:100%" placeholder="Пусто" id=mesta<?=$id_k1?> onblur="soxr(<?=$id_k1?>);">
  </td>
  
    <td>
<input type="text" value="<?echo $row4['prim'];?>" name="prim" style="width:100%" id=prim<?=$id_k1?> onblur="soxr(<?=$id_k1?>);">
  </td>
  
	<td align="center" onmouseover="this.style.backgroundColor='#ff1a1a'" onmouseout="this.style.backgroundColor='#ffffff'">
<div style="display: block; width: 100%; height: 100%;text-decoration: none;" onClick="udal(<?=$id_k1?>);" id=udal<?=$id_k1?>><font color=red> &nbsp;</font></div>
	</td>
</tr>

<tr class="udal_isachez" style="display:<? if($i == ($udal + 1) and !isset($_POST['new_kabinet']) and $i>15)
  {echo "block";}
  else
  {echo "none";} 
  ?>"align=center bgcolor=red>
<td>
Строка удалена
</td>
</tr>
</tr>

</form>
<?
}
?>
</tbody>
</table>

<center>
<a href="#" onClick="document.getElementById('new_kabinet').click();" title="Новая строка"><img src="images/new_str.png" width="80px" ></a> 
</center>

<!-- Скролл вверх вниз -->
<img src="images/up.png" alt="вверх"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 0%;" class=skrit id=up>
<img src="images/down.png" alt="вниз"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 95%;" id=down class=skrit>

</body>
</html>


