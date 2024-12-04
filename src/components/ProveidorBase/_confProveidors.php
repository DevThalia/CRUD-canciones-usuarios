<?php
$a_classes['ProveidorBase'] = 'ProveidorBase/ProveidorBase.class.php';
$a_classes['Proveidor'] = 'ProveidorBase/Proveidor.class.php';
$proveidorsFitxa = "ProveidorBase/proveidorsFitxa.php";
$proveidorsLlista = "ProveidorBase/proveidorsLlista.php";
$proveidorsOperacions = "ProveidorBase/proveidorsOperacions.php";
if (!$idiomaSistemaBase) $idiomaSistemaBase = 'ca';
$url_idioma='idiomes/' . $idiomaSistemaBase . '.conf.php';
if(!file_exists(__DIR__.'/'.$url_idioma)){
    $url_idioma='idiomes/' . CONF_APP_IDIOMA . '.conf.php';
}
$a_idiomes['ProveidorBase'] = 'ProveidorBase/'.$url_idioma;