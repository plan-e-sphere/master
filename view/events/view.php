  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo CSS.'/style_events.css';?>"/>
  <link rel="stylesheet" type="text/css" href=<?php echo CSS."/jquery.datetimepicker.css" ?>>
  <script type ="text/javascript" src = <?php echo JS."/jquery.datetimepicker.js" ?> ></script>
<script>
	function listInvite(){
		$('#myModal').on('show.bs.modal', function (e) {
			 $('#myInput').focus();
		})
	}
		
	function inviter(idFriend,idEvent){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('events/inviteEvent/'); ?>"+idFriend+"/"+idEvent,
			
		})
		.done(function(request){
			$('#bt_invit'+idFriend).html("invitation envoy&eacute;e ")
		});
	}
	
	function inviterGroupe(idGroup,idEvent){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('events/inviteGroupEvent/'); ?>"+idGroup+"/"+idEvent,
			
		})
		.done(function(request){
			$('#bt_invit'+idGroup).html("invitation envoy&eacute;e ")
			$( '#participants' ).load( "<?php echo Router::url('events/ajax/participants/'.$events->events_id) ?>",function() {
			  loadPopover(600);
			  });
		});
	}
	
	function acceptRefuse(userid, eventId, choix){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('events/acceptRefuse/'); ?>"+userid+"/"+eventId+"/"+choix,
		})
		.done(function(request){
			var tabRequest=request.split(";");
			if(tabRequest[0]==="1"){
                            $(".icone_choix").removeClass("selected_choice").addClass("unselected_choice");
                            $("#icone_accept").removeClass("unselected_choice").addClass("selected_choice");
                            enableTabs();
			}else if(tabRequest[0]==="-1"){
                            $(".icone_choix").removeClass("selected_choice").addClass("unselected_choice");
                            $("#icone_refuse").removeClass("unselected_choice").addClass("selected_choice");
                            selectTabs('0');                
                            disableTabs();   
			}else if(tabRequest[0]==="2"){
                            $(".icone_choix").removeClass("selected_choice").addClass("unselected_choice");
                            $("#icone_unknow").removeClass("unselected_choice").addClass("selected_choice");
                            selectTabs('0');
                            disableTabs();
			}
			set_alert_message("success",tabRequest[1]);
			$( '#participants' ).load( "<?php echo Router::url('events/ajax/participants/'.$events->events_id) ?>",function() {
			  loadPopover(600);
			  });
		});
	}
	
	function disableTabs(){
		$( "#tabs" ).tabs('disable',2);
		$( "#tabs" ).tabs('disable',3);
	};
	
	function enableTabs(){
		$( "#tabs" ).tabs('enable',2);
		$( "#tabs" ).tabs('enable',3);
	};
	function selectTabs(index){
		console.log(index);
		$( "#tabs" ).tabs({
			active: index
		});
	};
	$(function() {
                initialiseIcone(<?php echo $lnUserEvent->ln_users_events_accepted ?>); 
                initialiseIconePass(<?php echo $lnUserEvent->ln_users_events_accepted ?>); 
                $("#icone_accept").click(function(){
                    acceptRefuse(<?php echo $this->Session->User('users_id').",".$events->events_id ?>,'1');
                });
                $("#icone_unknow").click(function(){
                    acceptRefuse(<?php echo $this->Session->User('users_id').",".$events->events_id ?>,'2');  
                });
                $("#icone_refuse").click(function(){
                    acceptRefuse(<?php echo $this->Session->User('users_id').",".$events->events_id ?>,'-1');   
                });  
                
		$( '#participants' ).load( "<?php echo Router::url('events/ajax/participants/'.$events->events_id) ?>",function() {
		  loadPopover(600);
		  });
		$( "#tabs" ).tabs().addClass( "ui-helper-clearfix" );
		$( "#invite" ).tabs().addClass( "ui-helper-clearfix" );
                initialiseTabs(<?php echo $lnUserEvent->ln_users_events_accepted ?>); 
	});
	
	
	function loadScript() {
	  var script = document.createElement('script');
	  script.type = 'text/javascript';
	  script.src = 'https://maps.googleapis.com/maps/api/js?language=fr&v=3.exp&callback=initialize&key=AIzaSyAPin5ihi8yKd8FnD01-la1l8W6vq0tBbk';
	  document.body.appendChild(script);
	};
        
        function initialiseTabs(accept){
            if(accept==1){
                enableTabs();
            }else{
                disableTabs();
            }
        };
	
        function initialiseIcone(accept){
            if ( accept==0){
                $(".icone_choix").removeClass("selected_choice").addClass("unselected_choice");
            }else if(accept==1){
                $(".icone_choix").removeClass("selected_choice").addClass("unselected_choice");
                $("#icone_accept").removeClass("unselected_choice").addClass("selected_choice");
            }else if(accept==2){
                $(".icone_choix").removeClass("selected_choice").addClass("unselected_choice");
                $("#icone_unknow").removeClass("unselected_choice").addClass("selected_choice");
            }else{
                $(".icone_choix").removeClass("selected_choice").addClass("unselected_choice");
                $("#icone_refuse").removeClass("unselected_choice").addClass("selected_choice");
            }
        };
        function initialiseIconePass(accept){
            $(".icone_choix_pass").removeClass("selected_choice_pass").addClass("unselected_choice_pass");
            if(accept==1){
                $("#icone_accept_pass").removeClass("unselected_choice_pass").addClass("selected_choice_pass");
            }else if(accept==2){
                $("#icone_unknow_pass").removeClass("unselected_choice_pass").addClass("selected_choice_pass");
            }else{
                $("#icone_refuse_pass").removeClass("unselected_choice_pass").addClass("selected_choice_pass");
            }
        };
	//covoit
	function validerVoiture(){
		var voiture = {nbPlaceMax:$("#nbPlaceMax").val(),
			lieu:$("#covoiturages_lieu_rdv").val(),
			dateHeure:$("#datetimepicker").val()
		};
		var json = JSON.stringify(voiture);
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('events/addVoiture/'.$events->events_id.'/'.$this->Session->User('users_id').'/'); ?>"+json,
		}).done(function(request){
			$("#affichage").load( "<?php echo Router::url('events/passagers/'.$events->events_id.'/'.$this->Session->User('users_id').'/'.$this->Session->User('users_id')) ?>",function() {
			set_alert_message("success","Votre voiture a bien été ajoutée");
		  });
		});
	}
	
	function selectionnerChauffeur(idChauffeur){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('events/addPassager/'.$events->events_id.'/'.$this->Session->User('users_id').'/'); ?>"+idChauffeur,
		}).done(function(request){
                       $("#tabs-4").hide("slide" , { direction: "left" }, "slow", function(){
                           $(this).html(request);
                        }).show("slide" , { direction: "right" }, "slow" );
		});
	}
	
	
	function voitureCovoit(){
		$('#voiture').on('show.bs.modal', function (e) {
			 $('#myInput').focus();
		})
		$('#datetimepicker').datetimepicker({
			 lang:'FR',
			 i18n:{
			  FR:{
			   months:[
				'Janvier','Fevrier','Mars','Avril',
				'Mai','Juin','Juillet','Août',
				'Septembre','Octobre','Novembre','Decembre',
			   ],
			   dayOfWeek:[
				"Di","Lu", "Ma", "Me", 
				"Je", "Ve", "Sa"
			   ]
			  }
			 },
			 timepicker:true,
			 format:'d-m-Y H:i:00'
	});
	}
	
	function refuseCovoit(idChauffeur){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('events/removePassager/'.$events->events_id.'/'.$this->Session->User('users_id').'/'); ?>",
		}).done(function(request){
			$("#tabs-4").hide("slide" , { direction: "left" }, "slow", function(){
                           $(this).html(request);
                        }).show("slide" , { direction: "right" }, "slow" );
		});
	}
	//}
