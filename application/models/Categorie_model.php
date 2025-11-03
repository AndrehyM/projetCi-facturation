<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorie_model extends CI_Model
{
    private $table = 'categories';

    // Compter toutes les lignes
    public function count_all($keyword = '')
    {
        if (!empty($keyword)) {
            $this->db->like('name', $keyword);
        }
        return $this->db->count_all_results($this->table);
    }

    // Récupérer les catégories avec pagination
    public function get_paginated($limit, $offset, $keyword = '')
    {
        if (!empty($keyword)) {
            $this->db->like('name', $keyword);
        }
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->table, $limit, $offset);
        return $query->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
	//total table categorie
	public function  getCountTable()
   {
       $query = $this->db->get('categories');
       return $query->num_rows();
       
   }
   public function count_categories()
	{
	   return $this->db->count_all('categories');
	}
}
