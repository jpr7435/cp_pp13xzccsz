<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");
?>
<section class="main-container">
    <div class="container-fluid page-content">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Listado de Usuarios
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    foreach ($usuariosList as $l) {
                        $descr = $ci2->vista->getPerfilName($l['idPerfil']);
                        ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="our-team3">
                                <img src="http://<?php echo $this->config->item('host_cobranzas'); ?>/front/img/usuarios/<?php echo $l['imagen']; ?>" alt="">
                                <div class="team-content">
                                    <h3 class="post-title"><?php echo $l['nombre']; ?></h3>
                                    <span class="post"><?php echo $descr[0]['descripcion']; ?></span>
                                    <!--<p class="description">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio exercitationem facilis laborum perferendis quasi, ratione.
                                    </p>-->
                                    <ul class="team_social">
                                        <li>
                                            <a href="http://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/edit-user/<?php echo $l['idUsuario']; ?>"><i class="icon icon-pencil"></i></a>
                                            <!--<a href="http://<?php //echo $this->config->item("host_usuarios");  ?>/index.php/updateusuario"><i class="icon icon-pencil"></i></a>-->
                                        </li>
                                        <li>
                                            <a href="#"><i class="icon icon-eye"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="icon icon-user-check"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="team-prof">
                                    <h3 class="post-title"><?php echo $l['nombre']; ?></h3>
                                    <span class="post"><?php echo $descr[0]['descripcion']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>
