<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
?>

<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="theme-color" content="#1C2B36" />
        <title>Smart Contact - <?php echo $this->config->item('empresa'); ?></title>

        <!-- Favicon -->
        <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/favicon.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
        <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/favicon.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
        <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/favicon.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
        <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/favicon.png" rel="apple-touch-icon" type="image/png">
        <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/favicon.png" rel="icon" type="image/png">
        <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/favicon.png" rel="shortcut icon">
        <!-- /Favicon -->

        <!-- Global stylesheets -->
        <link type="text/css" rel="stylesheet" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/css/bootstrap.css"/>
        <link type="text/css" rel="stylesheet" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/css/animate.min.css"/>
        <link type="text/css" rel="stylesheet" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/css/main.css"/>
        <link type="text/css" rel="stylesheet" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/css/jquery-ui.css"/>
        <link type="text/css" rel="stylesheet" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/css/custom.css"/>
        <script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/lib/js/core/loader.js"></script>
        <!-- /Global stylesheets -->
    </head>
    <body id="top">


        <div id="preloader">
            <div id="status">
                <div class="loader"></div>
            </div>
        </div>
        <!-- /Preloader -->

        <div id="body-wrapper" class="body-container">

            <header class="main-nav clearfix">

                <!-- Branding -->
                <div class="navbar-left pull-left">
                    <div class="clearfix">
                        <ul class="left-branding pull-left">
                            <li class="visible-handheld"><span class="left-toggle-switch"><i class="icon-menu7"></i></span></li>
                            <li>
                                <a href="index.html"><div class="logo"></div></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /Branding -->
                <div class="navbar pull-left">
                    <i id="menu-close" class="icon-menu6" style="font-size: 20px; margin: 15px; cursor: pointer;"></i>
                    <i id="menu-open" style="font-size: 20px; margin: 15px; display: none; cursor: pointer;" class="icon-menu6"></i>
                    <i id="setPausas" style="font-size: 20px; margin: 15px; cursor: pointer;" class="icon-lock5"></i>
                    <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/listas/1"><img style="margin-right: 15px;" src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/calendar_32x32.png" alt="Promesas" title="Promesas"/></a>
                    <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/listas/2"><img style="margin-right: 15px;" src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/money_32x32.png" alt="Confirmaciones" title="Confirmaciones"/></a>
                    <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/exportaasignacion"><img style="margin-right: 15px;" src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/excel.png" alt="Exportar Asignacion" title="Exportar Asignacion"/></a>
                </div>
                
                <!-- Navbar icons -->
                
                <div class="navbar pull-right">
                    <div class="clearfix">
                        <ul class="pull-right top-icons">
                            <li><a href="#" class="btn-top-search visible-xs"><i class="icon-search4"></i></a></li>

                            <!-- Quick apps dropdown -->
                            <li class="dropdown apps-dropdown hidden-xs">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-grid2"></i></a>
                                <div class="dropdown-menu">
                                </div>
                            </li>
                            <!-- /Quick apps dropdown -->

                            <!-- Rightbar -->
                            <!--<li><a href="#" onclick="open_rightbar()"><span class="bubble">6</span><i class="icon-stack3"></i></a></li>-->
                            <!-- /Rightbar -->

                            <!-- User dropdown -->

                            <li class="dropdown user-dropdown">
                                <a class="user-name hidden-xs" data-toggle="dropdown"><?php echo $session['usuario']; ?><i class="icon-more2"></i><small><?php echo $session['proyecto_activo']; ?></small></a>
                                <a href="#" class="btn-user dropdown-toggle hidden-xs" data-toggle="dropdown"><!--<img src="http://via.placeholder.com/80x80" class="img-circle user" alt=""/>--></a>
                                <a href="#" class="dropdown-toggle visible-xs" data-toggle="dropdown"><i class="icon-more"></i></a>
                                <div class="dropdown-menu no-padding">
                                </div>
                            </li>
                            <!-- /User dropdown -->

                        </ul>
                    </div>
                </div>
                <!-- /Navbar icons -->
                <div class="navbar pull-right">
                    <ul id="actionPanelHeader" class="actionPanelHeader">
                        <?php
                        if(isset($accionesPanel[0]['idAccion'])){


                            foreach ($accionesPanel as $acp) {
                            $id = "";
                            if ($acp['idAccion'] == 1) {
                                $id = "sendCall";
                            } else if ($acp['idAccion'] == 3) {
                                $id = "progCall";
                            }else if ($acp['idAccion'] == 4) {
                                $id = "idDirecciones";
                            }else if ($acp['idAccion'] == 5) {
                                $id = "idMailes";
                            }
                            ?>
                            <li id="<?php echo $id; ?>" flag='<?php echo $acp['idAccion']; ?>' title="<?php echo $acp['descripcion']; ?>" data-placement="left"><i style="font-size: 32px;" class="<?php echo $acp['icono']; ?>"></i></li>
                            
                        <?php } ?>
                            <li id="idOthers" flag='99' title="Otros" data-placement="left"><i style="font-size: 32px;" class="icon-plus"></i></li>
                        <?php } ?>

                    </ul>
                </div>
            </header>
