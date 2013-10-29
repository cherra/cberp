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
        <label class="col-sm-2" for="nombre">Nombre</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" id="nombre" name="nombre" class="form-control required" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>" placeholder="Nombre">
        </div>
    </div>
    <?php if(isset($lineas)){ ?>
    <div class="form-group">
        <label class="col-sm-2" for="id_linea">Linea</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="id_linea" class="form-control required">
                <option value="">Selecciona una linea...</option>
                <?php foreach($lineas as $linea){ ?>
                <option value="<?php echo $linea->id_linea; ?>" <?php if(isset($datos) && $datos->id_linea == $linea->id_linea) echo "selected"; ?>><?php echo $linea->nombre; ?></option>
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