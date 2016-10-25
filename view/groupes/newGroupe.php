<h1><?php echo isset($title)?$title:'Créer un groupe'; ?></h1>
<form action="<?php echo Router::url('groupes/add'); ?>" method="post" class="form">
	<div class="form-group col-md-12">
		<label for="inputevents_libelle" class="label">Libelle</label>
		<input type="text" id="inputgroupes_libelle" name="groupes_libelle" value="" class="form-control" placeholder="Libelle">
	</div>
	<div class="form-group 2">
		<div class="form-group col-md-12">
			<label for="inputgroupes_description" class="label">Description</label>
			<textarea id="inputgroupes_description" name="groupes_description" class="form-control" placeholder="Description"></textarea>
		</div>
		<div class="form-group col-md-3">
			<label>Moderation</label>
			<div class="form-group ">
				<label class="col-md-2">
					<input type="radio" name="groupes_moderation" id="optionsRadios1" value="1" checked> Oui		  
				</label>
				<label class="col-md-2">
					<input type="radio" name="groupes_moderation" id="optionsRadios2" value="0">Non
				</label>
			</div>
		</div>
		<div class="form-group col-md-4">
			<label>Publication</label>
			<div class="form-group">
				<label class="col-md-2">
					<input type="radio" name="groupes_publication" id="optionsRadios1" value="Private" checked>Private		  
				</label>
				<label class="col-md-2">
					<input type="radio" name="groupes_publication" id="optionsRadios2" value="Public">Public
				</label>
			</div>
		</div>
	</div>
	<div class="form-group col-md-12">
		<div class="col-md-6">
			<input type="submit" class="btn btn-default col-md-4 col-md-offset-3" value="Ajouter">
		</div>
		<div class="col-md-6">
			<input type="reset" class="btn btn-default col-md-4 col-md-offset-3" value="Reset">
		</div>
	</div>
</form>