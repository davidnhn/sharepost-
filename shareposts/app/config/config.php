<?php
//DB PArams
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'shareposts');

//* APP Root
//! quand on veut recup qqch dans app
//C:\wamp64\www\mvc\app(\config\config.php)
define('APPROOT',dirname(dirname(__FILE__)));//remonte dun parent fois 2 depuis fichier config jusqua app

//*URL Root
//! quand on veut recup qqch dans public
define('URLROOT', 'http://localhost/shareposts');

//* SITE NAME
define('SITENAME', 'SharePosts');

//*APP VERSION
define('APPVERSION', '1.0.0');