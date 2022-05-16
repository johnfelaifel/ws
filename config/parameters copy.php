<?php
define ("appName","UReport");
define ("controller_default","CentralController");
define ("action_default","start");
define ("version","1.1");
define ("ipPublica","190.26.14.150");
define ("ipLocal","21.12.12");

//Pruebas
define ("PORT","80");
define ("PORT_DB","3306");
define ("SERVER_DB","127.0.0.1");
define ("USER_DB","dev");
define ("PASSWORD_DB","1234");
define ("DATABASE","simec");




//Ruta de URL general de la aplicacion
$tmpRuta=explode(appName, $_SERVER['PHP_SELF']);
define ("base_url","http://".$_SERVER['SERVER_NAME'].":".PORT.$tmpRuta[0].appName."/");

//Ruta de URL de las acciones del controlador principal
define ("base_central","http://".$_SERVER['SERVER_NAME'].":".PORT.$tmpRuta[0].appName."/Central/");

//Ruta de URL de las acciones del controlador administrativo
define ("base_admin","http://".$_SERVER['SERVER_NAME'].":".PORT.$tmpRuta[0].appName."/Admin/");

//Ruta de URL de las acciones del controlador UReport Aplicativo Web
define ("base_uweb","http://".$_SERVER['SERVER_NAME'].":".PORT.$tmpRuta[0].appName."/UReportWeb/");

//Ruta de URL de las acciones del controlador Tracking
define ("base_tracking","http://".$_SERVER['SERVER_NAME'].":".PORT.$tmpRuta[0].appName."/Tracking/");

//Ruta de URL de los assets
define ("base_assets",base_url."views/assets/"); 

//Ruta relativa para el uso de include o require
$tmpRuta=explode('index.php', $_SERVER['SCRIPT_FILENAME']);
define ("base_relative",$tmpRuta[0]."views/"); 


//Ruta relativa hacia la App Padre 
$tmpRuta=explode(APPNAME, $_SERVER['SCRIPT_FILENAME']);
define ("SERVER_RELATIVE",$tmpRuta[0]); 
?>