<link rel="stylesheet" href="<?php echo CSS.'/style_events.css';?>"/>	
<script type="text/javascript" >

	function chargerAdresse(idAdresse){
		if(idAdresse!==null){
                    if(idAdresse!=="---- Selectionner une adresse ----"){
                        $.ajax({
                            method: "POST",
                            url: "<?php echo Router::url('adresses/getAdresseById/') ?>"+idAdresse,
                        })
                        .done(function(request){
                                var adresse = JSON.parse( request );
                                $("#inputadresses_num_voie").val(adresse.adresses_num_voie).attr("readonly","readonly");
                                $("#inputadresses_voie").val(adresse.adresses_voie).attr("readonly","readonly");
                                $("#inputadresses_cp").val(adresse.adresses_cp).attr("readonly","readonly");
                                $("#inputadresses_ville").val(adresse.adresses_ville).attr("readonly","readonly");
                                $("#inputadresses_pays").val(adresse.adresses_pays).attr("readonly","readonly");
                                $("#inputadresses_libelle").val("").attr("readonly","readonly");
                        });
                    }else{
                                $("#listeAdresse").val(idAdresse);
				$("#inputadresses_num_voie").val("").attr("readonly",false);
                                $("#inputadresses_voie").val("").attr("readonly",false);
                                $("#inputadresses_cp").val("").attr("readonly",false);
                                $("#inputadresses_ville").val("").attr("readonly",false);
                                $("#inputadresses_pays").val("").attr("readonly",false);
                                $("#inputadresses_libelle").val("").attr("readonly",false);
                    }
		}
	}
	
	function ajoutAdresse(){
		var adresse = {adresses_libelle:$("#inputadresses_libelle").val(),
                                adresses_num_voie:$("#inputadresses_num_voie").val(),
                                adresses_voie:$("#inputadresses_voie").val(),
                                adresses_cp:$("#inputadresses_cp").val(),
                                adresses_ville:$("#inputadresses_ville").val(),
                                adresses_pays:$("#inputadresses_pays").val()
                                };
		var json = JSON.stringify( adresse );
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('adresses/addAdresse/'); ?>"+json,
		})
		.done(function(){
			$("#listeAdresse").load("<?php echo Router::url('adresses/getAdresseByUser/'.$this->Session->User('users_id'));?>");
		});
	}
        
	$(function(){
		$('.datetimepicker').datetimepicker({
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
			 format:'d-m-Y H:i'
		});
                
		$( window ).load(function(){
			chargerAdresse($("#listeAdresse").val());
		});
                
                $('#btn_create_event').click(function(){
                   valid=true;
                   //définition des dates de début et fin en js
                   var date_debut=new Date($('#inputevents_date_debut').val().substring(6,10), $('#inputevents_date_debut').val().substring(3,5)-1, $('#inputevents_date_debut').val().substring(0,2), $('#inputevents_date_debut').val().substring(11,13),$('#inputevents_date_debut').val().substring(14,16));
                   var date_fin=new Date($('#inputevents_date_fin').val().substring(6,10), $('#inputevents_date_fin').val().substring(3,5)-1, $('#inputevents_date_fin').val().substring(0,2), $('#inputevents_date_fin').val().substring(11,13),$('#inputevents_date_fin').val().substring(14,16));
                   var date_jour=new Date();  
                   //Vérification du libelle
                   if($('#inputevents_libelle').val() === ""){
                        $('#inputevents_libelle').removeClass("valid_form_border").addClass("error_form_border");
                        $('#inputevents_libelle_error').fadeIn().text("Veuillez renseigner un libelle");
                        valid = false;
                    }else if(!$('#inputevents_libelle').val().match(/^[a-z éèêëçäà-]+$/i)){
                        $('#inputevents_libelle').removeClass("valid_form_border").addClass("error_form_border");
                        $('#inputevents_libelle_error').fadeIn().text("Veuillez renseigner un libelle valide");
                        valid = false;                 
                    }else{
                        $('#inputevents_libelle').removeClass("error_form_border").addClass("valid_form_border");
                        $('#inputevents_libelle_error').fadeOut();
                    }
                    
                    //Vérification de la date de début
                   if($('#inputevents_date_debut').val() === ""){
                        $('#inputevents_date_debut').removeClass("valid_form_border").addClass("error_form_border");
                        $('#inputevents_date_debut_error').fadeIn().text("Veuillez renseigner une date de début");
                        valid = false;
                    }else if(!isValidDate($('#inputevents_date_debut').val())){
                        $('#inputevents_date_debut').removeClass("valid_form_border").addClass("error_form_border");
                        $('#inputevents_date_debut_error').fadeIn().text("Veuillez renseigner une date de début valide (JJ-MM-YYYY HH:mm)");
                        valid = false; 
                    }else if(date_debut < date_jour){
                        $('#inputevents_date_debut').removeClass("valid_form_border").addClass("error_form_border");
                        $('#inputevents_date_debut_error').fadeIn().text("La date de début ne peut pas être passée");
                        valid = false;
                    }else{
                        $('#inputevents_date_debut').removeClass("error_form_border").addClass("valid_form_border");
                        $('#inputevents_date_debut_error').fadeOut();
                    }
                    
                    //Vérification de la date de fin
                   if($('#inputevents_date_debut').val() !== "" && $('#inputevents_date_fin').val() !== ""){
                        //format date dd-MM-YYYY hh:mm
                        if(!isValidDate($('#inputevents_date_fin').val())){
                            $('#inputevents_date_fin').removeClass("valid_form_border").addClass("error_form_border");
                            $('#inputevents_date_fin_error').fadeIn().text("Veuillez renseigner une date de fin valide (JJ-MM-YYYY HH:mm)");
                            valid = false;      
                        }else if(date_fin < date_debut){//Controle date de fin antérieure à date début
                            $('#inputevents_date_fin').removeClass("valid_form_border").addClass("error_form_border");
                            $('#inputevents_date_fin_error').fadeIn().text("La date de fin ne peut pas être antérieure à la date de début");
                            valid = false;   
                        }else{
                            $('#inputevents_date_fin').css("border","1px solid #CCCCCC");
                            $('#inputevents_date_fin').removeClass("error_form_border").addClass("valid_form_border");
                            $('#inputevents_date_fin_error').fadeOut();
                        }
                    }else{
                        $('#inputevents_date_fin').removeClass("error_form_border").addClass("valid_form_border");
                        $('#inputevents_date_fin_error').fadeOut();
                    }
                    if(!valid){
                        set_alert_message("error","Un des champs est mal renseigné");
                    }
                    return valid;
                });
    })
	
