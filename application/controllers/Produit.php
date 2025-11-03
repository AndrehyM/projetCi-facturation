<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produit extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produit_model');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
		$this->lang->load('en_admin_lang','english');
		$this->load->helper('auth');
        require_admin();
		if (!$this->session->userdata('role') || $this->session->userdata('role') !== 'admin') {
			redirect('auth/login'); // ou une page d'erreur
		}
    }

    // ✅ Liste + Recherche + Pagination
    public function index()
    {
        $keyword = $this->input->get('search');
        $config = [
            'base_url' => base_url('produit/index'),
            'total_rows' => $this->Produit_model->count_all($keyword),
            'per_page' => 5,
            'page_query_string' => TRUE,
            'query_string_segment' => 'page',
            'reuse_query_string' => TRUE,
            'full_tag_open' => '<ul class="pagination justify-content-center">',
            'full_tag_close' => '</ul>',
            'first_link' => 'Début',
            'last_link' => 'Fin',
            'next_link' => 'Suivant',
            'prev_link' => 'Précédent',
            'num_tag_open' => '<li class="page-item"><span class="page-link">',
            'num_tag_close' => '</span></li>',
            'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close' => '</span></li>'
        ];
        $this->pagination->initialize($config);

        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $data['liste_produits'] = $this->Produit_model->get_paginated($config['per_page'], $page, $keyword);
        $data['categories'] = $this->Produit_model->get_all_categories();
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $keyword;

		$data['id'] = $this->session->userdata('id');
		$data['username'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');

        $this->load->view('inc/header', $data);
        $this->load->view('../views/admin/navside/sidenav', $data);
        $this->load->view('../views/admin/navside/nav', $data);
        $this->load->view('../views/produits/content.php', $data);
        $this->load->view('inc/footer', $data);
    }

    // ✅ Ajouter
    public function add()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);

        $photo = null;
        if (!empty($_FILES['photo']['name']) && $this->upload->do_upload('photo')) {
            $photo = 'uploads/' . $this->upload->data('file_name');
        }

        $data = [
            'category_id' => $this->input->post('category_id'),
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'photo' => $photo,
            'qte_stock' => $this->input->post('qte_stock'),
            'seuil_alert' => $this->input->post('seuil_alert')
        ];

        $this->Produit_model->insert($data);
        $this->session->set_flashdata('success', 'Produit ajouté avec succès.');
        redirect('produit');
    }

    // ✅ Modifier
    public function edit($id)
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);

        $produit = $this->Produit_model->get_by_id($id);
        $photo = $produit->photo;

        if (!empty($_FILES['photo']['name']) && $this->upload->do_upload('photo')) {
            $photo = 'uploads/' . $this->upload->data('file_name');
        }

        $data = [
            'category_id' => $this->input->post('category_id'),
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'photo' => $photo,
            'qte_stock' => $this->input->post('qte_stock'),
            'seuil_alert' => $this->input->post('seuil_alert')
        ];

        $this->Produit_model->update($id, $data);
        $this->session->set_flashdata('success', 'Produit modifié avec succès.');
        redirect('produit');
    }

    // ✅ Supprimer
    public function delete($id)
    {
        $this->Produit_model->delete($id);
        $this->session->set_flashdata('success', 'Produit supprimé.');
        redirect('produit');
    }
}
