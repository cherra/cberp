
<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <div class="col-xs-6">
            <p><?php echo anchor($link_back,'<span class="glyphicon glyphicon-chevron-left"></span> Regresar',array('class'=>'')); ?></p>
        </div>
        <div class="col-xs-6">
            <button type="submit" id="editar" class="btn btn-warning pull-right">Editar</button>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3">Nombre</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3">Código</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->codigo) ? $datos->codigo : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3" for="inventariado">Control de inventario</label>
        <div class="col-sm-6 col-md-4">
            <input type="checkbox" name="inventariado" disabled <?php 
            if(isset($datos->inventariado)){
                echo $datos->inventariado == 's' ? 'checked' : ''; 
            }
            ?>>
        </div>
    </div>
    <?php if(isset($producto)){ ?>
    <div class="form-group">
        <label class="col-sm-3">Producto</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo $producto->nombre; ?></p>
        </div>
    </div>
    
    <?php } ?>
<?php echo form_close(); ?>
