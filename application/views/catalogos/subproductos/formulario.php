<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo anchor($link_back,'<span class="glyphicon glyphicon-chevron-left"></span> Regresar',array('class'=>'')); ?>
        </div>
        <div class="col-xs-6">
            <button type="submit" id="guardar" class="btn btn-primary pull-right">Guardar</button>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="nombre">Nombre</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" id="nombre" name="nombre" class="form-control required" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>" placeholder="Nombre">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="codigo">Código</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="codigo" class="form-control number" value="<?php echo (isset($datos->codigo) ? $datos->codigo : ''); ?>" placeholder="Código">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="inventariado">Control de inventario</label>
        <div class="col-sm-6 col-md-4">
            <input type="checkbox" id="menu" name="inventariado" value="s" <?php 
            if(isset($datos->inventariado)){
                echo $datos->inventariado == 's' ? 'checked' : ''; 
            }
            ?>>
        </div>
    </div>
    <?php if(isset($productos)){ ?>
    <div class="form-group">
        <label class="col-sm-3" for="id_producto">Producto</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="id_producto" class="form-control required">
                <option value="">Selecciona un producto...</option>
                <?php foreach($productos as $producto){ ?>
                <option value="<?php echo $producto->id_producto; ?>" <?php if(isset($datos) && $datos->id_producto == $producto->id_producto) echo "selected"; ?>><?php echo $producto->nombre; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <?php } ?>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>