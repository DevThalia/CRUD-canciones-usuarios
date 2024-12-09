<?php

/**
 * @copyright Lluert Serveis Telemàtics, S.L. 
 * @license 
 * @see http://www.lluert.net 
 */

/**
 * Permet crear una operacio (si no li pasem idProveidor) o editar una existent (si li pasem idProveidor)
 */
##------------------------------------------------------
if (!$limit) $limit = 0;
$maximPaginaUsuari = 25; //NUMERO MAXIM DE LINIES A UN LLISTAT
##-------------------------------------------------------
include_once '../_inicialitza_pagina.php';
comprovaSeguretat();
if (!$capa) $capa = 'llistat';
if (!$capaOrigen) $capaOrigen = $capa;
$onMouseDown = '';
if ($capa == 'finestra1' || $capa == 'finestra2' || $capa == 'finestra3') {
    $onMouseDown = 'onMouseDown="comencaMoviment(\'' . $capa . '\')"';
}


if (!isset($_REQUEST['idProveidor'])) {
    //Comprovem si te acces administrador
    if ($usuariSessio->permisOperacio('gestioProveidors') != 1) {
?>
        <div class="barraSuperior" <?= $onMouseDown ?>>
            <div class="titolApartat">
                <?php
                if ($onMouseDown) {
                    echo '<div class="float-right"><a href="javascript:void(null);" onClick="buidaCapa(\'' . $capa . '\');refrescaCapa(\'' . $capaOrigen . '\')" class="fa fa-times noDisabled" title="Cerrar"></a></div>';
                } ?>
            </div>
        </div>
        <section>
            <div class="content-wrapper">
                <div class="content-heading">
                    ERROR
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-4">
                            <div class="panel panel-danger">
                                <div class="card-header">
                                    ERROR
                                </div>
                                <div class="card-body">
                                    <p><?= ucfirst(T_NO_TENS_PERMISOS) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php
        include_once "../_tancar_pagina.php";
        exit();
    }
    /*
     * Si no em passen el idProveidor -> Carreguem el modal de Fitxa NOU proveidor
     */

    ?>
    <div class="barraSuperior" <?= $onMouseDown ?>>
        <div class="titolApartat">
            <?php
            if ($onMouseDown) {
                echo '<div class="float-right"><a href="javascript:void(null);" onClick="buidaCapa(\'' . $capa . '\');refrescaCapa(\'' . $capaOrigen . '\')" class="fa fa-times noDisabled" title="Cerrar"></a></div>';
            } ?>
            <h1><?= ucfirst(T_PROVEIDOR_NOU) ?></h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="navbar   menuOperacions ">
            <?php
            if ($capa == 'llistat') {
            ?>
                <a onclick="tornarEnrera();" class="nav-link noDisabled">
                    <i class="fa fa-reply"></i><?= ucfirst(T_TORNAR) ?></a>
            <?php } ?>
        </div>
        <div class="card">
            <div class="card-body">

                <!--  INICI Contingut finestra POPUP MODAL -->
                <form method="post" action="javascript:insereixNouProveidor();" class="form-horizontal" name="nouPerfil" autocomplete="off">

                    <div class="row form-group mb">
                        <div class="col-md-4 col-sm-4 mt-1">
                            <label class="control-label"><?= ucfirst(T_PROVEIDOR_NOM) ?></label>
                            <input type="text" placeholder="<?= ucfirst(T_PROVEIDOR_NOM) ?>" class="form-control" id="nomProveidor" required="">
                        </div>
                        <div class="col-md-4 col-sm-4 mt-1">
                            <label class="control-label"><?= ucfirst(T_EMAIL) ?></label>
                            <input type="email" placeholder="<?= ucfirst(T_EMAIL) ?>" class="form-control" id="emailProveidor">
                        </div>
                        <div class="col-md-4 col-sm-4  mt-1">
                            <label class="control-label"><?= ucfirst(T_TELEFON) ?></label>
                            <input type="text" placeholder="<?= ucfirst(T_TELEFON) ?>" class="form-control" id="telProveidor">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <a class="btn btn-sm btn-outline-secondary" onClick="buidaCapa('<?= $capa ?>');"><?= ucfirst(T_CANCELAR) ?></a>
                        <button type="submit" class="btn btn-sm btn-outline-primary"><?= ucfirst(T_SEGUENT) ?></button>
                    </div>
                </form>
                <!--  FI Contingut finestra POPUP MODAL -->
            </div>
        </div>
    </div>
    <script>
        function insereixNouProveidor() {

            executa('<?= $proveidorsOperacions ?>', {
                operacio: 'insereixProveidor',
                nomProveidor: document.getElementById('nomProveidor').value,
                emailProveidor: document.getElementById('emailProveidor').value,
                telProveidor: document.getElementById('telProveidor').value,
            }, (res) => obreFitxa(res));

            function obreFitxa(res) {
                <?php
                if ($capaOrigen != $capa && ($capa == 'finestra1' || $capa == 'finestra2' || $capa == 'finestra3')) {
                    echo 'buidaCapa(\'' . $capa . '\');';
                }
                ?>
                actualitzaH('<?= $capaOrigen ?>', '<?= $proveidorsFitxa ?>?idProveidor=' + res.idProveidor);
            }
        }
    </script>
<?php

} else {
    /*
     *  Si hem pasen el idProveidor carreguem la fitxa operacio en una pagina nova
     */
    if ($usuariSessio->permisOperacio('gestioProveidors') == 2) {
        $permisLectura = 1;
    } else {
        $permisLectura = 0;
    }
    ////////////////////////////////////////////////////////////
    //// INICI CONTINGUT
    ////////////////////////////////////////////////////////////
    $proveidor = new Proveidor($db, $idProveidor);

?>
    <div class="barraSuperior" <?= $onMouseDown ?>>
        <div class="titolApartat">
            <?php
            if ($onMouseDown) {
                echo '<div class="float-right"><a href="javascript:void(null);" onClick="buidaCapa(\'' . $capa . '\');refrescaCapa(\'' . $capaOrigen . '\')" class="fa fa-times noDisabled" title="Cerrar"></a></div>';
            } ?>
            <h1><?= ucfirst(T_NOU . ' ' . T_PROVEIDOR) ?></h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="navbar menuOperacions">
            <?php if ($usuariSessio->permisOperacio('gestioProveidors') == 1) { ?>
                <a class="nav-link btn btn-outline-secondary" id="swal-eliminaPerfil">
                    <i class="fa fa-trash-alt"></i> <?= ucfirst(T_PROVEIDOR_ELIMINA) ?></a>

            <?php } ?>
            <a onclick="tornarEnrera();" class="nav-link btn btn-outline-secondary noDisabled">
                <i class="fa fa-reply"></i><?= ucfirst(T_TORNAR) ?></a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card btGruiSucces ">
                    <div class="card-header"><?= ucfirst(T_DADES_CONTACTE) ?></div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-8 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_NOM) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_NOM) ?>" class="form-control" name="nomProveidor" value="<?php echo escriu($proveidor->get('nomProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-4 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_ACTIU) ?></label>
                                    <div>
                                        <input <?php echo $disabled; ?> type="checkbox" class="checkbox-switch" name="flagActiuProveidor" <?php if ($proveidor->get('flagActiuProveidor')) {
                                                                                                                                                echo ' checked="checked"';
                                                                                                                                            } ?> <?php echo $readonly; ?> onChange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?= $idProveidor; ?>,camp:this.name,valor:this.checked*1})" data-size="small" data-on-text="SI" data-off-text="NO">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_EMAIL) ?></label>
                                    <input type="text" placeholder="Email" class="form-control" name="emailProveidor" value="<?php echo escriu($proveidor->get('emailProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-6 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_TELEFON) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_TELEFON) ?>" class="form-control" name="telProveidor" value="<?php echo escriu($proveidor->get('telProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-12 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_COMENTARIS) ?></label>
                                    <textarea class="form-control" name="comentarisProveidor" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})"><?php echo escriu($proveidor->get('comentarisProveidor')); ?></textarea>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card btGruiWarning mb">
                    <div class="card-header"><?= ucfirst(T_PROVEIDOR_DADES_FISCALS) ?></div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_NOM_FISCAL) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_NOM_FISCAL) ?>" class="form-control" name="nomFacturacioProveidor" value="<?php echo escriu($proveidor->get('nomFacturacioProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-6 form-group mb">
                                    <label class="control-label">CIF</label>
                                    <input type="text" placeholder="CIF" class="form-control" name="cifFacturacioProveidor" value="<?php echo escriu($proveidor->get('cifFacturacioProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-12 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_DIRECCIO_FACTURACIO) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_DIRECCIO_FACTURACIO) ?>" class="form-control" name="direccioFacturacioProveidor" value="<?php echo escriu($proveidor->get('direccioFacturacioProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-6 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_CODI_POSTAL_FACTURACIO) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_CODI_POSTAL_FACTURACIO) ?>" class="form-control" name="cpFacturacioProveidor" value="<?php echo escriu($proveidor->get('cpFacturacioProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-6 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_POBLACIO_FACTURACIO) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_POBLACIO_FACTURACIO) ?>" class="form-control" name="poblacioFacturacioProveidor" value="<?php echo escriu($proveidor->get('poblacioFacturacioProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-6 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_PROVEIDOR_COMPTE_COMPTABLE) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_PROVEIDOR_COMPTE_COMPTABLE) ?>" class="form-control" name="codiComptableProveidor" value="<?php echo escriu($proveidor->get('codiComptableProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-6 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_EMAIL) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_EMAIL) ?>" class="form-control" name="correuFacturacioProveidor" value="<?php echo escriu($proveidor->get('correuFacturacioProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-6 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_PROVINCIA) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_PROVINCIA) ?>" class="form-control" name="provinciaFacturacioProveidor" value="<?php echo escriu($proveidor->get('provinciaFacturacioProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>

                                <?php
                                $pais = new Paisos($db);
                                $pais->llista();
                                ?>

                                <div class="col-md-6 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_PAIS) ?></label>
                                    <select class="form-control select2" name="codiPaisFacturacioProveidor" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value,'paisFacturacioProveidor':$('#codiPais_'+this.value).attr('data-pais')})">
                                        <option value="" id="codiPais_" data-pais="">-------</option>
                                        <?php
                                        while ($pais->extreu()) {
                                            echo '<option value="' . $pais->get('codiPais') . '" id="codiPais_' . $pais->get('codiPais') . '" data-pais="' . $pais->get('nomPais') . '"';
                                            if ($pais->get('codiPais') == $proveidor->get('codiPaisFacturacioProveidor')) echo ' selected ';
                                            echo ' >' . $pais->get('nomPais') . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (defined('CONF_CONSTANT_FacturesProveidorsBase_facturesProveidors_modulFacturesProveidors') && CONF_CONSTANT_FacturesProveidorsBase_facturesProveidors_modulFacturesProveidors) {
        ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="card btGruiPrimary mb">
                        <div class="card-header"><?= ucfirst(T_PROVEIDOR_DADES_FACTURACIO) ?></div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-3 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_PROVEIDOR_FORMA_PAGAMENT) ?></label>
                                    <select name="idFormaPagament" class="form-control" <?= $readonly ?> onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                        <?php
                                        echo '<option value="0">---</option>';
                                        $formesPagament = new FormaPagament($db);
                                        if (!$ordre) $ordre = 'formesPagament.aliasFormaPagament';
                                        $formesPagament->llista('', $ordre);
                                        while ($formesPagament->extreu()) {
                                            echo '<option value="' . $formesPagament->get('idFormaPagament') . '"';
                                            if ($proveidor->get('idFormaPagament') == $formesPagament->get('idFormaPagament')) echo ' selected';
                                            echo '>' . $formesPagament->get('aliasFormaPagament');
                                            echo '</option>';
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    // if (!$readonly) echo '<a href="javascript:actualitza(\'finestra1\',\''.$formesPagamentFitxa.'?capaOrigen='.$capaOrigen.'&idProveedor=' . $idProveedor . '\')">'.ucfirst(T_PROVEIDOR_AFEGEIX_FORMA_PAGAMENT).'</a>';
                                    ?>
                                </div>

                                <div class="col-md-3 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_PROVEIDOR_DIA_1_PAGAMENT) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_PROVEIDOR_DIA_1_PAGAMENT) ?>" class="form-control" name="dia1Pagament" value="<?php echo escriu($proveidor->get('dia1Pagament')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-3 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_PROVEIDOR_DIA_2_PAGAMENT) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_PROVEIDOR_DIA_2_PAGAMENT) ?>" class="form-control" name="dia2Pagament" value="<?php echo escriu($proveidor->get('dia2Pagament')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                                <div class="col-md-3 form-group mb">
                                    <label class="control-label"><?= ucfirst(T_PROVEIDOR_COMPTE_BANCARI) ?></label>
                                    <input type="text" placeholder="<?= ucfirst(T_PROVEIDOR_COMPTE_BANCARI) ?>" class="form-control" name="compteBancariProveidor" value="<?php echo escriu($proveidor->get('compteBancariProveidor')); ?>" onchange="executa('<?= $proveidorsOperacions ?>',{operacio:'desaCampProveidor',idProveidor:<?php echo $proveidor->get('idProveidor'); ?>,'camp':this.name,'valor':this.value})">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($usuariSessio->permisOperacio('gestioProductes') > 0 && $productesLlista) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card btGruiWarning mb">
                        <div class="card-header"><?= ucfirst(T_LLISTAT) . ' ' . T_PRODUCTES ?></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12" id="capaPreus">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                actualitzaH('capaPreus', '<?= $productesLlista ?>?tipusMostra=llistaPreusProductesProveidors&idProveidor=<?= $idProveidor ?>');
            </script>
        <?php } ?>
    </div>
    </section> <!-- FI Contingut de la pàgina -->
    <script>
        $('#menu_llistaProveidors').addClass('active');



        //CONFIRM amb sweetalert
        $('#swal-eliminaPerfil').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "<?= addslashes(ucfirst(T_SEGUR_QUE_VOLS_ESBORRAR)) ?>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "<?= addslashes(ucfirst(T_CONFIRMACIO_ELIMINAR)) ?>",
                cancelButtonText: "No",
                closeOnConfirm: false,
                reverseButtons: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    executa('<?= $proveidorsOperacions ?>', {
                        operacio: 'eliminaProveidor',
                        idProveidor: <?php echo $idProveidor; ?>
                    }, (res) => {
                        tornarEnrera()
                    });
                }
            });

        });

        <?php if ($permisLectura) {
            echo 'desabilitaTOT(\'' . $capa . '\');';
        } ?>
    </script>
<?php
    ////////////////////////////////////////////////////////////
    //// FI CONTINGUT
    ///////////////////////////////////////////////////////////
    include_once "../_tancar_pagina.php";
}
