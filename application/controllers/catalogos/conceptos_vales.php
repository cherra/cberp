<?php

/**
 * Description of vales
 *
 * @author cherra
 */
class Conceptos_vales extends CI_Controller {
    
    private $folder = 'catalogos/';
    private $clase = 'conceptos_vales/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function vales( $offset = 0 ){
        $this->load->model('catalogos/vale','v');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Conceptos de vales <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'vales_agregar/'.$offset;
    	$data['action'] = $this->folder.$this->clase.'vales/'.$offset;
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->v->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'vales');
    	$config['total_rows'] = $this->v->count_all($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Descripción', 'Código de barras', 'Tipo', '');
    	foreach ($datos as $d) {
            $this->table->add_row(
                    $d->concepto,
                    $d->codigo_barras,
                    $d->tipo,
                    anchor($this->folder.$this->clase.'vales_ver/' . $d->id_concepto.'/'.$offset, '<span class="'.$this->config->item('icono_editar').'"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar una concepto
     */
    public function vales_agregar( $offset = 0 ) {
        $this->load->model('catalogos/vale','v');
        
    	$data['titulo'] = 'Conceptos de vales <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'vales/'.$offset;
    
    	$data['action'] = $this->folder.$this->clase.'vales_agregar/'.$offset;
    	if ( ($datos = $this->input->post()) ) {
    		if( ($id = $this->v->save($datos)) ){
                    $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                    redirect($this->folder.$this->clase.'vales_ver/'.$id.'/'.$offset);
                }else{
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
                    redirect($this->folder.$this->clase.'vales_agregar/'.$offset);
                }
    	}
        $this->load->view('catalogos/vales/formulario', $data);
    }
    
    
    /*
     * Vista previa del concepto
     */
    public function vales_ver( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/vale','v');
        
        $vale = $this->v->get_by_id($id);
        if ( empty($id) OR $vale->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'vales');
    	}
    	
    	$data['titulo'] = 'Conceptos de vales <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'vales/'.$offset;
        
    	$data['action'] = $this->folder.$this->clase.'vales_editar/' . $id .'/'.$offset;

    	$data['datos'] = $vale->row();
        
        $this->load->view('catalogos/vales/vista', $data);
    }
    
    /*
     * Editar un concepto
     */
    public function vales_editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/vale','v');
        
        $vale = $this->v->get_by_id($id);
        if ( empty($id) OR $vale->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'vales');
    	}
    	
    	$data['titulo'] = 'Conceptos de vales <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'vales_ver/'.$id.'/'.$offset;
    	$data['action'] = $this->folder.$this->clase.'vales_editar/' . $id.'/'.$offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            if(empty($datos['codigo_barras']))
                $datos['codigo_barras'] = 'n';
            $this->v->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'vales_ver/'.$id.'/'.$offset);
    	}

    	$data['datos'] = $this->v->get_by_id($id)->row();
        
        $this->load->view('catalogos/vales/formulario', $data);
    }
}
?>
