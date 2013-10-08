<?php

/**
 * Description of producto
 *
 * @author cherra
 */
class Producto extends CI_Model {
    
    private $tbl = 'Producto';
    
    /*
     * Cuenta todos los registros utilizando un filtro de busqueda
     */
    function count_all( $filtro = NULL ) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('p.nombre',$f);
                $this->db->or_like('l.nombre',$f);
            }
        }
        $this->db->join('Linea l','p.id_linea = l.id_linea');
        $query = $this->db->get($this->tbl.' p');
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('id_linea, nombre','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL) {
        $this->db->select('p.*');
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('p.nombre',$f);
                $this->db->or_like('l.nombre',$f);
            }
        }
        $this->db->join('Linea l','p.id_linea = l.id_linea');
        $this->db->order_by('p.nombre','asc');
        return $this->db->get($this->tbl.' p', $limit, $offset);
    }
    
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_producto', $id);
        return $this->db->get($this->tbl);
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
        $this->db->where('id_producto', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_producto', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
