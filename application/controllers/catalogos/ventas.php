<?php

/**
 * Description of ventas
 *
 * @author cherra
 */
class Ventas extends CI_Controller {
    
    private $folder = 'catalogos/';
    private $clase = 'ventas/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function clientes( $offset = 0 ){
        $this->load->model('catalogos/cliente','c');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Clientes <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'clientes_agregar/'.$offset;
    	$data['action'] = $this->folder.$this->clase.'clientes';
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->c->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'clientes');
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
                    anchor($this->folder.$this->clase.'clientes_ver/' . $d->id_cliente . '/' . $offset, '<span class="'.$this->config->item('icono_editar').'"></span>'),
                    anchor($this->folder.$this->clase.'clientes_credito_ver/' . $d->id_cliente . '/' . $offset, '<span class="glyphicon glyphicon-pencil"></span>','title="Crédito"')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar un cliente
     */
    public function clientes_agregar( $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/lista','l');
        
    	$data['titulo'] = 'Clientes <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'clientes/'.$offset;
    
    	$data['action'] = $this->folder.$this->clase.'clientes_agregar/'.$offset;
    	if ( ($datos = $this->input->post()) ) {
            if(strlen($datos['rfc']) > 0)
                $datos['tipo_impresion'] = 'factura';
            if( ($id = $this->c->save($datos)) ){
                $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                redirect($this->folder.$this->clase.'clientes_ver/'.$id.'/'.$offset);
            }else{
                $this->session->set_flashdata('mensaje',$this->config->item('error'));
                redirect($this->folder.$this->clase.'clientes_agregar/'.$offset);
            }
    	}
        
        $data['listas'] = $this->l->get_all()->result();
        $this->load->view('catalogos/clientes/formulario', $data);
    }
    
    
    /*
     * Vista previa del cliente
     */
    public function clientes_ver( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/lista','l');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'clientes');
    	}
    	
    	$data['titulo'] = 'Clientes <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'clientes/' . $offset;
        
    	$data['action'] = $this->folder.$this->clase.'clientes_editar/' . $id . '/' . $offset;

    	$data['datos'] = $cliente->row();
        $data['lista'] = $this->l->get_by_id($data['datos']->id_lista)->row();
        
        $this->load->view('catalogos/clientes/vista', $data);
    }
    
    /*
     * Editar un cliente
     */
    public function clientes_editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/lista','l');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'clientes');
    	}
    	
    	$data['titulo'] = 'Clientes <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'clientes_ver/'.$id . '/' . $offset;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'clientes_editar/' . $id . '/' . $offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
            if(strlen($datos['rfc']) > 0)
                $datos['tipo_impresion'] = 'factura';
            $this->c->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            redirect($this->folder.$this->clase.'clientes_ver/'.$id . '/' . $offset);
    	}

        $data['listas'] = $this->l->get_all()->result();
    	$data['datos'] = $this->c->get_by_id($id)->row();
        
        $this->load->view('catalogos/clientes/formulario', $data);
    }
    
    /*
     * Vista previa datos de crédito
     */
    public function clientes_credito_ver( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/ruta_cobranza','r');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'clientes/' . $offset);
    	}
    	
    	$data['titulo'] = 'Clientes <small>Datos de crédito</small>';
    	$data['link_back'] = $this->folder.$this->clase.'clientes/'. $offset;
        
    	$data['action'] = $this->folder.$this->clase.'clientes_credito_editar/' . $id . '/' . $offset;

    	$data['datos'] = $cliente->row();
        $data['ruta_cobranza'] = $this->r->get_by_id($data['datos']->id_ruta_cobranza)->row();
        
        $this->load->view('catalogos/clientes/vista_credito', $data);
    }
    
    /*
     * Editar datos de crédito
     */
    public function clientes_credito_editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/cliente','c');
        $this->load->model('catalogos/ruta_cobranza','r');
        
        $cliente = $this->c->get_by_id($id);
        if ( empty($id) OR $cliente->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'clientes');
    	}
    	
    	$data['titulo'] = 'Clientes <small>Editar datos de crédito</small>';
    	$data['link_back'] = $this->folder.$this->clase.'clientes_credito_ver/'.$id . '/' . $offset;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'clientes_credito_editar/' . $id . '/' . $offset;
    	 
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
            redirect($this->folder.$this->clase.'clientes_credito_ver/'.$id . '/' . $offset);
    	}

    	$data['datos'] = $this->c->get_by_id($id)->row();
        $data['rutas'] = $this->r->get_all()->result();
        
        $this->load->view('catalogos/clientes/formulario_credito', $data);
    }
    
    /*
     * 
     * Rutas de cobranza
     * 
     */
    
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
    
    /*
     * 
     * Concepto de pago
     * 
     */
    
    public function conceptos( $offset = 0 ){
        $this->load->model('catalogos/concepto_pago','c');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Conceptos de pago <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'conceptos_agregar/'.$offset;
    	$data['action'] = $this->folder.$this->clase.'conceptos/'.$offset;
        
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
                    anchor($this->folder.$this->clase.'conceptos_ver/' . $d->id_concepto_pago.'/'.$offset, '<span class="'.$this->config->item('icono_editar').'"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar una concepto
     */
    public function conceptos_agregar( $offset = 0 ) {
        $this->load->model('catalogos/concepto_pago','c');
        
    	$data['titulo'] = 'Rutas de cobranza <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'conceptos/'.$offset;
    
    	$data['action'] = $this->folder.$this->clase.'conceptos_agregar/'.$offset;
    	if ( ($datos = $this->input->post()) ) {
    		if( ($id = $this->c->save($datos)) ){
                    $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                    redirect($this->folder.$this->clase.'conceptos_ver/'.$id.'/'.$offset);
                }else{
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
                    redirect($this->folder.$this->clase.'conceptos_agregar/'.$offset);
                }
    	}
        $this->load->view('catalogos/conceptos_pago/formulario', $data);
    }
    
    
    /*
     * Vista previa del concepto
     */
    public function conceptos_ver( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/concepto_pago','c');
        
        $concepto = $this->c->get_by_id($id);
        if ( empty($id) OR $concepto->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'conceptos');
    	}
    	
    	$data['titulo'] = 'Conceptos de pago <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'conceptos/'.$offset;
        
    	$data['action'] = $this->folder.$this->clase.'conceptos_editar/' . $id.'/'.$offset;

    	$data['datos'] = $concepto->row();
        
        $this->load->view('catalogos/conceptos_pago/vista', $data);
    }
    
    /*
     * Editar un concepto
     */
    public function conceptos_editar( $id = NULL, $offset = 0 ) {
        $this->load->model('catalogos/concepto_pago','c');
        
        $concepto = $this->c->get_by_id($id);
        if ( empty($id) OR $concepto->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'conceptos');
    	}
    	
    	$data['titulo'] = 'Conceptos de pago <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'conceptos_ver/'.$id.'/'.$offset;
    	$data['action'] = $this->folder.$this->clase.'conceptos_editar/' . $id.'/'.$offset;
    	 
    	if ( ($datos = $this->input->post()) ) {
    		$this->c->update($id, $datos);
                $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
                redirect($this->folder.$this->clase.'conceptos_ver/'.$id.'/'.$offset);
    	}

    	$data['datos'] = $this->c->get_by_id($id)->row();
        
        $this->load->view('catalogos/conceptos_pago/formulario', $data);
    }
    
    
    /*
     * 
     * Vales
     * 
     */
    
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