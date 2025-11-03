<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Client_model');
        $this->load->library('pagination');
		$this->lang->load('en_admin_lang','english');
		$this->load->helper('auth');
        require_admin();
		if (!$this->session->userdata('role') || $this->session->userdata('role') !== 'admin') {
			redirect('auth/login'); // ou une page d'erreur
		}
    }

    public function index() {
        $search = $this->input->get('search');
        $config = [
            'base_url' => site_url('client/index'),
            'total_rows' => $this->Client_model->count_all($search),
            'per_page' => 5,
            'reuse_query_string' => true,
        ];
        $this->pagination->initialize($config);

        $page = $this->uri->segment(3, 0);
        $data['clients'] = $this->Client_model->get_clients($config['per_page'], $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

		$data['id'] = $this->session->userdata('id');
		$data['username'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');

        $this->load->view('inc/header', $data);
        $this->load->view('../views/admin/navside/sidenav', $data);
        $this->load->view('../views/admin/navside/nav', $data);
        $this->load->view('../views/clients/content.php', $data);
        $this->load->view('inc/footer', $data);
    }

    public function add() {
        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
        ];
        $this->Client_model->insert($data);
        redirect('client');
    }

    public function edit($id) {
        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
        ];
        $this->Client_model->update_client($id, $data);
        redirect('client');
    }

    public function delete($id) {
        $this->Client_model->delete_client($id);
        redirect('client');
    }
}
