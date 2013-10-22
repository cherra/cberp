<div class="page-header">
    <h2><?php echo $titulo; ?></h2>
</div>
<?php echo form_open($action, array('class' => 'form-inline', 'name' => 'form', 'id' => 'form', 'role' => 'form')) ?>
    <div class="form-group">
        <label class="sr-only" for="filtro">Filtros</label>
        <input type="text" class="form-control" name="filtro" id="filtro" placeholder="Filtros de busqueda" value="<?php if(isset($filtro)) echo $filtro; ?>" >
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
<?php echo form_close(); ?>
<div class="row">
    <div class="col-xs-12 col-sm-9 col-md-10">
        <?php echo $pagination; ?>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-2">
        <p class="text-right"><?php echo anchor($link_add,'<span class="glyphicon glyphicon-plus"></span> Nuevo', array('class' => 'btn btn-default btn-block')); ?></p>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div><?php echo $table; ?></div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#filtro').focus();
});
</script>