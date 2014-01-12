/*Including ONLY Events in the query:*/
function namespace_add_custom_types( $query ) {
 if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
   $query->set( 'post_type', array(
    'Event','post'
));
 return $query;
}
}
add_filter( 'pre_get_posts', 'namespace_add_custom_types' );

/*Check Event isActive*/
/*function isEventActive($Event){
$arrLT = get_post_custom_values('Event_lifetime', $Event->id);
$hoursLT = intval($arrLT[0]);
$currentTime = time();
   $postTime = get_post_time('U', true);
   $lifeTime = $hoursLT*60*60;

   if(($currentTime - $postTime) < $lifeTime){$status=true;}
else{$status=false;}

return $status;
}*/

function isEventActive($EventId){
$arrLT = get_post_custom_values('Event_lifetime', $EventId);
$hoursLT = intval($arrLT[0]);

$currentTime = time();
   $postTime = get_post_time('U', true);
   $lifeTime = $hoursLT*60*60;

   if(($currentTime - $postTime) < $lifeTime){$status=true;}
else{$status=false;}

return $status;
}

add_action( 'wpmem_post_register_data', 'wpmem_register_autologin' );

function wpmem_register_autologin($fields, $fb_login=false){
wp_set_auth_cookie( $fields[ID], true );
//var_dump($fields);
if(!$fb_login){
wp_redirect( get_permalink( get_option('profile_edit_page', '') ) );
exit;
}
}

function my_fb_register_function($user_wp_id, $user_profile, $facebook){
update_user_meta( $user_wp_id, 'image_url', 'https://graph.facebook.com/' . $user_profile[id] . '/picture' );

$user_data = get_userdata($user_wp_id);
$registered_date = $user_data->user_registered;
$registered_date = strtotime($registered_date);
$minuteago_date = strtotime('1 minute ago');
$user_data = (array)$user_data;
wpmem_register_autologin($user_data, true);
if($registered_date > $minuteago_date){
wp_redirect( get_permalink( get_option('profile_edit_page', '') ) );
exit;
}
}
add_action( 'nextend_fb_user_registered', 'my_fb_register_function',40,3 );
add_action( 'nextend_fb_user_logged_in', 'my_fb_register_function',40,3 );
add_action( 'nextend_fb_user_account_linked', 'my_fb_register_function',40,3 );


add_filter('admin_init', 'settings_register_user_pages');

function settings_register_user_pages()
{
   register_setting('reading', 'login_page', 'esc_attr');
   add_settings_field('login_page', '<label for="login_page">'.__('Login Page:' , 'magazino' ).'</label>' , 'settings_register_login_page_html', 'reading');

   register_setting('reading', 'register_page', 'esc_attr');
   add_settings_field('register_page', '<label for="register_page">'.__('Register Page:' , 'magazino' ).'</label>' , 'settings_register_register_page_html', 'reading');

   register_setting('reading', 'profile_edit_page', 'esc_attr');
   add_settings_field('profile_edit_page', '<label for="profile_edit_page">'.__('Profile Edit Page:' , 'magazino' ).'</label>' , 'settings_register_profile_edit_page_html', 'reading');

   register_setting('reading', 'terms_page', 'esc_attr');
   add_settings_field('terms_page', '<label for="terms_page">'.__('TOS Page:' , 'magazino' ).'</label>' , 'settings_register_terms_page_html', 'reading');
}

function settings_register_login_page_html(){
   $login_value = get_option( 'login_page', '' );
$login_args = array(
'selected' => $login_value,
'name' => 'login_page'
);
wp_dropdown_pages( $login_args );
}
function settings_register_register_page_html(){
   $register_value = get_option( 'register_page', '' );
$register_args = array(
'selected' => $register_value,
'name' => 'register_page'
);
wp_dropdown_pages( $register_args );
}
function settings_register_profile_edit_page_html(){
   $profile_edit_value = get_option( 'profile_edit_page', '' );
$profile_edit_args = array(
'selected' => $profile_edit_value,
'name' => 'profile_edit_page'
);
wp_dropdown_pages( $profile_edit_args );
}
function settings_register_terms_page_html(){
   $terms_value = get_option( 'terms_page', '' );
$terms_args = array(
'selected' => $terms_value,
'name' => 'terms_page'
);
wp_dropdown_pages( $terms_args );
}


