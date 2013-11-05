<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo anchor($link_back,'<span class="'.$this->config->item('icono_regresar').'"></span> Regresar'); ?>
        </div>
        <div class="col-xs-6">
            <button type="submit" id="guardar" class="btn btn-primary pull-right"><span class="<?php echo $this->config->item('icono_guardar'); ?>"></span> Guardar</button>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="concepto_pago">Descripción</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" id="concepto_pago" name="concepto_pago" class="form-control required" value="<?php echo (isset($datos->concepto_pago) ? $datos->concepto_pago : ''); ?>" placeholder="Descripción">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="observaciones">Observaciones</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" name="observaciones" class="form-control required" value="<?php echo (isset($datos->observaciones) ? $datos->observaciones : ''); ?>" placeholder="Observaciones">
        </div>
    </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#concepto_pago').focus();
    
});

</script>