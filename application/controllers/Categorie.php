<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorie extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Categorie_model');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->helper('url');
		$this->lang->load('en_admin_lang','english');
		$this->load->helper('auth');
        require_admin();
		if (!$this->session->userdata('role') || $this->session->userdata('role') !== 'admin') {
			redirect('auth/login'); // ou une page d'erreur
		}
    }

    // Liste + Recherche + Pagination
    public function index()
    {
        $keyword = $this->input->get('search');
        $config = [
            'base_url' => base_url('categorie/index'),
            'total_rows' => $this->Categorie_model->count_all($keyword),
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
            'cur_tag_close' => '</span></li>',
            'prev_tag_open' => '<li class="page-item"><span class="page-link">',
            'prev_tag_close' => '</span></li>',
            'next_tag_open' => '<li class="page-item"><span class="page-link">',
            'next_tag_close' => '</span></li>'
        ];

        $this->pagination->initialize($config);

        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $data['liste_categories'] = $this->Categorie_model->get_paginated($config['per_page'], $page, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $keyword;

		$data['id'] = $this->session->userdata('id');
		$data['username'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');
        // Vue
        $this->load->view('inc/header', $data);
        $this->load->view('../views/admin/navside/sidenav', $data);
        $this->load->view('../views/admin/navside/nav', $data);
        $this->load->view('../views/categories/content.php', $data);
        $this->load->view('inc/footer', $data);
    }

    // ✅ Ajouter
    public function add()
    {
        $name = $this->input->post('name');
        if (!empty($name)) {
            $this->Categorie_model->insert(['name' => $name]);
            $this->session->set_flashdata('success', 'Catégorie ajoutée avec succès.');
        } else {
            $this->session->set_flashdata('error', 'Le nom de la catégorie est requis.');
        }
        redirect('categorie');
    }

    // ✅ Modifier
    public function edit($id)
    {
        $name = $this->input->post('name');
        if (!empty($name)) {
            $this->Categorie_model->update($id, ['name' => $name]);
            $this->session->set_flashdata('success', 'Catégorie mise à jour.');
        } else {
            $this->session->set_flashdata('error', 'Le champ nom est vide.');
        }
        redirect('categorie');
    }

    // ✅ Supprimer
    public function delete($id)
    {
        $this->Categorie_model->delete($id);
        $this->session->set_flashdata('success', 'Catégorie supprimée.');
        redirect('categorie');
    }
}
