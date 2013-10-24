<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
    </div>
</div>

<div class="row-fluid">
<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <label class="col-sm-2" for="nombre">Nombre</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="text" id="nombre" name="nombre" class="form-control required" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>" placeholder="Nombre">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="apellido">Apellidos</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="text" name="apellido" class="form-control required" value="<?php echo (isset($datos->apellido) ? $datos->apellido : ''); ?>" placeholder="Apellidos">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="username">Nombre de usuario</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="text" name="username" class="form-control" value="<?php echo (isset($datos->username) ? $datos->username : ''); ?>" placeholder="Nombre de usuario">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="password">Contraseña</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="confirmar_password">Confirmar contraseña</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="password" id="confirmar_password" name="confirmar_password" class="form-control" placeholder="Confirmar contraseña">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="activo">Activo?</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="checkbox" name="activo" value="s" <?php 
            if(isset($datos->activo)){
                echo $datos->activo == 's' ? 'checked' : ''; 
            }
            ?>>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6 col-sm-offset-2 col-sm-3 col-md-2 col-lg-1">
            <?php echo anchor($link_back,'Regresar',array('class'=>'btn btn-default btn-block')); ?>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-2 col-lg-1">
            <button type="submit" id="guardar" class="btn btn-primary btn-block">Guardar</button>
        </div>
    </div>
<?php echo form_close(); ?>
</div>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>