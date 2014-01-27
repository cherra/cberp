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
        <label class="col-sm-2" for="cliente">Cliente</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <p class="form-control-static"><?php echo (isset($cliente) ? $cliente->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="id_articulo">Presentación</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <select name="id_articulo" class="form-control required">
                <option value="">Selecciona un artículo...</option>
                <?php
                if(isset($presentaciones)){
                    foreach($presentaciones as $presentacion){ ?>
                        <option value="<?php echo $presentacion->id_articulo; ?>" <?php if(isset($datos) && $datos->id_articulo == $presentacion->id_articulo) echo "selected"; ?>><?php echo $presentacion->nombre; ?></option>
                <?php    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2" for="descuento">Descuento</label>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <input type="text" id="descuento" name="descuento" class="form-control required" value="<?php echo (isset($datos->descuento) ? $datos->descuento : ''); ?>" placeholder="Descuento">
        </div>
    </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    
$(function () {
   
    $('#descuento').focus();
    
});

</script>