</script>
<!-- Boutons de participation -->
<div class="page-header">
	<div id="bt_reponse">
            <?php if ($lnUserEvent->ln_users_events_role!="createur"){
                if(date("YmdHi",strtotime($events->events_date_debut)) > date("YmdHi")){ ?>
                <span id="icone_accept_span"><i id="icone_accept" class="fa fa-thumbs-o-up fa-2x icone_choix" aria-hidden="true"></i></span>
                <span id="icone_unknow_span"><i id="icone_unknow" class="fa fa-hand-spock-o fa-2x icone_choix" aria-hidden="true"></i></span>
                <span id="icone_refuse_span"><i id="icone_refuse" class="fa fa-thumbs-o-down fa-2x icone_choix" aria-hidden="true"></i></span>   	
            <?php 
                }else{ ?>
                    <span id="icone_accept_span"><i id="icone_accept_pass" class="fa fa-thumbs-o-up fa-2x icone_choix_pass" aria-hidden="true"></i></span>   
                    <span id="icone_unknow_span"><i id="icone_unknow_pass" class="fa fa-hand-spock-o fa-2x icone_choix_pass" aria-hidden="true"></i></span>   
                    <span id="icone_refuse_span"><i id="icone_refuse_pass" class="fa fa-thumbs-o-down fa-2x icone_choix_pass" aria-hidden="true"></i></span>   
               <?php }
            }?>
        </div>
