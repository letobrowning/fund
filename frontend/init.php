<?php

### Инициализация фронтенда ###
include ($basedir . '/init.php'); 
include ($basedir . '/common/const.lib.php'); 
include ($basedir . '/frontend/lib/functions_front.php');
include ($basedir . '/frontend/lib/files.php');
include ($basedir . '/frontend/lib/language.php'); //Переводы и работа с файлами переводов
include ($basedir . '/frontend/lib/mail_function.php'); //Почта
require_once  ($basedir . '/frontend/lib/mainsms.class.php'); //MainSMS

# include ($basedir . '/frontend/....php'); 