
<?php
$result2 = mysql_query("SELECT * FROM prepod ORDER BY id_pp");
while($row2 = mysql_fetch_array($result2))
{

$id_pp2=$row2['id_pp'];
if ($id_pp=='') {("UPDATE prepod SET nagruzka_tru='' WHERE id_pp='$id_pp2'") or die (mysql_error ());}
$result = mysql_query("SELECT * FROM stroka WHERE id_pp='$id_pp2' ORDER BY id_pp");
while($row = mysql_fetch_array($result))
{
$id_str=$row['id_str'];
$id_pp=$row['id_pp'];

$result55 = mysql_query("SELECT *,TIME_TO_SEC(vr_end) - TIME_TO_SEC(vr_nach) AS 'secundi' FROM stroka WHERE id_pp='$id_pp'");
while($row55 = mysql_fetch_array($result55))
{
$sec=$row55['secundi'];
if ($sec>0){$summa=$summa+$sec;}
}
//echo $id_pp.'--'.$summa.'<br>';

mysql_query ("UPDATE prepod SET nagruzka_tru='$summa' WHERE id_pp='$id_pp'") or die (mysql_error ());
$summa=0;
}
//echo $id_pp2.'-'.$id_pp.'<br>';
$id_pp='';

}
$id_str='';

?>