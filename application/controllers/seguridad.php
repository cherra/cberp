<?php

class Seguridad extends CI_Controller{
    
    private $folder = '';
    private $clase = 'seguridad/';
    /**
    * *****************************************************************
    * titulo para el CRUD
    * *****************************************************************
    */
    private $titulo = 'Seguridad';
    
    function __construct() {
        parent::__construct();
    }
    
    public function permisos_lista( $offset = '0' ){
        
        $this->load->model('permiso','p');
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        $this->config->load("pagination");
        $page_limit = $this->config->item("per_page");
        $permisos = $this->p->get_paged_list($page_limit, $offset)->result();
        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url('seguridad/permisos_lista/');
        $config['total_rows'] = $this->p->count_all();
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Nombre', 'Ruta', 'Menú', 'Icono', '', '');
        foreach ($permisos as $permiso) {
                $this->table->add_row(
                        $permiso->nombre, 
                        $permiso->folder.'/'.$permiso->class.'/'.$permiso->method,
                        ($permiso->menu == 1 ? 'Si' : '-'),
                        '<span class="glyphicon glyphicon-'.$permiso->icon.'"></span>',
                        anchor('seguridad/permisos_update/' . $permiso->id_permiso, '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'btn btn-xs')),
                        anchor('seguridad/permisos_delete/' . $permiso->id_permiso, '<span class="glyphicon glyphicon-remove"></span>', array('class' => 'btn btn-xs'))
                );
        }
        $data['table'] = $this->table->generate();
        $data['titulo'] = 'Permisos <small>Lista</small>';
        $data['action'] = 'seguridad/permisos_lista';

        $this->load->view('lista', $data);
    }
    
    /**
	* *****************************************************************
	* Muestra en pantalla el formulario para editar un permiso
	* *****************************************************************
	*/
    public function permisos_update( $id = NULL ) {

        if (empty($id)) {
                redirect('seguridad/permisos_lista');
        }
        
        $this->load->model('permiso','p');

        $data['titulo'] = 'Permisos <small>Modificar</small>';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = 'seguridad/permisos_lista';

        $data['mensaje'] = '';
        $data['action'] = 'seguridad/permisos_update/' . $id;

        $permiso = $this->p->get_by_id($id)->row();
        if ($this->input->post()) {
            $permiso = array(
                'nombre' => $this->input->post('nombre'),
                'icon' => $this->input->post('icon'),
                'menu' => $this->input->post('menu')
                );
            $this->p->update($id, $permiso);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        $data['datos'] = (object)$permiso;
        $this->load->view('seguridad/permisos/formulario', $data);
    }
    
    public function permisos_delete( $id ){
        if (!empty($id)) {
            $this->load->model('permiso', 'p');
            $this->p->delete($id);
        }
        redirect('seguridad/permisos_lista');
    }
    
    public function roles_lista( $offset = 0 ){
        
        $this->load->model('rol','c');
        $this->titulo = "Roles";
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        // obtener datos
        $this->config->load("pagination");
        $page_limit = $this->config->item("per_page");
        $roles = $this->c->get_paged_list($page_limit, $offset)->result();

        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url('preferencias/seguridad/roles_lista/');
        $config['total_rows'] = $this->c->count_all();
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Nombre', 'Descripción', '', '', '');
        foreach ($roles as $rol) {
                $this->table->add_row(
                        $rol->nombre,
                        $rol->descripcion,
                        anchor('seguridad/roles_permisos/' . $rol->id_rol, '<span class="glyphicon glyphicon-lock"></span>', array('class' => 'btn btn-xs')),
                        anchor('seguridad/roles_update/' . $rol->id_rol, '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'btn btn-xs')),
                        anchor('seguridad/roles_delete/' . $rol->id_rol, '<span class="glyphicon glyphicon-remove"></span>', array('class' => 'btn btn-xs'))
                );
        }
        $data['table'] = $this->table->generate();
        $data['link_add'] = 'seguridad/roles_add/';
        $data['titulo'] = 'Roles <small>Lista</small>';
        $data['action'] = 'seguridad/roles_lista';

        $this->load->view('lista', $data);
    }
    
    public function roles_add() {
        $data['titulo'] = 'Roles <small>Agregar</small>';
        $data['link_back'] = 'seguridad/roles_lista/';
        $data['mensaje'] = '';
        $data['action'] = 'seguridad/roles_add';
        
        if ($this->input->post()) {
            $rol = array(
                'nombre' => $this->input->post('nombre', true),
                'descripcion' => $this->input->post('descripcion', true)
            );
            
            $this->load->model('rol', 'r');
            $this->r->save($rol);
            
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro nuevo</div>';
        }
        $this->load->view('seguridad/roles/formulario', $data);
    }
    
    public function roles_update( $id = NULL ) {

        if (empty($id)) {
            redirect('seguridad/roles_lista');
        }
        
        $this->load->model('rol','r');

        $data['titulo'] = 'Roles <small>Modificar</small>';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = 'seguridad/roles_lista/';

        $data['mensaje'] = '';
        $data['action'] = 'seguridad/roles_update/' . $id;

        $rol = $this->r->get_by_id($id)->row();
        $data['rol'] = $rol;
        if ($this->input->post()) {
            $rol = array(
                        'nombre' => $this->input->post('nombre'),
                        'descripcion' => $this->input->post('descripcion')
                        );
            $this->r->update($id, $rol);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
            $this->load->view('seguridad/roles/formulario', $data);
        }
        $data['rol'] = (object)$rol;
    }
    
    public function roles_delete( $id = NULL ){
        if (!empty($id)) {
            $this->load->model('rol', 'r');
            $this->r->delete($id);
        }
        redirect('seguridad/roles_lista/');
    }
    
    public function roles_permisos( $id ) {

        if (empty($id)) {
            redirect('seguridad/roles_lista');
        }
        
        $this->load->model('rol','r');
        $this->load->model('permiso','p');

        $data['titulo'] = 'Roles <small>Permisos</small>';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = 'seguridad/roles_lista/';

        $data['mensaje'] = '';
        $data['action'] = 'preferencias/seguridad/rol_permisos/' . $id;

        $rol = $this->r->get_by_id($id)->row();
        $data['rol'] = $rol;
        
        /* Si llegan datos por POST, se insertan en la base de datos*/
        if ($this->input->post()) {
            $perms = array();
            if($this->input->post('permisos')){
                foreach ($this->input->post('permisos') as $permiso){
                    $perms[] = array(
                        'id_rol' => $id,
                        'id_permiso' => $permiso,
                        'valor' => '1'
                    );
                }
            }
            $this->r->update_permisos($id, $perms);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        
        // Obtener todos los permisos
        $permisos = $this->p->get_all()->result();
        
        // generar tabla con permisos
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Menú','Acción', 'Ruta', 'Activo');
        foreach ($permisos as $permiso) {
            $this->table->add_row(
                    strtoupper($permiso->folder), 
                    $permiso->nombre, 
                    $permiso->permKey,
                    '<input type="checkbox" name="permisos[]" value="'.$permiso->id_permiso.'" '.($this->r->get_permiso_by_id($permiso->id_permiso, $id)->num_rows() > 0 ? 'checked' : '').'/>'
            );
        }
        $data['table'] = $this->table->generate();
        
        $this->load->view('seguridad/roles/permisos', $data);

    }
    
    
    public function usuarios_lista( $offset = 0 ){
        
        $this->load->model('usuario','u');
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        
        // obtener datos
        $this->config->load("pagination");
        $page_limit = $this->config->item("per_page");
        $usuarios = $this->u->get_paged_list($page_limit, $offset)->result();
        
        // generar paginacion
        $this->load->library('pagination');
        $config['base_url'] = site_url('seguridad/usuarios_lista/');
        $config['total_rows'] = $this->u->count_all();
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Nombre', 'Username', 'Activo', '');
        
        $i = 0 + $offset;
        foreach ($usuarios as $usuario) {
                $this->table->add_row(
                        $usuario->nombre,
                        $usuario->username,
                        $usuario->eliminado == 'n' ? '<span class="glyphicon glyphicon-ok"></span>' : '',
                        anchor('seguridad/usuarios_permisos/' . $usuario->id_usuario, '<span class="glyphicon glyphicon-lock"></span>', array('class' => 'btn btn-xs')),
                        anchor('seguridad/usuarios_roles/' . $usuario->id_usuario, '<span class="glyphicon glyphicon-user"></span>', array('class' => 'btn btn-xs')),
                        anchor('seguridad/usuarios_update/' . $usuario->id_usuario, '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'btn btn-xs')),
                        anchor('seguridad/usuarios_delete/' . $usuario->id_usuario, '<span class="glyphicon glyphicon-remove"></span>', array('class' => 'btn btn-xs'))
                );
        }
        
        $data['table'] = $this->table->generate();
        $data['link_add'] = 'seguridad/usuarios_add';
        $data['titulo'] = 'Usuarios <small>Lista</small>';
        $data['action'] = 'seguridad/usuarios_lista';

        $this->load->view('lista', $data);
    }
    
    public function usuarios_update( $id = NULL ) {
        if (empty($id)) {
            redirect('seguridad/usuarios_lista');
        }
        
        $this->load->model('usuario','u');

        $data['titulo'] = 'Usuarios <small>Modificar</small>';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = 'seguridad/usuarios_lista/';

        $data['mensaje'] = '';
        $data['action'] = 'seguridad/usuarios_update/' . $id;

        if ($this->input->post()) {
            if(strlen($this->input->post('password')) > 0){
                $usuario = array(
                    'nombre' => $this->input->post('nombre'),
                    'username' => $this->input->post('username'),
                    'password' => sha1($this->input->post('password')),
                    'activo' => $this->input->post('activo')
                );
            }else{
                $usuario = array(
                    'nombre' => $this->input->post('nombre'),
                    'username' => $this->input->post('username'),
                    'activo' => $this->input->post('activo')
                );
            }
            $this->u->update($id, $usuario);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        $usuario = $this->u->get_by_id($id)->row();
        $data['usuario'] = $usuario;
        $this->load->view('seguridad/usuarios/formulario', $data);
    }
    
    public function usuarios_add() {
        $data['titulo'] = 'Usuarios <small>Agregar</small>';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = 'seguridad/usuarios_lista/';
        $data['mensaje'] = '';
        $data['action'] = 'seguridad/usuarios_add';
        
        if ($this->input->post() == false) {
            $usuario = array(
                'nombre' => $this->input->post('nombre', true),
                'username' => $this->input->post('username', true),
                'password' => sha1($this->input->post('password')),
                'activo' => $this->input->post('activo', true)
            );
            
            $this->load->model('usuario', 'u');
            $this->u->save($usuario);
            
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro nuevo</div>';
        }
        $this->load->view('seguridad/usuarios/formulario', $data);
    }
    
    public function usuarios_delete( $id ){
        if (!empty($id)) {
            $this->load->model('usuario', 'u');
            $this->u->delete($id);
        }
        redirect('seguridad/usuarios_lista/');
    }
    
    public function usuarios_permisos( $id ) {

        if (empty($id)) {
                redirect('seguridad/usuarios_lista');
        }
        
        $this->load->model('usuario','u');
        $this->load->model('permiso','p');

        $data['titulo'] = 'Usuarios <small>Permisos</small>';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = 'seguridad/usuarios_lista/';

        $data['mensaje'] = '';
        $data['action'] = 'seguridad/usuario_permisos/' . $id;

        $usuario = $this->u->get_by_id($id)->row();
        $data['usuario'] = $usuario;
        
        /* Si llegan datos por POST, se insertan en la base de datos*/
        if ($this->input->post()) {
            $perms = array();
            if($this->input->post('permisos')){
                foreach ($this->input->post('permisos') as $permiso){
                    $perms[] = array(
                        'id_usuario' => $id,
                        'id_permiso' => $permiso,
                        'valor' => '1'
                    );
                }
            }
            $this->u->update_permisos($id, $perms);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Registro modificado</div>';
        }
        
        // Obtener todos los permisos
        $permisos = $this->p->get_all()->result();
        
        // generar tabla con permisos
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Menú','Acción', 'Ruta', 'Activo');
        foreach ($permisos as $permiso) {
            $this->table->add_row(
                    strtoupper($permiso->folder), 
                    $permiso->nombre, 
                    $permiso->permKey,
                    '<input type="checkbox" name="permisos[]" value="'.$permiso->id_permiso.'" '.($this->u->get_permiso_by_id($permiso->id_permiso, $id)->num_rows() > 0 ? 'checked' : '').'/>'
            );
        }
        $data['table'] = $this->table->generate();
        
        $this->load->view('seguridad/usuarios/permisos', $data);

    }
    
    public function usuarios_roles( $id ) {

        if (empty($id)) {
                redirect('seguridad/usuarios_lista');
        }
        
        $this->load->model('usuario','u');
        $this->load->model('rol','r');

        $data['titulo'] = 'Usuarios <small>Roles</small>';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        $data['link_back'] = 'seguridad/usuarios_lista/';

        $data['mensaje'] = '';
        $data['action'] = 'seguridad/usuarios_roles/' . $id;

        /* Si llegan datos por POST, se insertan en la base de datos*/
        if ($this->input->post()) {
            $roles = array();
            if($this->input->post('roles')){
                foreach ($this->input->post('roles') as $rol){
                    $roles[] = array(
                        'id_usuario' => $id,
                        'id_rol' => $rol
                    );
                }
            }
            $this->u->update_roles($id, $roles);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Roles actualizados</div>';
        }
        
        $usuario = $this->u->get_by_id($id)->row();
        $data['usuario'] = $usuario;
        
        // Obtener todos los permisos
        $roles = $this->r->get_all()->result();
        
        // generar tabla con permisos
        $this->load->library('table');
        $this->table->set_empty('&nbsp;');
        $tmpl = array ( 'table_open'  => '<table class="' . $this->config->item('tabla_css') . '">' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Nombre', 'Descripción');
        foreach ($roles as $rol) {
            $this->table->add_row(
                    $rol->nombre, 
                    $rol->descripcion, 
                    '<input type="checkbox" name="roles[]" value="'.$rol->id_rol.'" '.($this->u->get_rol_by_id($rol->id_rol, $id)->num_rows() > 0 ? 'checked' : '').'/>'
            );
        }
        $data['table'] = $this->table->generate();
        
        $this->load->view('seguridad/usuarios/roles', $data);

    }
    
    public function usuarios_password( ) {

        $this->load->model('usuario','u');
        
        $id = $this->session->userdata('id_usuario');

        $data['titulo'] = 'Usuario <small>Cambiar contraseña</small>';
        $data['atributos_form'] = array('id' => 'form', 'class' => 'form-horizontal');
        //$data['link_back'] = anchor('preferencias/preferencias','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));

        $data['mensaje'] = '';
        $data['action'] = 'seguridad/usuarios_password/' . $id;

        if ( $this->input->post() ) {
            $usuario = array('password' => sha1($this->input->post('password')));
            $this->u->update($id, $usuario);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Constraseña actualizada</div>';
        }

        $data['usuario'] = $this->u->get_by_id($id)->row();
        $this->load->view('seguridad/usuarios/formulario_password', $data);
    }
}

?>