function countDown($EventId){
$arrLT = get_post_custom_values('Event_lifetime', $EventId);
$hoursLT = intval($arrLT[0]);

$currentTime = time();
   $postTime = get_post_time('U', true);
   $lifeTime = $hoursLT*60*60;

   if(($currentTime - $postTime) < $lifeTime){
    $status=true;
    $age = $currentTime-$postTime;
    $countDown= $lifeTime-$age;
   
    $cd_days = (int)($countDown/(60*60*24));
    $cd_days_r = $countDown % (60*60*24);
    $cd_hours = (int)($cd_days_r/(60*60));
   
    $cd_hours_r = $cd_days_r % (60*60);
$cd_minutes = (int)($cd_hours_r/(60));
   }
else{$status=false;}
$arrCountDown=array(
'days'=>$cd_days,
'hours'=>$cd_hours,
'minutes'=>$cd_minutes
);
return $arrCountDown;
}
//Profile images
function getProfileImagesList($EventID){
global $wpdb;
$votedUsers = $wpdb->get_results("SELECT * FROM usersAnswers WHERE post_id='$EventID'");

$i=0;
$arrImages=array();
foreach ($votedUsers as $u) {
$img = get_user_meta($u->userId, 'image_url', true);
if($img!='' && get_usermeta($u->userId,'is_profile_image_approved')==1){
$arrImages[]=$img;
$i++;
}
if($i>5){break;}
}
return $arrImages;
}
function getMostActiveProfileImages(){
global $wpdb;
$arrVotesCount = array();
$usersVotes = $wpdb->get_results("SELECT userId FROM usersAnswers");
foreach ($usersVotes as $vote) {
if(empty($arrVotesCount[$vote->userId])){$arrVotesCount[$vote->userId]=1;}
else{$arrVotesCount[$vote->userId]++;}
}
arsort($arrVotesCount);
$i=0;
foreach ($arrVotesCount as $id=>$count) {
$img = get_user_meta($id, 'image_url', true);
if($img!='' && get_usermeta($id,'is_profile_image_approved')==1){
$arrImages[]=$img;
$i++;
}
if($i==6){break;}
}
return $arrImages;
}

//Login Logo

function my_login_logo() { ?>
   <style type="text/css">
       body.login div#login h1 a {
           background-image: url(<?php echo get_bloginfo( 'template_directory' ) ?>/images/logo.png);
margin-bottom: 30px;
background-size: auto 100%;
       }
   </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_custom_login_url() {
return site_url();
}
add_filter( 'login_headerurl', 'my_custom_login_url', 10, 4 );

/* ========================= Events Functions START ========================= */
function VoteTo($EventID, $answerValue, $answerID) {
global $wpdb;
if(!is_user_logged_in())
return false;

$userId = get_current_user_id();
$prevAns = $wpdb->get_row("SELECT * FROM usersAnswers WHERE userId = '$userId' AND post_id='$EventID'");
$arr = (array)$prevAns;
if(!empty($arr)){
//echo 'updating';
$data = array('userId' => $userId, 'meta_value' => $answerValue, 'post_id' => get_the_ID(), 'meta_id' => $answerID, 'createdAt' => time());
return $wpdb->update( 'usersAnswers', $data,$arr);
}else{
//echo 'inserting';
$data = array('userId' => $userId, 'meta_value' => $answerValue, 'post_id' => get_the_ID(), 'meta_id' => $answerID, 'createdAt' => time());
return $wpdb->insert('usersAnswers', $data);
}
}

function UserVotedTo($EventID) {
global $wpdb;
if(!is_user_logged_in())
return false;
$userId = get_current_user_id();
if(!$wpdb->get_row("SELECT * FROM usersAnswers WHERE userId = '$userId' AND post_id='$EventID'"))
return false;
return true;
}

