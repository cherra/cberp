<?php

/**
 * Description of concepto_pago
 *
 * @author cherra
 */
class Concepto_pago extends CI_Model {
    
    private $tbl = 'ConceptoPago';
    
    /*
     * Cuenta todos los registros utilizando un filtro de busqueda
     */
    function count_all( $filtro = NULL ) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('concepto_pago',$f);
            }
        }
        $query = $this->db->get($this->tbl);
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('concepto_pago','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('concepto_pago',$f);
            }
        }
        $this->db->order_by('concepto_pago','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_concepto_pago', $id);
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
        $this->db->where('id_concepto_pago', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_concepto_pago', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
