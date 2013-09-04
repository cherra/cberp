<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->config->item('nombre_proyecto'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <!-- css -------------------------------------------------------------------- -->
    <link href="<?php echo asset_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
   
  <!-- js ---------------------------------------------------------------------- -->
    <script src="<?php echo asset_url(); ?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url(); ?>bootstrap/js/bootstrap.min.js"></script>
   
</head>
<body>

<!-- menu-top ---------------------------------------------------------------- -->
<nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <?php echo anchor(site_url(), $this->config->item('nombre_proyecto'), 'class="navbar-brand"'); ?>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <p class="navbar-text pull-right hidden-phone">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-user"></span> <?php echo $this->session->userdata('nombre'); ?> <?php echo anchor('login/do_logout','(Salir)','class="navbar-link"'); ?>
    </p>
    <ul class="nav navbar-nav">
    <?php
        // Se obtienen los folders de los métodos para mostrarlos en la barra superior.
        $folders = $this->menu->get_folders();
        foreach($folders as $folder){ ?>
        <li <?php 
        // Si el primer segmento del URI es igual al folder quiere decir que es la opción seleccionada
        // y se marca como activa para resaltarla
        if( $this->uri->segment(1) == $folder->folder){
            echo 'class="active"'; 
        }
        ?>><?php 
        echo anchor($folder->folder.'/'.$folder->folder, ucfirst(strtolower($folder->folder)), 'class="navbar-link"'); ?></li>
        <?php } ?>
      <li><a href="#">Dashboard</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="#">Nuevo</a></li>
          <li><a href="#">Listado</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Informes<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="#">Eventos</a></li>
          <li><a href="#">Reportes</a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>

<!-- contenido --------------------------------------------------------------- -->
{contenido_vista}

</body>
</html>
