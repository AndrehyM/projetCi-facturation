<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestion_user extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->library('form_validation');
		$this->lang->load('en_admin_lang','english');
		$this->load->helper('auth');
        require_admin();
		if (!$this->session->userdata('role') || $this->session->userdata('role') !== 'admin') {
			redirect('auth/login'); // ou une page d'erreur
		}
    }

    public function index() {
        $data['id'] = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');

        // Pagination
        $this->load->library('pagination');
        $search = $this->input->get('search') ?? '';
        $config['base_url'] = site_url('gestion_user/index');
        $config['total_rows'] = $this->User_model->count_all($search);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'per_page';
        $this->pagination->initialize($config);

        $page = $this->input->get('per_page') ?? 0;
        $data['liste_utilisateurs'] = $this->User_model->get_users($config['per_page'], $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->load->view('inc/header', $data);
        $this->load->view('../views/admin/navside/sidenav', $data);
        $this->load->view('../views/admin/navside/nav', $data);
        $this->load->view('../views/admin/content', $data);
        $this->load->view('inc/footer', $data);
    }

    // Ajouter un utilisateur
    public function add() {
        $this->form_validation->set_rules('username','Nom','required');
        $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password','Mot de passe','required|min_length[6]');
        $this->form_validation->set_rules('role','Role','required');

        if($this->form_validation->run()) {
            $data = [
                'username' => $this->input->post('username'),
                'email'    => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role'     => $this->input->post('role'),
                'hash_expiry' => date('Y-m-d H:i:s', strtotime('+1 year'))
            ];
            $this->User_model->insert($data);
            $this->session->set_flashdata('success','Utilisateur ajouté.');
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        redirect('gestion_user');
    }

    // Supprimer
    public function delete($id) {
        $this->User_model->delete_user($id);
        $this->session->set_flashdata('success','Utilisateur supprimé.');
        redirect('gestion_user');
    }
}
