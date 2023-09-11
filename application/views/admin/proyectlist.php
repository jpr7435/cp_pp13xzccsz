<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2 -> load -> model("vista");

?>
<section class="main-container">
  <div class="container-fluid page-content">

    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="panel-title">
              Listado de Proyectos
            </div>
          </div>
          <div class="panel-body">

            <table class="table datatable">
              <thead>
                <tr>
                  <th>Id Proyecto</th>
                  <th>Proyecto</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <?php foreach($proyects as $pr){?>
                <tbody>
                  <tr>
                    <td><?php echo $pr['idProyecto'];  ?></td>
                    <td><?php echo $pr['descripcion'];  ?></td>
                    <td><a href="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/admin/fieldset/<?php echo $pr['descripcion']; ?>"><img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/databases.png" alt="Databases" title="Databases"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/admin/catalogos/<?php echo $pr['descripcion']; ?>"><img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/check.png" alt="Catalogo" title="Catalogo"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/admin/metas/<?php echo $pr['descripcion']; ?>"><img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/dollar.png" alt="Metas" title="Metas"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/admin/adicionales/<?php echo $pr['descripcion']; ?>"><img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/user_color.png" alt="Adicionales" title="Adicionales"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>

                  </tr>
                </tbody>
              <?php } ?>
            </table>
          </div>
        </div>
      </div>


      <div class="col-md-6 col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="panel-title">
              Agregar de Proyecto
            </div>
          </div>
          <div class="panel-body">
            <label>Nombre del proyecto</label>
            <input type="text" class="form-control" name="proyect-name" id="proyect-name" />
            <button type="button" class="btn btn-success" style="margin-top: 10px;" id="createPr-btn">Crear Proyecto</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
