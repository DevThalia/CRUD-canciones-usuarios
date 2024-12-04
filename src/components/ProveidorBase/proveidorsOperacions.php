<?php

/**
 * @copyright Lluert Serveis Telemàtics, S.L. 
 * @license 
 * @see http://www.lluert.net 
 */

/**
 * Aquesta pàgina fa les competicions sobre aulas
 */

//carreguem el fitxer de ..iguració
if (file_exists('../_inicialitza_pagina.php')) {
    include_once '../_inicialitza_pagina.php';
} else {
    die;
}
comprovaSeguretat();
$proveidor = new Proveidor($db);
if(!isset($operacio)) $operacio=0;
$jsonResultat = array('estatOperacio' => false, 'msgError' => '', 'paginaProveidor' => $_SERVER['PHP_SELF'], 'operacio' => $operacio);
switch ($operacio) {
    case "insereixProveidor":
        $proveidor = new Proveidor($db);
        if ($proveidor->set('nomProveidor', $nomProveidor)) {

            foreach ($_REQUEST as $request_camp => $request_valor) {
                if ($request_camp != 'operacio' && $request_camp != 'tipusMostra'  && $request_camp != 'nomProveidor') $proveidor->set($request_camp, ($request_valor));
            }
            if ($proveidor->desa()) {
                $jsonResultat['estatOperacio'] = true;
                $idProveidor= $proveidor->get('idProveidor');
            } else {
                $jsonResultat['msgError'] = 'Error '.$proveidor->get_msgError();
                $jsonResultat['query']=$proveidor->get_sql_query();
            }
            $jsonResultat['tipusError']=$proveidor->get_tipusError();
        } else {
            $jsonResultat['msgError'] = "falten camps o algun camp és incorrecte ";
        }
        break;
    case"desaCampProveidor":
        $proveidor = new Proveidor($db,$idProveidor);
        if ($proveidor->set($camp, $valor) && $proveidor->set('idProveidor', $idProveidor)) {
            foreach ($_REQUEST as $request_camp => $request_valor) {
                if ($request_camp != 'camp' && $request_camp != 'valor' && $request_camp != 'operacio' && $request_camp != 'tipusMostra' ) $proveidor->set($request_camp, ($request_valor));
            }
           if ($proveidor->desa()) {
                $jsonResultat['estatOperacio'] = true;

            } else {
                $jsonResultat['msgError'] = 'Error '.$proveidor->get_msgError();
                $jsonResultat['query']=$proveidor->get_sql_query();
            }
            $jsonResultat['tipusError']=$proveidor->get_tipusError();
        } else {
            $jsonResultat['msgError'] = "falten camps o algun camp es incorrecte ".$proveidor->get_msgError();
        }
        break;

    case 'eliminaProveidor':
        if($proveidor->set('idProveidor', $idProveidor)){
            if ($proveidor->elimina()) {
                $jsonResultat['estatOperacio'] = true;
            } else {
                $jsonResultat['msgError'] = $proveidor->get_msgError();
                $jsonResultat['query']=$proveidor->get_sql_query();
            }   
            $jsonResultat['tipusError']=$proveidor->get_tipusError();
        }else {
            $jsonResultat['msgError'] = "falten camps o algun camp és incorrecte ";
        }
        break;

    default :
        $jsonResultat['msgError'] = "el camp no existeix és vàlid";
}

if(!isset($idProveidor)) $idProveidor = 0;
$jsonResultat['idProveidor'] = $idProveidor;
echo json_encode($jsonResultat);
?>