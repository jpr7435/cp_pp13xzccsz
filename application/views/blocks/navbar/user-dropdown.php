<div class="user-icon text-center p-t-15">
    <!--<img src="http://via.placeholder.com/150x150" class="img-circle" alt=""/>-->
    <h5 class="text-center p-b-15 text-semibold">Hola! <?php echo $_SESSION['usuario']; ?></h5>
</div>
<ul class="user-links">
    <li><a href="user_profile_simple.php"><i class="icon-profile"></i> Mi Información</a></li>
    <li style="cursor: pointer;"><a href="#" id="setPausa"><i class="icon-lock5"></i> Pausas</a></li>
</ul>
<div class="text-center p-10"><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/logout" class="btn btn-block"><i class="icon-exit3 i-16 position-left"></i> Salir</a></div>
