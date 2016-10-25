<div class="page-header">
	<h1><?php echo isset($title)?$title:'Profil'; ?></h1>
</div>
<script>
	$(function() {
		$('[data-toggle="popover"]').webuiPopover({
			html: true,
			trigger: 'click',
			placement: 'bottom-left',
			delay: {show : 1400,	hide : 300},
			padding:false,
			width:'auto',
			animation: false
		});
		
	});
	
	function loadPopover(){
		$('[data-toggle="popover"]').webuiPopover({
			html: true,
			trigger: 'click',
			placement: 'bottom-left',
			delay: {show : 400,	hide : 300},
			padding:false,
			width:'auto',
			animation: false
		})
	};
	
	function friends(id_friend, method){	
		$('[data-toggle="popover"]').webuiPopover('hide');
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('users/askFriend/'); ?>"+id_friend+"/"+method,
			
		})
		.done(function(request) {
			if(request=="0"){
				var text_button=' En attente de validation&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-down"></span>';
				var img='<?php echo IMG."/attenteAmi.png";?>';
				var text_popover='<a class=\'link btn\' onclick=\'friends('+id_friend+',2)\'>Annuler mon invitation</a>';
				$('#button'+id_friend).html('<button class="button_perso" data-toggle="popover" data-content="'+text_popover+'"><img src="'+img+'" width="30" height="30"/><span>'+text_button+'</span></button>');
				loadPopover();			
			}else if(request=="1"){
				var text_button=' Ami&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-down"></span>';
				var img='<?php echo IMG.'/ami.png';?>';
				var text_popover='<a class=\'btn link\' onclick=\'friends('+id_friend+',4)\'>Retirer de ma liste d\'ami</a>';
				$('#button'+id_friend).html('<button class="button_perso" data-toggle="popover" data-content="'+text_popover+'"><img src="'+img+'" width="30" height="30"/><span>'+text_button+'</span></button>');
				loadPopover();
			}
			else if(request=="2" || request=="3" || request=="4"){
				var text_button='Ajouter';
				var img='<?php echo IMG.'/pasAmi.jpg';?>';
				$('#button'+id_friend).html('<button class="button_perso" onclick="friends(\''+id_friend+'\',\'0\');"><img src="'+img+'" width="30" height="30"/><span>'+text_button+'</span></button>');
				loadPopover();
			}
		});
	};
</script>
<?php
	switch ($users['users_amitie']) {
		case 0://pas ami
			$src = IMG.'/pasAmi.jpg';
			$button='<button class="button_perso" onclick="friends(\''.$users['users_id'].'\',\'0\');">
					<img src="'.$src.'" width="30" height="30"/>
					<span>Ajouter</span></button>';			
		break;
		case 1://ami
			$src = IMG.'/ami.png';
			$text='Ami&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-down"></span>';
			$data_content="<a class='btn link' onclick='friends(".$users['users_id'].",4)'>Retirer de ma liste d'ami</a>";
			$data_toggle="popover";
			$button='<button class="button_perso" data-toggle="'.$data_toggle.'" data-content="'.$data_content.'">
					<img src="'.$src.'" width="30" height="30"/>
					<span>'.$text.'</span></button>';
		break;
		case 2://accepter l'invitation
			$src = IMG.'/demandeAmi.png';
			$text='Accepter l\'invitation&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-down"></span>';
			$data_content="<a class='link btn' onclick='friends(".$users['users_id'].",1)'>Accepter l'invitation</a>
						<a class='link btn' onclick='friends(".$users['users_id'].",3)'>Refuser l'invitation</a>";
			$data_toggle="popover";
			$button='<button class="button_perso" data-toggle="'.$data_toggle.'" data-content="'.$data_content.'">
					<img src="'.$src.'" width="30" height="30"/>
					<span>'.$text.'</span></button>';
		break;
		case 3://en attente de validation
			$src = IMG.'/attenteAmi.png';
			$text='En attente de validation&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-down"></span>';
			$data_content="<a class='link btn' onclick='friends(".$users['users_id'].",2)'>Annuler mon invitation</a>";
			$data_toggle="popover";
			$button='<button class="button_perso" data-toggle="'.$data_toggle.'" data-content="'.$data_content.'">
					<img src="'.$src.'" width="30" height="30"/>
					<span>'.$text.'</span></button>';
		break;
		case 4://son profil
			$src = $this->Session->user('users_photo');
			$text='Voir mon profil';
			$button='<a class="button_perso btn" href="'.Router::url('users/profil/'.$users['users_id']).'/update">
					<img src="'.$src.'" width="30" height="30"/>
					<span>Editer mon profil</span></a>';
		break;
	}?>
	<div class="col-md-12">
		<h2 class="col-md-6">
			<img src="<?php echo $users['users_photo']; ?>" class="photo_arrondie"/> Profil de <?php echo $users['users_pseudo']; ?>
		</h2>
		<div id="button<?php echo $users['users_id'] ?>"  class="col-md-6 align-right">
			<?php echo $button;?>
		</div>
	</div>
	<div class="col-md-12">
		<b>Nom :</b> <?php echo $users['users_nom']; ?>
	</div>
	<div class="col-md-12">
		<b>Prenom :</b> <?php echo $users['users_prenom']; ?>
	</div>
	<div class="col-md-12">
		<b>Email :</b> <?php echo $users['users_mail']; ?>
	</div>
	