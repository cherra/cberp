<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo anchor($link_back,'<span class="'.$this->config->item('icono_regresar').'"></span> Regresar'); ?>
        </div>
        <div class="col-xs-6">
            <button type="submit" id="aceptar" class="btn btn-primary pull-right"><span class="<?php echo $this->config->item('icono_aceptar'); ?>"></span> Aceptar</button>
        </div>
    </div>
    <?php if(isset($presentaciones)){ ?>
    <div class="form-group">
        <label class="col-sm-3" for="id_articulo">Paquete</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select id="id_articulo" name="id_articulo" class="form-control required">
                <option value="">Selecciona una presentación...</option>
                <?php foreach($presentaciones as $presentacion){ ?>
                <option value="<?php echo $presentacion->id_articulo; ?>" <?php if(isset($datos) && $datos->id_articulo == $presentacion->id_articulo) echo "selected"; ?>><?php echo $presentacion->nombre; ?></option>
                <?php } ?>
            </select>
            <span class="help-block">Presentación que va a venderse como paquete.</span>
        </div>
    </div>
    <?php } ?>
    
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#id_articulo').focus();
    
    $('#aceptar').click(function(event){
        event.preventDefault();
        
        window.location = "<?php echo site_url($action); ?>/" + $('#id_articulo option:selected').val();
    });
    
});

</script>