<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js" integrity="sha512-qzgd5cYSZcosqpzpn7zF2ZId8f/8CHmFKZ8j7mU4OUXTNRd5g+ZHBPsgKEwoqxCtdQvExE5LprwwPAgoicguNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */





$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");
$ci2->load->model('Principal');


$hoy = date("Y-m-d");



?>

<section class="main-container">
    <!-- Page header -->
    <div class="header">
        <div class="header-content">
            <div class="page-title">
                <i class="icon-file-empty position-left"></i>Ranking de Pagos BBVA Castigo
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
 
    
    


      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="panel-title">Ranking de Pagos BBVA Castigo</div>
            </div>
            <div class="panel-body" style="text-align: center; overflow-x: auto;">
              <table id="ranking" data-paging='false' class="table datatable datatable-column-search-selects table-bordered">
                <thead>
                  <tr>
                    <th style="background: #F2F2F2;">Asesor</th>
                    <th style="background: #F2F2F2;">Total GAC</th>
                    <th style="background: #F2F2F2;">Meta</th>
                    <th style="background: #F2F2F2;">Ejecucion Meta</th>
                    <th style="background: #F2F2F2;">Faltante Meta</th>
                    
                  </tr>
                </thead>
                <tbody>

<?php


                  //echo $session['proyecto']. " prprprpr ";
                $generalGac=0;
                $totalMetas=0;
                $totalRecaudoMia=0;
                   foreach($usuariosPr as $Upr) {
                    $ejecucion = 0;
                    $validador = 0;
                    //echo $Upr['idUsuario']." ---- ".$Upr['carteras']. " ........ ";
                    $us = $this->vista->getusuario($Upr['idUsuario']);

                    $recaudoMia = $this->vista->getRecaudoMia($Upr['idUsuario'], $proyecto_activo);

                    $totalGac = $this->Principal->getTotalPagos($Upr['idUsuario'], $proyecto_activo);
                    //print_r($totalGac[0]['total']);
                    //$pagos = $this->vista->getPagos($Upr['idUsuario']);
                    $validaPrs = explode(";", $Upr['carteras']);

                  //  print_r($validaPrs);

                    foreach ($validaPrs as $key => $value) {
                      if($value == $proy[0]['idProyecto']){
                          $validador = 1;
                        //  echo "Entro"."<br>";
                      }
                    }

                    if(isset($us[0]['idEstado'])){
                    if($us[0]['idEstado'] < '3' && $us[0]['idPerfil'] == 6 && $validador == 1){

                    //$metas = $this->vista->getMetas($Upr['idUsuario']);
                    $meta = $us[0]['meta'];

                    $ejecucion = ($totalGac[0]['total']/$meta)*100;
                    $ejecucion2 = round($ejecucion,2);

                    $faltanteMeta = ($meta-$totalGac[0]['total']);

                if($ejecucion>=100){
                    $claseRow = 'style="background-color: #D0F5A9;"';
                  }elseif($ejecucion>=70 && $ejecucion<= 99){
                    $claseRow = 'style="background-color: #A9ECF5;"';
                  }elseif($ejecucion>=50 && $ejecucion<=69){
                    $claseRow = 'style="background-color: #F2F5A9;"';
                  }elseif($ejecucion>=30 && $ejecucion<=49){
                    $claseRow = 'style="background-color: #E47E55;"';
                  }elseif($ejecucion<30){
                    $claseRow = 'style="background-color: #F5A9A9;"';
                  }
                  //  $valor_banco = $pagos['valor_banco'];

                    ?>
                  <tr>
                    <td <?php echo $claseRow; ?>><?php echo $us[0]['nombre']; ?></td>
                    <td <?php echo $claseRow; ?>><?php echo "$" . number_format($totalGac[0]['total'],0); ?></td>
                    <td <?php echo $claseRow; ?>><?php echo "$" . number_format($meta,0); ?></td>
                    <td <?php echo $claseRow; ?>><?php echo $ejecucion2."%" ?></td>
                    <td <?php echo $claseRow; ?>><?php echo "$" . number_format($faltanteMeta,0); ?></td>
                    
                  </tr>


                <?php  

                    $generalGac = $generalGac + $totalGac[0]['total'];
                    $totalMetas = $totalMetas + $meta;
                    $totalRecaudoMia = $totalRecaudoMia + $recaudoMia[0]['total'];
            
                    } } } 
                    
                    $totalEjecucion = ($generalGac/$totalMetas)*100;
                    $totalEjecucion2 = round($totalEjecucion,2);
                    $totalFaltanteMeta = ($totalMetas - $generalGac);

                    
                    ?>
                    <tr>
                        <td style="background: #F2F2F2;"><strong>Total General</strong></td>
                        <td style="background: #F2F2F2;"><strong><?php echo "$".number_format($generalGac,0); ?></strong></td>
                        <td style="background: #F2F2F2;"><strong><?php echo "$".number_format($totalMetas,0); ?></strong></td>
                        <td style="background: #F2F2F2;"><strong><?php echo $totalEjecucion2." %" ?></strong></td>
                        <td style="background: #F2F2F2;"><strong><?php echo "$".number_format($totalFaltanteMeta,0); ?></strong></td>
                        
                    </tr>
                </tbody>
              </table>






            </div>
          </div><!-- panel -->
        </div><!-- col -->
      </div><!-- row -->



    </div><!-- container -->



</section>