<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<div class="annonces-achat">

<h1><?php
   $pageTitle = 'test';
   Loader::element('header_required', array('pageTitle' => $pageTitle));
   $metaTitle = $c->getCollectionAttributeValue('meta_title');
   if(!empty($metaTitle)) {
      print $metaTitle;
   } else {
      print $c->getCollectionName(); 
   }
?></h1>

<?php echo $slug; ?>
<?php foreach ($annonces as $annonce): ?>
	<?php var_dump($annonce); ?>
	<hr/>
<?php endforeach; ?>
</div>


