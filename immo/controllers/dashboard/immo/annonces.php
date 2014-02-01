<?php

defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('annonce', 'immo');
Loader::model('type_transaction', 'immo');

Loader::library('crud_controller', 'immo'); //Superset of Concrete5's Controller class -- provides simpler interface and some extra useful features.
class DashboardImmoAnnoncesController extends CrudController
{

    public function on_before_render()
    {
        //Load css into the <head> and javascript into the footer of all views for this controller
        // (If you want to load js/css only for one action, put the addHeaderItem/addFooterItem call in that action's method instead)
        //DEV NOTE: we use "on_before_render()" instead of "on_page_view()" (on_page_view only works in block controllers [??])
        $hh = Loader::helper('html');
        $this->addHeaderItem($hh->css('dashboard.css', 'immo'));
        $this->addFooterItem($hh->javascript('dashboard.js', 'immo'));
    }
    
    public function view() {
        $ttm = $this->model('type_transaction');      
        $type_transaction_id = empty($_GET['type']) ? 0 : ( $ttm->exists($_GET['type']) ? intval($_GET['type']) : 0 );
        $this->set('type_transaction_id', $type_transaction_id);
        $this->set('type_transaction_options', $ttm->getSelectOptions());

        $this->set('annonces', $this->model('annonce')->getByTypeTransactionId($type_transaction_id));
    }

}
