<?php
function table($den,$kurs,$id_gr)
{
//Для менюшки на правую кнопку
echo '<div onmouseover="right_click('.$den.$kurs.$id_gr.');$(this).css({\'background-color\':\'#e3e3e3\'});" onmouseout="$(this).css({\'background-color\':\'white\'});" class=div_ves id=div_ves'.$den.$kurs.$id_gr.'>';

//Вывести только то, что выбрали (в запрос MySQL идёт and)
	if(isset($_POST['change']) && !isset($_POST['videl']))
	{
		
		if($_POST['change_predmet']==true)     $p=$_POST['change_predmet'];
		if($_POST['change_kabinet']==true)     $k=$_POST['change_kabinet'];
		if($_POST['change_prepod']==true)      $pp=$_POST['change_prepod'];
		if($_POST['change_vr_nach']==true)     $vr_nach=$_POST['change_vr_nach'];
		if($_POST['change_vr_end']==true)      $vr_end=$_POST['change_vr_end'];
		
		if($p !== null)      $and_p=" and id_p='$p' "; //$div_per2='<div style="background:#dae534;">';
		if($k !== null)      $and_k=" and id_k='$k' ";
		if($pp !== null)     $and_pp=" and id_pp='$pp' ";
		if($vr_nach !== null)   $and_vr_nach=" and vr_nach='$vr_nach' ";
		if($vr_end !== null)    $and_vr_end=" and vr_end='$vr_end' ";
	}

  

 //Цикл, проверяющий общие включения checked
	if(zapros("SELECT fio_sokrat FROM checked")=='on') 	 $fio_sokrat='checked';
	if(zapros("SELECT predmet_sokrat FROM checked")=='on') $predmet_sokrat='checked';
	if(zapros("SELECT dop FROM checked")=='on')			 $dop='checked';

	$konec="</i></b></font>"; //Концовка шрифтов и цветов (продумать)

//Общий цикл, перечисляющий строки в одной ячейке
$result=mysql_query("SELECT * FROM stroka WHERE den='$den' and kurs='$kurs' and id_gr='$id_gr' $and_p $and_k $and_pp $and_vr_nach $and_vr_end $and_dop ORDER BY vr_nach,ochered");
while($row=mysql_fetch_array($result))
{
	//echo '<br>'.$row['ochered'].'<br>';
    $id_str=$row['id_str'];
    $id_pp=$row['id_pp'];
    $id_p=$row['id_p'];
    $id_k=$row['id_k'];
	$full2=$full;
	$full=$row['full'];
    $vr_nach=$row['vr_nach'];	
    $vr_end=$row['vr_end'];

	$fio='';$nazvanie='';$nomer='';//Чтоб не выводились подряд, если пустая строка

	//Окна
	global $okno_check;
	global $okno_den;
	global $okno_kurs;
		if($okno_check=='checked')
		{
			$svob_time==0;
			$gal=1;
			//пиздец
			if ($okno_den!=='' and $okno_kurs!=='' ) {$gal=2;if ($kurs==$okno_kurs and $den==$okno_den) {$svob_time=1;}}
			if ($okno_den!=='' and $den==$okno_den and $gal==1) {$svob_time=1;}
			if ($okno_kurs!=='' and $kurs==$okno_kurs and $gal==1) {$svob_time=1;}
			if ($okno_kurs=='' and $okno_den=='') {$svob_time=1;}
			if ($svob_time==1)
			{
				$okno_chas=$_POST['okno_chas'];
				$okno_min=$_POST['okno_min'];
				$obsh=(($okno_chas*60)+$okno_min);
				$yy=((($vr_nach[0].$vr_nach[1])*60)+($vr_nach[3].$vr_nach[4]))-((($proba[0].$proba[1])*60)+($proba[3].$proba[4]));
				if ($yy>=$obsh and $null==1)
				{
					if ($pechat=='checked') 
					{
						echo '<div style=background:#9e9e9e id=okno><font size=4>ОКНО<br></font></div>'; 
					}else{
						echo '<div style=background:#fdff6b id=okno><font size=5>ОКНО<br></font></div>'; 
					}
				}
			}
		}


    //Время nach
    $result1=mysql_query("SELECT * FROM redact WHERE chto='vr_nach'");
    while($row1=mysql_fetch_array($result1))
    {
		$font1=$row1['font'];
		$color1=$row1['color'];
		($row1['bold']=='on')?$bold1='<b>':'';
		($row1['italic']=='on')?$italic1='<i>':'';
    }


	
	//Время end 
	$result7=mysql_query("SELECT * FROM redact WHERE chto='vr_end'");
	while($row7=mysql_fetch_array($result7))
	{
		$font7=$row7['font'];
		$color7=$row7['color'];
		($row7['bold']=='on')?$bold7='<b>':'';
		($row7['italic']=='on')?$italic7='<i>':'';
	}


	//Предмет 
    $result4=mysql_query("SELECT * FROM predmet WHERE id_p='$id_p'");
    while($row4=mysql_fetch_array($result4))
    {
		//Сокращённые названия если стоит галочка
		($predmet_sokrat=='checked')?$nazvanie=$row4['sokrash']:$nazvanie=$row4['nazvanie'];
	}
	
	//Сам вывод
	$result7=mysql_query("SELECT * FROM redact WHERE chto='predmet'");
	while($row7=mysql_fetch_array($result7))
	{
		$font2=$row7['font'];
		$color2=$row7['color'];
		($row7['bold']=='on')?$bold2='<b>':'';
		($row7['italic']=='on')?$italic2='<i>':'';
	}



	//Кабинет
    $result3=mysql_query("SELECT * FROM kabinet WHERE id_k='$id_k'");
    while($row3=mysql_fetch_array($result3))
    {
      $nomer=$row3['nomer'];
	  //Сам вывод
      $result5=mysql_query("SELECT * FROM redact WHERE chto='kabinet'");
      while($row5=mysql_fetch_array($result5))
      {
        $font5=$row5['font'];
        $color5=$row5['color'];
        if($row5['bold']=='on')          $bold5='<b>';
        if($row5['italic']=='on')        $italic5='<i>';
      }

    }


	//Преподаватель
    $result2=mysql_query("SELECT * FROM prepod WHERE id_pp='$id_pp'");
    while($row2=mysql_fetch_array($result2))
    {
		//Сокращённые ФИО если стоит галочка
		($fio_sokrat=='checked')?$fio=$row2['fio_sokr']:$fio=$row2['fio'];
		
		//Сам вывод препода
		$result5=mysql_query("SELECT * FROM redact WHERE chto='prepod'");
		while($row5=mysql_fetch_array($result5))
		{
			$font3=$row5['font'];
			$color3=$row5['color'];
			($row5['bold']=='on')?$bold3='<b>':'';
			($row5['italic']=='on')?$italic3='<i>':'';
		}
    }

	global $vibor_check;
	if ($row['vibor']=='true' && $vibor_check=='checked') {$echo_vibor='<div style="background:#84d66b">';} else {$echo_vibor='';}
	if ($row['vibor']=='true' && $vibor_check=='checked') {$echo_vibor2='</div>';}  else {$echo_vibor2='';}

	//Сброс стилей
	global $pechat;
	if ($pechat=='checked')
	{
		$color1='';$color7='';$color2='';$color5='';$color3='';
		$font1='';$font7='';$font2='';$font5='';$font3='';
		$italic1='';$italic7='';$italic2='';$italic5='';$italic3='';
		$bold1='';$bold7='';$bold2='<b>';$bold5='';$bold3='';
		if ($row['vibor']=='true' && $vibor_check=='checked') {$echo_vibor='<div style="background:#d1d1d1">';}
		
	}


	if ($_POST['videl'])
	{
		//Поиск и выделение найдённых цветом
		$div_per2='<div style="background:#FFFFFF;">';
		$plu=0;
		$plu2=0;
		
		$p=$_POST['change_predmet'];
		$pp=$_POST['change_prepod'];
		$k=$_POST['change_kabinet'];
		$nach=$_POST['change_vr_nach'];
		$end=$_POST['change_vr_end'];
		
		if ($p==true) $plu++;
		if ($pp==true) $plu++;
		if ($k==true) $plu++;
		if ($nach==true) $plu++;
		if ($end==true) $plu++;
		
		if ($p==$id_p && $k!==true && $pp!==true && $nach!==true && $end!==true && $plu<2) {$div_per2='<div style="background:#dae534;">';}
		if ($k==$id_k && $p!==true && $pp!==true && $nach!==true && $end!==true && $plu<2) {$div_per2='<div style="background:#dae534;">';}
		if ($pp==$id_pp && $k!==true && $p!==true && $nach!==true && $end!==true && $plu<2) {$div_per2='<div style="background:#dae534;">';}
		if ($nach==$vr_nach && $k!==true && $pp!==true && $p!==true && $end!==true && $plu<2) {$div_per2='<div style="background:#dae534;">';}
		if ($end==$vr_end && $k!==true && $pp!==true && $nach!==true && $p!==true && $plu<2) {$div_per2='<div style="background:#dae534;">';}
		
		if ($p==$id_p) $plu2++;
		if ($k==$id_k) $plu2++;
		if ($pp==$id_pp) $plu2++;
		if ($nach==$vr_nach) $plu2++;
		if ($end==$vr_end) $plu2++;
		if ($plu2==$plu && $plu!==0) $div_per2='<div style="background:#dae534;">';
	}

	//Пересечение времени в один день у препода у всех классов
	if (isset($_POST['peresek_dni']))
	{	
		($_POST['radio']=='peresek_kabinet')?$kto=$nomer:'';
		($_POST['radio']=='peresek_prepod')?$kto=$fio:'';
		global $array_per;
		global $array_per2;
		global $nn;
		//global $mag;
		for ($kk=1;$kk<=$nn;$kk++)
		{
			if ($den==1) {$den2="Понедельник";}
			if ($den==2) {$den2="Вторник";}
			if ($den==3) {$den2="Среда";}
			if ($den==4) {$den2="Четверг";}
			if ($den==5) {$den2="Пятница";}
			if ($den==6) {$den2="Суббота";}

				$sokr_gr3=zapros("SELECT sokr_gr FROM gruppa WHERE id_gr='$id_gr'");

					//if ($kurs==6 or $kurs==7){ if ($mag!=='checked'){$kurs='';}}
					$klass=zapros("SELECT nazvanie FROM klass WHERE ochered='$kurs'");
					$array_per_if='<td nowrap><b>'.$kto.'</b></td><td nowrap>'.$den2.'</td><td nowrap>'.$sokr_gr3.'</td><td nowrap>'.$vr_nach.'-'.$vr_end.'</td><td nowrap>'.$klass.'</td>';

						if ($array_per_if==$array_per[$kk])
						{
							//echo '<b>per'.$kk.'</b>';
							$div_per='<div style=background:#dfff9e id=perviy'.$kk.'>';
							$div_end='</div>';
						}
						
					$array_per_if2='<td nowrap>'.$sokr_gr3.'</td><td nowrap>'.$vr_nach.'-'.$vr_end.'</td><td nowrap>'.$klass.'</td><div class=redact>'.$den.$kto.'</div>';

						if ($array_per_if2==$array_per2[$kk])
						{	
							$div_per2='<div style=background:#cfcfcf id=vtoroy'.$kk.'>';
							$div_end2='</div>';
							//echo '<b>vt'.$kk.'</b>';
						}
		}
	}
	if ($null==1 and $row['obyed']=='false') echo '<br>';

	//Рисование штрихов между одинаковым временем, двумя преподами
	if ($row['obyed']=='true' and $vr_end_8!==$vr_end and $vr_nach_8!==$vr_nach) {$obyed='<b>|||</b>';$vr_nach='';$vr_end='';$yama2=1;}
	if ($vr_nach_8==$vr_nach and $vr_end_8==$vr_end and $row['obyed']=='true') {$obyed='<b>///</b>';$vr_nach='';$vr_end='';$yama2=1;}

	
	//Для выявления пересечений времени в одной ячейке
	if($_POST['peresek']==true)
    {
      if($proba > $vr_nach and $row['obyed']=='false' and $row['full']=='false' and $full2=='false')
		{
		echo $proba;
        $polosa='<hr color=red size=5>';//Подчёркивает неправильное время
		$br='';
		}
    }
	echo $polosa;
	$polosa='';
	

							
	//echo $nazvanie.'-1'.$nazvanie2.'-2'.$row['obyed'];
		if ($row['full']=='true' and isset($_POST['peresek_dni'])) echo '<img src=images/full.png width=20px>';
		//Сам вывод в ячейку
		if ($vr_nach=='' and $vr_end=='' and $nazvanie=='' and $nomer=='' and $fio=='') 
		{
			echo '<b>ПУСТАЯ СТРОЧКА</b>';
		}
		else
		{
			$nnn=0;
			
			if ($row['obyed']=='true' and $nazvanie==$nazvanie2) {$nazvanie2=$nazvanie;$nazvanie='';$nnn=1;}
			if ($row['obyed']=='true'and $nomer==$nomer2) {$nomer2=$nomer;$nomer='';$nnn=1;}
			
			echo $div_per.$div_per2;
			echo $echo_vibor;
				if ($yama2!==1)
				{
					echo '<font color='.$color1.' size='.$font1.'>'.$bold1.$italic1.$vr_nach.$konec.'-';
					echo '<font '.$peresek.' color='.$color7.' size='.$font7.'>'.$bold7.$italic7.$vr_end.$konec.' ';
				}
			echo $obyed;
			echo '<font color='.$color2.' size='.$font2.'>'.$bold2.$italic2.$nazvanie.$konec.' ';
			echo '<font color='.$color5.' size='.$font5.'>'.$bold5.$italic5.$nomer.$konec.' ';
			echo '<font color='.$color3.' size='.$font3.'>'.$bold3.$italic3.$fio.$konec;
			echo $echo_vibor2;
			echo $div_end2.$div_end;

		}
		
		$vr_nach_8=$vr_nach;
		$vr_end_8=$vr_end;
		if ($nnn==0) $nazvanie2=$nazvanie;
		if ($nnn==0) $nomer2=$nomer;
		$div_per='';
		$div_end='';
		$div_per2='';
		$div_end2='';
		$line='';
		$obyed='';
		$yama2='';
		$echo_vibor='';
		$echo_vibor2='';
	
	//Дополнительно
	if($dop=='checked')
	{
		$result6=mysql_query("SELECT * FROM stroka WHERE id_str='$id_str'");
		while($row6=mysql_fetch_array($result6))
		{
			if ($row6['dop']!=='')
			{
				echo '<u> ('.$row6['dop'].')</u>';
			}
		}
	}

    $proba=$vr_end;//Для выявления пересечений времени
	$null=1;//Чтоб не выводилось первое ОКНО
	
}//Конец цикла, перечисляющего строки


echo '</div>';//Для менюшки на правую кнопку
?>

		<ul id="myMenu<?echo $den.$kurs.$id_gr;?>" class="contextMenu">
			<li  class="edit"><a href="#" onClick="window.location='yacheyka.php?den=<?=$den?>&kurs=<?=$kurs?>&id_gr=<?=$id_gr?>'" class=hide_right>&nbsp;&nbsp;&nbsp;Редактировать</a></li>
			<li class="copy"><a href="#" onClick="$.get('onclick.php?copy=!!&id_gr=<?=$id_gr?>&den=<?=$den?>&kurs=<?=$kurs?>');" class=hide_right>&nbsp;&nbsp;&nbsp;Копировать</a></li>
			<li class="cut"><a href="#" onClick="$.get('onclick.php?cut=!!&id_gr=<?=$id_gr?>&den=<?=$den?>&kurs=<?=$kurs?>');$('#div_ves<?=$den.$kurs.$id_gr?>').hide();" class=hide_right>&nbsp;&nbsp;&nbsp;Вырезать</a></li>
			<li class="paste"><a href="#" onClick="$.get('onclick.php?paste=!!&id_gr=<?=$id_gr?>&den=<?=$den?>&kurs=<?=$kurs?>',function(paste){$('#myDiv<?=$den?><?=$kurs?><?=$id_gr?>').html(paste);});" class=hide_right>&nbsp;&nbsp;&nbsp;Вставить</a></li>
			<li class="delete"><a href="#" onClick="$('#myMenu<?=$den.$kurs.$id_gr?>').hide();if (confirm('Точно очистить ячейку??')) $.get('onclick.php?ochist=!!&id_gr=<?=$id_gr?>&den=<?=$den?>&kurs=<?=$kurs?>'),$('#div_ves<?=$den.$kurs.$id_gr?>').hide();" class=hide_right>&nbsp;&nbsp;&nbsp;Очистить</a></li>
		</ul>
<?

}//Конец функции
?>