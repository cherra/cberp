<?php
/**
 * Description of paquete
 *
 * @author cherra
 */
class Paquete extends CI_Model {
    
    private $tbl = 'Paquete_Articulo';
    private $tbl_articulo = 'Articulo';
    
    /*
     * Cuenta todos los registros utilizando un filtro de busqueda
     */
    function count_all( $filtro = NULL ) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_paquete_articulo',$f);
            }
        }
        $this->db->join($this->tbl_articulo.' a', 'pa.id_articulo = a.id_articulo');
        $this->db->group_by('pa.id_articulo');
        $query = $this->db->get($this->tbl.' pa');
        return $query->num_rows();
    }
    
    /**
     *  Obtiene todos los registros de la tabla
     */
    function get_all() {
        $this->db->order_by('id_paquete_articulo','asc');
        return $this->db->get($this->tbl);
    }
    
    /**
    * Cantidad de registros por pagina
    */
    function get_paged_list($limit = NULL, $offset = 0, $filtro = NULL) {
        $this->db->select('a.*, COUNT(pa.id_articulo_paquete) AS articulos', FALSE);
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('id_paquete_articulo',$f);
            }
        }
        $this->db->join($this->tbl_articulo.' a', 'pa.id_articulo = a.id_articulo');
        $this->db->group_by('pa.id_articulo');
        $this->db->order_by('id_paquete_articulo','asc');
        return $this->db->get($this->tbl.' pa', $limit, $offset);
    }
    
    function get_presentaciones( $id_articulo ){
        $this->db->select('a.*, pa.*');
        $this->db->join($this->tbl_articulo.' a', 'pa.id_articulo_paquete = a.id_articulo');
        $this->db->where('pa.id_articulo', $id_articulo);
        $this->db->order_by('a.nombre');
        return $this->db->get($this->tbl.' pa');
    }
    /**
    * Obtener por id
    */
    function get_by_id($id) {
        $this->db->where('id_paquete_articulo', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_by_id_articulo($id) {
        $this->db->where('id_articulo', $id);
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
        $this->db->where('id_paquete_articulo', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * Eliminar por id
    */
    function delete($id) {
        $this->db->where('id_paquete_articulo', $id);
        $this->db->delete($this->tbl);
    } 
}
?>
