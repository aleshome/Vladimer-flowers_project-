<?php
# Here is general configuration file in CMS 
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
# Connect router controller's mtrhod
define('SKIN', ROOT.'/theme/shop');
define('NAME_SKIN', '/theme/shop');
include_once ROOT.'/engine/components/Routing/Router.php';
# Load project Libs
include_once ROOT.'/engine/components/libs/DataBase.php';
$query = DataBase::getConnection()->query("SELECT * FROM tbl_settings WHERE id = '1'")->fetch(PDO::FETCH_OBJ);
define('SITE_URL', $query->site_url);
define('COM_NAME', $query->company_name);
define('BASIC_META_DESC', $query->basic_meta_desc);
define('BASIC_META_KEYS', $query->basic_meta_key);
define('BASIC_TITLE', $query->site_title);
define('SITE_NAME', $query->site_name);
define('IMAGES', SITE_URL.'/uploads/products');
define('CSS_FOLDER', SITE_URL.NAME_SKIN.'/assets/css');
define('JS_FOLDER', SITE_URL.NAME_SKIN.'/assets/js');
include_once ROOT.'/engine/components/libs/Autoload.php';
#include_once ROOT.'/engine/components/libs/error.php';
include_once ROOT.'/engine/components/libs/Redirect.php';
include_once ROOT.'/engine/components/libs/Session.php';
# Load Security libs file and folder
include_once ROOT.'/engine/components/Security/security.class.php';
// include_once ROOT.'/engine/components/Security/anubis.class.php';
include_once ROOT.'/engine/components/Security/cryptography.class.php';
// include_once ROOT.'/engine/components/Security/generatePass.php';
// include_once ROOT.'/engine/components/Security/hash.class.php';
include_once ROOT.'/engine/components/Security/mail.class.php';
include_once ROOT.'/engine/components/Security/md5.class.php';
// include_once ROOT.'/engine/components/Security/PBKDF2.php';
// include_once ROOT.'/engine/components/Security/sh1.class.php';
// include_once ROOT.'/engine/components/Security/Validator.php';
include_once ROOT.'/engine/components/libs/GenerateAlias.php'; # Библиотека для генерации алиасов и так далее
# init Session component
Session::init();
