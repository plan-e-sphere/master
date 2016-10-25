<span>Mes Sphères</span>
<?php 
	
	$i=0; foreach($listeGroupes as $k => $v): ?>
            <a href="<?php echo Router::url('groupes/view/'.$v->groupes_id); ?>" class="lien_menu">
                    <?php echo $v->groupes_libelle; ?>
            </a>
    
<?php endforeach ?>
