<?php
include ('config.php');

if(isset($_POST['udal_dop']))
{
	$yy=$_POST['stolb_post'];
	mysql_query("DELETE FROM dop_tabl WHERE ochered='$yy'")  or die("Query failed");
}

if ($_POST['poloska']==TRUE)
{
	$poloska=$_POST['poloska'];
	mysql_query ("UPDATE checked SET poloska='$poloska'") or die (mysql_error ());
}


if ($_POST['new_stolb']==TRUE)
{
$new=zapros("SELECT ochered FROM dop_tabl ORDER BY ochered DESC LIMIT 1")+1;
mysql_query("INSERT INTO dop_tabl (id_k_dop,ochered) VALUES ('','$new');");
}

$poloska=zapros("SELECT poloska FROM checked");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Дополнительная таблица</title>

<script type="text/javascript" src="js/jquery.js"></script>
<link rel="stylesheet" href="css/style.css" type="text/css">
<script type="text/javascript" src="js/verx_niz.js"></script>

<script Language="JavaScript">
function kabb(id_kab,ochered){
$.post("onclick.php", {id_kab_post: id_kab,ochered_post:ochered},
   function(kabinet) {
	 $('#divv'+ochered).show();
	 $('#divv'+ochered).text(kabinet);
	 $('#id_kabinet_select'+ochered).hide();
   });
}
</script>

