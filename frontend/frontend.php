<?php
session_start();
$basedir = '/var/www/html'; 
define ('VIMG_DIR', '/var/www/html/img/');	
include ($basedir . '/backend/backend.php'); 
include ($basedir . '/frontend/init.php'); 
//$phone_to_test 
//Временно поставлю тут переменные для смс
//PROJECT (ИМЯ ПРОЕКТА) serg_text
//APIKEY (КЛЮЧ ПРОЕКТА) 37a643d4e936a
// MainSMS Инициализация объекта
// Список параметров ($project, $key, $useSSL = false, $testMode = false)
// $project - название проекта, берется со страницы http://mainsms.ru/office/api_account
// $key - ключ проекта, берется со страницы http://mainsms.ru/office/api_account
// $useSSL - не обязательный параметр, если true то взаимодействие будет осуществляться по протоколу https иначе http
// $testMode - не обязательный параметр, если true то сообщения не будут отправляться и деньги не будут списываться(используется для отладки)
$MainSMS_api = new MainSMS ( 'serg_text' , '37a643d4e936a', true, true );
# Структура URL: все идет через index.php
# action=...&subaction=...
# ajax_action=...&...
# Инклуды библиотек добавляем в init.php, сами библиотеки в lib

if(isset($_GET['lang'])){
	$_SESSION['lang'] = $_GET['lang'];
}
if(isset($_GET['logout'])){
	setcookie("uid", '', time()-3600);  
	setcookie("email", '', time()-3600);  
	setcookie("wallet", '', time()-3600);  
	
	unset($_SESSION['uid']);// = '';
	unset($_SESSION['email']);// = '';
	unset($_SESSION['wallet']);// = '';
	
	unset($_COOKIE['uid']);// = '';
	unset($_COOKIE['email']);// = '';
	unset($_COOKIE['wallet']);// = '';
	//$_SESSION['email'] = '';
	//$_SESSION['wallet'] = '';	
	
	//echo('<br>_COOKIE</br>');
	//print_r($_COOKIE);
	//echo('<br>_SESSION</br>');
	//print_r($_SESSION);
	//die('Exit');

	header('Location: /?action=login');
	
}
if(isset($_GET['translate_mod'])){
	if($_GET['translate_mod'] == -1){
		unset($_SESSION['translate_mod']);
	}else{
		$_SESSION['translate_mod'] = 1;
	}
	
}
//print_r($_SESSION);


if(isset($_SESSION['lang'])){
	//echo('Переменная есть');
	$lang = t_file_get($_SESSION['lang']);
}else{
	$lang = t_file_get('en');
	$_SESSION['lang'] = 'en';
}
include ($basedir . '/frontend/lib/frontend_config.php');
if (isset($_GET['ajax_action'])) {
	if($_GET['ajax_action'] == 'news_change_page'){
		include ('ajax/a_news_change_page.php');
	}else{ //Пока оставить для обратной совместимости, переписать news_change_page
		include ('ajax/a_'.$_GET['ajax_action'].'.php');
	}
}
if(isset($_COOKIE['uid']) AND isset($_COOKIE['email']) AND isset($_COOKIE['wallet'])){
	//echo('!**&!**');
	$_SESSION['uid'] = $_COOKIE['uid'];
	$_SESSION['email'] = $_COOKIE['email'];
	$_SESSION['wallet'] = $_COOKIE['wallet'];
}
if(isset($_COOKIE['admin_login'])){
	$_SESSION['admin_login'] = $_COOKIE['admin_login'];
}

include('header.php');
//На реге и регистрации левые кнопки ссылкой

if (isset($_GET['action'])) {
	
	if(isset($_GET['subaction'])){
		include ('mod/'.$_GET['action'].'/page_'.$_GET['subaction'].'.php');
	}else{
		include ('mod/page_'.$_GET['action'].'.php');
	}
}else{
	//include ('mod/page_'.$_GET['action'].'.php');
	//header('Location: http://95.179.236.117/?action=cabinet');
	//include ('mod/mainpage.php');
}
if(isset($_GET['ajax_action'])){
	if ($_GET['ajax_action'] == '...') {
		include ('mod/ajax.php'); # и там die () / exit ()
	}
}
if(!isset($_GET['action']) && !isset($_GET['subaction'])){
	$page_type = get_page_type();
	include($basedir . '/frontend/header_menu.php');
	if(!isset($page_type[0]) || strlen($page_type[0]) == 0){
		include ('mod/mainpage.php');
	}else{
		if($page_type[0] == 'page'){
			if(isset($page_type[1]) && strlen($page_type[1]) > 0){
				//Не статик страницы показываются из одного файла
				if($page_type[1] == 'about_us' || $page_type[1] == 'contacts'){
					include ('mod/page_page.php');
				}
				if($page_type[1] == 'smart_trading'){
					include ('mod/pages/page_smart_trading.php');
				}
				if($page_type[1] == 'smart_mining'){
					include ('mod/pages/page_smart_mining.php');
				}
				if($page_type[1] == 'smart_index'){
					include ('mod/pages/page_smart_index.php');
				}
			}
		}
		//faq отдельно, т.к. нет переходов на полные версии статей faq
		if($page_type[0] == 'faq'){
			include ('mod/pages/page_faq.php');
		}
		
		if($page_type[0] == 'category'){
			if(isset($page_type[1]) && strlen($page_type[1]) > 0){
				if($page_type[1] == 'news'){
					include ('mod/categorys/category_news.php');
				}
				if($page_type[1] == 'faq'){
					include ('mod/pages/page_faq.php');
				}
			}
		}
	}
	include($basedir . '/frontend/footer_menu.php');
}

include('footer.php');