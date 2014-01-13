<?php
header('Content-Type: text/x-csv; charset=utf-8');
header("Content-Disposition: attachment;filename=".date("d-m-Y")."-PacnucaHue.xls");
header("Content-Transfer-Encoding: binary ");
echo $_REQUEST['datatodisplay']; 
?>