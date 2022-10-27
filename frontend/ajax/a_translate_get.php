<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//$basedir = '/var/www/html';
//include ($_POST['basedir'].'/frontend/lib/language.php'); 
$all_langs = get_all_lang_name();
$result = array();
$result['POST'] = $_POST;
$result['all_langs'] = $all_langs;
$result['form_inner'] = '';
$tinyflag = false;
if(!isset($_POST['type'])){
	$_POST['type'] = 'input';
}
$lk = 1;
foreach($all_langs as $lang){

	$get_curr_val = get_lang_text_by_filename($_POST['lid'],$lang);
	if($_POST['type'] == 'textarea'){
		if($get_curr_val){
			$value = $get_curr_val;
		}else{
			$value = '';
		}
		if($_POST['eddtype'] == 'tinymce'){
			$textarea_class = 'tinymce';
			$tinyflag = true;
		}
		$result['form_inner'] .= '
		<div class="form-group pb15 col-sm-12">
			<div class="row">
				<div class="col-sm-1 trans_lang">
					<b>'.$lang.'</b>
				</div>
				<div class="col-sm-11 trans_value">
					<textarea id="txtarea'.$lk.'" class="form-control l_text '.$textarea_class.'" placeholder="Translate text" required >'.$value.'</textarea>
				</div>
			</div>
		</div>';
	}else{
		if($get_curr_val){
			$value = 'value = "'.$get_curr_val.'"';
		}else{
			$value = '';
		}
		
		$result['form_inner'] .= '
		<div class="form-group pb15 col-sm-12">
			<div class="row">
				<div class="col-sm-1 trans_lang">
					<b>'.$lang.'</b>
				</div>
				<div class="col-sm-11 trans_value">
					<input class="form-control l_text" placeholder="Translate text" required '.$value.'>
				</div>
			</div>
		</div>';
	}
	$lk++;
}
if($tinyflag){
	$result['form_inner'] .= "
			<script>
			$( document ).ready(function() {
			  tinymce.init({
				selector: '.tinymce',
				protect: [
				/\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
				/\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
				/<\?php.*?\?>/g  // Protect php code
			  ],
			  images_upload_url: 'postAcceptor.php',
			  images_upload_base_path: '/some/basepath',
			  images_upload_credentials: true,
				  height: 200,
				  language: 'ru',
			  theme: 'modern',
			  plugins: 'fullpage searchreplace autolink directionality visualblocks visualchars fullscreen codesample charmap hr pagebreak nonbreaking toc insertdatetime advlist lists textcolor wordcount   contextmenu colorpicker textpattern help code link table',
			  toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor fontsizeselect | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link | table | code | removeformat ',
			  image_advtab: true,
			  content_css: [
				'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				'//www.tinymce.com/css/codepen.min.css'
			  ]
			  });
			});
			</script>
	
	";
}
echo(json_encode($result));
die();
?>