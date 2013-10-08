<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
    </div>
</div>

<div class="row-fluid">
        <?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
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
            <div class="form-group">
                <div class="col-xs-6 col-sm-offset-2 col-sm-4 col-md-3 col-lg-2">
                    <?php echo anchor($link_back,'Regresar',array('class'=>'btn btn-default btn-block')); ?>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <button type="submit" id="editar" class="btn btn-warning btn-block">Editar</button>
                </div>
            </div>
        <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>