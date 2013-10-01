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
    	$data['link_add'] = anchor($this->folder.$this->clase.'productos_agregar','<span class="glyphicon glyphicon-plus"></span> Agregar', array('class' => 'btn btn-info'));
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
}
?>
