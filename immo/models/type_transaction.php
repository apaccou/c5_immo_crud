<?php defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('crud_model', 'immo');

class TypeTransactionModel extends BasicCRUDModel {
    
    protected $table = 'immo_type_transactions';

	public function getSelectOptions() {
		return $this->selectOptionsFromArray($this->getAll(), 'id', 'name', array(0 => '&lt;Choississez&gt;'));
	}          
     
}