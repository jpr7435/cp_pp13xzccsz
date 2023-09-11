<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
?>


<ul class="sidebar-accordion">



  <li class="list-title"><?php echo $session['proyecto_activo']; ?></li>
  <li>
    <form action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/fastsearch" target="_blank" method="post" name="fastsearch" id="fastsearch" class="sidebar-form">
      <div class="form-group">
        <div class="input-group input-group-sm">
          <input type="text" name="fast-search" class="form-control input-sm" id="fast-search" placeholder="Busqueda Rapida">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><b><i class="icon-search4"></i></b></button>
          </span>
        </div>
      </div>
    </form>
  </li>
  <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/dashboard/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-display4"></i><span class="list-label"> Dashboard</span></a></li>
  <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/buscar/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-search4"></i><span class="list-label"> Buscar</span></a></li>
  <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/asignacion/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-list"></i><span class="list-label"> Asignacion</span></a></li>
  <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/resumen-tareas/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-portfolio"></i><span class="list-label"> Tareas</span></a></li>
  <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/pagos/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-coin-dollar"></i><span class="list-label"> Pagos</span></a></li>
  
  <?php if ($session['proyecto_activo'] == 'avista') { ?> 
    <li><a href="http://172.16.23.100/whatsappavista/#/inicio/<?php echo $session['id']; ?>" target="_blank"><i class="icon icon-coin-dollar"></i><span class="list-label"> Whatsapp</span></a></li>
  <?php }else if ($session['proyecto_activo'] == 'bbva') { ?>
    <li><a href="http://172.16.23.100/whatsapp/#/inicio/<?php echo $session['id']; ?>" target="_blank"><i class="icon icon-coin-dollar"></i><span class="list-label"> Whatsapp</span></a></li>
  <?php }else if ($session['proyecto_activo'] == 'credivalores') { ?>
    <li><a href="http://172.16.23.100/whatsappcredivalores/#/inicio/<?php echo $session['id']; ?>" target="_blank"><i class="icon icon-coin-dollar"></i><span class="list-label"> Whatsapp</span></a></li>
  <?php }else if ($session['proyecto_activo'] == 'credivalores_pre') { ?>
    <li><a href="http://172.16.23.100/whatsappcredivalores/#/inicio/<?php echo $session['id']; ?>" target="_blank"><i class="icon icon-coin-dollar"></i><span class="list-label"> Whatsapp</span></a></li>
  <?php }else if ($session['proyecto_activo'] == 'movistar') { ?>
    <li><a href="http://172.16.23.100/whatsappmovistar/#/inicio/<?php echo $session['id']; ?>" target="_blank"><i class="icon icon-coin-dollar"></i><span class="list-label"> Whatsapp</span></a></li>
  <?php } ?>
  < li><a target="_blank" href="https://consulegalab.com/modulo_task/index.php/inicio/cobranzas"><i class="icon icon-magazine"></i><span class="list-label"> Tickets</span></a></li>
  <?php if ($session['perfil'] < 4) { ?>

    <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/event-search"><i class="icon icon-users4"></i> <span>Visor Eventos</span></a></li>
  <?php } ?>
  <?php if ($session['perfil'] < 5) { ?>
    <li class="list-title">Operativo</li>
    <li><a href=""><i class="icon-design"></i><span>Configuraciones</span></a>
      <ul>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/arbol/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-tree7"></i><span class="list-label"> Arbol de gestion</span></a></li>
        <li><a href="https://<?php echo $this->config->item('host_cobranzas'); ?>/index.php/admin/camposdinamicos"><i class="icon icon-list"></i><span class="list-label"> Campos Dinamicos</span></a></li>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/sms/admin/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-tree7"></i><span class="list-label"> Creacion de SMS</span></a></li>
      </ul>
    </li>
    <li><a href=""><i class="icon icon-upload"></i><span>Importar</span></a>
      <ul>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/importarinicial/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Base Inicial</span></a></li>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/importaractualizacion/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Actualización</span></a></li>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/importartareas/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Tareas</span></a></li>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/importarasignacion/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Asignacion</span></a></li>
        <?php if ($session['proyecto_activo'] == 'bbva') { ?>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/importarevolutivo/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Cargar Evolutivo</span></a></li>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/importarasignacionini/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Cargar Asignacion Inicial</span></a></li>
        <?php } ?>
        <?php if ($session['proyecto_activo'] == 'bcsc') { ?>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/executebasebcsc/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Ejecutar BCSC</span></a></li>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/cargartablasbcsc/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Cargar Tablas BCS</span></a></li>
        <?php } ?>
        <?php if ($session['proyecto_activo'] == 'bcsc_media') { ?>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/executebasebcsc_media/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Ejecutar BCSC Media</span></a></li>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/cargartablasbcsc_media/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Cargar Tablas BCS Media</span></a></li>
        <?php } ?>

        <?php if ($session['proyecto_activo'] == 'promotora') { ?>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/cargartablaspromotora/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Cargar Tablas Promotora</span></a></li>
        <?php } ?>
        <?php if ($session['proyecto_activo'] == 'credivalores') { ?>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/cargarpagoscredivalores/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Cargar Pagos Credivalores</span></a></li>
        <?php } ?>

      </ul>
    </li>
    <li>
      <a href=""><i class="icon icon-download"></i><span>Exportar</span></a>
      <ul>
        <?php if ($session['proyecto_activo'] == "credivalores" || $session['proyecto_activo'] == "credivalores_pre") { ?>
            <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/preexportarinformev1/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Exportar Informe V1</span></a></li>
            <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/preexportarinformev2/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Exportar Informe V2</span></a></li>
        <?php } ?>
        <?php if ($session['proyecto_activo'] == "bbva" || $session['proyecto_activo'] == "bbva_libranzas") { ?>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/exportarinformebbva/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Exportar Informe</span></a></li>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/exportarinformebbvaespejo/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Exportar Informe Espejo</span></a></li>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/exportarinformebbvatabla/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Exportar Informe Tabla</span></a></li>
        <?php } ?>
        <?php if ($session['proyecto_activo'] == 'credivalores') { ?>
          <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/preexportainfojudicial/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Exportar Informe Judicial</span></a></li>
        <?php } ?>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/prememo/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Armar Memo</span></a></li>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/exportaestadoclientes/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Exportar Estado Clientes</span></a></li>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/preexportadetallellamadas/<?php echo $session['proyecto_activo']; ?>"><i class="icon icon-upload"></i><span class="list-label"> Exportar Detalle Llamadas</span></a></li>
      </ul>
    </li>
    <li><a href=""><i class="icon icon-users4"></i> <span>Usuarios</span></a>
      <ul>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/user-list"><i class="icon icon-users4"></i> <span>Listado de Usuarios</span></a></li>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/add-user"><i class="icon icon-user-plus"></i> <span>Agregar de Usuarios</span></a></li>
      </ul>
    </li>
    <li><a href=""><i class="icon icon-upload"></i><span>Informes</span></a>
      <ul>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/informeprodc/h"><i class="icon icon-upload"></i><span class="list-label"> Informe Productividad</span></a></li>
      </ul>
    </li>

    <li><a href=""><i class="icon icon-upload"></i><span>SMS</span></a>
      <ul>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/sms/campana"><i class="icon icon-txt"></i><span class="list-label"> Campa&ntilde;as</span></a></li>
      </ul>
    </li>
    <li><a href=""><i class="icon icon-design"></i><span>Herramietas Masivas</span></a>
      <ul>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/herramientas/sms2"><i class="icon icon-txt"></i><span class="list-label"> SMS</span></a></li>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/herramientas/mail"><i class="icon icon-txt"></i><span class="list-label"> Mail</span></a></li>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/herramientas/avirtual"><i class="icon icon-txt"></i><span class="list-label"> Agente Virtual</span></a></li>
      </ul>
    </li>
    <li><a href=""><i class="icon icon-phone"></i><span>Predictivo</span></a>
      <ul>
        <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/operativo/fechaPredictivo"><i class="icon icon-upload"></i><span class="list-label"> Cargar Gestión</span></a></li>
      </ul>
    </li>




  <?php } ?>

  <!--<li><a href="#"><i class="icon-cart2"></i> <span>E-commerce</span></a>
  <ul>
  <li><a href="ecom_products.php">Products</a></li>
  <li><a href="ecom_product.php">Single product</a></li>
  <li><a href="ecom_orders.php">Orders list</a></li>
  <li><a href="ecom_cart.php">My Cart</a></li>
  <li><a href="ecom_checkout.php">Checkout</a></li>
