<?php

/*
|--------------------------------------------------------------------------
| Nombre del proyecto
|--------------------------------------------------------------------------
|
*/
$config['nombre_proyecto'] = 'ERP Becerra';

/*
|--------------------------------------------------------------------------
| Variable Super Usuario
|--------------------------------------------------------------------------
| Variable para ignorar el modulo de privilegios de usuario
|
*/
$config['developer_mode'] = 1;

/*
|--------------------------------------------------------------------------
| Fechas en español
|--------------------------------------------------------------------------
|
*/
$config['dias'] = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
$config['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

/*
|--------------------------------------------------------------------------
| Assets path
|--------------------------------------------------------------------------
|
| Ruta logica de los archivos que se utilizan en el lado del cliente, y se
| utiliza para el helper asset_url(), helpers/path_helper.php 
|
*/
$config['asset_path'] = 'assets/';

/*
|--------------------------------------------------------------------------
| Estilo CSS el HTML Tag <table>
|--------------------------------------------------------------------------
|
| Definicion de las clases CSS de Bootstrap para las tablas
|
*/
$config['tabla_css'] = 'table table-condensed table-striped';

/*
 * Mensajes
 */
$config['update_success'] = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Registro modificado con éxito</div>';
$config['create_success'] = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Registro creado con éxito</div>';
$config['error'] = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>¡Ocurrió un error!</div>';

?>