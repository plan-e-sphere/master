<?php if ($events->events_covoiturage == 1){ ?>
<div id="affichage">
<h2>Organisation du covoiturage</h2> 
		<?php 
		//debug($tripStaut);
		if ($tripStaut!="visiteur"){
			echo "Composition de votre véhicule <br/><br/>";
		}
		else{
			?> <a href="#" onclick="voitureCovoit();" class="btn btn-default" data-toggle="modal" data-target="#voiture"> proposer votre véhicule</a> <br/> <br/>
			<?php
			echo "Liste des véhicules disponibles <br/> " ;
		}
		
		if (sizeof($covoit)==0){
			if ($tripStaut=="visiteur"){
				echo "<b>Pas de véhicules disponibles pour l'instant </b>" ;
			}else{
				echo " <b> Aucune réservation pour le moment </b> ";
			}
		}else{ ?>
                    <div class="row"> <?php
		$idChauffeur = $chauffeur->users_id;
		foreach ($covoit as $k=>$v){ ?>
			<div class="col-md-4 text-center">
						<img src='<?php echo $v->users_photo;?>' alt='photo de profil' class='photo_arrondie'></img>
						<div>
							<?php 
							if($v->users_id == $this->Session->User('users_id')){
								echo "<b><font color='#00FF00'>Vous</font></b><br/>
								<a href='#' alt = 'annuler le covoit' onclick='refuseCovoit();' class='btn btn-default'><i class='fa fa-ban' aria-hidden='true' /> Annuler</i></a><br/>";								
							}
							if($v->users_id == $idChauffeur){
								echo "<b><font color = '#0000FF'>Conducteur</font></b><br/>";
								
							}
									
							echo "AKA :  ".$v->users_pseudo;?><br/>
							<i> <?php echo $v->users_nom.' '.$v->users_prenom;?></i>
							<?php 
							if($tripStaut=="visiteur"){
							?>
								<br/><a href='#' id="choisirCovoit" name = "choisirCovoit" onclick='selectionnerChauffeur(<?php echo $v->users_id ?>)' class='btn btn-default'><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> choisir ce chauffeur </a>
								
							<?php 
							}	?>
						</div>
			</div>
		<?php } ?> </div> <?php } ?>
</div>
	
<div id="debug"></div>
<!-- Modal  -->
<div class="modal fade" id="voiture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Liste de mes amis</h4>
			</div>
			<div class="modal-body row">
				<label> Nombre maximal de places libres : </label> <input type="text" id="nbPlaceMax" name = "covoiturages_nb_places_max"/><br/>
				<label> Lieu de rendez-vous pour le départ : </label> <input type="text" id="covoiturages_lieu_rdv" name="covoiturages_lieu_rdv"/><br/>
				<label> Date et Heure du rendez-vous : </label> <input type="text" id="datetimepicker" name = "covoiturages_datetime_rdv" /><br/>
				
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal" id="valider" onclick="validerVoiture();">Valider </button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>
	</div>
 </div>  
<?php } ?>