</ul>
</li>-->

<li class="list-title">Proyectos</li>
<?php
foreach ($carteras as $car) {
  $prUno = $ci2->vista->getProyectData($car);
  ?>
  <li><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/setpractivo/<?php echo $prUno[0]['descripcion']; ?>"><i class="icon icon-arrow-right15"></i> <span><?php echo $prUno[0]['descripcion']; ?></span></a></li>
<?php } ?>
<!--<li><a href="messages.php"><i class="icon-comment-discussion"></i> <span>Messages</span></a></li>
<li><a href="emails.php"><i class="icon-envelop"></i> <span>Emails</span></a></li>
<li><a href="#"><i class="icon-briefcase"></i> <span>Projects</span></a>
<ul>
<li><a href="projects_list.php">Projects list</a></li>
<li><a href="projects_details.php">Project details</a></li>
</ul>
</li>
<li>
<a href="#"><i class="icon-cash3"></i> <span>Invoice</span></a>
<ul>
<li><a href="invoice_list.php">Invoice list</a></li>
<li><a href="invoice_template.php">Invoice template</a></li>
</ul>
</li>-->
</ul>

<script>
if ($.fn.navAccordion) {
  $('.sidebar-accordion').each(function () {
    $(this).navAccordion({
      eventType: 'click',
      hoverDelay: 100,
      autoClose: true,
      saveState: false,
      disableLink: true,
      speed: 'fast',
      showCount: false,
      autoExpand: true,
      classExpand: 'acc-current-parent'
    });
  });
}


var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);

$(".sidebar ul.sidebar-accordion li a").each(function () {
  if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
  {
    $(this).addClass(" active");
    $(this).parent().parent().css("display", "block");
    $(this).parent().parent().parent().addClass(" active");
    $(this).parent().parent().parent().parent().css("display", "block");
    $(this).parent().parent().parent().parent().parent().addClass(" active");
  }
})

$(".leftmenu ul.sidebar-accordion li a").each(function () {
  if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
  {
    $(this).addClass(" active");
    $(this).parent().parent().css("display", "block");
    $(this).parent().parent().parent().addClass(" active");
    $(this).parent().parent().parent().parent().css("display", "block");
    $(this).parent().parent().parent().parent().parent().addClass(" active");
  }
})

</script>
