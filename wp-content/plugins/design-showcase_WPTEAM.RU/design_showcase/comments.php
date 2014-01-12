<?php global $kriesi_options; ?>
<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
		<p class="nocomments">Это сообщение защищено паролем. Введите пароль, чтобы посмотреть комментарии.</p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$i = 1;
?>

<!-- You can start editing here. -->

<?php 
$postauthor = get_the_author_id();
$got_trackbacks = 0;

if ($comments) : ?>
	<h3 id="comments">Комментарии к &#8220;<?php the_title(); ?>&#8221;</h3> 


	<ol class="commentlist">
        <!--the bgein of one comment-->
	<?php foreach ($comments as $comment) : ?>
    <?php $comment_type = get_comment_type(); ?>
	<?php if($comment_type == 'comment') { ?>
		<li class="comment <?php if (1 == $comment->user_id) {echo "admincomment";} if ($postauthor == $comment->user_id) {echo " authorcomment ";}?><?php /* echo $oddcomment; */ ?>" id="comment-<?php comment_ID() ?>">
         <div class="gravatar"><?php if(function_exists('get_avatar')) {
        $wo = get_bloginfo("template_url")."/images/gravatar".$i.".jpg";
		
        echo get_avatar( $comment, $size = '72', $default="$wo" );
		
		$i++;
		if($i >= 4){$i = 1;}
} ?>


</div>
<div class="comment_entry">
<div class="normal_link">
			<span class="floatleft"><strong><?php comment_author_link() ?></strong></span>
            <span class="floatright"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('j.m.Y') ?> дата <?php comment_time() ?></a> <?php edit_comment_link('e','',''); ?></span>
			<?php if ($comment->comment_approved == '0') : ?>
			<div class="clearboth"><strong>Ваш комментарий ожидает модерацию.</strong></div>
			<?php endif; ?>

		

			<?php comment_text() ?>
</div></div>
		</li>
        

	<?php /* Changes every other comment to a different class */	
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>
    <?php } else{ $got_trackbacks++;}// end of if comment_type?>
	<?php endforeach; /* end for each comment */ ?>

	</ol>
<?php if ($got_trackbacks != 0) {?>   
<h3 id="trackbacks">Трекбеки</h3>
<ol class="trackback_list">
<?php foreach ($comments as $comment) : ?>
<?php $comment_type = get_comment_type(); ?>
<?php if($comment_type != 'comment') { ?>
<li><?php comment_author_link() ?></li>
<?php } ?>
<?php endforeach; ?>
</ol>
<?php } ?>

 <?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post->comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->
		<h3 id="comments">Нет Комментариев</h3>
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p>Комментарии запрещены.</p>
		
	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

<h3 id="respond">Оставить Комментарий</h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

<p>Вы должны <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">авторизоваться</a> для <a href="http://wpteam.ru">отправки</a> комментария.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="kontaktformular normal_link">

<?php if ( $user_ID ) : ?>

<p>Вы вошли как <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. 
<?php
if(function_exists(wp_logout_url)){?>
				<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Выйти из этого аккаунта">Выйти &raquo;</a>
				<?php }else{
			?>
			<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Выйти из этого аккаунта">Выйти &raquo;</a>
			<?php } ?>

</p>

<?php else : ?>

<p>
	<input class="kontaktformular_input" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
	<label for="author"><small>Имя <?php if ($req) echo "<span>(обязательно)</span>"; ?></small></label>
</p>

<p>
	<input  class="kontaktformular_input" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
	<label for="email"><small>E-mail <span> <?php if ($req) echo "(обязательно)"; ?></span></small></label>
</p>

<p>
	<input class="kontaktformular_input" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
	<label for="url"><small>Вебсайт</small></label>
</p>


<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="50%" rows="10" tabindex="4" class="kontaktformular_textarea"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="отправить комментарий" class="abschicken"/>
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<?php do_action('comment_form', $post->ID); ?>
</p>


</form>
<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>
