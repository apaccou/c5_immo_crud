<?php defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('annonce', 'immo');

Loader::library('crud_controller', 'immo');
//Superset of Concrete5's Controller class -- provides simpler interface and some extra useful features.

class AchatImmobilierController extends CrudController {
	public function on_before_render() {
		//Load css into the <head> and javascript into the footer of all views for this controller
		// (If you want to load js/css only for one action, put the addHeaderItem/addFooterItem call in that action's method instead)
		//DEV NOTE: we use "on_before_render()" instead of "on_page_view()" (on_page_view only works in block controllers [??])
		$hh = Loader::helper('html');
		$this -> addHeaderItem($hh -> css('automobiles.css', 'automobiles'));
		$this -> addFooterItem($hh -> javascript('automobiles.js', 'automobiles'));
	}

	public function view($type_bien_url_slug = null) {
		if (!empty($type_bien_url_slug)) {             
			//$annonces = $this -> model('annonce') -> getByTypeBienUrlSlug($type_bien_url_slug);
            $annonces = $this -> model('annonce') -> getByTypeTransactionId($type_bien_url_slug);
		} else {
			$annonces = $this -> model('annonce') -> getAll();			
		}
        $this-> set('slug', $type_bien_url_slug);
		$this -> set('annonces', $annonces);
	}

}
