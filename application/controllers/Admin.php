<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Categorie_model');
		$this->load->model('Produit_model');
		$this->load->model('Client_model');
        $this->load->library('session');
		$this->lang->load('en_admin_lang','english');
		$this->load->helper('auth');
        require_admin();

		if (!$this->session->userdata('role') || $this->session->userdata('role') !== 'admin') {
			redirect('auth/login'); // ou une page d'erreur
		}
    }
	public function index()
	{
		$data['total_users'] = $this->User_model->getCountTable();
		$data['total_categories'] = $this->Categorie_model->getCountTable();
		$data['total_produits'] = $this->Produit_model->getCountTable();
		$data['total_clients'] = $this->Client_model->getCountTable();

		$data['id'] = $this->session->userdata('id');
		$data['username'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');

		//liste des users
		$data['liste_utilisateurs'] = $this->User_model->getAllUser();
		

		// chart 

	    $data['users'] = $this->User_model->count_users();
		
	    $data['clients'] = $this->Client_model->count_clients();
		
	    $data['categories'] = $this->Categorie_model->count_categories();
		
	    $data['produits'] = $this->Produit_model->count_products();

		$this->load->view('inc/header',$data);
		$this->load->view('../views/admin/navside/sidenav',$data);
		$this->load->view('../views/admin/navside/nav',$data);
		$this->load->view('../views/admin/dashboard.php',$data);
		$this->load->view('inc/footer',$data);
	}
}