function GetAnswers() { // use inside loop of Events
global $wpdb;
// Retrive possible answers
$answersTemp = explode('!!!SEP!!!', types_render_field('answer', array('separator'=>'!!!SEP!!!')));
$answers = array();
$EventID = get_the_ID();
// Build a new array of answers including meta_id, post_id, meta_key, meta_value (columns in wp_postmeta table) of each possible answer.
foreach($answersTemp as $a) {
$answers[] = $wpdb->get_row("SELECT * FROM wp_postmeta WHERE meta_key='wpcf-answer' AND meta_value='$a' AND post_id='$EventID'");
}
return $answers;
}

function UsersVotedToAnswer($answerID) {
global $wpdb;
$EventId = get_the_ID();
/*if(!is_user_logged_in())
return false;*/
$users = array();
$votes = $wpdb->get_results("SELECT * FROM usersAnswers WHERE meta_id='$answerID' AND post_id='$EventId'");
foreach($votes as $vote) {
$users[] = $vote->userId;
}
return $users;
}
function getUserEvents(){
global $wpdb;
if(!is_user_logged_in())
return false;
$userId = get_current_user_id();
$userEventsRaw = $wpdb->get_results("SELECT post_id FROM usersAnswers WHERE userId='$userId'");
foreach ($userEventsRaw as $key => $Event) {
$userEvents[]=$Event->post_id;
}
return $userEvents;
}
function minutesSinceVote($EventId){
$userId = get_current_user_id();
global $wpdb;
$vote = $wpdb->get_results("SELECT * FROM usersAnswers WHERE userId='$userId' AND post_id='$EventId'");
if(!empty($vote)){
$createdAt = $vote[0]->createdAt;
$now=time();
$minutesDif = ($now - $createdAt)/60;

return $minutesDif;
}else{
return 0;
}

}

/* ========================= Events Functions END ========================= */


//uploading SWF
function demo($mimes) {
if ( function_exists( 'current_user_can' ) )
$unfiltered = $user ? user_can( $user, 'unfiltered_html' ) : current_user_can( 'unfiltered_html' );
if ( !empty( $unfiltered ) ) {
$mimes = array(
'swf' => 'application/x-shockwave-flash',
/*'exe' => 'application/x-msdownload',*/
'jpg'=> 'image/jpeg',
'gif'=>'image/gif',
'png'=>'image/png'
);
}
return $mimes;
}
add_filter('upload_mimes','demo');

function save_image_url_to_user_meta($args) {//happens in every login !!! should be only at the first one...
update_user_meta( $args['WP_ID'], 'image_url', 'https://graph.facebook.com/' . $args['FB_ID'] . '/picture' );
}
add_filter('wpfb_login','save_image_url_to_user_meta');

//var_dump(wp_get_current_user()->ID);die;
function fb_login_button_text(){
return 'Login';
}
add_filter('wpfb_button_text', 'fb_login_button_text');

/*function ido($args){
var_dump($args);die;
}
add_filter('wpfb_insert_user', 'ido');*/

//***************//CREATE NEW POST TYPE//*************************//

//********************GENFON*************************************//
/*	
	function respondToJoinEventRequest()
		{
			$_GET['response'];
						
			if ($isApproved = true)
				{
					$status = 'approved';
				}
			else
				{
					$status = 'request';
				}
				return $status;
			
			
			$wpdb->update( $wpdb->usersEvents, array("status" => $status),  array("%s"));

		}
	
	function requestToJoin ()
		{

			$user = get_current_user();
			$requestorUserID = $user->ID;
			$eventPostId = 	$_POST["event-id"]; 
			$date = date("Y-m-d H:i:s", time()); //Now;
			$status = 'pending';
			$requesturMobilePhone = $POST[] ;
			$numberOfTickets = 
			$wpdb->insert($wpdb ->usersEvents, array("userId" => $requestorUserID, "postId" => $eventPostId, "dateOfRequest" => $date, "status" => $status,
			 "requesturMobilePhone" => $requesturMobilePhone, "numberOfTickets" => $numberOfTickets ), array ("%d","%d","%s", "%s", "%s", "%d"  ));
		}*/
		
//********************//GENFON//*************************************//		
