<?php

// session_start();
/**
* @package  System Kernel
* @author Mr.Wittaya Yaowapong
* @version 2.0A
* @copyright soatsolution co,ltd 2009 ;
*/

/**
*  @abstract
* This Engine Will Be Set All Environment  Variable For Start Systems
*/

// @! must declare this  variable befor  -> require for declare script  root path
//  define('ROOT_PATH',str_replace('\\','/',str_replace('system','',dirname(__FILE__)))) ;
//  define('PHP_VER',substr(phpversion(),0,1)) ;

 #DEFINE SESSION DIRECTORY_______________________
 // define('SESSION_PATH',ROOT_PATH . 'session') ;

#Check Session Directory  ? __________________________
#<!-- if directory do not exist ! script will be create it
// if(!file_exists(SESSION_PATH)){@mkdir(SESSION_PATH);}

#Config Session  ___________________________________
// session_save_path(SESSION_PATH);


#Declare Usefull Session Variable
// session_register('INSTALL_PATH') ;
// session_register('membership_no');
// session_register('first_access') ;
// $_SESSION['INSTALL_PATH'] = ROOT_PATH;


#Config Error Handing Display  ________________________
// error_reporting(6135);
error_reporting(0);

 # Load Common System ____________________________
 require_once base_path()."/app/system/system.config.php";
 require_once base_path()."/app/system/system.class.php";
 require_once base_path()."/app/system/system.datetime.php";
 require_once base_path()."/app/system/system.member.php";
 require_once base_path()."/app/system/system.function.php";


 /**
 * @desc Declare Common Object  And Variable
 * This Will Be Declare Object For Use Whole  Project
 * If You Want To Use Object Or Variable  On All Of  Project
 * You Must Declare It Here !
 */
  /**
  * @declare Object Date_Time
  */
//   $date_time = new Date_Time() ;
//   $date_time->split_operator = "-";

  /**
  * Dynmic Variable
  */
  //Theme
   // $dbo3->query_string = "SELECT current_theme FROM www_appearance";
   // $dbo3->query();
   // DEFINE(CURRENT_THEME,$dbo3->result(),true) ;

   // $dbo3->query_string = "SELECT * FROM www_appearance_color LIMIT 1";
   // $dbo3->query();
   // $Appearance = $dbo3->fetch_array();
   // DEFINE(MAIN_COLOR,$Appearance[main_color],true);

   //  $dbo3->query_string = "SELECT * FROM www_appearance_color LIMIT 1";
   // $dbo3->query();
   // $Appearance = $dbo3->fetch_array();
   // DEFINE(FG_COLOR,$Appearance[fg_color],true);


   // /**
   // * Topic
   // *
   // */
   // $dbo3->query_string = "SELECT new_topic_days FROM www_constant LIMIT 1 ";
   // $dbo3->query();
   // $TopicConf = $dbo3->fetch_array();
   // DEFINE(NEW_TOPIC_DAYS,$TopicConf[new_topic_days],true);
   //

   // $results = DB::select('SELECT current_theme FROM www_appearance limit 0,1');
   // // var_export($results) ;
   // echo $results['0']->current_theme;

?>
