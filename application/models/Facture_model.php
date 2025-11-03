<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facture_model extends CI_Model {

    // Compter toutes les factures pour pagination
    public function count_all($search = null) {
        $this->db->from('factures');
        $this->db->join('clients', 'factures.client_id = clients.id');
        if($search){
            $this->db->like('factures.numfacture', $search);
            $this->db->or_like('clients.name', $search);
        }
        return $this->db->count_all_results();
    }

    // Obtenir toutes les factures
    public function get_all($limit, $start, $search = null) {
        $this->db->select('factures.*, clients.name as client_name');
        $this->db->from('factures');
        $this->db->join('clients', 'factures.client_id = clients.id');
        if($search){
            $this->db->like('factures.numfacture', $search);
            $this->db->or_like('clients.name', $search);
        }
        $this->db->order_by('factures.id', 'ASC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    // Obtenir facture par id
    public function get_by_id($id) {
        $this->db->select('factures.*, clients.name as client_name, clients.email, clients.phone');
        $this->db->from('factures');
        $this->db->join('clients', 'factures.client_id = clients.id');
        $this->db->where('factures.id', $id);
        $facture = $this->db->get()->row();
        if($facture){
            $facture->items = $this->get_items($id);
        }
        return $facture;
    }

    // Obtenir les produits d’une facture
    public function get_items($facture_id){
        $this->db->select('fi.*, p.name as product_name');
        $this->db->from('facture_items fi');
        $this->db->join('products p', 'fi.product_id = p.id');
        $this->db->where('fi.facture_id', $facture_id);
        return $this->db->get()->result();
    }

    // Ajouter une facture avec ses items
    public function add_facture($data, $items){
        $this->db->trans_start();

        $this->db->insert('factures', $data);
        $facture_id = $this->db->insert_id();

        foreach($items as $item){
            if(!isset($item['product_id'], $item['quantity'], $item['priceUnit'])) continue;

            $item_data = [
                'facture_id' => $facture_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'priceUnit' => $item['priceUnit'],
                'subtotal' => $item['quantity'] * $item['priceUnit']
            ];
            $this->db->insert('facture_items', $item_data);

            // Mettre à jour le stock
            $this->db->set('qte_stock', 'qte_stock - '.$item['quantity'], FALSE);
            $this->db->where('id', $item['product_id']);
            $this->db->update('products');
        }

        $this->db->trans_complete();
        return $facture_id;
    }

	public function delete_facture($id) {
		// Supprime les lignes associées à la facture
		$this->db->where('facture_id', $id);
		$this->db->delete('facture_items');
	
		// Supprime la facture elle-même
		$this->db->where('id', $id);
		$this->db->delete('factures');
	}
	
}
