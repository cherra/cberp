<?php

/**
 * Description of presentacion
 *
 * @author cherra
 */
class Presentacion extends CI_Model {
    
    private $tbl = 'Articulo';
    
    /*
     * Cuenta todos los registros utilizando un filtro de busqueda
     */
    function count_all( $filtro = NULL ) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('a.nombre',$f);
                $this->db->or_like('sp.nombre',$f);
                $this->db->or_like('p.nombre',$f);
            }
        }
        $this->db->join('Subproducto sp', 'a.id_subproducto = sp.id_subproducto');
        $this->db->join('Producto p', 'sp.id_producto = p.id_producto');
        $query = $this->db->get($this->tbl.' a');
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('nombre','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL) {
        $this->db->select('a.*, CONCAT(sp.codigo,a.codigo) AS codigo', FALSE);
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('a.nombre',$f);
                $this->db->or_like('sp.nombre',$f);
                $this->db->or_like('p.nombre',$f);
            }
        }
        $this->db->join('Subproducto sp', 'a.id_subproducto = sp.id_subproducto');
        $this->db->join('Producto p', 'sp.id_producto = p.id_producto');
        $this->db->order_by('a.nombre','asc');
        return $this->db->get($this->tbl.' a', $limit, $offset);
    }
    
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_articulo', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_codigo($codigo) {
        $this->db->select('a.*');
        $this->db->where('CONCAT(sp.codigo,a.codigo)', $codigo);
        $this->db->join('Subproducto sp','a.id_subproducto = sp.id_subproducto');
        return $this->db->get($this->tbl.' a');
    }
    
    /**
    * Alta
    */
    function save( $datos ) {
        $this->db->insert($this->tbl, $datos);
        return $this->db->insert_id();
    }

    /**
    * Actualizar por id
    */
    function update($id, $datos) {
        $this->db->where('id_articulo', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_articulo', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
