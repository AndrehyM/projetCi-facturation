<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produit_model extends CI_Model
{
    private $table = 'products';

    // Compter les produits
    public function count_all($keyword = '')
    {
        if (!empty($keyword)) {
            $this->db->like('products.name', $keyword);
        }
        return $this->db->count_all_results($this->table);
    }

    // Récupérer produits avec pagination + recherche
    public function get_paginated($limit, $offset, $keyword = '')
    {
        $this->db->select('products.*, categories.name AS categorie_name');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        if (!empty($keyword)) {
            $this->db->like('products.name', $keyword);
            $this->db->or_like('categories.name', $keyword);
        }
        $this->db->order_by('products.id', 'ASC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    // CRUD
    public function insert($data) { 
		return $this->db->insert($this->table, $data);
	 }

    public function update($id, $data) { 
		return $this->db->update($this->table, $data, ['id' => $id]); 
	}

    public function delete($id) { 
		return $this->db->delete($this->table, ['id' => $id]); 
	}

    public function get_by_id($id)
    {
        $this->db->select('products.*, categories.name AS categorie_name');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        return $this->db->get_where($this->table, ['products.id' => $id])->row();
    }

    public function get_all_categories()
    {
        return $this->db->order_by('name', 'ASC')->get('categories')->result();
    }
	//total table produits
	public function  getCountTable()
   {
       $query = $this->db->get('products');
       return $query->num_rows();
       
   }
   public function count_products()
   {
	  return $this->db->count_all('products');
   }
	//  Liste complète des produits (pour Factures)
     public function getAllProducts() {
       $this->db->select('products.*, categories.name as categorie_name');
      $this->db->from('products');
    $this->db->join('categories', 'products.category_id = categories.id', 'left');
    $this->db->order_by('products.name', 'ASC');
    $query = $this->db->get();
    return $query->result();
}

}
