<?php
$modeDev = strpos("#" . $host, 'lluert.dev');
$modeLocal = strpos("#" . $host, 'lluert.local');
$modeTest = strpos("#" . $host, 'test.');

if ($modeLocal) {
    //BBDD
    if (!defined('CONF_DB_SERVIDOR')) define('CONF_DB_SERVIDOR', 'localhost');
    if (!defined('CONF_DB_BBDD')) define('CONF_DB_BBDD', 'dev_demoLluert');
	if (!defined('CONF_DB_USUARI')) define('CONF_DB_USUARI', 'dev_lluert');
	if (!defined('CONF_DB_CONTRASENYA')) define('CONF_DB_CONTRASENYA', 'bJCzYfr8*WCq-.8q3__Z');
    //FTP
	if (!defined('CONF_FTP_SERVIDOR')) define('CONF_FTP_SERVIDOR', 'demo.lluert.dev');
	if (!defined('CONF_FTP_USUARI')) define('CONF_FTP_USUARI', 'dev_demolluert');
	if (!defined('CONF_FTP_CONTRASENYA')) define('CONF_FTP_CONTRASENYA', '?Xo4uhmYadw2v04aX');
    if (!defined('CONF_MODE_DEBUG')) define('CONF_MODE_DEBUG', true);
	if (!defined('CONF_TEST')) define('CONF_TEST',	'3');
	if (!defined('CONF_INFODESENVOLUPAMENT')) define('CONF_INFODESENVOLUPAMENT', 'lluert@lluert.net');
}else if ($modeDev) {
	/* DESENVOLUPAMENT */
	//BBDD
	if (!defined('CONF_DB_SERVIDOR')) define('CONF_DB_SERVIDOR', 'localhost');	
	if (!defined('CONF_DB_BBDD')) define('CONF_DB_BBDD', 'dev_demoLluert');
	if (!defined('CONF_DB_USUARI')) define('CONF_DB_USUARI', 'dev_lluert');
	if (!defined('CONF_DB_CONTRASENYA')) define('CONF_DB_CONTRASENYA', 'bJCzYfr8*WCq-.8q3__Z');
	//FTP per penjar arxius localment
	if (!defined('CONF_FTP_SERVIDOR')) define('CONF_FTP_SERVIDOR', 'localhost');
	if (!defined('CONF_FTP_USUARI')) define('CONF_FTP_USUARI', 'dev_demolluert');
	if (!defined('CONF_FTP_CONTRASENYA')) define('CONF_FTP_CONTRASENYA', '?Xo4uhmYadw2v04aX');
	// define(conf_ftp_carpetaBasePublica='imgGestio';
	if (!defined('CONF_MODE_DEBUG')) define('CONF_MODE_DEBUG', true);
	if (!defined('CONF_TEST')) define('CONF_TEST',	'1');
	if (!defined('CONF_INFODESENVOLUPAMENT')) define('CONF_INFODESENVOLUPAMENT', 'lluert@lluert.net');

	if (!defined('CONF_APIREDSYS_SECRETKEY')) define('CONF_APIREDSYS_SECRETKEY','rP1vX7mX1tR1jF5vK8lS0uB6pK5cY1xT8yY0pG0lI8bF4lI8lC');
	if (!defined('CONF_APIREDSYS_IDCLIENT')) define('CONF_APIREDSYS_IDCLIENT','1f3f98bf-c138-4901-9c68-f7695949e2c5');
	if (!defined('CONF_APIREDSYS_URL_BASE')) define('CONF_APIREDSYS_URL_BASE','https://apis-i.redsys.es:20443/psd2/xs2a');

}elseif($modeTest){	
	/* TEST */
	if (!defined('CONF_TEST')) define('CONF_TEST',	'2');

}else{
	/* REAL */	
	if (!defined('CONF_TEST')) define('CONF_TEST',	'0');
	//REAL
	if (!defined('CONF_DB_SERVIDOR')) define('CONF_DB_SERVIDOR', 'p:localhost');
	if (!defined('CONF_DB_BBDD')) define('CONF_DB_BBDD', 'demoLluert');
	if (!defined('CONF_DB_USUARI')) define('CONF_DB_USUARI', 'demolluert');
	if (!defined('CONF_DB_CONTRASENYA')) define('CONF_DB_CONTRASENYA', 'lLslu15$10');
	//FTP per penjar arxius localment
	if (!defined('CONF_FTP_SERVIDOR')) define('CONF_FTP_SERVIDOR', 'localhost');
	if (!defined('CONF_FTP_USUARI')) define('CONF_FTP_USUARI', 'demolluert');
	if (!defined('CONF_FTP_CONTRASENYA')) define('CONF_FTP_CONTRASENYA', '4J&czc98');
}

