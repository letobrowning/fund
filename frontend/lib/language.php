<?php 
//Обновляем содержимое языкового файла, если его нет, то создаем
function t_file_update($name,$data){
	global $basedir;
	$filename = $basedir . '/frontend/lang/'.$name.'.csv';
	//echo($filename);
	
	$fp = fopen($filename, 'w');
	$error = '';
	foreach ($data as $fields) {
		
		if(fputcsv($fp, $fields)){
			
		}else{
			$error = 'Ошибка в '.$fields;
		}
	}
	fclose($fp);
	if(strlen($error) > 0){
		return $error;
	}else{
		return true;
	}
}

function get_all_lang_name(){
	global $basedir;
	$lang_files  = scandir ($basedir . '/frontend/lang/');
	$lang_names = array();
	foreach($lang_files as $fname){
		if($fname != '.' AND $fname != '..'){
			$lang_names[] = str_replace('.csv','',$fname);
		}
	}
	return($lang_names);
}


//Обновляем значение в файле, если значения по tid нет, то создаем
//Возвращает массив, который нужно потом t_file_update
//Задаем новое значение в виду array(id, value);
//t_file_update('ru',t_file_update_val($lang,array('Name','Имя2')));
function t_file_update_val($data,$newval){
	if(is_array($newval) AND is_array($data)){
		$data[$newval[0]] = $newval;
		return $data;
	}else{
		return ERROR_INCORRECT_PARAMETERS;
	}
	
}
//Получим значение из ранее полученного языкового массива
function t_get_val($name,$form = false,$type = array('input')){
	global $lang;
	global $basedir;
	if(isset($lang[$name])){	
		$text =  $lang[$name][1];
	}else{
		
		$text =  $name;
	}
	if(isset($_SESSION['translate_mod'])){
			if($form){
				$result = array();
				$result['text'] =  $text;
				$result['lnk'] =  '<span class="translate_lnk" data-toggle="modal" data-target="#modal-translate" data-lid="'.$name.'" >[t]</span>';
				return $result;
			}else{
				$add_data = '';
				if(count($type) > 1){
					$add_data = ' data-type="'.$type[0].'" data-eddtype="'.$type[1].'"';
				}else{
					$add_data = ' data-type="'.$type[0].'"';
				}
				$text =  $text.'<span class="translate_lnk" data-toggle="modal" '.$add_data .' data-target="#modal-translate" data-lid="'.$name.'" >[t]</span>';	
			}
	}
	
	return $text;
}


//Для вывода полей формы, где нужен перевод
function lang_input($type, $name, $class ='', $id = '',$required = false, $placeholder = '',$data = '',$helpblock = '',$value = '',$disabled = ''){
	$result = '';
	if($type == 'textarea'){
		$result .= '<textarea name="'.$name.'"';
		if($id){
			$result .= ' id="'.$id.'"';
		}
		if($class){
			$result .= ' class="'.$class.'"';
		}
		if($required){
			$result .= ' required';
		}
		if($disabled){
			$result .= ' disabled';
		}
		if($data){
			$result .= ' '.$data;
		}
		if($placeholder){
			$text = t_get_val($placeholder,true);
			if(is_array($text)){
				$result .= ' placeholder="'.$text['text'].'" >';
			}else{
				$result .= ' placeholder="'.$text.'">';
			}
		}else{
			$result .= '>';
		}
		if($value){
			$result .= $value;
		}
		
		$result .= '</textarea>';
		if($placeholder){
			if(is_array($text)){
				$result .= $text['lnk'];
			}
		}
	}else{
		$result .= '<input type="'.$type.'" name="'.$name.'"';
		if($id){
			$result .= ' id="'.$id.'"';
		}
		if($class){
			$result .= ' class="'.$class.'"';
		}
		if($required){
			$result .= ' required';
		}
		if($disabled){
			$result .= ' disabled';
		}
		if($value){
			$result .= ' value="'.$value.'"';
		}
		if($data){
			$result .= ' '.$data;
		}
		if($placeholder){
			$text = t_get_val($placeholder,true);
			//echo('<pre>');
			//print_r($text);
			//echo('</pre>');
			if(is_array($text)){
				$result .= ' placeholder="'.$text['text'].'" >'.$text['lnk'];
			}else{
				$result .= ' placeholder="'.$text.'">';
			}
		}else{
			$result .= '>';
		}
		if($helpblock){
			$result .= '<span class="help-block" style="display:none;">'.$helpblock.'</span>';
		}
	}

	return $result;
}

//Для вывода подсказок, где нужен перевод
function lang_tooltip($name,$placement = 'right'){
	global $lang;
	global $basedir;
	if(isset($lang[$name])){
		$text =  $lang[$name][1];
	}else{
		$text =  $name;
	}
	$result = '<span class="tooltip_btn pl5 text-light-blue" data-toggle="tooltip" data-placement="'.$placement.'" title="'.$text.'">?</span>';
	if(isset($_SESSION['translate_mod'])){
		$result =  $result.'<span class="translate_lnk" data-toggle="modal" data-target="#modal-translate" data-lid="'.$name.'" >[t]</span>';	
	}
	
	return $result;
}



function get_lang_text_by_filename($name,$lname){
	$lang_file = t_file_get($lname);
	if(isset($lang_file[$name])){
		return $lang_file[$name][1];
	}else{
		return false;
	}
}

//Получаем содержимое языкового файла, если его нет, то по умолчанию выводим en
function t_file_get($name){
	ini_set("auto_detect_line_endings", true);
	global $basedir;
	$result = array();
	$filename = $basedir . '/frontend/lang/'.$name.'.csv';
	//echo($filename);
	if(!file_exists($filename)){
		$filename = $basedir . '/frontend/lang/en.csv';
	}
	
	$fp = fopen($filename, 'r');
	while (($data = fgetcsv($fp)) !== FALSE) {
        //$num = count($data);
        $result[$data[0]] = array($data[0],$data[1]);
        
    }
	fclose($fp);
	return $result;
	//fclose($fp);
}


?>