</script>
<form action="<?php echo Router::url('events/add'); ?>" method="post" class="form">
	<div class="form-group bloc-form col-md-12">
		<input type="hidden" name="events_id" value="<?php echo $events->events_id; ?>">
		<h3>Informations générales</h3>
		<hr/>
		<div class="form-group col-md-12">
                    <label for="inputevents_libelle" class="label">Libelle <span class="red">*</span></label>
                        <span id="inputevents_libelle_error" class="error_form"></span>
			<input type="text" id="inputevents_libelle" name="events_libelle" value="<?php echo $events->events_libelle;?>" class="form-control" placeholder="Libelle">
		</div>
		<div class="form-group">
			<div class="form-group col-md-6">
				<label for="inputevents_date_debut" class="label">Date de d&eacute;but <span class="red">*</span></label>
                                <span id="inputevents_date_debut_error" class="error_form"></span>
				<input type="text" id="inputevents_date_debut" name="events_date_debut" value="<?php echo $events->events_date_debut;?>"  class="form-control datetimepicker <?php echo $form['events_date_debut'];?>" placeholder="jj-mm-yyyy hh:mn">
			</div>
			<div class="form-group col-md-6">
				<label for="inputevents_date_fin" class="label">Date de fin</label>
                                <span id="inputevents_date_fin_error" class="error_form"></span>
				<input type="text" id="inputevents_date_fin" name="events_date_fin" value="<?php if(date("Ymd",strtotime($events->events_date_fin))!= '19700101'){echo $events->events_date_fin;} ?>"  class="form-control datetimepicker <?php echo $form['events_date_fin'];?>" placeholder="jj-mm-yyyy hh:mn">	
			</div>
		</div>
		<div class="form-group">
			<div class="form-group col-md-6">
				<label for="inputevents_keyword" class="label">Mots cl&eacute;s</label>
				<input type="text" id="inputevents_keyword" name="events_keyword" value="" class="form-control" placeholder="Mots cl&eacute;s" data-role="tagsinput">	
			</div>
			<div class="form-group col-md-6">
				<label for="inputevents_nb_participants_max" class="label">Nombre de participants max</label>
				<input type="number" id="inputevents_nb_participants_max" name="events_nb_participants_max" value="<?php echo $events->events_nb_participants_max;?>" class="form-control" placeholder="Nombre de participants max">	
			</div>
		</div>
		<div class="form-group col-md-12">
			<label for="inputevents_description" class="label">Description</label>
			<textarea type="text" id="inputevents_description" name="events_description" class="form-control" placeholder="Description"><?php echo $events->events_description;?></textarea>
		</div>
		<div class="form-group col-md-12">
			<label for="inputevents_image" class="label">Image</label>
			<!-- <input type="file" id="inputevents_image" name="events_image"> -->
			<input type="text" id="inputevents_image" name="events_image" value="<?php echo $events->events_image;?>" class="form-control" placeholder="Url">
		</div>
	</div>
	<div class="form-group bloc-form col-md-12">
		<h3>Publication</h3>
		<hr/>
		<div class="form-group col-md-6">
			<label>Validation</label>
			<div class="form-group ">
				<label class="col-md-2">
					<input type="radio" name="events_validation" id="optionsRadios1" value="1" <?php if($events->events_validation!="Non"):?>checked<?php endif ?>> Oui		  
				</label>
				<label class="col-md-2">
					<input type="radio" name="events_validation" id="optionsRadios2" value="0" <?php if($events->events_validation=="Non"):?>checked<?php endif ?>>Non
				</label>
			</div>
		</div>
		<div class="form-group col-md-6">
			<label>Publication</label>
			<div class="form-group">
				<label class="col-md-2">
					<input type="radio" name="events_publication" id="optionsRadios1" value="Private" <?php if($events->events_publication!="Public"):?>checked<?php endif ?>>Private		  
				</label>
				<label class="col-md-2">
					<input type="radio" name="events_publication" id="optionsRadios2" value="Public" <?php if($events->events_publication=="Public"):?>checked<?php endif ?>>Public
				</label>
			</div>
		</div>
	</div>
	<div class="form-group bloc-form col-md-12">
		<h3>Covoiturage</h3>
		<hr/>
		<label class="Label">Dans le cas d'un long trajet voulez-vous activer l'option covoiturage ?</label>
		<div class="form-group">
				<label class="col-md-2">
					<input type="radio" name="events_covoiturage" id="covoitOui" value="1" <?php if($events->events_covoiturage=="1"):?>checked<?php endif ?>>Oui	  
				</label>
				<label class="col-md-2">
					<input type="radio" name="events_covoiturage" id="covoitNon" value="0" <?php if($events->events_covoiturage!="1"):?>checked<?php endif ?>>Non
				</label>
			</div>
	</div><br/>
	<div class="form-group bloc-form col-md-12">
		<h3>Adresse</h3>
		<hr/>
		<label class="Label">Adresse de l'évènement </label>
		<div id="adresse_form" class="form-group col-md-12">
			<select id="listeAdresse" onchange="chargerAdresse(this.value);">
				<option>---- Selectionner une adresse ----</option>
				<?php foreach($adresses as $k=>$v):?>
					<option value="<?php echo $v->adresses_id;?>" <?php if($v->adresses_id==$events->adresses_id):?>selected<?php endif ?>><?php echo $v->adresses_libelle;?></option>
				<?php endforeach;?>
			</select>
			<input type="hidden" id="inputevents_adresses_id" name="events_adresses_id" value="<?php echo $events->adresses_id;?>"/>
                        <a class="cursor-pointer" onclick="chargerAdresse('---- Selectionner une adresse ----')"><i class="fa fa-times" aria-hidden="true"></i></a>
		</div>
                <!-- Formulaire d'adresse -->
                 <div class="form-group col-md-12">
                        <label for="inputadresses_libelle" class="label">Nom d'adresse</label>
                        <input type="text" id="inputadresses_libelle" name="adresses_libelle" value="" class="form-control" placeholder="Nom de l'adresse (à ne renseigner que si vous voulez sauvegarder cette adresse dans vos favoris)">
                </div>
                <div class="form-group col-md-2">
                        <label for="inputadresses_num_voie" class="label">N°</label>
                        <input type="text" id="inputadresses_num_voie" name="adresses_num_voie" value="" class="form-control" placeholder="N°">
                </div>
                <div class="form-group col-md-10">
                        <label for="inputadresses_voie" class="label">Nom de la voie</label>
                        <input type="text" id="inputadresses_voie" name="adresses_voie" value="" class="form-control" placeholder="Nom de la voie">
                </div>
                <div class="form-group col-md-4">
                        <label for="inputadresses_cp" class="label">Code Postal</label>
                        <input type="text" id="inputadresses_cp" name="adresses_cp" value="" class="form-control" placeholder="Code Postal">
                </div>
                <div class="form-group col-md-4">
                        <label for="inputadresses_ville" class="label">Ville</label>
                        <input type="text" id="inputadresses_ville" name="adresses_ville" value="" class="form-control" placeholder="Ville">
                </div>
                <div class="form-group col-md-4">
                        <label for="inputadresses_pays" class="label">Pays</label>
                        <input type="text" id="inputadresses_pays" name="adresses_pays" value="" class="form-control" placeholder="Pays">
                </div>
	</div>
	<div class="form-group bloc-form col-md-12">
		<h3>Fournitures</h3>
		<hr/>
		<label class="Label">Fournitures</label>
		<div id="ingredient_form" class="form-group col-md-12">
		<?php $i=0;foreach ($fournitures as $k => $v):?>
		<div id="ingredient<?php echo $i;?>">
			<div class="col-md-6">
				<label for="inputfournitures_libelle" class="label">Libelle</label>
			</div>
			<div class="col-md-3">
				<label for="fournitures_qte" class="label">Quantite</label>
			</div>
			<div class="col-md-3">
				<label for="inputfournitures_unite" class="label">Unite</label>
			</div>
			<div class="col-md-6">
				<input type="text" id="inputfournitures_libelle" name="fournitures_libelle[]" value="<?php echo $v->fournitures_libelle;?>" class="form-control" placeholder="Libelle">
			</div>
			<input type="hidden" name="fournitures_id[]" value="<?php echo $v->fournitures_id;?>">
			<div class="col-md-3">
				<input type="text" id="inputfournitures_qte" name="fournitures_qte[]" value="<?php echo $v->fournitures_quantite;?>" class="form-control" placeholder="Quantite">
			</div>
			
			<div class="col-md-3">
				<input list="liste_unite" type="text" id="inputfournitures_unite" name="fournitures_unite[]" value="<?php echo $v->fournitures_unite;?>" class="form-control" placeholder="Unite">
			</div>
			<datalist id="liste_unite">
			  <option value="Litre">
			  <option value="packs">
			  <option value="paquets">
			  <option value="unite">
			</datalist>
		</div>
		<?php $i++;endforeach ?>
	</div>
			<button type="button" onclick="create()" class="btn btn-default">+</button>
			<button type="button" onclick="deleteField()" class="btn btn-default">-</button>
		<?php if(empty($events->events_id)){?>
		<div class="form-group col-md-12">
			<div class="col-md-6">
				<input type="submit" id="btn_create_event" class="btn btn-default col-md-4 col-md-offset-3" value="Créer">
			</div>
			<div class="col-md-6">
				<input type="button" class="btn btn-default col-md-4 col-md-offset-3" value="Annuler" onclick='location.href="/"'>
			</div>
		</div>
		<?php }else{?>
		<div class="form-group col-md-12">
			<div class="col-md-4">
				<input type="submit" class="btn btn-default col-md-4 col-md-offset-3" value="Modifier">
			</div>
			<div class="col-md-4">
				<input type="reset" class="btn btn-default col-md-4 col-md-offset-3" value="Reset">
			</div>
			<div class="col-md-4">
				<a href="<?php echo Router::url('events/view/'.$events->events_id); ?>" class="btn btn-default col-md-4 col-md-offset-3"> Annuler</a>
			</div>
		</div>
		<?php }?>
	</div>
