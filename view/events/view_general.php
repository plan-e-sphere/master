<div class="col-md-6">
	<div class="col-md-12">
		<h2><?php echo $events->events_libelle; ?>
			<?php if(date("Ymd",strtotime($events->events_date_fin))== '19700101'){?>
				<small class="black">Le <?php echo strftime('%a %d %b %Y',strtotime($events->events_date_debut)); ?></small>
			<?php }else{?>
				<small class="black">Du <?php echo strftime('%a %d %b %Y',strtotime($events->events_date_debut)); ?> au <?php echo strftime('%a %d %b %Y',strtotime($events->events_date_fin)); ?></small>
			<?php }?>
		</h2>
	</div>
	<div class="col-md-12">
		<b>Description :</b> <?php echo $events->events_description; ?>
	</div>
	<div class="col-md-12">
		<b>Mots cl&eacute;s :</b> <?php echo $events->events_keyword; ?>
	</div>
	<div class="col-md-12">
		<b>Ev&egrave;nement valid&eacute; :</b> <?php echo $events->events_validation; ?>
	</div>
	<div class="col-md-12">
		<b>Createur :</b> <a href="<?php echo Router::url('users/profil/'.$events->users_users_id);?>"><?php echo $events->users_pseudo;?></a>
	</div>
	<div class="col-md-12">
		<b>Nombre de participants maximum :</b> <?php echo $events->events_nb_participants_max; ?>
	</div>
</div>
<div class="col-md-6 div_image_view_events">
	<img src="<?php echo $events->events_image; ?>" class="image_view_events"/>
</div>

