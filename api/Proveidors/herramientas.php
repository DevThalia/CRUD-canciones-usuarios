<?php
if (!function_exists('comprovaSeguretatAPI')) {
    function comprovaSeguretatAPI($aliasOperacioComprovaSegretat = 0, $token_apiKey = '')
    {
        global $db;

        $a_REQUEST = array();
        if (file_get_contents("php://input")) {
            $a_REQUEST = json_decode(file_get_contents("php://input"),true);
        } else {
            $a_REQUEST = $_REQUEST;
        }        
        $a_errorAutenticacio = json_decode(T_JSON_ERRORS_AUTENTICACIO, true);
        $jsonResultat = array('estatOperacio' => false, 'msgError' => '');
        // $derectorioActual = str_replace('SistemaBase', '', __DIR__);
        if (!(trim($token_apiKey))) $token_apiKey = '';
        if (($token_apiKey != '' && $token_apiKey) || (isset($_REQUEST['formulariAutenticacio']) && ($_REQUEST['formulariAutenticacio'] == 1))) {
            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_display_errors'] = 0;
            if ($token_apiKey) {
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idClient'] = 0;
                $usuariSessio = new Usuari($db);
                $usuariSessio->set('apiKey', $token_apiKey);

                $permis_per_accedir = $usuariSessio->validaAcces_i_carrega();
                if ($permis_per_accedir == 1 || ($token_apiKey && $usuariSessio->get('idUsuari') && ($permis_per_accedir == 1 || $permis_per_accedir < 0))) {
                    // si es token NO MERA IP DE ACSESO DE HORARIO
                    $usuariSessio->carregaDades();
                    $numEmpresa = 0;
                    $idEmpresa = 0;
                    if (class_exists('Empreses')) {
                        $empresa = new Empreses($db);
                        /*
                        *  CAL MIRAR SI HI HA VARIES EMPRESES que l'enviiin via REQUEST!!!!
                        *
                        */
                        $numEmpresa = $empresa->numEmpreses();
                        if ($numEmpresa > 1 && !isset($a_REQUEST['idEmpresa'])) {
                            //Error cal indicar la empresa!!
                            $jsonResultat['msgError'] = ucfirst('FALTA EMPRESA');
                        } else {
                            $filreEmpresa = " relEmpresesUsuaris.idUsuari in (" . $usuariSessio->get('idUsuari') . ") AND flagActiuEmpresa=1";
                            if ($a_REQUEST['idEmpresa']) {
                                $filreEmpresa .= ' AND relEmpresesUsuaris.idEmpresa=' . $a_REQUEST['idEmpresa'];
                            }
                            $a_empresa = $empresa->llistaInnerRelEmpresesUsuaris($filreEmpresa, 'relEmpresesUsuaris.ordreRelEmpresaUsuari asc,idEmpresa asc', 1);
                            if (isset($a_empresa[0]['idEmpresa'])) $idEmpresa = $a_empresa[0]['idEmpresa'];
                            if ($idEmpresa) {
                                
                            } elseif ($numEmpresa == 1) {
                                $empresa->getIds('flagActiuEmpresa=1', 'idEmpresa asc');
                                if ($empresa->extreu()) {
                                    $empresa->getIds('', 'idEmpresa asc');
                                    $empresa->extreu();
                                    $empresa->set('idUsuari', $usuariSessio->get('idUsuari'));
                                    if ($empresa->desaRelEmpresesUsuaris()) {
                                        $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] = $empresa->get('idEmpresa');
                                        $idEmpresa = $empresa->get('idEmpresa');
                                    }
                                }
                                
                            }
                        }
                    }

                    if ($idEmpresa) {
                        if(isset($a_REQUEST['idEmpresa'])) $idEmpresa=$a_REQUEST['idEmpresa'];///no es correcto
                            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat'] = 'autenticat';
                            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] = $idEmpresa;
                            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari'] = $usuariSessio->get('idUsuari');
                            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_loginUsuari'] = $usuariSessio->get('loginUsuari');
                            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_emailUsuari'] = $usuariSessio->get('emailUsuari');
                            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_nomUsuari'] = $usuariSessio->get('nomUsuari');
                            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idPerfil'] = $usuariSessio->get('idPerfil');
                            $jsonResultat['estatOperacio'] = true;
                        
                    } else {
                        $errorAutenticacio = 4; // accés DENEGAT
                        if (isset($a_errorAutenticacio[$permis_per_accedir])) $jsonResultat['msgError'] = $a_errorAutenticacio[$permis_per_accedir];
                    }
                } else {
                    $errorAutenticacio = $permis_per_accedir; //usuari, horari, ip
                    if (isset($a_errorAutenticacio[$permis_per_accedir])) $jsonResultat['msgError'] = $a_errorAutenticacio[$permis_per_accedir];
                }
            } else {

                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat'] = '';
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari'] = '';
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_loginUsuari'] = '';
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_nomUsuari'] = '';
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idPerfil'] = 0;
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_emailUsuari'] = '';
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] = 0;
                $jsonResultat['msgError'] =  $a_errorAutenticacio[0];
            }
            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idioma'] = CONF_APP_IDIOMA;
        } elseif ((isset($_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat']) && $_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat'] != 'autenticat') || (!isset($_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat']))) { //NO ESTEM autenticats
            $jsonResultat['msgError'] = $a_errorAutenticacio[4];
        } else { //ESTEM autenticats, continuem...
            if ($aliasOperacioComprovaSegretat) {
                $usuariSessio = new Usuari($db, $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari']);
                switch ($aliasOperacioComprovaSegretat) {
                    case 'gestioUsuaris':
                        if ($usuariSessio->permisOperacio('gestioUsuaris') < 1) {
                            if ($_REQUEST['idUsuari'] == $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari']) {
                            } else {
                                $jsonResultat['msgError'] = ucfirst(T_NO_TENS_PERMISOS);
                            }
                        }
                        break;
                    default:
                        if ($usuariSessio->permisOperacio($aliasOperacioComprovaSegretat) < 1) {
                            $jsonResultat['msgError'] = ucfirst(T_NO_TENS_PERMISOS);
                        }
                        break;
                }
            }
        }
        if (!$jsonResultat['estatOperacio']) {
            http_response_code(200);
            $a_resultatTMP = array();
            $a_resultatTMP['status'] = "error";
            $a_resultatTMP['error'] = $jsonResultat;
            echo json_encode($a_resultatTMP, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
            exit();
        }
    }
}
