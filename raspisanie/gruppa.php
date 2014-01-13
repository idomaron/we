
<?php
include 'config.php';

$g = mysql_num_rows($result3 = mysql_query("SELECT ochered FROM gruppa ORDER BY ochered "));
$kon=mysql_result($result3,$g-1,"ochered");
$ochered_konec=$kon+1;


$id_gr=$_POST['id_gr'];
if ($_POST['prefix']=='udal') mysql_query("DELETE FROM gruppa WHERE id_gr=$id_gr")  or die("Query failed");
$nazvanie=$_POST['nazvanie'];
$sokr_gr=$_POST['sokr_gr'];
$ochered=$_POST['ochered'];
mysql_query ("UPDATE gruppa SET nazvanie='$nazvanie', sokr_gr='$sokr_gr', ochered='$ochered' WHERE id_gr='$id_gr'") or die (mysql_error ());

//Новая строка с пустыми значениями
 if(isset($_GET['new_gruppa']))
 {
mysql_query("INSERT INTO gruppa (nazvanie, sokr_gr, ochered) VALUES ('', '', '$ochered_konec');");
 }

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Группы</title>
<script type="text/javascript" src="js/jquery.js"></script>
<link type="text/css" rel="stylesheet" media="screen" href="css/style.css" >
<!-- Save-->
<script type="text/javascript">
function soxr(id) {
var nazvanie_ajax = $('#nazvanie'+id).val();
var sokr_gr_ajax = $('#sokr_gr'+id).val();
var ochered_ajax = $('#ochered'+id).val();
$.post("gruppa.php", { nazvanie: nazvanie_ajax, sokr_gr: sokr_gr_ajax,ochered:ochered_ajax, id_gr:id} );
}
</script>

<!-- Udalenie-->
<script type="text/javascript">
function udal(id) {
			if (confirm('Точно удалять '+$('#nazvanie'+id).val()+'?')) {
			$.post("gruppa.php", { prefix: 'udal', id_gr: id} );
			$('#tab'+id).fadeOut("slow");
		}
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
<br>

<center>
<a href="#" onClick="document.getElementById('new_gruppa').click();" title="Новая строка"><img src="images/new_str.png" width="80px"></a> &nbsp; <a href=gruppa.php><img src="images/reload.png" width=50px></a>
</center>

<form method=GET action="gruppa.php">
<input type=submit name=new_gruppa value="" id=new_gruppa style=display:none>
</form>

<center>
<table border="2">

<td>
    Название
</td>
<td>
    Порядк <br /> номер
</td>
<td>
    Сокращ.
</td>
<td>
    Удалить
</td>

<?
$result = mysql_query("SELECT * FROM gruppa ORDER by ochered");
while($row = mysql_fetch_array($result))
{
$id_gr=$row['id_gr'];
?>
<tr id="tab<?=$id_gr?>" >
<td>
<input type="text" name="nazvanie" value="<?=$row['nazvanie']?>" style="width:500px;" onblur="soxr(<?=$id_gr?>);" id="nazvanie<?=$id_gr?>" />
</td>
<td>
<input type="text" name="id_gr" value="<?=$row['ochered']?>" style="width:50px;" onblur="soxr(<?=$id_gr?>);" id="ochered<?=$id_gr?>" />
</td>
<td>
<input type="text" name="sokr_gr" value="<?=$row['sokr_gr']?>" style="width:100px;" onblur="soxr(<?=$id_gr?>);" id="sokr_gr<?=$id_gr?>" />
</td>
	<td onmouseover="this.style.backgroundColor='#ff1a1a'" onmouseout="this.style.backgroundColor='#ffffff'">
<div style="display: block; width: 100%; height: 100%;text-decoration: none;" onClick="udal(<?=$id_gr?>);" id=udal<?=$id_gr?>><font color=red> &nbsp;</font></div>
	</td>
</tr>
<?}?>
</table>
</center>

</body>
</html>

