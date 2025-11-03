<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factures extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Facture_model');
        $this->load->model('Client_model');
        $this->load->model('Produit_model');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->lang->load('en_admin_lang','english');
		$this->load->helper('auth');
        require_admin();
		if (!$this->session->userdata('role') || $this->session->userdata('role') !== 'admin') {
			redirect('auth/login'); // ou une page d'erreur
		}
    }

    // Liste des factures
    public function index() {
        $search = $this->input->get('search');
        $config['base_url'] = site_url('factures/index');
        $config['total_rows'] = $this->Facture_model->count_all($search);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);

        $page = $this->input->get('per_page') ?: 0;

        $data['factures'] = $this->Facture_model->get_all($config['per_page'], $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $data['id'] = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');

        $this->load->view('inc/header', $data);
        $this->load->view('../views/admin/navside/sidenav', $data);
        $this->load->view('../views/admin/navside/nav', $data);
        $this->load->view('factures/list', $data);
        $this->load->view('inc/footer');
    }
	public function delete($id) {
		// Vérifie que l'utilisateur est admin
		if ($this->session->userdata('role') !== 'admin') {
			show_error('Accès interdit');
		}
	
		$facture = $this->Facture_model->get_by_id($id);
		if (!$facture) {
			show_error('Facture introuvable');
		}
	
		$this->Facture_model->delete_facture($id);
		$this->session->set_flashdata('success', 'Facture supprimée avec succès.');
		redirect('factures');
	}
	

    // Ajouter facture
    public function add() {
        $data['clients'] = $this->Client_model->getAllclients(1000, 0);
        $data['products'] = $this->Produit_model->getAllproducts();

        if($this->input->post()){
            $client_id = $this->input->post('client_id');
            $date_facture = $this->input->post('date_facture');
            $numfacture = 'FAC-'.time();
            $items = $this->input->post('items');

            if(empty($items) || !is_array($items)){
                $this->session->set_flashdata('error','Aucun produit sélectionné.');
                redirect('factures/add');
            }

            $total_HT = 0;
            foreach($items as $item){
                $qty = isset($item['quantity']) ? (float)$item['quantity'] : 0;
                $price = isset($item['priceUnit']) ? (float)$item['priceUnit'] : 0;
                $total_HT += $qty * $price;
            }
            $total_TTC = $total_HT * 1.2;

            $facture_data = [
                'client_id' => $client_id,
                'date_facture' => $date_facture,
                'numfacture' => $numfacture,
                'total_HT' => $total_HT,
                'total_TTC' => $total_TTC
            ];

            $facture_id = $this->Facture_model->add_facture($facture_data, $items);
            $this->session->set_flashdata('success','Facture créée avec succès.');
            redirect('factures/view/'.$facture_id);
        }

        $data['id'] = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');

        $this->load->view('inc/header', $data);
        $this->load->view('../views/admin/navside/sidenav', $data);
        $this->load->view('../views/admin/navside/nav', $data);
        $this->load->view('factures/add', $data);
        $this->load->view('inc/footer');
    }

    // Voir une facture
    public function view($id){
        $data['facture'] = $this->Facture_model->get_by_id($id);

        $data['id'] = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');

        $this->load->view('inc/header', $data);
        $this->load->view('../views/admin/navside/sidenav', $data);
        $this->load->view('../views/admin/navside/nav', $data);
        $this->load->view('factures/view', $data);
        $this->load->view('inc/footer');
    }

    // Impression
    public function print($id) {
        $data['facture'] = $this->Facture_model->get_by_id($id);
        if(!$data['facture']) show_error('Facture introuvable');

        $data['id'] = $this->session->userdata('id');
        $this->load->view('factures/print', $data);
    }

	public function pdf($id) {
		$this->load->library('pdf');
		$data['facture'] = $this->Facture_model->get_by_id($id);
	
		if(!$data['facture']) show_error('Facture introuvable');
	
		$html = $this->load->view('factures/pdf', $data, true);
		$this->pdf->create($html, 'facture_'.$data['facture']->numfacture);
	}
	
}