<!-- Soxr time-->
<script Language="JavaScript">
function soxr(id_left){
var vr_lev_new = ($('#vr_nach_lev'+id_left).val());
$.post("onclick.php", {id_left_post: id_left,vr_lev_new_post:vr_lev_new});
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
<center><a href="table.php"><h3>К большой таблице</h3></a>
<a href=dop_tabl.php><img src="images/reload.png" width=50px></a>
</center>
<br />
 
 
 
<form method=POST>
	<select name=day>
		<option value=7>Все дни</option>
		<option value=1>Понедельник</option>
		<option value=2>Вторник</option>
		<option value=3>Среда</option>
		<option value=4>Четверг</option>
		<option value=5>Пятница</option>
		<option value=6>Суббота</option>
	</select>
	<br>
	<label onmouseover="this.style.backgroundColor='#fcfcc9'" onmouseout="this.style.backgroundColor='#ffffff'">Предмет
	<input type=checkbox name=checked_predmet <?=$checked_predmet?>></label>
	<br>
	Разделитель
	<input type=text value="<?=$poloska?>" name="poloska">
	<br>
	<input type=submit value=Жми>
</form>
 

<?

$plus=$_POST['day'];

if ($_POST['day']==TRUE)
{
	$nach=$plus;$konec=$plus;
}

if ($_POST['day']==7)
{
	$nach=1;$konec=6;
}

for ($den=$nach;$den<=$konec;$den++)
{
	$j=0;

	if ($den=='1') echo '<h3><center> Понедельник </center></h3>';
	if ($den=='2') echo '<h3><center> Вторник </center></h3>';
	if ($den=='3') echo '<h3><center> Среда </center></h3>';
	if ($den=='4') echo '<h3><center> Четверг </center></h3>';
	if ($den=='5') echo '<h3><center> Пятница </center></h3>';
	if ($den=='6') echo '<h3><center> Суббота </center></h3>';
	?>
	<table border="1" width="100%">
		<tr>
			<td width=30px title="Включить редактирование таблицы"><img src="images/vkl.png" width=30px onclick="$(this).hide();$('#vikl').show();$('.but').toggle();" id="vkl"><img src="images/vikl.png" width=30px onclick="$(this).hide();$('#vkl').show();$('.but').toggle();" style="display:none" id="vikl"></td>

		<?
		//Общий цикл, перечисляющий строки вверху
		$result = mysql_query("SELECT * FROM dop_tabl ORDER by ochered");
		while($row = mysql_fetch_array($result))
			{
			$j=$j+1;
			$id_k_dop=$row['id_k_dop'];
			$och=$row['ochered'];
			?>
			<td id="tdd<?=$j?>">

				<select style="display:none;width:50px;" id="id_kabinet_select<?=$och?>" onchange="kabb($(this).val(),<?=$och?>);">
					<option ></option>
						<?php
					$result89 = mysql_query("SELECT * FROM kabinet");
					while($row89 = mysql_fetch_array($result89))
					{
					  ?>
					<option value="<?=$row89['id_k']?>"
					<?
					if ($row89['id_k']==$id_k_dop) {echo "selected";$nomer=$row89['nomer'];}
					?>
					>
					<?=$row89['nomer']?></option> 
					<?
					 }
					?>
				</select>

				<div ondblclick='$("#id_kabinet_select<?=$och?>").toggle("fast");$(this).hide();' id="divv<?=$och?>" ><?=$nomer?></div>
				
				<form method=POST action=dop_tabl.php>
				<input type=hidden name=stolb_post value=<?if (!isset($och)) {echo '1';} else {echo $och;}?>>
				<input type=submit style=display:none value=Удал. name=udal_dop class=but>
				</form>
				
				<?$nomer='---';?>
			</td>
			<?
			$names[$j]=$id_k_dop;
			//$names["1"] = "425";
			//$names["2"] = "317";
			}
			
			?>
			
		<td style=display:none class=but>
		<form method=POST action="dop_tabl.php">
		<input type=submit name=new_stolb value="Новый столбец">
		</form>
		</td>
		
		</tr>
		

	<?
	$array = array();
	//Общий цикл, перечисляющий время
	$result2 = mysql_query("SELECT * FROM para ORDER BY vr_nach");
	while($row2 = mysql_fetch_array($result2))
	{
		$left++;
		$vr_nach_lev=$row2['vr_nach'];
		$id=$row2['id'];
		?>
		<tr>
			<td>
				<input type=text value="<?=$vr_nach_lev?>" style="width:50px" onblur="soxr('<?=$id?>');" id=vr_nach_lev<?=$left?>>
			</td>
			<?
			for ($i=1;$i<=$j;$i++)
			{
				foreach ($names as $kab => $value) 
				{
					if ($i==$kab) $kab_new=$value;
				}
				$uu=$uu+1;
				?>
			<td >

				<?
				//ondblclick="javascript:view_a(=$uu);"
				$inline2='table-cell';
				$null=1;
				$ris=1;
				$prepod2=3;
				$vr_end2=0;
				$vr_nach2=0;
				$predmet3=0;

				//Поиск препода по времени и кабинету
				//$vr_nach - слева столбец
				$result3 = mysql_query("SELECT * FROM stroka WHERE vr_nach<='$vr_nach_lev' and den='$den' and id_k='$kab_new'");
				while($row3 = mysql_fetch_array($result3))
				{
					$prepod=0;
					//if ($null==1) echo '<br>';
					//$null=1;
					$hh=$hh+1;
					$id_str=$row3['id_str'];
					$id_gr=$row3['id_gr'];
					
					$kurs=$row3['kurs'];
					$id_pp=$row3['id_pp'];
					$id_p=$row3['id_p'];
					$vr_end=$row3['vr_end'];
					$vr_nach=$row3['vr_nach'];
					$full=$row3['full'];
					$obyed=$row3['obyed'];

					//Вывод в ячейку
					if ($vr_end>$vr_nach_lev)
					{
						//Препод
						$prepod=zapros("SELECT fio_sokr FROM prepod WHERE id_pp=$id_pp");
						//Факультет
						$sokr_gr2=zapros("SELECT sokr_gr FROM gruppa WHERE id_gr=$id_gr");
						//Предмет
						$predmet2=zapros("SELECT sokrash FROM predmet WHERE id_p=$id_p");

							$vso = $vr_end.$vr_nach.$prepod.$sokr_gr2.$predmet2;
							$yo = in_array($vso,$array);
							if ($yo == true)
							{
								if ($ris == 1)echo '<center><img src="images/down_black.gif" height=30px></center>';
							}
							else
							{
								$aa=zapros("SELECT id_gr FROM gruppa WHERE sokr_gr='$sokr_gr2'");//Ссылки на группы
								if  ($prepod2!==$prepod and $vr_end2!==$vr_end and $vr_nach2!==$vr_nach )
									{
										
										//echo $prepod.'-'.$prepod2;
										echo $vr_nach.' ';
										if ($prepod !==0)
										{
											$prepod_sokr=substr_replace($prepod ,"",-7);//Без последних символов
											echo ' <b>'.$prepod_sokr.'</b>';
											echo '<br>';
										}
										else
										{
											echo '<br>';
										}
										if ($_POST['checked_predmet'] == 'on') echo '<font color=red>'.$predmet2.'</font>&nbsp;';
										echo '<a class="aa" href=yacheyka.php?den='.$den.'&kurs='.$kurs.'&id_gr='.$aa.'>'.$sokr_gr2.'</a>';
										echo '&nbsp;('.$kurs.')&nbsp;';
									}
									else
									{
									
										if ($prepod2!==$prepod and $full=='false' and $obyed=='false' and $prepod!=='' and $predmet3==$predmet2) echo  $prepod.'=='.$prepod2.'<div title="Конфликт преподов" style=background:red;height:5px>'.$sokr_gr2.'</div>';
										//if ($obyed=='false' and $prepod2==$prepod) echo $poloska.'<a class="aa" href=yacheyka.php?den='.$den.'&kurs='.$kurs.'&id_gr='.$aa.'>'.$sokr_gr2.'</a>&nbsp;('.$kurs.')&nbsp;';
										//if ($predmet3!==$predmet2 and $_POST['checked_predmet']=='on') echo '<font color=green>'.$predmet2.'</font>';
									}
							}
						$array[$hh] = $vso;
						$prepod2=$prepod;
						$vr_end2=$vr_end;
						$vr_nach2=$vr_nach;
						$predmet3=$predmet2;
						$ris=2;
					}
					
					$null=0;
				}
			  ?>
			 </td>
			<?
			}
		  ?>
		</tr>
		<?
	}
	?>
	

	</table>
<br><br>
<hr size=8 color=#000000>
<?
}
?>

<?
if ($_POST['day']==7)
{
?>
<!-- Скролл вверх вниз -->
<img src="images/up.png" alt="вверх"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 0%;" class=skrit id=up>
<img src="images/down.png" alt="вниз"  border="0" width="40" height="30" style="position: fixed; left: 60%; top: 95%;" id=down class=skrit>
<?
}
?>
<?

//mysql_query ("UPDATE dop_tabl SET ochered='$j' WHERE id_k_dop='$id_k_dop'") or die (mysql_error ());

?>

</body>
</html>
