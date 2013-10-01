<?php
/**
 * Description of precio
 *
 * @author cherra
 */
class Precio extends CI_Model {
    
    private $tbl = 'Articulo_Lista';
    
    function get_precio($id_articulo, $id_lista){
        return $this->db->get_where($this->tbl,array('id_articulo' => $id_articulo, 'id_lista' => $id_lista),1);
    }
    
    /*
     * Cuenta todos los registros utilizando un filtro de busqueda
     */
    function count_all( $filtro = NULL ) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_articulo_lista',$f);
            }
        }
        $query = $this->db->get($this->tbl);
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('id_articulo_lista','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_articulo_lista',$f);
            }
        }
        $this->db->order_by('id_articulo_lista','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_articulo_lista', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_articulo($id) {
        $this->db->where('id_articulo', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_lista($id) {
        $this->db->where('id_lista', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_articulo_lista($id_articulo, $id_lista) {
        $this->db->where('id_articulo', $id_articulo);
        $this->db->where('id_lista', $id_lista);
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
        $this->db->where('id_articulo_lista', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_articulo_lista', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
