<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->config->item('nombre_proyecto'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <!-- css -------------------------------------------------------------------- -->
    <link href="<?php echo asset_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="<?php echo asset_url(); ?>bootstrap/css/bootstrap-theme.min.css" rel="stylesheet"> -->
   
  <!-- js ---------------------------------------------------------------------- -->
    <script src="<?php echo asset_url(); ?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo asset_url(); ?>js/jquery.validate.js"></script>
    <script src="<?php echo asset_url(); ?>js/messages_es.js"></script>
    <style>
        body { 
            padding-top: 55px; 
/*            padding-bottom: 60px;*/
        }
        
        .sidebar-nav{
            margin-top: 10px;
            padding: 9px 0px;
        }
        
        .sidebar-nav .nav li{
            margin-left: 10px;
        }
        
        .page-header{
            margin: 0px 0 15px;
            padding-bottom: 5px;
        }
        
        .navbar-fixed-top{
            margin-bottom: 0px;
        }
        
        .pagination{
            margin: 10px 0;
        }
    </style>
</head>
<body>

<!-- menu-top ---------------------------------------------------------------- -->
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container-fluid">
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
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Mi cuenta<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Mis datos</a></li>
                        <li><a href="#">Cambiar contraseña</a></li>
                        <li><?php echo anchor('login/do_logout','Salir','class="navbar-link"'); ?></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Configuración<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('seguridad/permisos_lista', 'Permisos'); ?></li>
                        <li><?php echo anchor('seguridad/roles_lista', 'Roles'); ?></li>
                        <li><?php echo anchor('seguridad/usuarios_lista', 'Usuarios'); ?></li>
                        <li class="divider"></li>
                        <li><?php echo anchor('preferencias/plantillas_lista', 'Plantillas de impresión'); ?></li>
                        <li><?php echo anchor('preferencias/configuracion_lista', 'Parámetros globales'); ?></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav">
            <?php
                // Se obtienen los folders de los métodos para mostrarlos en la barra superior.
                $folders = $this->menu->get_folders();
                $folder_activo = false;
                foreach($folders as $folder){ ?>
                <li <?php 
                // Si el primer segmento del URI es igual al folder quiere decir que es la opción seleccionada
                // y se marca como activa para resaltarla
                if( $this->uri->segment(1) == $folder->folder){
                    echo 'class="active"';
                    $folder_activo = $folder->folder;
                }
                ?>><?php 
                echo anchor($folder->folder.'/'.$folder->folder, ucfirst(strtolower($folder->folder)), 'class="navbar-link"'); ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<!--<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
  <button type="button" class="btn btn-default navbar-btn">Sign in</button>

</nav>-->

<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-sm-12">
<!-- contenido --------------------------------------------------------------- -->
{contenido_vista}
        </div>
        <div class="col-sm-offset-3 col-lg-offset-2 col-sm-3 col-lg-4">
                <p><?php if(isset($mensaje)) echo $mensaje ?></p>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('form').validate({
            rules: {
                confirmar_password: {
                    equalTo: "#password"
                }
            },
            highlight: function(element, errorClass) {
                $(element).fadeOut(function() {
                  $(element).fadeIn();
                });
            }
        });
    });
</script>
</body>
</html>
