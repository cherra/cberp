<?php
/**
 * Description of rutas
 *
 * @author cherra
 */
class Rutas_cobranza extends CI_Controller {
    
    private $folder = 'catalogos/';
    private $clase = 'rutas_cobranza/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function rutas( $offset = 0 ){
        $this->load->model('catalogos/ruta_cobranza','r');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Rutas de cobranza <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'rutas_agregar';
    	$data['action'] = $this->folder.$this->clase.'rutas';
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->r->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'rutas');
    	$config['total_rows'] = $this->r->count_all($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', '');
    	foreach ($datos as $d) {
            $this->table->add_row(
                    $d->descripcion,
                    anchor($this->folder.$this->clase.'rutas_ver/' . $d->id_ruta_cobranza, '<span class="'.$this->config->item('icono_editar').'"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar una ruta
     */
    public function rutas_agregar() {
        $this->load->model('catalogos/ruta_cobranza','r');
        
    	$data['titulo'] = 'Rutas de cobranza <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'rutas';
    
    	$data['action'] = $this->folder.$this->clase.'rutas_agregar';
    	if ( ($datos = $this->input->post()) ) {
    		if( ($id = $this->r->save($datos)) ){
                    $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                    redirect($this->folder.$this->clase.'rutas_ver/'.$id);
                }else{
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
                    redirect($this->folder.$this->clase.'rutas_agregar');
                }
    	}
        $this->load->view('catalogos/rutas_cobranza/formulario', $data);
    }
    
    
    /*
     * Vista previa de la linea
     */
    public function rutas_ver( $id = NULL ) {
        $this->load->model('catalogos/ruta_cobranza','r');
        
        $ruta = $this->r->get_by_id($id);
        if ( empty($id) OR $ruta->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'rutas');
    	}
    	
    	$data['titulo'] = 'Rutas de cobranza <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'rutas';
        
    	$data['action'] = $this->folder.$this->clase.'rutas_editar/' . $id;

    	$data['datos'] = $ruta->row();
        
        $this->load->view('catalogos/rutas_cobranza/vista', $data);
    }
    
    /*
     * Editar una linea
     */
    public function rutas_editar( $id = NULL ) {
        $this->load->model('catalogos/ruta_cobranza','r');
        
        $ruta = $this->r->get_by_id($id);
        if ( empty($id) OR $ruta->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'rutas');
    	}
    	
    	$data['titulo'] = 'Rutas de cobranza <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'rutas_ver/'.$id;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'rutas_editar/' . $id;
    	 
    	if ( ($datos = $this->input->post()) ) {
    		$this->r->update($id, $datos);
                $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
                redirect($this->folder.$this->clase.'rutas_ver/'.$id);
    	}

    	$data['datos'] = $this->r->get_by_id($id)->row();
        
        $this->load->view('catalogos/rutas_cobranza/formulario', $data);
    }
}
?>
