<?php defined('C5_EXECUTE') or die(_("Access Denied."));
//https://github.com/herent/c5_boilerplate/blob/master/controller.php
//https://github.com/jordanlev/c5_boilerplate_crud/blob/master/packages/automobiles/controller.php

class ImmoPackage extends Package {

	protected $pkgHandle = 'immo';
	protected $appVersionRequired = '5.6.1.2';
	protected $pkgVersion = '0.1';

	public function getPackageName() {
		return t('Immo for estate agency');
	}

	public function getPackageDescription() {
		return t('Theme and functionnality for estate agency.');
	}

	public function on_start() {
		//                stuff here will run on every page request before anything else.
		//                if full page cache is turned on, this will not run on cached pages
		//
		//                events are the most common use case
		//                for more details on events, check out the documentation here:
		//                http://www.concrete5.org/documentation/developers/system/events
		//
	}

	public function install($post = array()) {
		//
		//                the post object is passed in if you are using the dashbord/install.php
		//                package element. any form fields that you use in that element will
		//                be elements of this array.  you do not need a form tag. check the
		//                element file for examples of syntax
		//
		//                it's beneficial for installation to split things out into
		//                separate functions for organization and ease of reading
		//
		$pkg = parent::install();
		//this will automatically install our package-level db.xml schema for us (among other things)

		//données test
		$this -> seedData($pkg, 'annonces.sql');
		
		//données à définir au lancement du site
		$this -> seedData($pkg, 'type_transactions.sql');

		$this -> installOrUpgrade($pkg);
	}

	public function upgrade() {
		$this -> installOrUpgrade($this);
		parent::upgrade();
	}

	private function installOrUpgrade($pkg) {

//		$this -> installBlocks($pkg);
//		$this -> installSinglePages($pkg);
//		$this -> installPageAttributes($pkg);
//		$this -> installPageTypes($pkg);
//		$this -> installPages($pkg);
//		$this -> installThemes($pkg);
//		$this -> installJobs($pkg);
//		$this -> installGroups();
//		$this -> setPermissions();
		
		//Frontend Page:
		$this -> getOrAddSinglePage($pkg, '/achat-immobilier', 'Acheter');
		$this -> getOrAddSinglePage($pkg, '/location-immobilier', 'Louer');

		//Dashboard Pages:
		//Install one page for each *controller* (not each view),
		// plus one at the top-level to serve as a placeholder in the dashboard menu
		$this -> getOrAddSinglePage($pkg, '/dashboard/immo', 'Immobilier');
		//top-level pleaceholder
		$this -> getOrAddSinglePage($pkg, '/dashboard/immo/annonces', 'Gestion des Annonces');
		$this -> getOrAddSinglePage($pkg, '/dashboard/immo/misc', 'Gestion avancée');		

		//Special 'config' page (for package-wide settings)
//		$config_page = $this -> getOrAddSinglePage($pkg, '/dashboard/automobiles/config', 'Configuration');
//		$config_page -> setAttribute('exclude_nav', 1);
		//don't show this page in the dashboard menu

		//Config settings:
//		$this -> getOrAddConfig($pkg, 'currency_symbol', '$');
//		$this -> getOrAddConfig($pkg, 'dummy_example', 'test');
	}

	private function installBlocks($pkg) {
	}

	private function installSinglePages($pkg) {

		//this array will hold all the custom dashboard page paths and their icons.
		//see the setupDashboardIcons method for more info
	}

	private function installPageAttributes($pkg) {
	}

	private function installPageTypes($pkg) {
	}

	private function installPages($pkg) {
	}

	private function installThemes($pkg) {
	}

	private function installJobs($pkg) {
	}

	private function installGroups() {
	}

	private function setPermissions() {
	}

	public function uninstall() {
		parent::uninstall();

		$table_prefix = 'immo_';
		//<--make sure this is unique enough to not accidentally drop other tables!
		$db = Loader::db();
		$tables = $db -> GetCol("SHOW TABLES LIKE '{$table_prefix}%'");
		$sql = 'DROP TABLE ' . implode(',', $tables);
		$db -> Execute($sql);
	}

	/*** UTILITY FUNCTIONS ***/
	private function seedData($pkg, $filename) {
		//NOTE that you can only run one query at a time,
		// so each sql statement must be in its own file!
		$db = Loader::db();
		$sql = file_get_contents($pkg -> getPackagePath() . '/seed_data/' . $filename);
		$r = $db -> execute($sql);
		if (!$r) {
			throw new Exception(t('Unable to install data: %s', $db -> ErrorMsg()));
		}
	}

	private function getOrAddSinglePage($pkg, $cPath, $cName = '', $cDescription = '') {
		Loader::model('single_page');

		$sp = SinglePage::add($cPath, $pkg);

		if (is_null($sp)) {
			//SinglePage::add() returns null if page already exists
			$sp = Page::getByPath($cPath);
		} else {
			//Set page title and/or description...
			$data = array();
			if (!empty($cName)) {
				$data['cName'] = $cName;
			}
			if (!empty($cDescription)) {
				$data['cDescription'] = $cDescription;
			}

			if (!empty($data)) {
				$sp -> update($data);
			}
		}

		return $sp;
	}

	private function getOrInstallBlockType($pkg, $btHandle) {
		$bt = BlockType::getByHandle($btHandle);
		if (empty($bt)) {
			BlockType::installBlockTypeFromPackage($btHandle, $pkg);
			$bt = BlockType::getByHandle($btHandle);
		}
		return $bt;
	}

	private function getOrAddConfig($pkg, $key, $default_value_if_new = null) {
		$cfg = $pkg -> config($key, true);
		//pass true to retrieve the full object (so we can differentiate between a non-existent config versus an existing config that has value set to null)
		if (is_null($cfg)) {
			$pkg -> saveConfig($key, $default_value_if_new);
			return $default_value_if_new;
		} else {
			return $pkg -> config($key);
		}
	}

}
