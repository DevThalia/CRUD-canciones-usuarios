<?php

/**
 * @copyright Lluert Serveis Telemàtics, S.L. 
 * @license 
 * @see http://www.lluert.net 
 */

/**
 * Aquesta pàgina llista les operacions per poder assignar despres als proveidors
 */

include_once '../_inicialitza_pagina.php';
comprovaSeguretat();
////////////////////////////////////////////////////////////
//// INICI CONTINGUT
////////////////////////////////////////////////////////////
if (!$capa) $capa = 'llistat';
if (!$capaOrigen) $capaOrigen = $capa;
$onMouseDown = '';
if ($capa == 'finestra1' || $capa == 'finestra2' || $capa == 'finestra3') {
    $onMouseDown = 'onMouseDown="comencaMoviment(\'' . $capa . '\')"';
}

##------------------------------------------------------
if (!isset($limit)) $limit = 0;
$maximPaginaProveidor = 25; //NUMERO MAXIM DE LINIES A UN LLISTAT
##-------------------------------------------------------
switch ($tipusMostra) {

    default:
        if (!isset($idProveidor)) $idProveidor = '';
        if (!isset($nomProveidor)) $nomProveidor = '';
        if (!isset($emailProveidor)) $emailProveidor = '';
        if (!isset($cifFacturacioProveidor)) $cifFacturacioProveidor = '';
        if (!isset($paisFacturacioProveidor)) $paisFacturacioProveidor = '';
        if (!isset($poblacioFacturacioProveidor)) $poblacioFacturacioProveidor = '';
        if (!isset($flagActiuProveidor)) $flagActiuProveidor = '';
        if (!isset($campOrdre)) $campOrdre = '';

?>
        <div class="barraSuperior" <?= $onMouseDown ?>>
            <div class="titolApartat">
                <?php
                if ($onMouseDown) {
                    echo '<div class="float-right"><a href="javascript:void(null);" onClick="buidaCapa(\'' . $capa . '\');refrescaCapa(\'' . $capaOrigen . '\')" class="fa fa-times noDisabled" title="Cerrar"></a></div>';
                } ?>
                <h1><?= ucfirst(T_LLISTAT) . ' ' . T_PROVEIDORS ?></h1>
            </div>
        </div>
        <div class="container-fluid">
            <div class="navbar menuOperacions">
                <?php if ($usuariSessio->permisOperacio('gestioProveidors') == 1) { ?>
                    <a class="nav-link btn btn-outline-secondary" onClick="javascript:actualitza('finestra1','<?= $proveidorsFitxa ?>?capaOrigen=<?= $capa ?>');">
                        <i class="fa fa-plus" style="font-size:1em;"></i> <?= ucfirst(T_NOU) . ' ' . T_PROVEIDOR ?>
                    </a>
                <?php } ?>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php

                    echo '<form name="llistatProveidors" action="javascript:actualitzaH(\'' . $capa . '\',\'' . $proveidorsLlista . '?tipusMostra=llista&capaOrigen=' . $capaOrigen;
                    echo '&idProveidor=\'+document.llistatProveidors.idProveidor.value+\'';
                    echo '&nomProveidor=\'+document.llistatProveidors.nomProveidor.value+\'';
                    echo '&emailProveidor=\'+document.llistatProveidors.emailProveidor.value+\'';
                    echo '&cifFacturacioProveidor=\'+document.llistatProveidors.cifFacturacioProveidor.value+\'';
                    echo '&paisFacturacioProveidor=\'+document.llistatProveidors.paisFacturacioProveidor.value+\'';
                    echo '&poblacioFacturacioProveidor=\'+document.llistatProveidors.poblacioFacturacioProveidor.value+\'';
                    echo '&flagActiuProveidor=\'+document.llistatProveidors.flagActiuProveidor.value+\'';
                    echo '&campOrdre=\'+document.llistatProveidors.campOrdre.value+\'';
                    echo '&limit=\'+document.llistatProveidors.limit.value)">';
                    ?>
                    <input type="hidden" name="campOrdre" value="<?php echo $campOrdre; ?>">
                    <input type="hidden" name="limit" value="<?php echo $limit; ?>">

                    <!--Capcaleres-->
                    <table class="table table-bordered table-striped">
                        <thead>

                            <th style="width:100px;text-align:center"><?= ucfirst(T_EDIT) ?></th>

                            <th style="width:100px;">ID
                                <?php $columnaOrdre = 'proveidors.idProveidor'; ?>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> ASC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' ASC') echo 'fa-caret-up active';
                                                                                                                                                                                                                                            else echo 'fa-angle-up'; ?>"></i></a>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> DESC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' DESC') echo 'fa-caret-down active';
                                                                                                                                                                                                                                                else echo 'fa-angle-down'; ?>"></i></a>
                            </th>
                            <th><?= ucfirst(T_NOM) ?>
                                <?php $columnaOrdre = 'proveidors.nomProveidor'; ?>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> ASC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' ASC') echo 'fa-caret-up active';
                                                                                                                                                                                                                                            else echo 'fa-angle-up'; ?>"></i></a>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> DESC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' DESC') echo 'fa-caret-down active';
                                                                                                                                                                                                                                                else echo 'fa-angle-down'; ?>"></i></a>
                            </th>
                            <th><?= ucfirst(T_EMAIL) ?>
                                <?php $columnaOrdre = 'proveidors.emailProveidor'; ?>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> ASC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' ASC') echo 'fa-caret-up active';
                                                                                                                                                                                                                                            else echo 'fa-angle-up'; ?>"></i></a>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> DESC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' DESC') echo 'fa-caret-down active';
                                                                                                                                                                                                                                                else echo 'fa-angle-down'; ?>"></i></a>
                            </th>
                            <th><?= ucfirst(T_PROVEIDOR_CIF) ?>
                                <?php $columnaOrdre = 'proveidors.cifFacturacioProveidor'; ?>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> ASC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' ASC') echo 'fa-caret-up active';
                                                                                                                                                                                                                                            else echo 'fa-angle-up'; ?>"></i></a>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> DESC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' DESC') echo 'fa-caret-down active';
                                                                                                                                                                                                                                                else echo 'fa-angle-down'; ?>"></i></a>
                            </th>
                            <th>
                                <?= ucfirst(T_PAIS) ?>
                                <?php $columnaOrdre = 'proveidors.paisFacturacioProveidor'; ?>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> ASC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' ASC') echo 'fa-caret-up active';
                                                                                                                                                                                                                                            else echo 'fa-angle-up'; ?>"></i></a>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> DESC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' DESC') echo 'fa-caret-down active';
                                                                                                                                                                                                                                                else echo 'fa-angle-down'; ?>"></i></a>

                            </th>
                            <th>
                                <?= ucfirst(T_POBLACIO) ?>
                                <?php $columnaOrdre = 'proveidors.poblacioFacturacioProveidor'; ?>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> ASC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' ASC') echo 'fa-caret-up active';
                                                                                                                                                                                                                                            else echo 'fa-angle-up'; ?>"></i></a>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> DESC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' DESC') echo 'fa-caret-down active';
                                                                                                                                                                                                                                                else echo 'fa-angle-down'; ?>"></i></a>

                            </th>
                            <th>
                                <?= ucfirst(T_ACTIU) ?>
                                <?php $columnaOrdre = 'proveidors.flagActiuProveidor'; ?>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> ASC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' ASC') echo 'fa-caret-up active';
                                                                                                                                                                                                                                            else echo 'fa-angle-up'; ?>"></i></a>
                                <a href="javascript:document.llistatProveidors.campOrdre.value='<?php echo $columnaOrdre; ?> DESC';document.llistatProveidors.limit.value='0';document.llistatProveidors.submit();"><i class="fa float-right <?php if ($campOrdre == $columnaOrdre . ' DESC') echo 'fa-caret-down active';
                                                                                                                                                                                                                                                else echo 'fa-angle-down'; ?>"></i></a>

                            </th>
                            <?php
                            echo '<tr>';
                            echo '<td class="titol"></td>';
                            echo '<td class="titol"><input class="form-control" type="text"  name="idProveidor" value="' . $idProveidor . '" onchange="document.llistatProveidors.limit.value=0;submit();" /></td>';
                            echo '<td class="titol"><input class="form-control" type="text"  name="nomProveidor" value="' . $nomProveidor . '" onchange="document.llistatProveidors.limit.value=0;submit();" /></td>';
                            echo '<td class="titol"><input class="form-control" type="text"  name="emailProveidor" value="' . $emailProveidor . '" onchange="document.llistatProveidors.limit.value=0;submit();" /></td>';
                            echo '<td class="titol"><input class="form-control" type="text"  name="cifFacturacioProveidor" value="' . $cifFacturacioProveidor . '" onchange="document.llistatProveidors.limit.value=0;submit();" /></td>';
                            echo '<td class="titol"><input class="form-control" type="text"  name="paisFacturacioProveidor" value="' . $paisFacturacioProveidor . '" onchange="document.llistatProveidors.limit.value=0;submit();" /></td>';
                            echo '<td class="titol"><input class="form-control" type="text"  name="poblacioFacturacioProveidor" value="' . $poblacioFacturacioProveidor . '" onchange="document.llistatProveidors.limit.value=0;submit();" /></td>';
                            // <input class="form-control" type="number"  name="flagActiuProveidor" value="' . $flagActiuProveidor . '" onchange="document.llistatProveidors.limit.value=0;submit();" />
                            echo '<td class="titol">
                                        <select class="form-control" style="width:50px;" name="flagActiuProveidor" onchange="document.llistatProveidors.limit.value=0;submit();">';
                            echo '<option value=""';
                            if ($flagActiuProveidor == '') echo ' selected ';
                            echo '>---</option>';
                            echo '<option value="1"';
                            if ($flagActiuProveidor == '1') echo ' selected ';
                            echo '>Sí</option>';
                            echo '<option value="0"';
                            if ($flagActiuProveidor == '0') echo ' selected ';
                            echo '>No</option>';
                            echo '</select></td>';
                            echo '</tr>';
                            ?>
                        </thead>
                        <?php

                        $filtre = '';

                        if ($idProveidor) {
                            if ($filtre) $filtre .= ' and ';
                            $filtre .= "proveidors.idProveidor =" . $idProveidor;
                        }
                        if ($nomProveidor) {
                            if ($filtre) $filtre .= ' and ';
                            $filtre .= "proveidors.nomProveidor like '%$nomProveidor%'";
                        }
                        if ($emailProveidor) {
                            if ($filtre) $filtre .= ' and ';
                            $filtre .= "proveidors.emailProveidor like  '%$emailProveidor%'";
                        }
                        if ($cifFacturacioProveidor) {
                            if ($filtre) $filtre .= ' and ';
                            $filtre .= "proveidors.cifFacturacioProveidor like  '%$cifFacturacioProveidor%'";
                        }
                        if ($paisFacturacioProveidor) {
                            if ($filtre) $filtre .= ' and ';
                            $filtre .= "proveidors.paisFacturacioProveidor like  '%$paisFacturacioProveidor%'";
                        }
                        if ($poblacioFacturacioProveidor) {
                            if ($filtre) $filtre .= ' and ';
                            $filtre .= "proveidors.poblacioFacturacioProveidor like  '%$poblacioFacturacioProveidor%'";
                        }
                        if ($flagActiuProveidor != "") {
                            if ($filtre) $filtre .= ' and ';
                            $filtre .= "proveidors.flagActiuProveidor =  $flagActiuProveidor";
                        }


                        if (!isset($campOrdre)) $campOrdre = 'proveidors.nomProveidor DESC';

                        if (!isset($proveidor)) $proveidor = new Proveidor($db);
                        if ($a_llistaProveidors = $proveidor->llista($filtre, $campOrdre, $limit . ',' . $maximPaginaProveidor)) {
                            foreach ($a_llistaProveidors as $proveidorTmp) {
                                echo '<tr>';
                                echo '<td><a onclick="javascript:actualitzaH(\'' . $capa . '\',\'' . $proveidorsFitxa . '?idProveidor=' . $proveidorTmp['idProveidor'] . '\');" alt="modificar" title="modificar"><center><i class="fa fa-edit" style="color:#555;cursor:pointer;"></i></center></a></td>';
                                echo '<td>' . $proveidorTmp['idProveidor'] . '</td>';
                                echo '<td>' . $proveidorTmp['nomProveidor'] . '</td>';
                                echo '<td>' . $proveidorTmp['emailProveidor'] . '</td>';
                                echo '<td>' . $proveidorTmp['cifFacturacioProveidor'] . '</td>';
                                echo '<td>' . $proveidorTmp['paisFacturacioProveidor'] . '</td>';
                                echo '<td>' . $proveidorTmp['poblacioFacturacioProveidor'] . '</td>';
                                if ($proveidorTmp['flagActiuProveidor'] == 1) {
                                    echo "<td>Sí</td>";
                                } else {
                                    echo "<td>No</td>";
                                }
                                // echo '<td>' . $proveidorTmp['flagActiuProveidor'] . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="8">
                                <nav>
                                    <ul class="pagination justify-content-center m-2">
                                        <?php
                                        if ($proveidor->numProveidors($filtre) > $maximPaginaProveidor) {
                                            echo '<p style="text-align:center">';
                                            if (($limit - 1) >= 0) echo '<a class="taronja negreta" href="javascript:document.llistatProveidors.limit.value=\'' . ($limit - $maximPaginaProveidor) . '\'; document.llistatProveidors.submit();"> Anterior </a>';
                                            else echo '<span class="negreta" style="color:#CCCCCC; text-decoration:none"> Anterior </span>';
                                            echo '<span class="negreta" style="margin-left:40px;">' . ucfirst(T_PAGINA) . ' ' . (($limit / $maximPaginaProveidor) + 1) . '</span> de ' . ceil($proveidor->numProveidors($filtre) / $maximPaginaProveidor);
                                            $numeroActual = ceil((($limit / $maximPaginaProveidor) + 1));
                                            $numeroTotal = ceil($proveidor->numProveidors($filtre) / $maximPaginaProveidor);
                                            if ($numeroActual != $numeroTotal) echo '<a class="negreta" style="margin-left:40px;" href="javascript:document.llistatProveidors.limit.value=\'' . ($limit + $maximPaginaProveidor) . '\'; document.llistatProveidors.submit();"> Seg&uuml;ent </a>';
                                            else echo '<span class="negreta" style="color:#CCCCCC; text-decoration:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Seg&uuml;ent </span>';
                                            echo '</p>';
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <script>
            (function(window, document, $, undefined) {
                activaMenu('#menu_llistaProveidors', '<?= $capa ?>');
            })(window, document, window.jQuery);
        </script>
<?php
        break;
}
?>

<?php
////////////////////////////////////////////////////////////
//// FI CONTINGUT
///////////////////////////////////////////////////////////

include_once "../_tancar_pagina.php";
