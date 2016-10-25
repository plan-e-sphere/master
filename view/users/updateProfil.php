<div class="page-header">
	<h1><?php echo isset($title)?$title:'Profil'; ?></h1>
</div>
<div class="col-md-12">
	<h2 class="col-md-6">
		<img src="<?php echo $users['users_photo']; ?>" class="photo_arrondie"/> Profil de <?php echo $users['users_pseudo']; ?>
	</h2>
</div>
<form action="<?php echo Router::url('users/add/update'); ?>" method="post" class="form">
	<input type="hidden" name="users_id" value="<?php echo $users['users_id']; ?>">
	<div class="form-group col-md-12">
		<label for="inputusers_nom" class="label">Nom</label>
		<input type="text" id="inputusers_nom" name="users_nom" value="<?php echo $users['users_nom']; ?>" class="form-control" placeholder="Nom">
	</div>
	<div class="form-group">
		<div class="form-group col-md-6">
			<label for="inputusers_prenom" class="label">Prenom</label>
			<input type="text" id="inputusers_prenom" name="users_prenom" value="<?php echo $users['users_prenom']; ?>"  class="form-control" placeholder="Prenom">
		</div>
		<div class="form-group col-md-6">
			<label for="inputusers_email" class="label">Email</label>
			<input type="text" id="inputusers_email" name="users_mail" value="<?php echo $users['users_mail']; ?>"  class="form-control" placeholder="Email">	
		</div>
	</div>
	<div class="form-group">
		<div class="form-group col-md-6">
			<label for="inputusers_photo" class="label">Photo</label>
			<input type="text" id="inputusers_photo" name="users_photo" value="<?php echo $users['users_photo']; ?>"  class="form-control" placeholder="Photo">
		</div>
		<div class="form-group col-md-6">
			<label for="inputusers_pseudo" class="label">Pseudo</label>
			<input type="text" id="inputusers_pseudo" name="users_pseudo" value="<?php echo $users['users_pseudo']; ?>"  class="form-control" placeholder="Pseudo">
		</div>
	</div>
	<div class="form-group col-md-12">
		<div class="col-md-6">
			<input type="submit" class="btn btn-default col-md-4 col-md-offset-3" value="Modifier">
		</div>
		<div class="col-md-6">
			<input type="reset" class="btn btn-default col-md-4 col-md-offset-3" value="Reset">
		</div>
	</div>
</form>