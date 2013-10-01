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
    
    public function productos( $offset = 0 ){
        $this->load->model('catalogos/producto','p');
        $this->load->model('catalogos/linea','l');
        
        $this->config->load("pagination");
    	
        $data['titulo'] = 'Productos <small>Lista</small>';
    	$data['link_add'] = anchor($this->folder.$this->clase.'productos_agregar','<span class="glyphicon glyphicon-plus"></span> Nuevo', array('class' => 'btn btn-default'));
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
                    array('data' => anchor($this->folder.$this->clase.'productos_editar/' . $d->id_producto, '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'btn btn-default btn-xs')), 'style' => 'text-align: right;')
            );
    	}
    	$data['table'] = $this->table->generate();
    	
    	$this->load->view('catalogos/lista', $data);
    }
    
    /*
     * Agregar un producto
     */
    public function productos_agregar() {
        $this->load->model('catalogos/producto','p');
        $this->load->model('catalogos/linea','l');
        
    	$data['titulo'] = 'Productos <small>Registro nuevo</small>';
    	$data['link_back'] = anchor($this->folder.$this->clase.'productos','<span class="glyphicon glyphicon-arrow-left"></span> Regresar',array('class'=>'btn btn-default'));
    
    	$data['action'] = $this->folder.$this->clase.'productos_agregar';
    	if ( ($datos = $this->input->post()) ) {
    		$this->p->save($datos);
    		$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>¡Registro exitoso!</div>';
    	}
        $data['lineas'] = $this->l->get_all()->result();
        $this->load->view('catalogos/productos/formulario', $data);
    }
    
    /*
     * Editar un producto
     */
    public function productos_editar( $id = NULL ) {
    	$this->load->model('catalogos/producto', 'p');
        $this->load->model('catalogos/linea','l');
        
        $producto = $this->p->get_by_id($id);
        if ( empty($id) OR $producto->num_rows() <= 0) {
            die($id);
    		redirect($this->folder.$this->clase.'productos');
    	}
    	
    	$data['titulo'] = 'Productos <small>Editar registro</small>';
    	$data['link_back'] = anchor($this->folder.$this->clase.'productos','<i class="glyphicon glyphicon-arrow-left"></i> Regresar',array('class'=>'btn btn-default'));
    	$data['mensaje'] = '';
    	$data['action'] = $this->folder.$this->clase.'productos_editar/' . $id;
    	 
    	if ( ($datos = $this->input->post()) ) {
    		$this->p->update($id, $datos);
    		$data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>¡Registro modificado!</div>';
    	}

        $data['lineas'] = $this->l->get_all()->result();
    	$data['datos'] = $this->p->get_by_id($id)->row();
        
        $this->load->view('catalogos/productos/formulario', $data);
    }
}
?>
