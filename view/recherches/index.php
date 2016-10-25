<div class="page-header">
	<h1><?php echo isset($title)?$title:'R&eacute;sultat de la recherche'; ?></h1>
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
				var text_popover='<a class=\'link btn\' onclick=\'friends('+id_friend+',2)\'>Annuler mon invitation</a>';
				$('#button'+id_friend).html('<button class="button_perso" data-toggle="popover" data-content="'+text_popover+'"><i class="fa fa-user fa-lg orange"></i> <span>'+text_button+'</span></button>');
				loadPopover();			
			}else if(request=="1"){
				var text_button=' Ami&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-down"></span>';
				var text_popover='<a class=\'btn link\' onclick=\'friends('+id_friend+',4)\'>Retirer de ma liste d\'ami</a>';
				$('#button'+id_friend).html('<button class="button_perso" data-toggle="popover" data-content="'+text_popover+'"><i class="fa fa-user fa-lg green"></i> <span>'+text_button+'</span></button>');
				loadPopover();
			}
			else if(request=="2" || request=="3" || request=="4"){
				var text_button='Ajouter';
				$('#button'+id_friend).html('<button class="button_perso" onclick="friends(\''+id_friend+'\',\'0\');"><i class="fa fa-user-plus fa-lg"></i> <span>'+text_button+'</span></button>');
				loadPopover();
			}
		});
	};
</script>
<h2>Resultats correspondants &agrave; votre recherche </h2>
<h3 class="col-md-12">Personnes</h3>
<div id="resultat_recherche">
<?php $i=0;foreach ($users as $k => $v): 

			switch ($v->users_amitie) {
				case 0://pas ami
					$button='<button class="button_perso" onclick="friends(\''.$v->users_id.'\',\'0\');">
							<i class="fa fa-user-plus fa-lg"></i> <span>Ajouter</span></button>';			
				break;
				case 1://ami
					$text='Ami&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-down"></span>';
					$data_content="<a class='btn link' onclick='friends(".$v->users_id.",4)'>Retirer de ma liste d'ami</a>";
					$data_toggle="popover";
					$button='<button class="button_perso" data-toggle="'.$data_toggle.'" data-content="'.$data_content.'">
							<i class="fa fa-user fa-lg green"></i> <span>'.$text.'</span></button>';
				break;
				case 2://accepter l'invitation
					$src = IMG.'/demandeAmi.png';
					$text='Accepter l\'invitation&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-down"></span>';
					$data_content="<a class='link btn' onclick='friends(".$v->users_id.",1)'>Accepter l'invitation</a>
								<a class='link btn' onclick='friends(".$v->users_id.",3)'>Refuser l'invitation</a>";
					$data_toggle="popover";
					$button='<button class="button_perso" data-toggle="'.$data_toggle.'" data-content="'.$data_content.'">
							<img src="'.$src.'" width="30" height="30"/>
							<span>'.$text.'</span></button>';
				break;
				case 3://en attente de validation
					$text='En attente de validation&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-down"></span>';
					$data_content="<a class='link btn' onclick='friends(".$v->users_id.",2)'>Annuler mon invitation</a>";
					$data_toggle="popover";
					$button='<button class="button_perso" data-toggle="'.$data_toggle.'" data-content="'.$data_content.'">
							<i class="fa fa-user fa-lg orange"></i> <span>'.$text.'</span></button>';
				break;
				case 4://son profil
					$src = $this->Session->user('users_photo');
					$text='Voir mon profil';
					$button='<a class="button_perso btn" href="'.Router::url('users/profil/'.$v->users_id).'">
							<img src="'.$src.'" width="30" height="30"/>
							<span>Voir mon profil</span></a>';
				break;
			}
			?>
			
	<div class="col-md-5 recherche_result">
		<div class="col-md-6">
			<a href=<?php echo Router::url('users/profil/'.$v->users_id);?>>
				<img src="<?php echo $v->users_photo; ?>" class="photo_arrondie_petite"/>
			
			<?php if(trim($v->users_pseudo)!=""):echo $v->users_pseudo;else: echo $v->users_prenom." ".$v->users_nom; endif ?></a>
		</div>
		<div id="button<?php echo $v->users_id ?>"  class="col-md-6 align-right">
				<?php echo $button;?>
		</div>
	</div>
    <?php endforeach ?>
    <h3 class="col-md-12">Evénements</h3>
    <?php $i=0;foreach ($events as $k => $v):?>
    <div class="col-md-5 recherche_result">
        <a href=<?php echo Router::url('events/view/'.$v->events_id);?>>
            <img src="<?php echo $v->events_image; ?>" class="photo_arrondie_petite"/>
            <?php echo $v->events_libelle; ?>
        </a>
    </div>
    <?php endforeach;?>
</div>