</div>

<div class="row">
	<div id="admin" class="col-md-6 text-left">
                <?php if(date("YmdHi",strtotime($events->events_date_debut)) > date("YmdHi")){ ?>
                    <a href="#" onclick="listInvite();" class="btn btn-default" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope"></i> Inviter</a>
		<?php 
                }
                if($events->users_users_id==$this->Session->User('users_id')):?>
			<a href="<?php echo Router::url('events/view/'.$events->events_id.'/update'); ?>" class="btn btn-default"><i class="fa fa-pencil"></i> Modifier</a>
			<button type="button" class="btn btn-default"
					data-toggle="popover" title="Etes-vous sur ?" data-html="true" data-trigger="click"
					data-content="<a href='<?php echo Router::url('events/delete/'.$events->events_id); ?>'><button type='button' class='btn btn-default'>Supprimer</button></a>" 
					data-placement="bottom"><i class="fa fa-trash"></i> Supprimer
			</button>
		<?php endif;?>
	</div>	
	<div id="participants" class="col-md-6 text-right"></div>		
</div>	
<div id="tabs" class="col-md-12">
  <ul>
    <li><a href="#tabs-1"><i class="fa fa-home"></i> Général</a></li>
    <li><a href="#tabs-2" onclick="loadScript();"><i class="fa fa-map-marker"></i> Localisation</a></li>
    <li><a href="#tabs-3"><i class="fa fa-shopping-bag"></i> Mon inventaire</a></li>
    <?php if ($events->events_covoiturage == 1){ ?>
		<li><a href="#tabs-4"><i class="fa fa-car"></i> Covoiturage</a></li>
	<?php } ?>
    <li><a href="#tabs-5"><i class="fa fa-list" aria-hidden="true"></i> Sondages</a></li>
  </ul>
<div id="tabs-1">
	<?php include('view_general.php');?>
</div>
<div id="tabs-2" >
	<div class="row">
		<?php include('view_localisation.php');?>
	</div>
</div>
<div id="tabs-3" >
	<?php include('view_fourniture.php');?>
</div>
<div id="tabs-4" class='tab_event'>
        <?php include('view_covoiturage.php');?>
</div>
<div id="tabs-5">
        <?php include('view_sondage.php');?>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Lancer une invitation</h4>
			</div>
			<div class="modal-body row">
				<div id="invite" class="col-md-12">
				  <ul>
					<li><a href="#friends">Mes amis</a></li>
					<li><a href="#groups">Mes groupes</a></li>
				  </ul>
				<div id="friends">
					<?php foreach ($friendsList as $k => $v):?>
					<div class="col-md-4 text-center">
						<img src='<?php echo $v->users_photo;?>' alt='photo de profil' class='photo_arrondie'></img>
						<div>
							AKA :  <?php echo $v->users_pseudo;?><br/>
							<i> <?php echo $v->users_nom.' '.$v->users_prenom;?></i>
						</div>
						<?php if(!$v->invit): ?>
							<div id='bt_invit<?php echo $v->users_id;?>'>
								<input type='button' value='inviter' onClick='inviter(<?php echo $v->users_id;?>,<?php echo $events->events_id;?>);' />
							</div>
						<?php else: ?>
							<b> D&eacute;j&agrave; invit&eacute;</b>
						<?php endif;?>
					</div>
				<?php endforeach;?>
				</div>
				<div id="groups" >
					<?php foreach ($groupsList as $k => $v):?>
					<div class="col-md-4 text-center">
						<div>
							<?php echo $v->groupes_libelle;?>
						</div>
						<div id='bt_invit<?php echo $v->groupes_id;?>'>
							<input type='button' value='inviter' onClick='inviterGroupe(<?php echo $v->groupes_id;?>,<?php echo $events->events_id;?>);' />
						</div>
					</div>
				<?php endforeach;?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>
	</div>
 </div>
</div>