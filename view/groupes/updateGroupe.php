
<div class="page-header">
	<h1><?php echo isset($title)?$title:'Ev&egravenement'; ?></h1>
</div>
<h2>Modifier un &eacute;v&egrave;nement</h2>
				<form action="<?php echo Router::url('events/add'); ?>" method="post" class="form">
					<input type="hidden" name="events_id" value="<?php echo $events->events_id; ?>">
					<div class="form-group col-md-12">
						<label for="inputevents_libelle" class="label">Libelle</label>
						<input type="text" id="inputevents_libelle" name="events_libelle" value="<?php echo $events->events_libelle; ?>" class="form-control" placeholder="Libelle">
					</div>
					<div class="form-group">
						<div class="form-group col-md-6">
							<label for="inputevents_date_debut" class="label">Date de d&eacute;but</label>
							<input type="date" id="inputevents_date_debut" name="events_date_debut" value="<?php echo date("Y-m-d",strtotime($events->events_date_debut)); ?>"  class="form-control" placeholder="Date de d&eacute;but">
						</div>
						<div class="form-group col-md-6">
							<label for="inputevents_date_fin" class="label">Date de fin</label>
							<input type="date" id="inputevents_date_fin" name="events_date_fin" value="<?php echo date("Y-m-d",strtotime($events->events_date_fin)); ?>"  class="form-control" placeholder="Date de fin">	
						</div>
					</div>
					<div class="form-group col-md-12">
						<label for="inputevents_keyword" class="label">Mots cl&eacute;s</label>
						<input type="text" id="inputevents_keyword" name="events_keyword" value="<?php echo $events->events_keyword; ?>" class="form-control" placeholder="Mots cl&eacute;s">	
					</div>
					<div class="form-group">
						<div class="form-group col-md-6">
							<label for="inputevents_nb_participants_max" class="label">Nombre de participants max</label>
							<input type="number" id="inputevents_nb_participants_max" name="events_nb_participants_max" value="<?php echo $events->events_nb_participants_max; ?>" class="form-control" placeholder="Nombre de participants max">	
						</div>
						<div class="form-group col-md-6">
							<label for="inputevents_validation" class="label">Validation</label>
							<div class="form-group">
								<label class="col-md-2">
									<input type="radio" name="events_validation" id="optionsRadios1" value="1" <?php if($events->events_validation=="Oui"):?>checked<?php endif ?>> Oui		  
								</label>
								<label>
									<input type="radio" name="events_validation" id="optionsRadios2" value="0" <?php if($events->events_validation=="Non"):?>checked<?php endif ?>>Non
								<label>
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="inputevents_validation" class="label">Publication</label>
							<div class="form-group">
								<label class="col-md-2">
									<input type="radio" name="events_publication" id="optionsRadios1" value="Private" checked>Private		  
								</label>
								<label class="col-md-2">
									<input type="radio" name="events_publication" id="optionsRadios2" value="Public">Public
								</label>
							</div>
						</div>
					</div>
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
	<script type="text/javascript" >
			var div = document.getElementById('ingredient_form');
			var numIngredient=<?php echo $i?>;
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
		<button type="button" onclick="create()" class="btn btn-default">+</button><button type="button" onclick="deleteField()" class="btn btn-default">-</button>
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
				</form>