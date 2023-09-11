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
                <i class="icon-file-empty position-left"></i>Paginas de Localizacion Deudores
            </div>
        </div>
    </div>
    <!-- /Page header -->

    <div class="container-fluid page-content">
 
    
    


      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="panel-title">Paginas de Localizacion Deudores</div>
            </div>
            <div class="panel-body" style="text-align: center; overflow-x: auto;">
              <table id="localizacion" data-paging='false' class="table datatable">
                <thead>
                  <tr>
                    <th style="background: #F2F2F2;">Nombre</th>
                    <th style="background: #F2F2F2;">Link</th>
                    <th style="background: #F2F2F2;">Abrir</th>
                    
                  </tr>
                </thead>
                <tbody>


                <?php 

                    // Datos de conexión a la base de datos
                    $servername = "localhost";
                    $username = "usuarioselect";
                    $password = "Gh%P=+U]9;g*s8r";
                    $dbname = "collector_bbva";

                    // Crear conexión
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Verificar la conexión
                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    // Consulta a la base de datos
                    $sql = "SELECT * FROM localizacion";
                    $resultado = $conn->query($sql);

                    // Cerrar la conexión
                    $conn->close();
                    ?>

                <?php if ($resultado->num_rows > 0): ?>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fila['nombre']; ?></td>
                            <td><?php echo $fila['link']; ?></td>
                                  <td class="center aligned">
                                  <a href="<?php echo $fila['link'];?>" target="_blank">
                                  <i class="icon icon-search4"></i>
                                  </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>

                </tbody>

                            <tr>
                <td colspan="4">No se encontraron registros</td>
            </tr>
        <?php endif; ?>


              </table>






            </div>
          </div><!-- panel -->
        </div><!-- col -->
      </div><!-- row -->



    </div><!-- container -->



</section>