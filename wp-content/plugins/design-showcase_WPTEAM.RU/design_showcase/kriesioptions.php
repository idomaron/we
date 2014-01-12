<?php
global $kriesi_options;

function k_generate(){
$options = $newoptions  = get_option('kriesi_options');

if ( $_POST['kriesi_options'] ) {
		$newoptions['enable_jquery'] = strip_tags(stripslashes($_POST['enable_jquery']));
		$newoptions['enable_imgtooltips'] = strip_tags(stripslashes($_POST['enable_imgtooltips']));
		$newoptions['enable_tooltips'] = strip_tags(stripslashes($_POST['enable_tooltips']));
		$newoptions['enable_tabs'] = strip_tags(stripslashes($_POST['enable_tabs']));
		$newoptions['enable_scrolling'] = strip_tags(stripslashes($_POST['enable_scrolling']));
		$newoptions['enable_footer'] = strip_tags(stripslashes($_POST['enable_footer']));
		$newoptions['com_cat'] = strip_tags(stripslashes($_POST['com_cat']));
		$newoptions['com_page'] = strip_tags(stripslashes($_POST['com_page']));
		$newoptions['enable_fav_post'] = strip_tags(stripslashes($_POST['enable_fav_post']));
		$newoptions['google_analaytics'] = stripslashes($_POST['google_analaytics']);
		}
		
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('kriesi_options', $options);
		}
		
$enable_jquery = empty( $options['enable_jquery'] ) ? false : true;
$enable_imgtooltips = empty( $options['enable_imgtooltips'] ) ? false : true;
$enable_tooltips = empty( $options['enable_tooltips'] ) ? false : true;
$enable_tabs = empty( $options['enable_tabs'] ) ? false : true;
$enable_footer = empty( $options['enable_footer'] ) ? false : true;
$enable_scrolling = empty( $options['enable_scrolling'] ) ? false : true;
$com_cat = empty( $options['com_cat'] ) ? "" : $options['com_cat'];
$com_page = empty( $options['com_page'] ) ? "" : $options['com_page'];
$enable_fav_post = empty( $options['enable_fav_post'] ) ? false : true;
$google_analaytics = empty( $options['google_analaytics'] ) ? "" : $options['google_analaytics'];

?>
<div class="wrap">
<h2>Design Showcase Настройки. Локализация От <a href="http://wpteam.ru/">WPTEAM.RU</a></h2>

<form method="post" action="">
<table class="form-table">

<tr valign="top">
<th scope="row"><label>Java Script Настройки</label></th>
<td>
<label for="enable_jquery">
<input type="checkbox" <?php if ($enable_jquery){echo "checked='checked'";}?> value="1" id="enable_jquery" name="enable_jquery"/>Включить jQuery?
</label><br/>

<label for="enable_imgtooltips">
<input type="checkbox" <?php if ($enable_imgtooltips){echo "checked='checked'";}?> value="1" id="enable_imgtooltips" name="enable_imgtooltips"/>Включить Всплывающие подсказки для Изображений?
</label><br/>

<label for="enable_tooltips">
<input type="checkbox" <?php if ($enable_tooltips){echo "checked='checked'";}?> value="1" id="enable_tooltips" name="enable_tooltips"/>Включить Всплывающие подсказки для Названий?
</label><br/>

<label for="enable_tabs">
<input type="checkbox" <?php if ($enable_tabs){echo "checked='checked'";}?> value="1" id="enable_tabs" name="enable_tabs"/>Включить Табы в Сайдбаре?
</label><br/>

<label for="enable_footer">
<input type="checkbox" <?php if ($enable_footer){echo "checked='checked'";}?> value="1" id="enable_footer" name="enable_footer"/>Включить Трансформацию информации в футере в слайд навигацию?
</label><br/>

<label for="enable_scrolling">
<input type="checkbox" <?php if ($enable_scrolling){echo "checked='checked'";}?> value="1" id="enable_scrolling" name="enable_scrolling"/>Включить плавную прокрутку для Главных(Anchor) ссылок?
</label><br/><br/>
Внимание: Отключение jQuery выключит любые другие функции на javascript
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="com_cat">Категория Новостей в Сайдбаре</label></th>
<td><input name="com_cat" type="text" id="com_cat" value="<?php if ($com_cat){echo $com_cat;}?>" size="2" maxlength="2" /><br/>
	Введите Номер Категории здесь, эта категория будет исключена со страниц с записями и с архивами
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="com_page">Навигация Страниц</label></th>
<td><input name="com_page" type="text" id="com_page" value="<?php if ($com_page){echo $com_page;}?>" size="70" maxlength="255" /><br/>
	Введите последовательно в ряд страницы, которые вы хотите показывать в главном меню (верхний правый угол)<br/>
    Если оставите пустым, будут показаны все страницы (будет выпадающее меню)<br/>
    Немного Примеров:<br/>
    <strong>include=9,16,22,24,33</strong> (тут будет показано 5 страниц с id 9, 16, 22, 24, 33)<br/>
    <strong>exclude=2,6,12</strong> (тут будут показаны все записи кроме страниц с id 2, 6, 12)<br/>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="enable_fav_post">Любимые(Избранные) Записи</label></th>
<td>
<label for="enable_fav_post">
<input type="checkbox" <?php if ($enable_fav_post){echo "checked='checked'";}?> value="1" id="enable_fav_post" name="enable_fav_post"/>Включить Избранные Записи?
</label></td>
</tr>


<tr valign="top">
<th scope="row"><label for="google_analaytics">Трекинг Код Google Analytics</label></th>
<td>
<textarea class="code" style="width: 98%; font-size: 12px;" id="google_analaytics" rows="10" cols="60" name="google_analaytics">
<?php if ($google_analaytics){echo $google_analaytics;}?>
</textarea>
	Введите Ваш Аналитикс Трекинг Код Здесь.
	</td>
</tr>


</table>

<p class="submit">
<input id="kriesi_options" type="hidden" value="1" name="kriesi_options"/>
<input type="submit" name="Submit" value="Сохранить Настройки" /></p>

</form>

</div>
<?php
}

?>