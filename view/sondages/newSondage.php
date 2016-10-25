<link rel="stylesheet" href="<?php echo CSS.'/style_events.css';?>"/>

<form action="<?php echo Router::url('sondages/addSondage/'.$event_id); ?>" method="post" class="form">
	<div class="form-group bloc-form col-md-12">
		<input type="hidden" name="sondages_id" value="<?php echo $sondages->sondages_id; ?>">
		<h3>Informations générales</h3>
		<hr/>
		<div class="form-group col-md-12">
                    <label for="inputsondages_libelle" class="label">Libelle <span class="red">*</span></label>
                        <span id="inputsondages_libelle_error" class="error_form"></span>
			<input type="text" id="inputsondages_libelle" name="sondages_libelle" value="<?php echo $sondages->sondages_libelle;?>" class="form-control" placeholder="Libelle">
		</div>
		<div class="form-group col-md-12">
                    <label for="inputsondages_libelle" class="label">Question <span class="red">*</span></label>
                        <span id="inputsondages_libelle_error" class="error_form"></span>
			<input type="text" id="inputsondages_libelle" name="sondages_request" value="<?php echo $sondages->sondages_request;?>" class="form-control" placeholder="Objet du sondage">
		</div>
	</div>
	<div class="form-group bloc-form col-md-12">
		<h3>Propositions</h3>
		<hr/>
		<label class="Label">Propositions</label>
			<div class="form-group">
				<label class="col-md-2">
					<input type="radio" name="sondages_propositions" id="optionsRadios1" value="Date" <?php //if($sondages->sondages_propositions!="Date"):?>checked<?php //endif ?>>Date		  
				</label>
				<label class="col-md-2">
					<input type="radio" name="sondages_propositions" id="optionsRadios2" value="Autre" <?php //if($sondages->sondages_propositions=="Date"):?>checked<?php //endif ?>>Autre (lieu, animation, etc.)
				</label>
			</div>
		<?php //if($sondages=='Date')
				//{?>
					<!--<div id="ingredient_form" class="form-group col-md-12">
					<?php //$i=0;foreach ($propositions as $k => $v):?>
						<div id="ingredient<?php //echo $i;?>">
							<div class="col-md-6">
								<label for="inputfournitures_libelle" class="label">Date</label>
							</div>
							<div class="col-md-6">
								<input type="text" id="inputfournitures_libelle" name="fournitures_libelle[]" value=""<?php //echo $v->propositions_libelle;?>" class="form-control" placeholder="jj-mm-yyyy hh:mn">
							</div>
							<input type="hidden" name="fournitures_id[]" value=""<?php //echo $v->fournitures_id;?>">
						</div>
					<?php //$i++;endforeach ?>
					</div>
				<?php //}
						//else
						//{?>
					<!--<div id="ingredient_form" class="form-group col-md-12">
					<?php //$i=0;foreach ($propositions as $k => $v):?>
						<div id="ingredient<?php //echo $i;?>">
							<div class="col-md-6">
								<label for="inputfournitures_libelle" class="label">Thème</label>
							</div>
							<div class="col-md-3">
								<label for="fournitures_qte" class="label">Libelle</label>
							</div>
							<div class="col-md-6">
								<input type="text" id="inputfournitures_libelle" name="fournitures_libelle[]" value="<?php //echo $v->fournitures_libelle;?>" class="form-control" placeholder="Thème">
							</div>
							<input type="hidden" name="fournitures_id[]" value="<?php //echo $v->fournitures_id;?>">
							<div class="col-md-3">
								<input type="text" id="inputfournitures_qte" name="fournitures_qte[]" value="<?php //echo $v->fournitures_quantite;?>" class="form-control" placeholder="Libelle">
							</div>
						</div>
					<?php //$i++;endforeach ?>
					</div>
				<?php //} ?>
				-->
				
				
			<button type="button" onclick="create()" class="btn btn-default">+</button>
			<button type="button" onclick="deleteField()" class="btn btn-default">-</button>
		<?php if(empty($sondages->sondages_id)){?>
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
				<a href="<?php echo Router::url('events/view/'.$sondages->sondages_id); ?>" class="btn btn-default col-md-4 col-md-offset-3"> Annuler</a>
			</div>
		</div>
		<?php }?>
	</div>
</form>