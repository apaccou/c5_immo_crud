<?php

defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('crud_model', 'immo');

class AnnonceModel extends BasicCRUDModel
{

    protected $table = 'immo_annonces';

    public function getById($id)
    {
        $sql = "SELECT annonce.*, type_transactions.name AS type_transactions_name" .
            " FROM {$this->table} annonce" .
            " INNER JOIN immo_type_transactions type_transactions ON type_transactions.id = annonce.type_transaction_id" .
			" WHERE annonce.{$this->pkid} = ?" . " LIMIT 1";
        $vals = array(intval($id));
        return $this->db->GetRow($sql, $vals);
    }

	public function getByTypeTransactionId($type_transaction_id) {
		$sql = "SELECT annonce.*"
		     . " FROM {$this->table} annonce";
		$vals = array();
		
		if (!empty($type_transaction_id)) {
			$sql .= " WHERE annonce.type_transaction_id = ?";
			$vals[] = intval($type_transaction_id);
		}
		
		$sql .= " ORDER BY annonce.name";
		
		return $this->db->GetArray($sql, $vals);
	}
    
    public function getByTypeBienId($type_bien_id)
    {
    }

}
