<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
<div class='col-md-12'>
<h1><?php echo isset($title)?$title:'Groupes'; ?></h1>
<?php $i=0; foreach($listeGroupes as $k => $v): ?>
    <div class="col-md-3">
            <p><a href="<?php echo Router::url('groupes/view/'.$v->groupes_id); ?>" class="link_head">
            <button type="button" class="circle white">
                    <div class="pastille_arrondie_petite" style='background-color:<?php echo $color;?>'></div>
                    <h4><?php echo $v->groupes_libelle; ?></h4>				
            </button>
            </a></p>
    </div>
<?php endforeach ?>
</div>