
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
        <label class="col-sm-2" for="nombre">Nombre</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?></p>
        </div>
    </div>
    <?php if(isset($linea)){ ?>
    <div class="form-group">
        <label class="col-sm-2" for="id_linea">Linea</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($linea) ? $linea->nombre : ''); ?></p>
        </div>
    </div>
    
    <?php } ?>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>