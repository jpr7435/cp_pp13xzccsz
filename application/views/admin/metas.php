<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
$mes = date("m");
?>
<section class="main-container">
    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i> Metas del proyecto - <?php echo $slug; ?>
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">

      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Listado de Metas <?php echo $slug; ?></div>
                </div>
                <div id="field-list" class="panel-body">
                    <table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Meta</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $usu){
                              $nom = $this->vista->getusuario($usu['idUsuario']);
                              $premeta = $this->vista->getMetaUSer($usu['idUsuario'], $idPr, $mes);
                              if(isset($premeta[0]['valor'])){
                                $meta = $premeta[0]['valor'];
                              }else{
                                $meta = 0;
                              }

                              if($nom[0]['idEstado'] == 1){
                              ?>
                                <tr>
                                    <td><?php echo $nom[0]['nombre']; ?></td>
                                    <td><input type="text" class="form-control" name="meta<?php echo $usu['idUsuario']; ?>" id="meta<?php echo $usu['idUsuario']; ?>" value="<?php echo number_format($meta,2); ?>" /></td>
                                    <td><button type="button" name="save-meta" user="<?php echo $usu['idUsuario']; ?>" pro="<?php echo $idPr; ?>" class="btn btn-success save-metas">Guardar</button></td>
                                </tr>
                              <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>
