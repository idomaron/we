<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>



<?php include (TEMPLATEPATH . '/searchform.php'); ?>

Архивы по месяцам:
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>

Архивы по категориям:
  <ul>
     <?php wp_list_cats(); ?>
  </ul>

	

<?php get_footer(); ?>
