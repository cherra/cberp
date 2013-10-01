<?php
/**
 * Description of descuento
 *
 * @author cherra
 */
class Descuento extends CI_Model {
    
    private $tbl = 'Tarjeta_Cliente';
    
    /*
     * Cuenta todos los registros utilizando un filtro de busqueda
     */
    function count_all( $filtro = NULL ) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_tarjeta_cliente',$f);
            }
        }
        $query = $this->db->get($this->tbl);
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('id_tarjeta_cliente','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_tarjeta_cliente',$f);
            }
        }
        $this->db->order_by('id_tarjeta_cliente','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_tarjeta_cliente', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_cliente($id) {
        $this->db->where('id_cliente', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_articulo($id) {
        $this->db->where('id_articulo', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_cliente_articulo($id_cliente, $id_articulo) {
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('id_articulo', $id_articulo);
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
        $this->db->where('id_tarjeta_cliente', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_tarjeta_cliente', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
