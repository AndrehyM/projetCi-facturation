<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // Vérifier login avec MD5
    public function verify_login($email, $password) {
        $md5_pass = $password;
        return $this->db->get_where('users', [
            'email' => $email,
            'password' => $md5_pass
        ])->row();
    }

    // Récupérer utilisateur par email
    public function get_user_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }
	//afficher listes des users
	public function getAllUser(){
		$query = $this->db->query('SELECT * FROM users GROUP BY id ASC');
		return $query->result();
	 }
    // Enregistrer le token de reset
    public function set_reset_hash($email, $hash_key, $expiry) {
        $data = [
            'has_key' => $hash_key,
            'hash_expiry' => $expiry
        ];
        $this->db->where('email', $email);
        return $this->db->update('users', $data);
    }

    // Récupérer utilisateur par token
    public function get_user_by_hash($hash_key) {
        $this->db->where('has_key', $hash_key);
        $this->db->where('hash_expiry >=', date('Y-m-d H:i:s'));
        return $this->db->get('users')->row();
    }

    // Mettre à jour le mot de passe avec MD5
    public function update_password($id, $new_password) {
        $data = [
            'password' => $new_password,
            'has_key' => NULL,
            'hash_expiry' => NULL
        ];
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

	//total table users
	public function  getCountTable()
   {
       $query = $this->db->get('users');
       return $query->num_rows();
       
   }

   public function count_users()
   {
      return $this->db->count_all('users');
   }

   // Récupérer les utilisateurs avec pagination et recherche
public function get_users($limit, $start, $search = null) {
    if ($search) {
        $this->db->like('username', $search);
        $this->db->or_like('email', $search);
    }
    $query = $this->db->get('users', $limit, $start);
    return $query->result();
}

// Compter les utilisateurs (pour pagination)
public function count_all($search = null) {
    if ($search) {
        $this->db->like('username', $search);
        $this->db->or_like('email', $search);
    }
    return $this->db->count_all_results('users');
}

   // Insérer un nouvel utilisateur
public function insert($data) {
    return $this->db->insert('users', $data);
}
//supprimer
public function delete_user($id) { 
	return $this->db->delete($this->table, ['id' => $id]); 
}

}
