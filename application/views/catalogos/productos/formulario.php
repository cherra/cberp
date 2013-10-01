<div class="row">
    <div class="page-header">
        <h2><?php echo $titulo; ?></h2>
        <?php echo $link_back; ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <form name="form" id="form" action="<?php echo $action; ?>" class="form-horizontal" method="post">
            <div class="form-group">
                <label class="hidden-xs" for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control required" value="<?php echo (isset($datos->nombre) ? $datos->nombre : ''); ?>" placeholder="Nombre">
            </div>
            <?php if(isset($lineas)){ ?>
            <div class="form-group">
                <label class="hidden-xs" for="id_linea">Linea</label>
                <select name="id_linea" class="form-control required">
                    <option value="0">Selecciona una linea...</option>
                    <?php foreach($lineas as $linea){ ?>
                    <option value="<?php echo $linea->id_linea; ?>"><?php echo $linea->nombre; ?></option>
                    <?php } ?>
                </select>
            </div>
            <?php } ?>
            <button type="submit" id="guardar" class="btn btn-primary">Guardar</button>
        </form>     
    </div>
</div>

<script type="text/javascript">
    
$(function () {
   
    $('#nombre').focus();
    
});

</script>