<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
    </div>
</div>

<div class="row-fluid">
<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <label class="col-sm-2 col-lg-1" for="nombre">Nombre</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="text" id="nombre" name="nombre" class="form-control required" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>" placeholder="Nombre">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 col-lg-1" for="icon">Ícono</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="text" id="icon" name="icon" class="form-control" value="<?php echo (isset($datos->icon) ? $datos->icon : ''); ?>" placeholder="Ícono">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 col-lg-1" for="menu">Menú</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="checkbox" id="menu" name="menu" value="1" <?php 
            if(isset($datos->menu)){
                echo $datos->menu == 1 ? 'checked' : ''; 
            }
            ?>>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6 col-sm-offset-2 col-lg-offset-1 col-sm-3 col-md-2 col-lg-1">
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