<?php global $kriesi_options; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php if (is_home()) { bloginfo('name'); ?><?php } elseif (is_category() || is_page() ||is_single()) { ?> <?php } ?><?php wp_title(''); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Лента" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="DS_option1" content="<?php echo bloginfo('template_url'); ?>" />
<meta name="DS_option2" content="<?php echo $kriesi_options['enable_imgtooltips']; ?>" />
<meta name="DS_option3" content="<?php echo $kriesi_options['enable_tooltips']; ?>" />
<meta name="DS_option4" content="<?php echo $kriesi_options['enable_scrolling']; ?>" />
<meta name="DS_option5" content="<?php echo $kriesi_options['enable_footer']; ?>" />
<meta name="DS_option6" content="<?php echo $kriesi_options['enable_tabs']; ?>" />


<?php if ($kriesi_options['enable_jquery']){
wp_enqueue_script('jquery');
wp_head(); ?>
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/custom.js"></script>
<?php
}else{
wp_head(); 
}

if ( ( is_single() || is_page() || is_home() ) && ( !is_paged() ) ) {
        echo '<meta name="robots" content="index, follow" />' . "\n";
} else {
        echo '<meta name="robots" content="noindex, follow" />' . "\n";
}


?>
<!--[if lt IE 8]>
<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE8.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/iefix.css" type="text/css" media="screen" />
<![endif]-->
</head>
<body>

<div id="wrapper">  
<div id="top">  
	<div id="head">
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<strong class="description"><?php bloginfo('description'); ?></strong>

	<div id="mainmenu">
        <ul id="nav">
            <?php wp_list_pages('title_li=&'.$kriesi_options['com_page']); ?>
        </ul>
        
	</div>
    
    	<ul id="submenu">
        	<li class="options jshide"><a href="">Субнавигация</a></li>
            <li class="search_js jshide"><a href="">Поиск</a></li>
            <li class="rssfeed"><a href="<?php bloginfo('rss2_url'); ?>">Подписаться на Ленту</a></li>
        </ul>
        
        <div class="headersearch"><?php include (TEMPLATEPATH . "/searchform.php"); ?></div>
        
	</div>
    <?php if (class_exists('simple_breadcrumb') && !(is_front_page() && !is_paged())) {$bc = new simple_breadcrumb; } ?>
    <div id="main">
	<div class="content <?php echo $post->post_name;?>">
    