if (!defined('CONF_MODE_DEBUG')) define('CONF_MODE_DEBUG', false);
if (!defined('CONF_TEST')) define('CONF_TEST', '');
if (!defined('CONF_INFODESENVOLUPAMENT')) define('CONF_INFODESENVOLUPAMENT', '');
if (!defined('CONF_IDIOMA_SISTEMA_BASE')) define('CONF_IDIOMA_SISTEMA_BASE', 'CA,ES'); //idiomes 
if (!defined('CONF_APP_LOGO')) define('CONF_APP_LOGO',	'img/lluert_logo.png');
if (!defined('CONF_APP_LOGO_FAVICON')) define('CONF_APP_LOGO_FAVICON',	'img/favicon/');
if (!defined('CONF_APP_LOGO_menu')) define('CONF_APP_LOGO_menu',	'img/lluert_white.png');
if (!defined('CONF_APP_LOGO_LLUERT')) define('CONF_APP_LOGO_LLUERT',	'img/lluert_white.png');
if (!defined('CONF_APP_NAME')) define('CONF_APP_NAME',	"Demo lluert");
if (!defined('CONF_APP_IDIOMA')) define('CONF_APP_IDIOMA', 'ca');

if (!defined('CONF_SECRET_ENCRYPT_LLUERT')) define('CONF_SECRET_ENCRYPT_LLUERT', 'bUohTRCps3R*Q');
if (!defined('CONF_METHOD_ENCRYPT_LLUERT')) define('CONF_METHOD_ENCRYPT_LLUERT', 'aes256');
if (!defined('CONF_FTP_CARPETA_BASE_PRIVADA'))  define('CONF_FTP_CARPETA_BASE_PRIVADA', '_documents');

if (!defined('CONF_CARPETA_BASE_SISTEMA_PRIVADA')) define('CONF_CARPETA_BASE_SISTEMA_PRIVADA', '../../_documents');
if (!defined('CONF_CARPETA_BASE_SISTEMA_PRIVADA_WEB')) define('CONF_CARPETA_BASE_SISTEMA_PRIVADA_WEB', '../../_documents');
if (!defined('CONF_FTP_PASV')) define('CONF_FTP_PASV', false);
if (!defined('CONF_FTP_PORT')) define('CONF_FTP_PORT', 21);

if (!defined('CONF_FTP_CARPETA_BASE_PUBLICA'))  define('CONF_FTP_CARPETA_BASE_PUBLICA', '_documentsPublics');
if (!defined('CONF_CARPETA_BASE_SISTEMA_PUBLICA')) define('CONF_CARPETA_BASE_SISTEMA_PUBLICA', '../../_documentsPublics');
if (!defined('CONF_CARPETA_BASE_SISTEMA_PUBLICA_WEB')) define('CONF_CARPETA_BASE_SISTEMA_PUBLICA_WEB', '../../_documentsPublics');
if (!defined('CONF_URL_DOCUMENTS_PUBLICS')) define('CONF_URL_DOCUMENTS_PUBLICS', 'https://img.demo.lluert.dev');
if (!defined('CONF_URL_API_SISTEMA')) define('CONF_URL_API_SISTEMA', 'http://api.demo.lluert.local');
if (!defined('CONF_URL_SISTEMA')) define('CONF_URL_SISTEMA', $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST']);

if (!defined('CONF_idUsuariSessioClientPerDefecte')) define('CONF_idUsuariSessioClientPerDefecte', 0);
//si utelesa para filtrar empresas
if(!defined('CONF_VEURE_TOTES_LES_EMPRESES')) define('CONF_VEURE_TOTES_LES_EMPRESES', false);
if(!defined('CONF_TASQUES_MOSTRAR_CAP_DE_SEMANA')) define('CONF_TASQUES_MOSTRAR_CAP_DE_SEMANA', 'true');

//unsplash
if(!defined('CONF_UNSPLASH_ACCESSKEY')) define('CONF_UNSPLASH_ACCESSKEY', 'z7L_giun0VcihiMpvCYFgSIIs5wjdTyzb2T3u3UFIFQ');
if(!defined('CONF_UNSPLASH_SECRETKEY')) define('CONF_UNSPLASH_SECRETKEY', '-SZcLG4g4SPzIvPayXDx9b70m1GHCpLIiMTpBDO4Wy8');
