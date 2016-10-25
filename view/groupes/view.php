<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
<script>
	function listInvite(){
		$('#myModal').on('show.bs.modal', function (e) {
			 $('#myInput').focus();
		})
	}
	
	function loadAdmin(id_groupe){
		$('#administrateur')
                .hide().fadeIn(1000) // make sure #target starts hidden
                .load("<?php echo Router::url('groupes/ajax/administrateur/'); ?>"+id_groupe, function() {
                    $(this).fadeIn(1000); // when page.html has loaded, fade #target in
                });
	}
	
	function loadModo(id_groupe){
		$('#moderateur')
                .hide().fadeIn(1000) // make sure #target starts hidden
                .load("<?php echo Router::url('groupes/ajax/moderateur/'); ?>"+id_groupe, function() {
                    $(this).fadeIn(1000); // when page.html has loaded, fade #target in
                });
	}
	
	function loadMembre(id_groupe){
		$('#membre')
                .hide().fadeIn(1000) // make sure #target starts hidden
                .load("<?php echo Router::url('groupes/ajax/membre/'); ?>"+id_groupe, function() {
                    $(this).fadeIn(1000); // when page.html has loaded, fade #target in
                });
	}
	
	function inviter(idFriend,idGroupe){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('groupes/inviteGroupe/'); ?>"+idFriend+"/"+idGroupe,
			
		})
		.done(function(request){
			$('#bt_invit'+idFriend).html("invitation envoy&eacute;e ");
			loadMembre(idGroupe);
		});
	}
	
	function promouvoir(role, id_user, id_groupe){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('groupes/promouvoir/'); ?>" + role + "/" + id_user + "/" + id_groupe,
		})
		.done(function(request){
			loadMembre(id_groupe);
			loadModo(id_groupe);
			loadAdmin(id_groupe);
		});
	}
	
	function exclure(id_user, id_groupe){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('groupes/exclure/'); ?>" + id_user + "/" + id_groupe,
		})
		.done(function(request){
			$('#bt_invit'+id_user).html("<input type='button' value='inviter' onClick='inviter("+id_user+","+id_groupe+");' />");
			loadMembre(id_groupe);
			loadModo(id_groupe);
			loadAdmin(id_groupe);
		});
	}
	
	function quitter(id_user, id_groupe){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('groupes/quitter/'); ?>" + id_user + "/" + id_groupe,
		})
		.done(function(request){
			loadMembre(id_groupe);
			loadModo(id_groupe);
			loadAdmin(id_groupe);
			$('#message_notif').html(request);
			$('#container_message_notif').fadeIn('slow').delay(800).fadeOut('slow');
		});
	}
</script>
<div id="page-header">
</div>

<div class="row">
	<div id="admin" class="col-md-6 text-left">
		<?php if($groupes->role!="Visiteur"):?>
			<a href="#" onclick="listInvite();" class="btn btn-default glyphicon glyphicon-envelope" data-toggle="modal" data-target="#myModal"> Inviter</a>
		<?php else:?>
			<button class="btn btn-default glyphicon glyphicon-remove" onclick="quitter(<?php echo $this->Session->User('users_id').','.$groupes->groupes_id;?>);"> Quitter</button>
		<? endif;if($groupes->role=="Membre" or $groupes->role=="Modo"):?>
			<button class="btn btn-default glyphicon glyphicon-remove" onclick="quitter(<?php echo $this->Session->User('users_id').','.$groupes->groupes_id;?>);"> Quitter</button>
		<?php endif;if($groupes->role=="Modo" or $groupes->role=="Admin"):?>
			<a href="<?php echo Router::url('groupes/view/'.$groupes->groupes_id.'/update'); ?>" class="btn btn-default glyphicon glyphicon-pencil"> Modifier</a>
		<?php endif;if($groupes->role=="Admin"):?>
			<button type="button" class="btn btn-default glyphicon glyphicon-remove"
					data-toggle="popover" title="Etes-vous sur ?" data-html="true" data-trigger="click"
					data-content="<a href='<?php echo Router::url('groupes/delete/'.$groupes->groupes_id); ?>'><button type='button' class='btn btn-default'>Supprimer</button></a>" 
					data-placement="bottom"> Supprimer
			</button>
		<?php endif;?>
	</div>		
</div>	


<div class="col-md-12">
	<h2><?php echo $groupes->groupes_libelle; ?> <small><?php echo $groupes->groupes_description; ?></small></h2>
</div>
<div class="col-md-6">
	<h3>Administrateur(s):</h3>
	<div id="administrateur">
		<?php foreach ($groupes->users_admins as $k => $v): ?>
			<h4><img src="<?php echo $v->users_photo; ?>" class="photo_arrondie_petite"/> <?php echo $v->users_pseudo; ?></h4>
		<?php endforeach ?>
	</div>
</div>
<div class="col-md-6">
	<h3>Modérateur(s):</h3>
	<div id="moderateur">
		<?php foreach ($groupes->users_modos as $k => $v): ?>
			<h4>
				<img src="<?php echo $v->users_photo; ?>" class="photo_arrondie_petite"/> <?php echo $v->users_pseudo; ?>
				<?php if($groupes->role=="Admin"):?>
					<button class="button_perso" onclick="promouvoir('Admin',<?php echo $v->users_id.','.$groupes->groupes_id;?>);">Promotion</button>
					<button class="button_perso" onclick="exclure(<?php echo $v->users_id.','.$groupes->groupes_id;?>);">Exclure</button>
				<?php endif;?>
			</h4>
		<?php endforeach ?>
	</div>
</div>
<div class="col-md-12">
	<h3>Membre(s):</h3>
	<div id="membre">
		<?php foreach ($groupes->users_membres as $k => $v): ?>
			<h4>
				<img src="<?php echo $v->users_photo; ?>" class="photo_arrondie_petite"/> <?php echo $v->users_pseudo; ?>
				<?php if($groupes->role=="Admin"):?>
					<button class="button_perso" onclick="promouvoir('Modo',<?php echo $v->users_id.','.$groupes->groupes_id;?>);">Promotion</button>
					<button class="button_perso" onclick="exclure(<?php echo $v->users_id.','.$groupes->groupes_id;?>);">Exclure</button>
				<?php endif;?>
			</h4>
		<?php endforeach ?>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Liste de mes amis</h4>
			</div>
			<div class="modal-body row">
				<?php foreach ($friendsList as $k => $v):?>
					<div class="col-md-4 text-center">
						<img src='<?php echo $v->users_photo;?>' alt='photo de profil' class='photo_arrondie'></img>
						<div>
							AKA :  <?php echo $v->users_pseudo;?><br/>
							<i> <?php echo $v->users_nom.' '.$v->users_prenom;?></i>
						</div>
						<?php if(!$v->invit): ?>
							<div id='bt_invit<?php echo $v->users_id;?>'>
								<input type='button' value='inviter' onClick='inviter(<?php echo $v->users_id;?>,<?php echo $groupes->groupes_id;?>);' />
							</div>
						<?php else: ?>
							<b> D&eacute;j&agrave; dans le groupe</b>
						<?php endif;?>
					</div>
				<?php endforeach;?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>
	</div>
 </div>