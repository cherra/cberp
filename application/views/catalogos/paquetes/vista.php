<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <div class="col-xs-6">
            <?php echo anchor($link_back,'<span class="'.$this->config->item('icono_regresar').'"></span> Regresar'); ?>
        </div>
        <div class="col-xs-6">
            <button type="submit" id="guardar" class="btn btn-warning pull-right"><span class="<?php echo $this->config->item('icono_editar'); ?>"></span> Editar</button>
        </div>
    </div>
    <?php if(isset($paquete)){ ?>
    <div class="form-group">
        <label class="col-sm-3" for="id_articulo">Paquete</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo $paquete->nombre; ?></p>
        </div>
    </div>
    <?php } ?>
<?php echo form_close(); ?>
<div class="row">
    <div class="col-sm-12">
        <?php echo $table; ?>
    </div>
</div>

<script type="text/javascript">
    
$(function () {
   
    $('#id_articulo_paquete').focus();
    
    $('#id_articulo_paquete').change(function(){
        $('#cantidad').removeAttr('disabled').focus();
    });
});

</script>