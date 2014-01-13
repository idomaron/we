<?php

if (!@fopen('config.php', "r")) {
include ('install.php');
} else {
include ('table.php');
}

?>