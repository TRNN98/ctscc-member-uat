<?php
/**
* @name System Configuration
* @category Configuration
* @author MR.Wittaya Yaowapong
* @copyright so-at solution co,ltd
*
* @abstract
* > This Configuration File Will Be Declare Global Variable
* > For Use Whole Of This Porject
* > And  This File Will Be Place On Top Of Project
* > Be Carefull
*/

#DECLARE GLOBAL SYSTEM DBMS_____________________
 global    $_DBTYPE ,$_DBSERVER , $_DBUSER ,$_DBPASSWD ,$_DBNAME , $_DBCHAR_SET ,$_DBCHAR_NAME ,$_DBCHAR_COLLATION;

#DATABASE  ACCOUNT______________________________
#@!<!-- Host -->
 define($_DBTYPE ,'mysql',false);

 // define(_DBSERVER,'203.151.24.15',false);
 // define(_DBUSER,'coopmoj_admin',false);
 // define(_DBPASSWD,'flKsruU3z',false) ;
 // define(_DBNAME,'coopmoj_test',false);

//  define(_DBSERVER,'203.151.24.15',false);
//  define(_DBUSER,'coopmoj_admin',false);
//  define(_DBPASSWD,'flKsruU3z',false) ;
//  define(_DBNAME,'coopmoj_test',false);

//  define(_DBCHAR_SET,'utf8',false) ;
//  define(_DBCOLLATION,'utf8_unicode_ci',false);


#DECLARE ENVIRONMENT SYSTEM VARIABLE ____________
 $first_page =	"index.php" ;
 $this_page =	$_SERVER['PHP_SELF'];
 $request_page	=	$_SERVER['HTTP_REFERER'] ;
 $today	=	date("Y-n-j H:i:s") ;
define('DATETIME',date("Y-n-j H:i:s"));
define('DATE',date("Y-n-j"));
define('TIME',date("H:i:s"));

#DECLARE DIRECTORY PATH __________________________

define('PHOTO_PATH','mediafiles/picture/') ;
define('FILE_PATH','mediafiles/data/');
//  define('MEDIA_PATH','/mediafiles/');
define('MEDIA_PATH','/mediafiles/');
define('BOARD_PHOTO_PATH','photo/board/');
define('BOARD_FILE_PATH','data/board/');

#__________________________________________________

?>
