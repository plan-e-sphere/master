<link rel="stylesheet" href="<?php echo CSS.'/style_users.css';?>"/>
<div class="page-header">
	<h1><img src="<?php echo $users['users_photo']; ?>" class="photo_arrondie"/> Profil de <?php echo $users['users_pseudo']; ?></h1>
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
<div id="menu_user" class="col-md-12">
    <a class="button_perso_users btn align-left" href="<?php echo Router::url('users/profil/'.$users['users_id'])?>/update">
        <i class="fa fa-pencil fa-lg" aria-hidden="true"></i> <span>Editer mon profil</span>
    </a>
    <a class="button_perso_users btn align-left" href="<?php echo Router::url('adresses/mesAdresses')?>">
        <i class="fa fa-map-marker fa-lg" aria-hidden="true"></i> <span>Gérer mes adresses</span>
    </a>
    <a class="button_perso_users btn align-left" href="<?php echo Router::url('users/profil/'.$users['users_id'])?>/update">
        <i class="fa fa-car" aria-hidden="true"></i> <span>Gérer mes voitures</span>
    </a>
</div>
<hr>
<div id="profil" class="col-md-12">
    <div class="col-md-12">
            <b>Nom :</b> <?php echo $users['users_nom']; ?>
    </div>
    <div class="col-md-12">
            <b>Prenom :</b> <?php echo $users['users_prenom']; ?>
    </div>
    <div class="col-md-12">
            <b>Email :</b> <?php echo $users['users_mail']; ?>
    </div>
</div>