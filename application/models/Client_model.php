<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_model extends CI_Model {

    private $table = 'clients';

    public function __construct() {
        parent::__construct();
    }
	public function count_clients()
	{
	   return $this->db->count_all('clients');
	}

    public function get_clients($limit, $start, $search = null) {
        if ($search) {
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('phone', $search);
        }
        $query = $this->db->get($this->table, $limit, $start);
        return $query->result();
    }

    public function count_all($search = null) {
        if ($search) {
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('phone', $search);
        }
        return $this->db->count_all_results($this->table);
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function update_client($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete_client($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

	//  Liste complète des clients (pour Factures)
public function getAllClients() {
    $query = $this->db->order_by('name', 'ASC')->get($this->table);
    return $query->result();
}
//total table categorie
public function  getCountTable()
{
	$query = $this->db->get('clients');
	return $query->num_rows();
	
}

}
