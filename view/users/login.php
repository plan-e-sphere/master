<div class="page-header">
	<h1>Erreur d'identification</h1>
</div>	
	<p>Erreur dans votre identifiant ou mot de passe veuillez r&eacute;essayer</p>
	<div id="connexion">
	   <form id="connexion" action="<?php echo Router::url('users/login'); ?>" method="post" class="form">

			<label for="inputuser_mail" class="label">E-mail</label>
			<input type="text" id="inputuser_mail" name="users_mail" value="" class="form-control" placeholder="E-mail"/>


			<label for="inputuser_password" class="label">Mot de passe</label>
			<input type="password" id="inputuser_password" name="users_password" value="" class="form-control" placeholder="Mot de passe"/>

		<div class="form-group">
		</div>
			<div class="col-md-6">
				<input type="submit" class="btn btn-default col-md-4 col-md-offset-3" value="Se connecter">
			</div>
			<div class="col-md-6">
				<input type="reset" class="btn btn-default col-md-4 col-md-offset-3" value="Reset">
			</div>
	   </form>
	</div>
