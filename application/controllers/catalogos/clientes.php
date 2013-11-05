<?php

/**
 * Description of clientes
 *
 * @author cherra
 */
class Clientes extends CI_Controller {
    
    private $folder = 'catalogos/';
    private $clase = 'clientes/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function cliente( $offset = 0 ){
        $this->load->model('catalogos/cliente','c');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Clientes <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'cliente_agregar/'.$offset;
    	$data['action'] = $this->folder.$this->clase.'cliente';
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->c->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'cliente');
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
    	$this->table->set_heading('Núm.','Nombre', 'Teléfono', 'Forma de pago', '');
    	foreach ($datos as $d) {
            $this->table->add_row(
                    $d->id_cliente,
                    $d->nombre,
                    $d->telefono,
                    $d->tipo_pago,
                    anchor($this->folder.$this->clase.'cliente_ver/' . $d->id_cliente . '/' . $offset, '<span class="'.$this->config->item('icono_editar').'"></span>'),
                    anchor($this->folder.$this->clase.'cliente_credito_ver/' . $d->id_cliente . '/' . $offset, '<span class="glyphicon glyphicon-pencil"></span>','title="Crédito"')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar un cliente
     */
    public function cliente_agregar( $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/lista','l');
        
    	$data['titulo'] = 'Clientes <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'cliente/'.$offset;
    
    	$data['action'] = $this->folder.$this->clase.'cliente_agregar/'.$offset;
    	if ( ($datos = $this->input->post()) ) {
            if(strlen($datos['rfc']) > 0)
                $datos['tipo_impresion'] = 'factura';
            if( ($id = $this->c->save($datos)) ){
                $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                redirect($this->folder.$this->clase.'cliente_ver/'.$id.'/'.$offset);
            }else{
                $this->session->set_flashdata('mensaje',$this->config->item('error'));
                redirect($this->folder.$this->clase.'cliente_agregar/'.$offset);
            }
    	}
        
        $data['listas'] = $this->l->get_all()->result();
        $this->load->view('catalogos/clientes/formulario', $data);
    }
    
    
    /*
     * Vista previa del cliente
     */
    public function cliente_ver( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/lista','l');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'cliente');
    	}
    	
    	$data['titulo'] = 'Clientes <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'cliente/' . $offset;
        
    	$data['action'] = $this->folder.$this->clase.'cliente_editar/' . $id . '/' . $offset;

    	$data['datos'] = $cliente->row();
        $data['lista'] = $this->l->get_by_id($data['datos']->id_lista)->row();
        
        $this->load->view('catalogos/clientes/vista', $data);
    }
    
    /*
     * Editar un cliente
     */
    public function cliente_editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/lista','l');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'cliente');
    	}
    	
    	$data['titulo'] = 'Clientes <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'cliente_ver/'.$id . '/' . $offset;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'cliente_editar/' . $id . '/' . $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            if(strlen($datos['rfc']) > 0)
                $datos['tipo_impresion'] = 'factura';
            $this->c->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'cliente_ver/'.$id . '/' . $offset);
    	}

        $data['listas'] = $this->l->get_all()->result();
    	$data['datos'] = $this->c->get_by_id($id)->row();
        
        $this->load->view('catalogos/clientes/formulario', $data);
    }
    
    /*
     * Vista previa datos de crédito
     */
    public function cliente_credito_ver( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/ruta_cobranza','r');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'cliente/' . $offset);
    	}
    	
    	$data['titulo'] = 'Clientes <small>Datos de crédito</small>';
    	$data['link_back'] = $this->folder.$this->clase.'cliente/'. $offset;
        
    	$data['action'] = $this->folder.$this->clase.'cliente_credito_editar/' . $id . '/' . $offset;

    	$data['datos'] = $cliente->row();
        $data['ruta_cobranza'] = $this->r->get_by_id($data['datos']->id_ruta_cobranza)->row();
        
        $this->load->view('catalogos/clientes/vista_credito', $data);
    }
    
    /*
     * Editar datos de crédito
     */
    public function cliente_credito_editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/ruta_cobranza','r');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'cliente');
    	}
    	
    	$data['titulo'] = 'Clientes <small>Editar datos de crédito</small>';
    	$data['link_back'] = $this->folder.$this->clase.'cliente_credito_ver/'.$id . '/' . $offset;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'cliente_credito_editar/' . $id . '/' . $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            if(empty($datos['lun']))
                $datos['lun'] = 'n';
            if(empty($datos['mar']))
                $datos['mar'] = 'n';
            if(empty($datos['mie']))
                $datos['mie'] = 'n';
            if(empty($datos['jue']))
                $datos['jue'] = 'n';
            if(empty($datos['c']))
                $datos['vie'] = 'n';
            if(empty($datos['sab']))
                $datos['sab'] = 'n';
            if(empty($datos['dom']))
                $datos['dom'] = 'n';
            if(empty($datos['deudor']))
                $datos['deudor'] = 'n';
            $this->c->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'cliente_credito_ver/'.$id . '/' . $offset);
    	}

    	$data['datos'] = $this->c->get_by_id($id)->row();
        $data['rutas'] = $this->r->get_all()->result();
        
        $this->load->view('catalogos/clientes/formulario_credito', $data);
    }
}
?>