</form>
 <script>
	var div = document.getElementById('ingredient_form');
			var numIngredient=0;
			function create(){
				var target = document.getElementById('ingredient_form');
				var elem = document.createElement('div');
				var txt = 
				'<div class="col-md-6">'+
				'	<label for="inputfournitures_libelle" class="label">Libelle</label>'+
				'</div>'+
				'<div class="col-md-3">'+
				'	<label for="fournitures_qte" class="label">Quantite</label>'+
				'</div>'+
				'<div class="col-md-3">'+
				'	<label for="inputfournitures_unite" class="label">Unite</label>'+
				'</div>'+
				'<div class="col-md-6">'+
				'	<input type="text" id="inputfournitures_libelle" name="fournitures_libelle[]" value="" class="form-control" placeholder="Libelle">'+
				'</div>'+
				'<div class="col-md-3">'+
				'	<input type="text" id="fournitures_qte" name="fournitures_qte[]" value="" class="form-control" placeholder="Quantite">'+
				'</div>'+
				'<div class="col-md-3">'+
				'	<input list="liste_unite" type="text" id="inputfournitures_unite" name="fournitures_unite[]" class="form-control" placeholder="Unite">'+
				'</div>';

				elem.innerHTML=txt;
				elem.id = 'ingredient' + numIngredient;
				target.appendChild(elem);
				numIngredient++;
			}
	function deleteField() {
		if(numIngredient>0){
			numIngredient--;
		}
		var divIngredient = document.getElementById('ingredient' + numIngredient);
		div.removeChild(divIngredient);
	}
 </script>