<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Fitxer que conté funcions auxiliars de la intranet
 */
////////////////////////////////
//// variables disponibles a totes les pàgines
////////////////////////////////
if (!function_exists('nomDiesSetmanaCurt')) {
    function nomDiesSetmanaCurt($dia, $idiomaSistemaBase)
    {
        $idiomaSistemaBase = strtoupper($idiomaSistemaBase);
        $a_diesSetmana = array("--", "dl", "dt", "dc", "dj", "dv", "ds", "dg");
        if ($idiomaSistemaBase == 'ES') {
            $a_diesSetmana = array("--", "lun", "mar", "mié", "jue", "vie", "sab", "dom");
        }
        return $a_diesSetmana[$dia];
    }
}
if (!function_exists('nomDiesSetmana')) {
    function nomDiesSetmana($dia, $idiomaSistemaBase)
    {
        $idiomaSistemaBase = strtoupper($idiomaSistemaBase);
        $a_diesSetmana = array("----", "Dilluns", "Dimarts", "Dimecres", "Dijous", "Divendres", "Dissabte", "Diumenge");
        if ($idiomaSistemaBase == 'ES') {
            $a_diesSetmana = array("----", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        }
        return $a_diesSetmana[$dia];
    }
}
if (!function_exists('nomdiesSetmanaES')) {
    function nomdiesSetmanaES($mes)
    {
        $a_diesSetmanaES = array("--", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom");
        return $a_diesSetmanaES[$mes];
    }
}
if (!function_exists('nomdiesSetmanaCA')) {
    function nomdiesSetmanaCA($mes)
    {
        $a_diesSetmanaES = array("----", "Dilluns", "Dimarts", "Dimecres", "Dijous", "Divendres", "Dissabte", "Diumenge");
        return $a_diesSetmanaES[$mes];
    }
}
if (!function_exists('nomMesGlobalTextosMesos')) {
    function nomMesGlobalTextosMesos($mes, $idiomaSistemaBase)
    {
        $idiomaSistemaBase = strtoupper($idiomaSistemaBase);
        $arrayGlobalTextosMesos = array("", "Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre");
        if ($idiomaSistemaBase == 'ES') {
            $arrayGlobalTextosMesos = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        }
        if ($mes == -1) return $arrayGlobalTextosMesos;
        else return $arrayGlobalTextosMesos[$mes];
    }
}
if (!function_exists('nomMesGlobalTextosMesosAbreviat')) {
    function nomMesGlobalTextosMesosAbreviat($mes, $idiomaSistemaBase)
    {
        $idiomaSistemaBase = strtoupper($idiomaSistemaBase);
        $arrayGlobalTextosMesosAbrev = array("", "Gen", "Feb", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Des");
        if ($idiomaSistemaBase == 'ES') {
            $arrayGlobalTextosMesosAbrev = array("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
        }
        return $arrayGlobalTextosMesosAbrev[$mes];
    }
}
if (!function_exists('nomMesGlobalTextosMesosES')) {
    function nomMesGlobalTextosMesosES($mes)
    {
        $arrayGlobalTextosMesosES = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        return $arrayGlobalTextosMesosES[$mes];
    }
}
if (!function_exists('nomMesGlobalTextosMesosAbrevEs')) {
    function nomMesGlobalTextosMesosAbrevEs($mes)
    {
        $arrayGlobalTextosMesosAbrevCa = array("", "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
        return $arrayGlobalTextosMesosAbrevCa[$mes];
    }
}

if (!function_exists('nomMesGlobalTextosMesosCa')) {
    function nomMesGlobalTextosMesosCa($mes)
    {
        $arrayGlobalTextosMesosCa = array("", "Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre");
        return $arrayGlobalTextosMesosCa[$mes];
    }
}
if (!function_exists('nomMesGlobalTextosMesosAbrevCa')) {
    function nomMesGlobalTextosMesosAbrevCa($mes)
    {
        $arrayGlobalTextosMesosAbrevCa = array("", "Gen", "Feb", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Des");
        return $arrayGlobalTextosMesosAbrevCa[$mes];
    }
}

/////////////////////////////////
//// FUNCIONS AUXILIARS
/////////////////////////////////

/**
 * Per mostrar les cometes dobles de la BD al input de la fitxa
 * 
 * @param string amb la cadena codificada
 * @return string amb la cadena descodificada
 */
if (!function_exists('escriu')) {
    function escriu($textModificar)
    {
        // $textModificar = htmlspecialchars($textModificar);
        if (isset($textModificar)) return htmlentities($textModificar);
    }
}
/**
 *  ens serveix per escriure el numero en format  milers(.) i decimals (,)  ex. 1,456,653.65 i arrodonir a 2 decimals
 * @param type $numero
 */
if (!function_exists('formataNumero')) {
    function formataNumero($numero, $decimal = 2)
    {
        return number_format(round($numero, $decimal), $decimal, ',', '.');
    }
}

if (!function_exists('desFormataNumero')) {
    function desFormataNumero($numero, $decimal = 2)
    {
        $strlen = strlen($numero) - 3;
        // $count1 = substr_count($numero, ',');
        // $count2 = substr_count($numero, '.');
        $pos1 = strpos($numero, ',', $strlen);
        $pos2 = strpos($numero, '.', $strlen);
        if ($pos1 > $pos2) {
            $numero = str_replace('.', '', $numero);
            $a_numero = explode(',', $numero);
            $total = count($a_numero);
            $numero = '';
            foreach ($a_numero as $index => $value) {
                if (($index + 1) == $total && $decimal == strlen($value)) {
                    $numero .= '.';
                }
                $numero .= $value;
            }
        } else {
            $numero = str_replace(',', '', $numero);
            $a_numero = explode('.', $numero);
            $total = count($a_numero);
            $numero = '';
            foreach ($a_numero as $index => $value) {
                if (($index + 1) == $total && $decimal == strlen($value)) {
                    $numero .= '.';
                }
                $numero .= $value;
            }
        }
        return $numero;
    }
}
/*
 *  fem aquesta funcio per comprovar que el valor enviat es un enter
 *  per evitar utilitzar la funcio (int) en la classe
 */
if (!function_exists('esEnter')) {
    function esEnter($valor)
    {
        if (isset($valor) && $valor != '') $valor = $valor;
        else $valor = 0;
        $int_valor = (int) $valor;
        $str_valor = (string) $int_valor;
        if ($str_valor == $valor) {
            return true;
        }
        return false;
    }
}
if (!function_exists('esBoleano')) {
    function esBoleano($valor)
    {
        if ($valor != '') {
            $int_valor = (int)$valor;
            $str_valor = (string)$int_valor;
            if (is_bool($valor)) {
                return true;
            } elseif ($str_valor == $valor) {
                if ($int_valor == 0 || $int_valor == 1) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }
}
if (!function_exists('esDouble')) {
    function esDouble($valor)
    {
        if ($valor != '' || $valor == 0) {
            $valorTMP = $valor;
            $valor = round($valor, 4);
            $double_valor = (float)$valor;
            $str_valor = (string)$double_valor;
            if (($str_valor == $valor) || esEnter($valorTMP)) {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('esDateTime')) {
    function esDateTime($dateHora)
    {
        if ($dateHora && strtolower($dateHora) != 'null') {
            list($date, $hora) = array_pad(explode(' ', $dateHora), 2, '');
            if (!$hora) {
                $hora = $date;
            }
            $resultat = esDate($date);
            if ($resultat || esHora($hora) || esHora($hora, 'G:i:s') || esHora($hora, 'H:i')) {
                return true;
            }
            return false;
        }
        return true;
    }
}
if (!function_exists('esTipo')) {
    function esTipo($type, $valor)
    {
        $type = strtolower($type); //Convierte una cadena a minsculas
        if ($type == "enter") {
            return esEnter($valor);
        } elseif ($type == "boleano") {
            return esBoleano($valor);
        } elseif ($type == "double") {
            return esDouble($valor);
        } elseif ($type == "datetime" || $type == "date" || $type == "hora") {

            return esDateTime($valor);
        } elseif ($type == "string") {
            return is_string($valor);
        }
    }
}
if (!function_exists('validateDate')) {
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
if (!function_exists('esDate')) {
    function esDate($date, $noseusa = 0)
    {
        $resultat = false;
        if (strpos('#' . $date, '/')) {
            list($dia, $mes, $any) = explode('/', $date);
            $resultat = checkdate($mes, $dia, $any);
        } elseif (strpos('#' . $date, '-')) {
            list($any, $mes, $dia) = explode('-', $date);
            $resultat = checkdate($mes, $dia, $any);
        }
        return $resultat;
    }
}
if (!function_exists('esDateBorrar')) {
    function esDateBorrar($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
if (!function_exists('esHora')) {
    function esHora($hora, $format = 'H:i:s')
    {
        $d = DateTime::createFromFormat($format, $hora);
        return $d && $d->format($format) == $hora;
    }
}

/* 
 *  Per penjar fitxers 
 * @param string origen - ruta on es troba el fitxer (normalment el  /tmp/nomFitxer
 * @param string desti -  ruta on vols guardar el fitxer destí  carpeta/nomFitxer
 * @param string operacio- per si tenim diferents rutes per penjar el fitxer, per exemple GoogleDrive, FTP, Dropbox, etc. podriem diferenciar-ho per la operacio
 */
if (!function_exists('pujaFitxer')) {
    function pujaFitxer($origen, $desti, $operacio = 0, $connexio = 0)
    {
        if (!$operacio) $operacio = '';
        if (!$connexio) $connexio = '';
        $resultat = false;
        switch ($operacio) {
            case 'movefile':
                $resultat = move_uploaded_file($origen, $desti);
                break;
            case 'sftp':

                break;
            default:
                $resultat = ftp_puja($origen, $desti, $connexio);

                break;
        }
        return $resultat;
    }
}
/* 
 *  Per eliminarfitxers 
 * @param string nomFitxer -  ruta on es troba el fitxer a eliminar carpeta/nomFitxer
 * @param string operacio- per si tenim diferents rutes per penjar el fitxer, per exemple GoogleDrive, FTP, Dropbox, etc. podriem diferenciar-ho per la operacio
 */
if (!function_exists('eliminaFitxer')) {
    function eliminaFitxer($nomFitxer, $operacio = 0)
    {
        if (!$operacio) $operacio = '';
        //switch ($operacio){
        //case 'GoogleDrive': api_google; break;
        //default:
        return ftp_elimina($nomFitxer);
        //unlink($nomFitxer);
        //break;
        //}
    }
}

/*
 * Retorna un fitxer
 * @param string fitxerDesti - ruta on es troba el fitxer a retornar carpeta/nomFitxer
 * @param string titol - el títol del document que vols retornar 
 * @param string operacio - per si tenim diferents sistemes de emmagatzemar fitxers, per exempel GoogleDrive, Dropbox, etc.
 */
if (!function_exists('retornaFitxer')) {
    function retornaFitxer($fitxerDesti, $titolFitxer = 0, $operacio = 0, $disposition = 'attachment')
    {
        if ($fitxerDesti) {
            //switch ($operacio){
            //case 'GoogleDrive': api_googleDrive; break;
            //default;
            if (!$titolFitxer) {
                $titolFitxer = $fitxerDesti;
            }
            $a_extensioFoto = explode('.', $fitxerDesti);
            $extensioFoto = $a_extensioFoto[count($a_extensioFoto) - 1];
            $extensioFoto = strtolower($extensioFoto);
            switch ($extensioFoto) {
                case 'gif':
                    $type = "image/gif";
                    break;
                case 'png':
                    $type = "image/png";
                    break;
                case 'jpg':
                    $type = "image/jpeg";
                    break;
                case 'jpe':
                    $type = "image/jpeg";
                    break;
                case 'jpeg':
                    $type = "image/jpeg";
                    break;
                case 'gif':
                    $type = "image/gif";
                    break;
                case 'bmp':
                    $type = "image/bmp";
                    break;
                case 'tif':
                    $type = "image/tiff";
                    break;
                case 'tiff':
                    $type = "image/tiff";
                    break;
                case 'svg':
                    $type = "image/svg+xml";
                    break;
                case 'gz':
                    $type = "application/x-gzip";
                    break;
                case 'htm':
                    $type = "text/html";
                    break;
                case 'html':
                    $type = "text/html";
                    break;
                case 'php':
                    $type = "text/html";
                    break;
                case 'tar':
                    $type = "application/x-tar";
                    break;
                case 'txt':
                    $type = "text/plain";
                    break;
                case 'zip':
                    $type = "application/zip";
                    break;
                case 'pdf':
                    $type = "application/pdf";
                    break;
                case 'doc':
                    $type = "application/msword";
                    break;
                case 'docx':
                    $type = "officedocument.wordprocessingml.document";
                    break;
                case 'xls':
                    $type = "application/vnd.ms.excel";
                    break;
                case 'xlsx':
                    $type = "officedocument.spreadsheetml.sheet";
                    break;
                case 'odt':
                    $type = "application/vnd.oasis.opendocument.text";
                    break;
                case 'ods':
                    $type = "application/vnd.oasis.opendocument.spreadsheet";
                    break;
                case 'ai':
                    $type = "application/postscript";
                    break;
                case 'fh8':
                    $type = "application/freehand";
                    break;
                case 'txt':
                    $type = "text/plain";
                    break;
                case 'csv':
                    $type = "text/csv";
                    break;
                case 'stl':
                    $type = "model/x.stl-binary";
                    break;
                default:
                    $type = "application/octet-stream";
                    break;
            }
            if (isset($_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari'])) {
                header('Set-Cookie:fileDownload=true; path=/');
            }
            header("Last-Modified: " . gmdate("D, d M Y H:i:s T", time()));
            header("Cache-Control: cache, must-revalidate");
            header("Pragma: no-cache");
            header("Expires:0");
            header("Content-Type: $type");
            if (!$disposition) $disposition = 'attachment';
            header("Content-Disposition: $disposition; filename=$titolFitxer");

            // header("Content-Disposition: attachment; filename=$titolFitxer");
            // header("Content-Disposition: inline; filename=$titolFitxer");
            readfile($fitxerDesti);

            //break;
            //}
        }
    }
}
if (!function_exists('tipoDocumento')) {
    function tipoDocumento($extensio)
    {
        $extensio = strtolower($extensio);

        switch ($extensio) {
            case 'gif':
                $type = "image/gif";
                break;
            case 'png':
                $type = "image/png";
                break;
            case 'jpg':
                $type = "image/jpeg";
                break;
            case 'jpe':
                $type = "image/jpeg";
                break;
            case 'jpeg':
                $type = "image/jpeg";
                break;
            case 'gif':
                $type = "image/gif";
                break;
            case 'bmp':
                $type = "image/bmp";
                break;
            case 'tif':
                $type = "image/tiff";
                break;
            case 'tiff':
                $type = "image/tiff";
                break;
            case 'svg':
                $type = "image/svg+xml";
                break;
            case 'gz':
                $type = "application/x-gzip";
                break;
            case 'htm':
                $type = "text/html";
                break;
            case 'html':
                $type = "text/html";
                break;
            case 'php':
                $type = "text/html";
                break;
            case 'tar':
                $type = "application/x-tar";
                break;
            case 'txt':
                $type = "text/plain";
                break;
            case 'zip':
                $type = "application/zip";
                break;
            case 'pdf':
                $type = "application/pdf";
                break;
            case 'doc':
                $type = "application/msword";
                break;
            case 'docx':
                $type = "officedocument.wordprocessingml.document";
                break;
            case 'xls':
                $type = "application/vnd.ms.excel";
                break;
            case 'xlsx':
                $type = "officedocument.spreadsheetml.sheet";
                break;
            case 'odt':
                $type = "application/vnd.oasis.opendocument.text";
                break;
            case 'ods':
                $type = "application/vnd.oasis.opendocument.spreadsheet";
                break;
            case 'ai':
                $type = "application/postscript";
                break;
            case 'fh8':
                $type = "application/freehand";
                break;
            case 'txt':
                $type = "text/plain";
                break;
            default:
                $type = "application/octet-stream";
                break;
        }
        return $type;
    }
}


if (!function_exists('retornaTypeArxiu')) {
    function retornaTypeArxiu($nomArxiu)
    {
        $info = pathinfo($nomArxiu);
        return tipoDocumento($info['extension']);
    }
}


if (!function_exists('returnIcono')) {
    function returnIcono($extensio)
    {
        $file = "fa-file";
        $extensio = strtolower($extensio);
        switch ($extensio) {
            case 'gif':
                $file = "fa-file-image";
                break;
            case 'png':
                $file = "fa-file-image";
                break;
            case 'jpg':
                $file = "fa-file-image";
                break;
            case 'jpe':
                $file = "fa-file-image";
                break;
            case 'jpeg':
                $file = "fa-file-image";
                break;
            case 'gz':
                $file = "fa-file-archive";
                break;
            case 'htm':
                $file = "fa-file-code";
                break;
            case 'html':
                $file = "fa-file-code";
                break;
            case 'php':
                $file = "fa-file-code";
                break;
            case 'tar':
                $file = "fa-file-archive";
                break;
            case 'txt':
                $file = "fa-file";
                break;
            case 'zip':
                $file = "fa-file-archive";
                break;
            case 'pdf':
                $file = "fa-file-pdf";
                break;
            case 'doc':
                $file = "fa-file-word";
                break;
            case 'docx':
                $file = "fa-file-word";
                break;
            case 'xls':
                $file = "fa-file-excel";
                break;
            case 'xlsx':
                $file = "fa-file-excel";
                break;
            case 'odt':
                $file = "fa-file-word";
                break;
            case 'ods':
                $file = "fa-file-word";
                break;
            default:
                $file = "fa-file";
                break;
        }
        return $file;
    }
}

/* 
 *  Per penjar fitxers utilitzant el FTP
 * @param string origen - ruta on es troba el fitxer (normalment el  /tmp/nomFitxer
 * @param string desti -  ruta on vols guardar el fitxer destí  carpeta/nomFitxer
 */

if (!function_exists('ftp_conecta')) {
    function ftp_conecta($servidor = 0, $port = 0, $login = 0, $contrasenya = 0, $passivo = 0)
    {
        if (!$servidor) $servidor = CONF_FTP_SERVIDOR;
        if (!$port) $port = CONF_FTP_PORT;
        if ($ftp_id = ftp_connect($servidor, $port)) {
            if (!$login) {
                $login = CONF_FTP_USUARI;
            }
            if (!$contrasenya) {
                $contrasenya = CONF_FTP_CONTRASENYA;
            }
            if (ftp_login($ftp_id, $login, $contrasenya)) {
                if (!$passivo) {
                    if (defined(CONF_FTP_PASV) && CONF_FTP_PASV) {
                        $pasivo = CONF_FTP_PASV;
                    }
                }
                if ($passivo) {
                    ftp_pasv($ftp_id, true);
                }
                return $ftp_id;
            } else {
                echo 'ERROR LOGIN' . CONF_FTP_USUARI . '-' . CONF_FTP_CONTRASENYA . '#####';
            }
            ftp_quit($ftp_id);
        }

        return false;
    }
}


if (!function_exists('ftp_desconecta')) {
    function ftp_desconecta($ftp_id)
    {
        ftp_quit($ftp_id);
    }
}


if (!function_exists('ftp_puja')) {
    function ftp_puja($origen, $desti, $ftp_connexio = 0)
    {
        $res = false;
        if (!$ftp_connexio) $ftp_id = ftp_conecta();
        else $ftp_id = $ftp_connexio;
        if ($ftp_id) {
            if ($res = ftp_put($ftp_id, $desti, $origen, FTP_BINARY)) {
            } else {
                echo "ERROR PUT" . $origen . ' > ' . $desti;
            }

            if (!$ftp_connexio) ftp_quit($ftp_id);
        } else {
            echo 'Error connexio FTP';
        }
        return ($res);
    }
}
if (!function_exists('ftp_elimina')) {
    function ftp_elimina($arxiu, $ftp_connexio = 0)
    {
        if (!$ftp_connexio) $ftp_id = ftp_conecta();
        else $ftp_id = $ftp_connexio;
        if ($ftp_id) {
            $resultat = ftp_delete($ftp_id, $arxiu);
            if (!$ftp_connexio) {
                ftp_quit($ftp_id);
            }
            return $resultat;
        }
        return false;
    }
}
if (!function_exists('ftp_creaDirectori')) {
    function ftp_creaDirectori($directori, $ftp_connexio = 0)
    {
        $resultat = false;
        if (!$ftp_connexio) $ftp_id = ftp_conecta();
        else $ftp_id = $ftp_connexio;
        if ($ftp_id) {
            $parts = array_filter(explode('/', $directori)); // 2013/06/11/username
            foreach ($parts as $part) {
                if (!@ftp_chdir($ftp_id, $part)) {
                    $resultat = ftp_mkdir($ftp_id, $part);
                    ftp_chmod($ftp_id, 0775, $part);
                    ftp_chdir($ftp_id, $part);
                }
            }
        }
        if (!$ftp_connexio) ftp_quit($ftp_id);
        return $resultat;
    }
}
if (!function_exists('ftp_eliminaDirectori')) {
    function ftp_eliminaDirectori($directori, $ftp_connexio = 0)
    {
        $resultat = false;
        if (!$ftp_connexio) $ftp_id = ftp_conecta();
        else $ftp_id = $ftp_connexio;
        if ($ftp_id) {
            $a_arxius = ftp_nlist($ftp_id, $directori);
            if ($a_arxius) {
                foreach ($a_arxius as $arxiu) {
                    $resultat = $resultat * ftp_delete($ftp_id, $arxiu);
                }
                if ($resultat) {
                    $resultat = ftp_rmdir($ftp_id, $directori);
                }
            } else {
                $resultat = true;
            }
        }
        if (!$ftp_connexio) ftp_quit($ftp_id);
        return $resultat;
    }
}
//Funció per enviar emails
if (!function_exists('enviaMail')) {
    function enviaMail($mail_a, $mail_copia, $mail_assumpte, $mail_cos, $fitxerAdjunt = '', $fitxerAdjuntBorarr = 0, $nomFitxer = '', $flagFacturacio = '', $flagRebreCopia = 0, $idEmpresa = 0)
    {
        global $db;
        // mail copia si envia cuando ponemos flagRebreCopia 0 no se envia  1 copia normal 2 copia oculta
        $enviat = false;
        if (CONF_TEST == 1) {
            $mail_a = CONF_INFODESENVOLUPAMENT;
            $mail_assumpte = '[DEV]' . $mail_assumpte;
        } elseif (CONF_TEST == 2) {
            $mail_assumpte = '[TEST]' . $mail_assumpte;
        }
        date_default_timezone_set('Europe/Madrid');
        $mail             = new PHPMailer(true);
        $mail->IsSMTP(); // telling the class to use SMTP
        // $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        $Host       = ''; // sets the SMTP server
        $Port       = '';                    // set the SMTP port for the GMAIL server
        $Username   = ''; // SMTP account username
        $Password   = '';        // SMTP account password
        $mail_de = '';
        $mail_de_nameUser = '';
        if ($flagFacturacio) {
            if (defined('CONF_SMTP_SERVIDOR_FACTURACIO')) $Host       = CONF_SMTP_SERVIDOR_FACTURACIO; // sets the SMTP server
            if (defined('CONF_SMTP_PORT_FACTURACIO')) $Port       = CONF_SMTP_PORT_FACTURACIO;                    // set the SMTP port for the GMAIL server
            if (defined('CONF_SMTP_USUARI_FACTURACIO')) $Username   = CONF_SMTP_USUARI_FACTURACIO; // SMTP account username
            if (defined('CONF_SMTP_CONTRASENYA_FACTURACIO')) $Password   = CONF_SMTP_CONTRASENYA_FACTURACIO;        // SMTP account password
            if (defined('CONF_SMTP_EMAIL_FACTURACIO')) $mail_de = CONF_SMTP_EMAIL_FACTURACIO;
            if (defined('CONF_SMTP_NOMUSUARI_FACTURACIO')) $mail_de_nameUser = CONF_SMTP_NOMUSUARI_FACTURACIO;
        }
        if (defined('CONF_SMTP_SERVIDOR') && !$Host) $Host       = CONF_SMTP_SERVIDOR; // sets the SMTP server
        if (defined('CONF_SMTP_PORT') && !$Port) $Port       = CONF_SMTP_PORT;                    // set the SMTP port for the GMAIL server
        if (defined('CONF_SMTP_USUARI') && !$Username) $Username   = CONF_SMTP_USUARI; // SMTP account username
        if (defined('CONF_SMTP_CONTRASENYA') && !$Password) $Password   = CONF_SMTP_CONTRASENYA;        // SMTP account password
        if (defined('CONF_SMTP_EMAIL') && !$mail_de) $mail_de = CONF_SMTP_EMAIL;
        if (defined('CONF_SMTP_NOMUSUARI') && !$mail_de_nameUser) $mail_de_nameUser = CONF_SMTP_NOMUSUARI;

        if ($idEmpresa) {
            $confParametres = new ConfParametres($db);
            $confParametres->set('filtroEmpresa', 0);
            if ($a_confParametres = $confParametres->llista('idEmpresa=' . $idEmpresa)) {
                foreach ($a_confParametres as $confParametresTMP) {
                    $campoConf = $confParametresTMP['etiquetaConfParametre'];
                    $valorConf = $confParametresTMP['valorConfParametre'];
                    if ($flagFacturacio) {
                        switch ($campoConf) {
                            case 'CONF_SMTP_SERVIDOR_FACTURACIO':
                                $Host = $valorConf;
                                break;
                            case 'CONF_SMTP_PORT_FACTURACIO':
                                $Port = $valorConf;
                                break;
                            case 'CONF_SMTP_USUARI_FACTURACIO':
                                $Username = $valorConf;
                                break;
                            case 'CONF_SMTP_CONTRASENYA_FACTURACIO':
                                $Password  = $valorConf;
                                break;
                            case 'CONF_SMTP_EMAIL_FACTURACIO':
                                $mail_de = $valorConf;
                                break;
                            case 'CONF_SMTP_NOMUSUARI_FACTURACIO':
                                $mail_de_nameUser = $valorConf;
                                break;
                        }
                    } else {
                        switch ($campoConf) {
                            case 'CONF_SMTP_SERVIDOR':
                                $Host = $valorConf;
                                break;
                            case 'CONF_SMTP_PORT':
                                $Port = $valorConf;
                                break;
                            case 'CONF_SMTP_USUARI':
                                $Username = $valorConf;
                                break;
                            case 'CONF_SMTP_CONTRASENYA':
                                $Password  = $valorConf;
                                break;
                            case 'CONF_SMTP_EMAIL':
                                $mail_de = $valorConf;
                                break;
                            case 'CONF_SMTP_NOMUSUARI':
                                $mail_de_nameUser = $valorConf;
                                break;
                        }
                    }
                }
            }
        }
        if (CONF_SMTP_SECURE) {
            $mail->SMTPSecure = CONF_SMTP_SECURE;
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
        } else {
            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;
        }
        $mail->Host       = $Host; // sets the SMTP server
        $mail->Port       = $Port;                    // set the SMTP port for the GMAIL server
        $mail->Username   = $Username; // SMTP account username
        $mail->Password   = $Password;        // SMTP account password
        $mail->CharSet = 'UTF-8';
        $mail->Subject    = $mail_assumpte;
        if (!$mail_de && defined('CONF_SMTP_EMAIL')) {
            $mail_de = CONF_SMTP_EMAIL;
        } elseif (!$mail_de && defined('CONF_SMTP_INFORMACIO')) {
            $mail_de = CONF_SMTP_INFORMACIO;
        }
        if (!$mail_de_nameUser) $mail_de_nameUser = $mail_de;
        if ($mail_de) {
            $mail->SetFrom($mail_de, ($mail_de_nameUser));
        }
        $mail->AltBody    = ("Para ver el mensaje, por favor, utilice un visor de correo electrónico HTML compatible!");; // optional, comment out and test
        $mail->MsgHTML($mail_cos);
        if ($nomFitxer && $fitxerAdjunt) {
            $mail->addStringAttachment($fitxerAdjunt, $nomFitxer);
        } else {
            if (($fitxerAdjunt) && (file_exists($fitxerAdjunt))) {
                $mail->AddAttachment($fitxerAdjunt);
            }
        }


        $mail->ClearAddresses();

        $a_mails = explode(',', $mail_a);
        foreach ($a_mails as $mail_tmp) {
            if ($mail_tmp) {
                $mail->AddAddress($mail_tmp, $mail_tmp);
            }
        }
        if ($flagRebreCopia) {
            if (!$mail_copia) {
                $mail_copia = $mail_de;
            }
            $a_mails = explode(',', $mail_copia);
            foreach ($a_mails as $mail_tmp) {
                if ($mail_tmp) {
                    if ($flagRebreCopia == 2) {
                        $mail->addBCC($mail_tmp, $mail_tmp);
                    } else {
                        $mail->addCC($mail_tmp, $mail_tmp);
                    }
                }
            }
        }
        if ($mail->Send()) {
            $enviat = true;
        }
        $mail->ClearAllRecipients();
        if (($fitxerAdjuntBorarr) && (file_exists($fitxerAdjunt))) {
            unlink($fitxerAdjunt);
        }
        return $enviat;
    }
}


if (!function_exists('testParametres')) {
    function testParametres()
    {
        //Comprova SMTP
        $restultatTest = false;
        try {
            date_default_timezone_set('Europe/Madrid');
            $mail             = new PHPMailer(true);
            $mail->IsSMTP(); // telling the class to use SMTP
            //  $mail->SMTPDebug = SMTP::DEBUG_SERVER;    // 1 = errors and messages
            // 2 = messages only
            if (CONF_SMTP_SECURE) {
                $mail->SMTPSecure = CONF_SMTP_SECURE;
                $mail->SMTPAuth   = true;                  // enable SMTP authentication
            } else {
                $mail->SMTPSecure = false;
                $mail->SMTPAutoTLS = false;
            }
            $mail->Host       = CONF_SMTP_SERVIDOR; // sets the SMTP server
            $mail->Port       = CONF_SMTP_PORT;                    // set the SMTP port for the GMAIL server
            $mail->Username   = CONF_SMTP_USUARI; // SMTP account username
            $mail->Password   = CONF_SMTP_CONTRASENYA;        // SMTP account password
            $mail->CharSet = 'UTF-8';

            $smtp = new SMTP;
            //$smtp->do_debug = SMTP::DEBUG_CONNECTION;
            if (!$smtp->connect($mail->Host, $mail->Port)) {
                throw new Exception('Error connect: falla Host o Port ');
            }
            //Say hello
            if (!$smtp->hello(gethostname())) {
                throw new Exception('EHLO failed: ' . $smtp->getError());
            }
            //Get the list of ESMTP services the server offers
            $e = $smtp->getServerExtList();
            //If server can do TLS encryption, use it
            // if (is_array($e) && array_key_exists('STARTTLS', $e)) {
            //     $tlsok = $smtp->startTLS();
            //     if (!$tlsok) {
            //         throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
            //     }
            //     //Repeat EHLO after STARTTLS
            //     if (!$smtp->hello(gethostname())) {
            //         throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
            //     }
            //     //Get new capabilities list, which will usually now include AUTH if it didn't before
            //     $e = $smtp->getServerExtList();
            // }
            //If server supports authentication, do it (even if no encryption)
            if (is_array($e) && array_key_exists('AUTH', $e)) {
                if ($smtp->authenticate(CONF_SMTP_USUARI, CONF_SMTP_CONTRASENYA)) {
                } else {
                    throw new Exception('Authentication failed: ' . $smtp->getError());
                }
            }


            if ($mail->smtpConnect()) {
                $restultatTest = true;
                $_SESSION['SESSIO_' . CONF_DB_BBDD . 'msgParmetresError'] = '';
                $mail->smtpClose();
            } else {
            }
        } catch (Exception $e) {
            $_SESSION['SESSIO_' . CONF_DB_BBDD . 'msgParmetresError'] = 'Error SMTP - Comprova les dades de enviament de mail <br>' . $e->getMessage();
        }
        //ALTRES FUNCIONS DE TEST

        return $restultatTest;
    }
}
//////////////////////////////////
//// AUTENTICACIÓ
//////////////////////////////////
/**
 * comprova que es pugui executar el codi que hi hagi després de la seva crida
 * Si no hi ha permis per continuar t'ha de fer fora de la pàgina. 
 * 
 * @param 
 * @return 
 */
if (!function_exists('comprovaSeguretat')) {
    function comprovaSeguretat($aliasOperacioComprovaSegretat = 0, $token_apiKey = '')
    {
        global $db;
        // $derectorioActual = str_replace('SistemaBase', '', __DIR__);
        if (!(trim($token_apiKey))) $token_apiKey = '';
        if (($token_apiKey != '' && $token_apiKey) || (isset($_REQUEST['formulariAutenticacio']) && ($_REQUEST['formulariAutenticacio'] == 1))) {
            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_display_errors'] = 0;
            if (isset($_REQUEST['codiValidacio']) && isset($_REQUEST['idUsuari']) && ($token_apiKey == '' || !$token_apiKey)) {
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idClient'] = 0;
                $usuariSessio = new Usuari($db, $_REQUEST['idUsuari']);
                $usuariSessio->set('codiValidacio', $_REQUEST['codiValidacio']);
                if ($usuariSessio->validateCode()) {
                    $_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat'] = 'autenticat';
                    $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari'] = $usuariSessio->get('idUsuari');
                    $_SESSION['SESSIO_' . CONF_DB_BBDD . '_loginUsuari'] = $usuariSessio->get('loginUsuari');
                    $_SESSION['SESSIO_' . CONF_DB_BBDD . '_emailUsuari'] = $usuariSessio->get('emailUsuari');
                    $_SESSION['SESSIO_' . CONF_DB_BBDD . '_nomUsuari'] = $usuariSessio->get('nomUsuari');
                    $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idPerfil'] = $usuariSessio->get('idPerfil');
                    $usuariSessioTMP = new Usuari($db);
                    $data_actual = date('Y-m-d H:i:s');
                    $usuariSessioTMP->set('idUsuari', $usuariSessio->get('idUsuari'));
                    $usuariSessioTMP->set('dataAcces', $data_actual);
                    $usuariSessioTMP->desa();
                } else {
                    $errorAutenticacio = 5; // codigo no es valido
                    $jsonResultat = array('estatOperacio' => false, 'msgError' => $errorAutenticacio);
                    if ($jsonResultat) echo json_encode($jsonResultat);

                    exit();
                }
            } elseif ((isset($_REQUEST['loginUsuari']) && isset($_REQUEST['contrasenyaUsuari']) && $_REQUEST['loginUsuari'] && $_REQUEST['contrasenyaUsuari']) || ($token_apiKey != '' && $token_apiKey)) {
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idClient'] = 0;
                $usuariSessio = new Usuari($db);
                if (($token_apiKey != '')) $usuariSessio->set('apiKey', $token_apiKey);
                else {
                    $usuariSessio->set('loginUsuari', $_REQUEST['loginUsuari']);
                    $usuariSessio->set('contrasenyaUsuari', $_REQUEST['contrasenyaUsuari']);
                }

                $permis_per_accedir = $usuariSessio->validaAcces_i_carrega();
                if ($permis_per_accedir == 1 || ($token_apiKey && $usuariSessio->get('idUsuari') && ($permis_per_accedir == 1 || $permis_per_accedir < 0))) {
                    // si es token NO MERA IP DE ACSESO DE HORARIO
                    $usuariSessio->carregaDades();
                    $numEmpresa = 0;
                    $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] = 0;
                    if (class_exists('Empreses')) {
                        $empresa = new Empreses($db);
                        $filreEmpresa = " relEmpresesUsuaris.idUsuari in (" . $usuariSessio->get('idUsuari') . ")";
                        $numEmpresa = $empresa->numEmpreses();
                        $a_llistaEmpresa = $empresa->llistaInnerRelEmpresesUsuaris($filreEmpresa, 'relEmpresesUsuaris.ordreRelEmpresaUsuari asc,idEmpresa asc');
                        $idEmpresaFlagActiuEmpresa = 0;
                        $idEmpresa = 0;
                        foreach ($a_llistaEmpresa as $llistaEmpresaTMP) {
                            if ($llistaEmpresaTMP['flagActiuEmpresa']) {
                                if (!$idEmpresaFlagActiuEmpresa) {
                                    $idEmpresaFlagActiuEmpresa = $llistaEmpresaTMP['idEmpresa'];
                                    $idEmpresa = $llistaEmpresaTMP['idEmpresa'];
                                }
                            } elseif (!$idEmpresa) $idEmpresa = $llistaEmpresaTMP['idEmpresa'];
                        }
                        if ($idEmpresa) {
                            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] = $idEmpresa;
                        } elseif ($numEmpresa == 1) {
                            $empresa->getIds('flagActiuEmpresa=1', 'idEmpresa asc');
                            if (!$empresa->extreu()) {
                                $empresa->getIds('', 'idEmpresa asc');
                                $empresa->extreu();
                            }
                            $empresa->set('idUsuari', $usuariSessio->get('idUsuari'));
                            if ($empresa->desaRelEmpresesUsuaris()) {
                                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] = $empresa->get('idEmpresa');
                            }
                        }
                    }
                    if ($usuariSessio->get('clauDosFactorsUsuari') && ($token_apiKey == '' || !$token_apiKey)) {
                        $codiValidacio = $_REQUEST['codiValidacio'];
                        $idUsuari = $usuariSessio->get('idUsuari');
                        require('_formulariAutenticacio.php');
                        exit();
                    } else {
                        $_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat'] = 'autenticat';
                        $usuariSessioTMP = new Usuari($db);
                        $data_actual = date('Y-m-d H:i:s');
                        $usuariSessioTMP->set('idUsuari', $usuariSessio->get('idUsuari'));
                        $usuariSessioTMP->set('dataAcces', $data_actual);
                        $usuariSessioTMP->desa();
                    }
                    if ($_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] || !$numEmpresa) {
                        $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari'] = $usuariSessio->get('idUsuari');
                        $_SESSION['SESSIO_' . CONF_DB_BBDD . '_loginUsuari'] = $usuariSessio->get('loginUsuari');
                        $_SESSION['SESSIO_' . CONF_DB_BBDD . '_emailUsuari'] = $usuariSessio->get('emailUsuari');
                        $_SESSION['SESSIO_' . CONF_DB_BBDD . '_nomUsuari'] = $usuariSessio->get('nomUsuari');
                        $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idPerfil'] = $usuariSessio->get('idPerfil');


                        // $idiomaSistemaBase=new Idiomes($db);
                        // $a_idiomasTMP=$idiomaSistemaBase->llista("WHERE flagPerDefecte=1");
                        // $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idIdioma']=$a_idiomasTMP[0]['idIdioma'];

                        // errorParametresSistema();
                        //header('Location:' . $_SERVER['HTTP_REFERER']);

                    } else {
                        $errorAutenticacio = 4; // sin empresa

                        $jsonResultat = array('estatOperacio' => false, 'msgError' => $errorAutenticacio);
                        if ($jsonResultat) echo json_encode($jsonResultat);

                        exit();
                    }
                } else {
                    $errorAutenticacio = $permis_per_accedir; //usuari, horari, ip
                    $jsonResultat = array('estatOperacio' => false, 'msgError' => $errorAutenticacio);
                    if ($jsonResultat) echo json_encode($jsonResultat);

                    exit();
                }
            } else {
                if (isset($_COOKIE["token_autenticat"])) {
                    unset($_COOKIE["token_autenticat"]);
                    setcookie("token_autenticat", null, -1);
                }
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat'] = '';
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari'] = '';
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_loginUsuari'] = '';
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_nomUsuari'] = '';
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idPerfil'] = 0;
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_emailUsuari'] = '';
                $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] = 0;

                // $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idIdioma']=0;

                $errorAutenticacio = 0; //usuari i contrasenya no vàlids/inexistents
                $jsonResultat = array('estatOperacio' => false, 'msgError' => $errorAutenticacio);
                if ($jsonResultat) echo json_encode($jsonResultat);

                exit();
            }
            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idioma'] = CONF_APP_IDIOMA;
        } elseif ((isset($_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat']) && $_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat'] != 'autenticat') || (!isset($_SESSION['SESSIO_' . CONF_DB_BBDD . '_autenticat']))) { //NO ESTEM autenticats
            //require('_formulariAutenticacio.php');
            if (isset($_COOKIE["token_autenticat"])) {
                unset($_COOKIE["token_autenticat"]);
                setcookie("token_autenticat", null, -1);
            }
            $jsonResultat = array('estatOperacio' => false, 'msgError' => 0);
            if ($jsonResultat) echo json_encode($jsonResultat);

            //header('Location:../_formulariAutenticacio.php');
            exit();
        } else { //ESTEM autenticats, continuem...
            //echo 'entro alias'.$aliasOperacioComprovaSegretat;
            if (!isset($capa)) $capa = '';
            if (!$capa) $capa = 'finestra1';
            if ($aliasOperacioComprovaSegretat) {
                $usuariSessio = new Usuari($db, $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari']);
                switch ($aliasOperacioComprovaSegretat) {
                    case 'gestioUsuaris':
                        if ($usuariSessio->permisOperacio('gestioUsuaris') < 1) {
                            if ($_REQUEST['idUsuari'] == $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari']) {
                            } else {
                                $jsonResultat = array('estatOperacio' => false, 'msgError' => T_PERMIS_DENEGAT);
                                if ($jsonResultat) echo json_encode($jsonResultat);
                                include '_tancar_pagina.php';
                                exit();
                            }
                        }
                        break;
                    default:
                        if ($usuariSessio->permisOperacio($aliasOperacioComprovaSegretat) < 1) {
                            $jsonResultat = array('estatOperacio' => false, 'msgError' => T_PERMIS_DENEGAT);
                            if ($jsonResultat) echo json_encode($jsonResultat);
                            include '_tancar_pagina.php';
                            exit();
                        }
                        break;
                }
            }
        }
    }
}
if (!function_exists('dobleComprovaSeguretat')) {
    function dobleComprovaSeguretat($action = '')
    {
        global $db, $usuarisOperacions;
        $usuariSessio = new Usuari($db, $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari']);
        $date_authorize = date($_SESSION['SESSIO_' . CONF_DB_BBDD . '_time_doble_validation']);
        if ($date_authorize < time() || !$usuariSessio->get('idUsuari')) {
            $text = '<p><b>Hola ' . $usuariSessio->get('nomUsuari') . ' ' . $usuariSessio->get('cognomUsuari') . '</b></p><p class="text-center">' . T_INTRUDUEIX_LES_TEVES_DADES . '</p>' . ucfirst(T_CONTRASENYA) . ':';
?>
            <script>
                dobleComprovaSeguretat();

                function dobleComprovaSeguretat() {
                    Swal.fire({
                        icon: 'question',
                        html: '<?= $text ?>',
                        input: 'password',
                        inputValue: '',
                        confirmButtonColor: "#50C050",
                        confirmButtonText: "<?= ucfirst(T_INICIAR_SESSION) ?>",
                        cancelButtonText: "<?= ucfirst(T_CANCELAR) ?>",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        reverseButtons: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        preConfirm: (id) => {
                            dataTMP = id;
                            if (dataTMP.trim().length < 2) {
                                Swal.showValidationMessage("<?= T_ERROR_FALTEN_CAMPS ?>");
                            }
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var contrasenyaUsuariTMP = (result.value);
                            executa('<?= $usuarisOperacions ?>', {
                                operacio: 'validarAutenticacio',
                                contrasenyaUsuari: contrasenyaUsuariTMP
                            }, (res) => {
                                if (res.autenticacio == 1) {
                                    swal.close();
                                    refrescaCapa('<?= $_REQUEST['capa'] ?>');
                                } else {
                                    dobleComprovaSeguretat();
                                    Swal.showValidationMessage(res.msgError);
                                }
                            });
                        } else {

                        }
                    });
                }
            </script>
        <?php
            exit();
        } else {
            $_SESSION['SESSIO_' . CONF_DB_BBDD . '_time_doble_validation'] =  strtotime('+ 5 minutes');
        }
    }
}
if (!function_exists('errorParametresSistema')) {
    function errorParametresSistema()
    {
        global $db;
        $resultat = false;
        if (isset($_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari']) && $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari']) {
            $usuariSessio = new Usuari($db, $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari']);
            if ($usuariSessio->permisOperacio('gestioConfParametres') == 1) {
                if (!testParametres()) $resultat = true;
            }
        }
        return $resultat;
    }
}
/**
 * per fer el logout. elimina dades de la sessió i t'envia al formulari de login.
 * 
 * @param 
 * @return 
 */
if (!function_exists('tancaSessio')) {
    function tancaSessio()
    {
        $formulariAutenticacioTMP = $_SESSION['SESSIO_' . CONF_DB_BBDD . '_NOM_ARXIU_FORMULARI_AUTENTICACIO'];
        session_destroy(); //eliminem la sessió
        ?>
        <script>
            window.location = '<?= $formulariAutenticacioTMP ?>';
        </script>
<?php
        // header("location:index2.php"); //redirigim al formulari de login
    }
}
/**
 * és per a canviar un numero a format data mes
 *
 * @param
 * @return
 */
if (!function_exists('formatDataMes')) {
    function formatDataMes($numero)
    {
        if (esEnter($numero)) {
            if ($numero > 0 && $numero <= 12) {
                $fecha = DateTime::createFromFormat('!m', $numero);
                return $fecha->format('m'); // 01
            }
        }
        return false;
    }
}
/**
 * és per a canviar un numero a format data dia
 *
 * @param
 * @return
 */
if (!function_exists('formatDataDia')) {
    function formatDataDia($numero)
    {
        if (esEnter($numero)) {
            if ($numero > 0 && $numero <= 31) {
                $fecha = DateTime::createFromFormat('!d', $numero);
                return $fecha->format('d'); // 01
            }
        }
        return false;
    }
}

if (!function_exists('quitar_acentos')) {
    function quitar_acentos($cadena)
    {
        $originales  = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýýþÿ«ªº·';
        $modificadas = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYBSaaaaaaaceeeeiiiidnoooooouuuuyyby_...';
        // $cadena = utf8_decode($cadena);
        $cadena = mb_convert_encoding($cadena, 'UTF-8', mb_list_encodings());
        // $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtr($cadena, mb_convert_encoding($originales, 'UTF-8', mb_list_encodings()), $modificadas);
        // return utf8_encode($cadena);
        return mb_convert_encoding($cadena, 'UTF-8', mb_list_encodings());
    }
}
if (!function_exists('dataIniciSetmana')) {
    function dataIniciSetmana($fecha, $mostrarCapsDeSetmana = false)
    {
        $numeroTMP = 0;
        do {
            $fecha = date("Y-m-d", strtotime($fecha . "- $numeroTMP  days"));
            $numero = date('w', strtotime($fecha));
            $numeroTMP = 1;
        } while ($numero != 1);
        return $fecha;
        // if ($mostrarCapsDeSetmana) {
        //     if ($numero) {
        //         $numero = $numero - 1;
        //         return date("Y-m-d", strtotime($fecha . "- $numero  days"));
        //     } else {
        //         $numeroFin = 6;
        //         return date("Y-m-d", strtotime($fecha . "- $numeroFin  days"));
        //     }
        // } else {
        //     if ($numero) {
        //         $numero = $numero - 1;
        //         return date("Y-m-d", strtotime($fecha . "- $numero  days"));
        //     } else {
        //         $numeroFin = 5;
        //         return date("Y-m-d", strtotime($fecha . "- $numeroFin  days"));
        //     }
        // }
    }
}
if (!function_exists('dataFiSetmana')) {
    function dataFiSetmana($fecha, $mostrarCapsDeSetmana = false)
    {
        $numeroTMP = 0;
        $fecha = dataIniciSetmana($fecha); //buscar el inicioo de la semana
        $fecha = date("Y-m-d", strtotime($fecha . "+4 days")); //
        $salir = 0;
        do {
            $fecha = date("Y-m-d", strtotime($fecha . "+ $numeroTMP  days"));
            $numero = date('w', strtotime($fecha));
            $numeroTMP = 1;
            if ($mostrarCapsDeSetmana) {
                if ($numero == 0) {
                    $salir = 1;
                }
            } else {
                if ($numero == 5) {
                    $salir = 1;
                }
            }
        } while (!$salir);
        return $fecha;
        // if ($mostrarCapsDeSetmana) {
        //     if ($numero) {
        //         $numeroFin = 7 - $numero;
        //         return date("Y-m-d", strtotime($fecha . "+ $numeroFin days"));
        //     } else {
        //         return date("Y-m-d", strtotime($fecha . "+ $numero days"));
        //     }
        // } else {
        //     if ($numero) {
        //         $numeroFin = 5 - $numero;
        //         return date("Y-m-d", strtotime($fecha . "+ $numeroFin days"));
        //     } else {
        //         return date("Y-m-d", strtotime($fecha . "+ $numero days"));
        //     }
        // }
    }
}
if (!function_exists('formataTextTemps')) {
    function formataTextTemps($duradaEnMinuts)
    {
        $signe = '';
        if ($duradaEnMinuts < 0) {
            $signe = '-';
            $duradaEnMinuts = (-1) * $duradaEnMinuts;
        }
        if ($duradaEnMinuts >= 60) {
            $durada = round((($duradaEnMinuts) * 1 / 60));
            $factorMinuts = 60;
            if (($duradaEnMinuts - (60 * $durada)) < 0) {
                $textDurada = ($durada - 1) . ' h';
                $textDurada .= ' ' . round(60 + ($duradaEnMinuts - (60 * $durada))) . ' min';
            } else {
                $textDurada = $durada . ' h';
                if ($duradaEnMinuts - (60 * $durada)) $textDurada .= ' ' . round($duradaEnMinuts - (60 * $durada)) . ' min';
            }
        } else {
            $textDurada = round($duradaEnMinuts) . ' min';
        }


        return htmlentities($signe . $textDurada);
    }
}
if (!function_exists('formataCSVExcel')) {
    function formataCSVExcel($valor)
    {
        $valor = str_replace('"', '\'', $valor);
        return utf8_decode(str_replace(';', ',', $valor));
    }
}
if (!function_exists('formataCadena')) {
    function formataCadena($cadena)
    {
        $cadena = trim($cadena);
        $cadena = str_replace("'", "\'", $cadena);
        $cadena = ($cadena);
        return $cadena;
    }
}


if (!function_exists('textosMesos')) {
    function textosMesos($mes)
    {
        $arrayGlobalTextosMesos = array("", "Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre");
        $mes = $mes * 1;
        return $arrayGlobalTextosMesos[$mes];
    }
}
if (!function_exists('textosMesosAbrev')) {
    function textosMesosAbrev($mes)
    {
        $arrayGlobalTextosMesosAbrev = array("", "Gen", "Feb", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Des");
        $mes = $mes * 1;
        return $arrayGlobalTextosMesosAbrev[$mes];
    }
}
//retorna el MAX size de un fitxer que podem pujar
if (!function_exists('file_upload_max_size')) {
    function file_upload_max_size()
    {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $post_max_size = parse_size(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size;
    }
}
//Per treure espais i coses rares
if (!function_exists('parse_size')) {
    function parse_size($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }
}
if (!function_exists('formata_size')) {
    function formata_size($valor)
    {
        $mida = 'bytes';
        if ($valor > 1024 * 1024 * 1024) {
            $valor = $valor / (1024 * 1024);
            $mida = 'GB';
        } elseif ($valor > 1024 * 1024) {
            $valor = $valor / (1024 * 1024);
            $mida = 'MB';
        } elseif ($valor > 1024) {
            $valor = $valor / 1024;
            $mida = 'KB';
        }
        return $valor . ' ' . $mida;
    }
}
if (!function_exists('generarTokenCodigo')) {
    function generarTokenCodigo()
    {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIIJKLMNOPQRSTUVWXYZ';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < 20; $i++) {
            $key .= $pattern[mt_rand(0, $max)];
        }
        return $key;
    }
}
if (!function_exists('getIpPublica')) {
    /**
     * 
     */
    function getIpPublica()
    {
        // if (isset($_SERVER["HTTP_CLIENT_IP"])) {
        //     return $_SERVER["HTTP_CLIENT_IP"];
        // } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        //     return $_SERVER["HTTP_X_FORWARDED_FOR"];
        // } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
        //     return $_SERVER["HTTP_X_FORWARDED"];
        // } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
        //     return $_SERVER["HTTP_FORWARDED_FOR"];
        // } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
        //     return $_SERVER["HTTP_FORWARDED"];
        // } else {
        return $_SERVER["REMOTE_ADDR"];
        // }
    }
}
if (!function_exists('getIpPrivada')) {
    // Intentamos primero saber si se ha utilizado un proxy para acceder a la página,
    // y si éste ha indicado en alguna cabecera la IP real del usuario.
    function getIpPrivada()
    {

        // if (getenv('HTTP_CLIENT_IP')) {
        //     return  getenv('HTTP_CLIENT_IP');
        //   } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        //     return  getenv('HTTP_X_FORWARDED_FOR');
        //   } elseif (getenv('HTTP_X_FORWARDED')) {
        //     return  getenv('HTTP_X_FORWARDED');
        //   } elseif (getenv('HTTP_FORWARDED_FOR')) {
        //     return  getenv('HTTP_FORWARDED_FOR');
        //   } elseif (getenv('HTTP_FORWARDED')) {
        //     return  getenv('HTTP_FORWARDED');
        //   } else {
        // Método por defecto de obtener la IP del usuario
        // Si se utiliza un proxy, esto nos daría la IP del proxy
        // y no la IP real del usuario.
        return  $_SERVER["SERVER_ADDR"];
        //   }
    }
}
if (!function_exists('desFormataTextUrl')) {
    function desFormataTextUrl($textModificar = null)
    {
        if ($textModificar) {
            // $textModificar = str_replace("&euro;", "€",$textModificar);
            $textModificar = str_replace("|int|", "?", $textModificar);
            $textModificar = str_replace("|and|", "&", $textModificar);
            $textModificar = str_replace("|plus|", "+", $textModificar);
            $textModificar = str_replace("|perc|", "%", $textModificar);
            $textModificar = str_replace("|c|", "'", $textModificar);
            $textModificar = str_replace("|cc|", "\"", $textModificar);

            // $textModificar = str_replace('"', '\"',$textModificar);
        }

        return $textModificar;
    }
}
if (!function_exists('formataTextUrl')) {
    function formataTextUrl($textModificar)
    {
        if ($textModificar) {
            $textModificar = str_replace('"', '&#34;', $textModificar);
            $textModificar = str_replace("?", "|int|", $textModificar);
            $textModificar = str_replace("&", "|and|", $textModificar);
            $textModificar = str_replace("+", "|plus|", $textModificar);
            $textModificar = str_replace("%", "|perc|", $textModificar);
        }

        return htmlentities($textModificar);
    }
}
if (!function_exists('validateDni')) {
    function validateDni($dni)
    {
        $letra = substr($dni, -1);
        $numeros = substr($dni, 0, -1);
        if (esEnter($numeros)) {
            if (substr("TRWAGMYFPDXBNJZSQVHLCKE", ($numeros * 1) % 23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8) {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('validateNie')) {
    function validateNie($nif)
    {
        if (preg_match('/^[XYZT][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z0-9]/', $nif)) {
            for ($i = 0; $i < 9; $i++) {
                $num[$i] = substr($nif, $i, 1);
            }
            if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X', 'Y', 'Z'), array('0', '1', '2'), $nif), 0, 8) % 23, 1)) {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('validateCif')) {
    function validateCif($cif)
    {
        $cif_codes = 'JABCDEFGHI';

        $sum = (string) getCifSum($cif);
        $n = (10 - substr($sum, -1)) % 10;

        if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif)) {
            if (in_array($cif[0], array('A', 'B', 'E', 'H'))) {
                // Numerico
                return ($cif[8] == $n);
            } elseif (in_array($cif[0], array('K', 'P', 'Q', 'S'))) {
                // Letras
                return ($cif[8] == $cif_codes[$n]);
            } else {
                // Alfanumérico
                if (is_numeric($cif[8])) {
                    return ($cif[8] == $n);
                } else {
                    return ($cif[8] == $cif_codes[$n]);
                }
            }
        }

        return false;
    }
}
if (!function_exists('getCifSum')) {

    function getCifSum($cif)
    {
        $sum = $cif[2] + $cif[4] + $cif[6];

        for ($i = 1; $i < 8; $i += 2) {
            $tmp = (string) (2 * $cif[$i]);

            $tmp = $tmp[0] + ((strlen($tmp) == 2) ?  $tmp[1] : 0);

            $sum += $tmp;
        }

        return $sum;
    }
}
if (!function_exists('fornmatarTextoJSON')) {
    function fornmatarTextoJSON($text)
    {
        if ($text) {
            $text = trim($text);
            //$text = str_replace(array("\n", "\r\n", "\r"), "<br/>", $text);

            $text = (str_replace(array("\n", "\r", "\t", "\v", "\0"), "<br>", $text));
            $text =  preg_replace('/(\v|\s)+/', ' ', $text); // quetar doble espacio y caracteres raros

            $text = trim($text);
            $text = addslashes($text);
            return $text;
        }
    }
}
if (!function_exists('returnSumaDiesLaborables')) {
    function returnSumaDiesLaborables($fecha, $numDies)
    {
        if (esDate($fecha) && esEnter($numDies)) {
            $fecha = date('Y-m-d', strtotime($fecha));
            $numero = date('w', strtotime($fecha));
            if (($numero == 6 || $numero == 0) && !$numDies) $numDies = 1;
            while ($numDies > 0) {
                $fecha = date('Y-m-d', strtotime($fecha));
                $fecha = date('Y-m-d', strtotime($fecha . '+ 1 days'));
                $numero = date('w', strtotime($fecha));
                if ($numero != 6 && $numero != 0) $numDies--;
            }
            return $fecha;
        }
        return false;
    }
}
if (!function_exists('returnColumnLetterExcel')) {
    function returnColumnLetterExcel($c)
    {
        $c = intval($c);
        if ($c <= 0) {
            return '';
        }
        $letter = '';

        while ($c != 0) {
            $p = ($c - 1) % 26;
            $c = intval(($c - $p) / 26);
            $letter = chr(65 + $p) . $letter;
        }

        return $letter;
    }
}
if (!function_exists('textFecha')) {
    function textFecha($dataInici, $dataFinal, $idiomaMin, $tipusFormat = 0)
    {
        $idiomaMin = strtoupper($idiomaMin);

        if ($dataInici == '0000-00-00 00:00:00') {
            $dataInici = '';
        }
        if ($dataFinal == '0000-00-00 00:00:00') {
            $dataFinal = '';
        }
        $textFecha = '';
        if ($dataFinal || $dataInici) {
            $mesInici = 0;
            $mesFinal = 0;
            $diaInici = 0;
            $diaFinal = 0;
            $anyInici = 0;
            $anyFinal = 0;
            if (!$dataInici && $dataFinal) {
                $dataInici = $dataFinal;
            }
            if ($dataInici && !$dataFinal) {
                $dataFinal = $dataInici;
            }
            $horaInici = date('H:i', strtotime($dataInici));
            $horaFinal = date('H:i', strtotime($dataFinal));
            $dataFinal = date('Y-m-d', strtotime($dataFinal));
            $dataInici = date('Y-m-d', strtotime($dataInici));

            $diaInici = date('d', strtotime($dataInici));
            $mesInici = (date('m', strtotime($dataInici))) * 1;
            $anyInici = date('Y', strtotime($dataInici));
            $diaFinal = date('d', strtotime($dataFinal));
            $mesFinal = (date('m', strtotime($dataFinal))) * 1;
            if ($tipusFormat) {
                $anyFinal = date('Y', strtotime($dataFinal));
                if ($tipusFormat == 2) {
                    if ($idiomaMin == 'CA') {
                        $textMesFinal = nomMesGlobalTextosMesosCa(($mesFinal * 1));
                        $textMesInici = nomMesGlobalTextosMesosCa(($mesInici * 1));
                    } else {
                        $textMesFinal = nomMesGlobalTextosMesosES(($mesFinal * 1));
                        $textMesInici = nomMesGlobalTextosMesosES(($mesInici * 1));
                    }
                } else {
                    if ($idiomaMin == 'CA') {
                        $textMesFinal = nomMesGlobalTextosMesosAbrevCa(($mesFinal * 1));
                        $textMesInici = nomMesGlobalTextosMesosAbrevCa(($mesInici * 1));
                    } else {
                        $textMesFinal = nomMesGlobalTextosMesosAbrevES(($mesFinal * 1));
                        $textMesInici = nomMesGlobalTextosMesosAbrevES(($mesInici * 1));
                    }
                }
                if ($dataFinal != $dataInici || $dataInici != date('Y-m-d') || $dataFinal != date('Y-m-d')) {
                    if ($diaInici) {
                        $textFecha .= $diaInici;
                    }
                    if ($mesFinal != $mesInici) {
                        if ($textFecha) {
                            $textFecha .= '-';
                        }
                        $textFecha .= $textMesInici;
                    }
                    if ($diaFinal && $dataInici != $dataFinal) {
                        if ($textFecha) {
                            $textFecha .= ' a ';
                        }
                        $textFecha .= $diaFinal;
                    }
                    if ($textFecha) {
                        $textFecha .= '-';
                    }
                    $textFecha .= $textMesFinal;
                    if ($textFecha) {
                        $textFecha .= ' ';
                    }
                    if (date('Y') != $anyFinal) {
                        $textFecha .= $anyFinal;
                    }
                } else {
                    $textFecha = T_AVUI;
                    if ($horaInici) {
                        if ($textFecha) {
                            $textFecha .= ' ';
                        }
                        $textFecha .= $horaInici . ' h';
                    }
                    if ($horaFinal && $horaInici != $horaFinal) {
                        if ($textFecha) {
                            $textFecha .= ' a ';
                        }
                        $textFecha .= $horaFinal . ' h';
                    }
                }
            } else {
                $anyFinal = date('Y', strtotime($dataFinal));
                if ($idiomaMin == 'CA') {
                    $textMesFinal = nomMesGlobalTextosMesosCa(($mesFinal * 1));
                    $textMesInici = nomMesGlobalTextosMesosCa(($mesInici * 1));
                } else {
                    $textMesFinal = nomMesGlobalTextosMesosES(($mesFinal * 1));
                    $textMesInici = nomMesGlobalTextosMesosES(($mesInici * 1));
                }
                if ($diaInici) {
                    $textFecha .= $diaInici;
                }
                if ($mesFinal != $mesInici) {
                    if ($textFecha) {
                        $textFecha .= ' de ';
                    }
                    $textFecha .= $textMesInici;
                }
                if ($diaFinal && $dataInici != $dataFinal) {
                    if ($textFecha) {
                        $textFecha .= ' a ';
                    }
                    $textFecha .= $diaFinal;
                }
                if ($textFecha) {
                    $textFecha .= ' de ';
                }
                $textFecha .= $textMesFinal;
                if ($textFecha) {
                    $textFecha .= ' ';
                }
                $textFecha .= $anyFinal;
            }
        }
        return $textFecha;
    }
}
if (!function_exists('array_sort_by')) {
    /**
     */
    function array_sort_by(&$arrIni, $col, $order = SORT_ASC)
    {
        $arrAux = array();
        foreach ($arrIni as $key => $row) {
            $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
            $arrAux[$key] = strtolower($arrAux[$key]);
        }
        array_multisort($arrAux, $order, $arrIni);
    }
}
if (!function_exists('esValid_EAN')) {

    function esValid_EAN($message)
    {
        $codiEAN = sprintf("%'.014d\n", $message); //añadoimos a lo de 12 y 13 ->0
        $checksum = 0;
        foreach (str_split(($codiEAN)) as $pos => $val) {
            if ($pos < 13) {
                $checksum += $val * (3 - 2 * ($pos % 2));
            }
        }
        $check_digit = ((10 - ($checksum % 10)) % 10);
        if ($check_digit == $codiEAN[13]) {
            return true;
        }
        return false;
    }
}
if (!function_exists('decrypt')) {
    function decrypt($data)
    {
        $secret = hex2bin(CONF_SECRET_ENCRYPT_LLUERT);
        $ivlen = openssl_cipher_iv_length(CONF_METHOD_ENCRYPT_LLUERT);
        $iv = base64_decode(substr($data, 0, $ivlen), true);
        $data = base64_decode(substr($data, $ivlen), true);
        $tag = substr($data, strlen($data) - $ivlen);
        $data = substr($data, 0, strlen($data) - $ivlen);
        try {
            return openssl_decrypt(
                $data,
                CONF_METHOD_ENCRYPT_LLUERT,
                $secret,
                OPENSSL_RAW_DATA,
                $iv,
                $tag
            );
        } catch (\Exception $e) {
            return false;
        }
    }
}
if (!function_exists('encrypt')) {
    function encrypt($data)
    {
        $secret = hex2bin(CONF_SECRET_ENCRYPT_LLUERT);
        $ivlen = openssl_cipher_iv_length(CONF_METHOD_ENCRYPT_LLUERT);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $tag = '';
        $encrypted = openssl_encrypt(
            $data,
            CONF_METHOD_ENCRYPT_LLUERT,
            $secret,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '',
            $ivlen
        );
        return base64_encode($iv) . base64_encode($encrypted . $tag);
    }
}
