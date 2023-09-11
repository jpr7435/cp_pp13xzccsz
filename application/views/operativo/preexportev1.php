<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
?>

<section class="main-container">

    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Exporte de informe V1 - <?php echo $session['proyecto_activo']; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
        <div style="clear: both; height: 25px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <form name="fechas-credivalores" id="fechas-credivalores" method="post" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/exportarinformev1">
                        <div class="form-group">
                            <button class="btn btn-success btn-labeled" type="submit"><b><i class="icon-floppy-disk"></i></b>Exportar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
