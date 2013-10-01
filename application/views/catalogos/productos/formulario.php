<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
    </div>
</div>

<div class="row-fluid">
    <p><?php echo $link_back; ?></p>
        <?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
            <div class="form-group">
                <label class="col-md-2 hidden-xs" for="nombre">Nombre</label>
                <div class="col-md-4">
                    <input type="text" id="nombre" name="nombre" class="form-control required" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>" placeholder="Nombre">
                </div>
            </div>
            <?php if(isset($lineas)){ ?>
            <div class="form-group">
                <label class="col-md-2 hidden-xs" for="id_linea">Linea</label>
                <div class="col-md-4">
                    <select name="id_linea" class="form-control required">
                        <option value="">Selecciona una linea...</option>
                        <?php foreach($lineas as $linea){ ?>
                        <option value="<?php echo $linea->id_linea; ?>" <?php if(isset($datos) && $datos->id_linea == $linea->id_linea) echo "selected"; ?>><?php echo $linea->nombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php } ?>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-4">
                    <button type="submit" id="guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>