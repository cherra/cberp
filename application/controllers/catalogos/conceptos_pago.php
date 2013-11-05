<?php
/**
 * Description of conceptos_pago
 *
 * @author cherra
 */
class Conceptos_pago extends CI_Controller {
    
    private $folder = 'catalogos/';
    private $clase = 'conceptos_pago/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function conceptos( $offset = 0 ){
        $this->load->model('catalogos/concepto_pago','c');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Conceptos de pago <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'conceptos_agregar';
    	$data['action'] = $this->folder.$this->clase.'conceptos';
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->c->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'conceptos');
    	$config['total_rows'] = $this->c->count_all($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', 'Observaciones', '');
    	foreach ($datos as $d) {
            $this->table->add_row(
                    $d->concepto_pago,
                    $d->observaciones,
                    anchor($this->folder.$this->clase.'conceptos_ver/' . $d->id_concepto_pago, '<span class="'.$this->config->item('icono_editar').'"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar una concepto
     */
    public function conceptos_agregar() {
        $this->load->model('catalogos/concepto_pago','c');
        
    	$data['titulo'] = 'Rutas de cobranza <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'conceptos';
    
    	$data['action'] = $this->folder.$this->clase.'conceptos_agregar';
    	if ( ($datos = $this->input->post()) ) {
    		if( ($id = $this->c->save($datos)) ){
                    $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                    redirect($this->folder.$this->clase.'conceptos_ver/'.$id);
                }else{
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
                    redirect($this->folder.$this->clase.'conceptos_agregar');
                }
    	}
        $this->load->view('catalogos/conceptos_pago/formulario', $data);
    }
    
    
    /*
     * Vista previa del concepto
     */
    public function conceptos_ver( $id = NULL ) {
        $this->load->model('catalogos/concepto_pago','c');
        
        $concepto = $this->c->get_by_id($id);
        if ( empty($id) OR $concepto->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'conceptos');
    	}
    	
    	$data['titulo'] = 'Concetos de pago <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'conceptos';
        
    	$data['action'] = $this->folder.$this->clase.'conceptos_editar/' . $id;

    	$data['datos'] = $concepto->row();
        
        $this->load->view('catalogos/conceptos_pago/vista', $data);
    }
    
    /*
     * Editar un concepto
     */
    public function conceptos_editar( $id = NULL ) {
        $this->load->model('catalogos/concepto_pago','c');
        
        $concepto = $this->c->get_by_id($id);
        if ( empty($id) OR $concepto->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'conceptos');
    	}
    	
    	$data['titulo'] = 'Conceptos de pago <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'conceptos_ver/'.$id;
    	$data['action'] = $this->folder.$this->clase.'conceptos_editar/' . $id;
    	 
    	if ( ($datos = $this->input->post()) ) {
    		$this->c->update($id, $datos);
                $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
                redirect($this->folder.$this->clase.'conceptos_ver/'.$id);
    	}

    	$data['datos'] = $this->c->get_by_id($id)->row();
        
        $this->load->view('catalogos/conceptos_pago/formulario', $data);
    }
}
?>
