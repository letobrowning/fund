<?php
//В конфиге необходимо задать $upload_dir
function image_upload($file){
	$basedir = '';
	$uploaddir=VIMG_DIR;
	if (file_exists($uploaddir.''.date('Y'))) {
		 //echo "Папка есть год";
		$uploaddir = $uploaddir.date('Y');
		$basedir = date('Y');
	} else {
		mkdir($uploaddir.''.date('Y'), 0700, true);
		$uploaddir = $uploaddir.date('Y');
		$basedir = date('Y');
	}
	if (file_exists($uploaddir.'/'.date('m'))) {
		 //echo "Папка есть месяц";
		$uploaddir = $uploaddir.'/'.date('m');
		$basedir = $basedir.'/'.date('m');
	} else {
		mkdir($uploaddir.'/'.date('m'), 0700, true);
		$uploaddir = $uploaddir.'/'.date('m');
		$basedir = $basedir.'/'.date('m');
	}
	if (file_exists($uploaddir.'/'.date('d'))) {
		//echo "Папка есть день";
		$uploaddir = $uploaddir.'/'.date('d');
		$basedir = $basedir.'/'.date('d');
	} else {
		mkdir($uploaddir.'/'.date('d'), 0700, true);
		$uploaddir = $uploaddir.'/'.date('d');
		$basedir = $basedir.'/'.date('d');
	}	
	$latname = $file['name'];
	$latname = mb_strtolower($latname,mb_detect_encoding($latname));
	$latname = strtr($latname, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>'',' '=>'_'));
	$uploadfile = $uploaddir .'/'. $latname;
	$basedir = $basedir.'/'.$latname;
	$i = 0;
	//Если файл с таким имененм существует то добавляем в конец названия файла порядковый номер
	while (file_exists($uploadfile)){
		$ilast = $i;
		$i++;
		if($ilast == 0){
			$uploadfile = str_replace(".", $i.".", $uploadfile);
			$basedir = str_replace(".", $i.".", $basedir);
		}else{
			$uploadfile = str_replace($ilast.".", $i.".", $uploadfile);
			$basedir = str_replace($ilast.".", $i.".", $basedir);
		}
	}
	//echo($uploadfile);
	//die();
	if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
		return $uploadfile;
	} else {
		$error = true;
		return false;
	}	
}

?>