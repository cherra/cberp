<?php
/**
 * Description of articulos
 *
 * @author cherra
 */
class Articulos extends CI_Controller {
    
    private $folder = 'catalogos/';
    private $clase = 'articulos/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function lineas( $offset = 0 ){
        $this->load->model('catalogos/linea','l');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Lineas <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'lineas_agregar';
    	$data['action'] = $this->folder.$this->clase.'lineas';
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->l->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'lineas');
    	$config['total_rows'] = $this->l->count_all($filtro);
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
            $linea = $this->l->get_by_id($d->id_linea)->row();
            $this->table->add_row(
                    $d->nombre,
                    anchor($this->folder.$this->clase.'lineas_ver/' . $d->id_linea, '<span class="glyphicon glyphicon-edit"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar una linea
     */
    public function lineas_agregar() {
        $this->load->model('catalogos/linea','l');
        
    	$data['titulo'] = 'Lineas <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'lineas';
    
    	$data['action'] = $this->folder.$this->clase.'lineas_agregar';
    	if ( ($datos = $this->input->post()) ) {
    		if( ($id = $this->l->save($datos)) ){
                    $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                    redirect($this->folder.$this->clase.'lineas_ver/'.$id);
                }else{
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
                    redirect($this->folder.$this->clase.'lineas_agregar');
                }
    		//$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>¡Registro exitoso!</div>';
    	}
        $this->load->view('catalogos/lineas/formulario', $data);
    }
    
    
    /*
     * Vista previa de la linea
     */
    public function lineas_ver( $id = NULL ) {
        $this->load->model('catalogos/linea','l');
        
        $linea = $this->l->get_by_id($id);
        if ( empty($id) OR $linea->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'lineas');
    	}
    	
    	$data['titulo'] = 'Lineas <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'lineas';
        if($this->session->flashdata('mensaje'))
            $data['mensaje'] = $this->session->flashdata('mensaje');
    	$data['action'] = $this->folder.$this->clase.'lineas_editar/' . $id;

    	$data['datos'] = $this->l->get_by_id($id)->row();
        
        $this->load->view('catalogos/lineas/vista', $data);
    }
    
    /*
     * Editar una linea
     */
    public function lineas_editar( $id = NULL ) {
        $this->load->model('catalogos/linea','l');
        
        $linea = $this->l->get_by_id($id);
        if ( empty($id) OR $linea->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'lineas');
    	}
    	
    	$data['titulo'] = 'Lineas <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'lineas_ver/'.$id;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'lineas_editar/' . $id;
    	 
    	if ( ($datos = $this->input->post()) ) {
    		$this->l->update($id, $datos);
                $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
    		//$mensaje = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>¡Registro modificado!</div>';
                redirect($this->folder.$this->clase.'lineas_ver/'.$id);
    	}

    	$data['datos'] = $this->l->get_by_id($id)->row();
        
        $this->load->view('catalogos/lineas/formulario', $data);
    }
    
    /*
     * Listado de productos
     */
    public function productos( $offset = 0 ){
        $this->load->model('catalogos/producto','p');
        $this->load->model('catalogos/linea','l');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Productos <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'productos_agregar';
    	$data['action'] = $this->folder.$this->clase.'productos';
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->p->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'productos');
    	$config['total_rows'] = $this->p->count_all($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', 'Linea', '');
    	foreach ($datos as $d) {
            $linea = $this->l->get_by_id($d->id_linea)->row();
            $this->table->add_row(
                    $d->nombre,
                    (!empty($linea->nombre) ? $linea->nombre : ''),
                    anchor($this->folder.$this->clase.'productos_ver/' . $d->id_producto, '<span class="glyphicon glyphicon-edit"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar un producto
     */
    public function productos_agregar() {
        $this->load->model('catalogos/producto','p');
        $this->load->model('catalogos/linea','l');
        
    	$data['titulo'] = 'Productos <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'productos';
    
    	$data['action'] = $this->folder.$this->clase.'productos_agregar';
    	if ( ($datos = $this->input->post()) ) {
    		if( ($id = $this->p->save($datos)) ){
                    $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                    redirect($this->folder.$this->clase.'productos_ver/'.$id);
                }else{
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
                    redirect($this->folder.$this->clase.'productos_agregar');
                }
    		//$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>¡Registro exitoso!</div>';
    	}
        $data['lineas'] = $this->l->get_all()->result();
        $this->load->view('catalogos/productos/formulario', $data);
    }
    
    public function productos_ver( $id = NULL ) {
    	$this->load->model('catalogos/producto', 'p');
        $this->load->model('catalogos/linea','l');
        
        $producto = $this->p->get_by_id($id);
        if ( empty($id) OR $producto->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'productos');
    	}
    	
    	$data['titulo'] = 'Productos <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'productos';
        if($this->session->flashdata('mensaje'))
            $data['mensaje'] = $this->session->flashdata('mensaje');
    	$data['action'] = $this->folder.$this->clase.'productos_editar/' . $id;

    	$data['datos'] = $this->p->get_by_id($id)->row();
        $data['linea'] = $this->l->get_by_id($data['datos']->id_linea)->row();
        
        $this->load->view('catalogos/productos/vista', $data);
    }
    
    /*
     * Editar un producto
     */
    public function productos_editar( $id = NULL ) {
    	$this->load->model('catalogos/producto', 'p');
        $this->load->model('catalogos/linea','l');
        
        $producto = $this->p->get_by_id($id);
        if ( empty($id) OR $producto->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'productos');
    	}
    	
    	$data['titulo'] = 'Productos <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'productos_ver/'.$id;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'productos_editar/' . $id;
    	 
    	if ( ($datos = $this->input->post()) ) {
    		$this->p->update($id, $datos);
                $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
    		//$mensaje = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>¡Registro modificado!</div>';
                redirect($this->folder.$this->clase.'productos_ver/'.$id);
    	}

        $data['lineas'] = $this->l->get_all()->result();
    	$data['datos'] = $this->p->get_by_id($id)->row();
        
        $this->load->view('catalogos/productos/formulario', $data);
    }
    
    /*
     * Listado de subproductos
     */
    public function subproductos( $offset = 0 ){
        $this->load->model('catalogos/subproducto','s');
        $this->load->model('catalogos/producto','p');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Subproductos <small>Lista</small>';
    	$data['link_add'] = $this->folder.$this->clase.'subproductos_agregar';
    	$data['action'] = $this->folder.$this->clase.'subproductos';
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $page_limit = $this->config->item("per_page");
    	$datos = $this->s->get_paged_list($page_limit, $offset, $filtro)->result();
    	
        // generar paginacion
    	$this->load->library('pagination');
    	$config['base_url'] = site_url($this->folder.$this->clase.'subproductos');
    	$config['total_rows'] = $this->s->count_all($filtro);
    	$config['per_page'] = $page_limit;
    	$config['uri_segment'] = 4;
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();
    	
    	// generar tabla
    	$this->load->library('table');
    	$this->table->set_empty('&nbsp;');
    	$tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
    	$this->table->set_template($tmpl);
    	$this->table->set_heading('Nombre', 'Código', 'Producto', '');
    	foreach ($datos as $d) {
            $producto = $this->p->get_by_id($d->id_producto)->row();
            $this->table->add_row(
                    $d->nombre,
                    $d->codigo,
                    (!empty($producto->nombre) ? $producto->nombre : ''),
                    anchor($this->folder.$this->clase.'subproductos_ver/' . $d->id_subproducto, '<span class="glyphicon glyphicon-edit"></span>')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('lista', $data);
    }
    
    /*
     * Agregar un producto
     */
    public function subproductos_agregar() {
        $this->load->model('catalogos/subproducto','s');
        $this->load->model('catalogos/producto','p');
        
    	$data['titulo'] = 'Subproductos <small>Registro nuevo</small>';
    	$data['link_back'] = $this->folder.$this->clase.'subproductos';
    
    	$data['action'] = $this->folder.$this->clase.'subproductos_agregar';
    	if ( ($datos = $this->input->post()) ) {
    		if( ($id = $this->s->save($datos)) ){
                    $this->session->set_flashdata('mensaje',$this->config->item('create_success'));
                    redirect($this->folder.$this->clase.'subproductos_ver/'.$id);
                }else{
                    $this->session->set_flashdata('mensaje',$this->config->item('error'));
                    redirect($this->folder.$this->clase.'subproductos_agregar');
                }
    		//$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>¡Registro exitoso!</div>';
    	}
        $data['productos'] = $this->p->get_all()->result();
        $this->load->view('catalogos/subproductos/formulario', $data);
    }
    
    public function subproductos_ver( $id = NULL ) {
    	$this->load->model('catalogos/subproducto', 's');
        $this->load->model('catalogos/producto', 'p');
        
        $subproducto = $this->s->get_by_id($id);
        if ( empty($id) OR $subproducto->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'subproductos');
    	}
    	
    	$data['titulo'] = 'Subproductos <small>Ver registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'subproductos';
        if($this->session->flashdata('mensaje'))
            $data['mensaje'] = $this->session->flashdata('mensaje');
    	$data['action'] = $this->folder.$this->clase.'subproductos_editar/' . $id;

    	$data['datos'] = $this->s->get_by_id($id)->row();
        $data['producto'] = $this->p->get_by_id($data['datos']->id_producto)->row();
        
        $this->load->view('catalogos/subproductos/vista', $data);
    }
    
    /*
     * Editar un producto
     */
    public function subproductos_editar( $id = NULL ) {
        $this->load->model('catalogos/subproducto', 's');
    	$this->load->model('catalogos/producto', 'p');
        
        $subproducto = $this->s->get_by_id($id);
        if ( empty($id) OR $subproducto->num_rows() <= 0) {
            redirect($this->folder.$this->clase.'subproductos');
    	}
    	
    	$data['titulo'] = 'Subproductos <small>Editar registro</small>';
    	$data['link_back'] = $this->folder.$this->clase.'subproductos_ver/'.$id;
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'subproductos_editar/' . $id;
    	 
    	if ( ($datos = $this->input->post()) ) {
            if(strlen($datos['codigo']) == 0){
                $datos['codigo'] = null;
            }
            $this->s->update($id, $datos);
            $this->session->set_flashdata('mensaje',$this->config->item('update_success'));
            //$mensaje = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>¡Registro modificado!</div>';
            redirect($this->folder.$this->clase.'subproductos_ver/'.$id);
    	}

        $data['productos'] = $this->p->get_all()->result();
    	$data['datos'] = $this->s->get_by_id($id)->row();
        
        $this->load->view('catalogos/subproductos/formulario', $data);
    }
}
?>
