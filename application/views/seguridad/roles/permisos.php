<div class="row-fluid">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
    </div>
</div>

<div class="row-fluid">
<?php echo form_open($action, array('class' => 'form-horizontal', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <label class="col-sm-2 col-lg-1" for="nombre">Nombre</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <p><?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 col-lg-1" for="menu">Marcar todos</label>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="checkbox" id="marcar_todos">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
        <?php
        echo $table;
        ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6 col-sm-offset-6 col-sm-3 col-md-offset-8 col-md-2">
            <?php echo anchor($link_back,'Regresar',array('class'=>'btn btn-default btn-block')); ?>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-2">
            <button type="submit" id="guardar" class="btn btn-primary btn-block">Guardar</button>
        </div>
    </div>
<?php echo form_close(); ?>
</div>
<script>
    $(document).ready(function(){
        $('#marcar_todos').change(function(){
            if($(this).is(':checked')){
                $('table input[type="checkbox"]').attr('checked','checked');
            }
        });
    });
</script>