<?php defined('C5_EXECUTE') or die(_("Access Denied."));

$dh = Loader::helper('concrete/dashboard');
$ih = Loader::helper('concrete/interface');
$form = Loader::helper('form');
?>


<?php echo $dh->getDashboardPaneHeaderWrapper('Annonces'); ?>
    <form action="<?php echo $this->action('view'); ?>" method="get" class="segment-filter form-inline">
        <label for="type">Type de transaction :</label>
        <?php echo $form->select('type', $type_transaction_options, $type_transaction_id); ?>
        <input type="submit" class="btn ccm-input-submit" value="Go" />
        <span class="loading-indicator"><img src="<?php echo ASSETS_URL_IMAGES; ?>/throbber_white_16.gif" width="16" height="16" alt="loading..." /></span>
    </form>
    
    <?php if (!empty($type_transaction_id)): ?>
    
    <hr/>
    
    <?php
    Loader::library('crud_display_table', 'immo');
    $table = new CrudDisplayTable($this);
    
    $table->addColumn('type_bien_id', 'Type Bien Id');
    $table->addColumn('year', 'Model Year');
    $table->addColumn('name', 'Name');    
    
    $table->addAction('edit', 'right', 'Edit', 'icon-pencil');
    $table->addAction('delete', 'right', 'Delete', 'icon-trash');

    $table->display($annonces);
    ?>
    
    <p><?php echo $ih->button("Ajouter Nouveau {$type_transaction_options[$type_transaction_id]}...", $this->action('add', $type_transaction_id), false, 'primary'); ?></p>
    
    <?php endif ?>    

<?php echo $dh->getDashboardPaneFooterWrapper(); ?>