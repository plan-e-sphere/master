<?php 
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;

FacebookSession::setDefaultApplication(Conf::$fb_id, Conf::$fb_secret);

$helper = new FacebookRedirectLoginHelper(Router::url('connexions/fbConnect'));
$scope = array('email','public_profile');
$loginUrl = $helper->getLoginUrl($scope);
?>
<script src = "js/classie.js"></script>
<script src = "js/modernizr.custom.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
<link rel="stylesheet" type="text/css" href="css/component.css" />
<div class="col-md-4 col-sm-offset-1">
	<img src="img/ordi.png" width="100%"/>
</div>
<div class="clear"></div>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
	<h3><i class="fa fa-arrow-circle-right fa-lg show_panel close_panel" aria-hidden="true"></i> Menu</h3>
	<a href="#" class="menu_connexion" onclick="nouveauCpte();" data-toggle="modal" data-target="#myModal">Créer un compte</a>
	<a href="#" class = "connexion menu_connexion">J'ai déjà un compte </a>
	<a href="<?php echo $loginUrl;?>" style="color:white;background-color: #5f78ab; width: 230px; height: 50px; line-height: 50px; font-size: 14px; cursor: pointer; vertical-align: middle;padding:0">
		<img style="float: left;margin-top:5px;" src="img/facebook-metro.png" height="40">
		Connexion avec Facebook
	</a>
</nav>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s3">
	<h3><i class="fa fa-arrow-circle-right fa-lg connexion show_panel close_panel" aria-hidden="true"></i> Connexion</h3>
	<div id="connexion">
	   <form id="connexion" action="<?php echo Router::url('users/login'); ?>" method="post" class="form">

			<label for="inputuser_mail" class="label label_white">E-mail</label>
			<input type="text" id="inputuser_mail_connect" name="users_mail" value="" class="form-control" placeholder="E-mail"/>


			<label for="inputuser_password" class="label label_white">Mot de passe</label>
			<input type="password" id="inputuser_password_connect" name="users_password" value="" class="form-control" placeholder="Mot de passe"/>

		<div class="form-group">
		</div>
                <div class="col-md-12 center">
                        <button type="submit" class="connexion_btn"><i class="fa fa-check-circle" aria-hidden="true"></i> Se connecter</button>
                </div>
	   </form>
	</div>
</nav>
<!-- modals inscription-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Création de votre compte</h4>
			</div>
			<div class="modal-body row">
				<form action="<?php echo Router::url('users/add'); ?>" method="post">
					<div class="col-md-12">
						<label for="inputuser_pseudo" class="label label_black">Pseudo</label><br/>
						<input type="text" id="inputuser_pseudo" name="users_pseudo" class="form_connexion" value="" placeholder="Pseudo">
					</div>
					<div class="col-md-12">
                                            <label for="inputuser_nom" class="label label_black">Nom <span class="red">*</span></label>
                                            <span id="inputuser_nom_error" class="error_form"></span><br/>
                                            <input type="text" id="inputuser_nom" name="users_nom" class="form_connexion" value=""  placeholder="Nom">
					</div>
					<div class="col-md-12">	
						<label for="inputuser_prenom" class="label label_black">Prenom <span class="red">*</span></label>
                                                <span id="inputuser_prenom_error" class="error_form"></span><br/>
						<input type="text" id="inputuser_prenom" name="users_prenom" class="form_connexion" value=""  placeholder="Prenom">
					</div>
					<div class="col-md-12">	
                                            <label for="inputuser_mail" class="label label_black">E-mail <span class="red">*</span></label>
                                            <span id="inputuser_mail_error" class="error_form"></span><br/>
                                            <input type="text" id="inputuser_mail" name="users_mail" class="form_connexion" value=""  placeholder="monAdresse@domaine.com">
					</div>
					<div class="col-md-12">	
						<label for="inputuser_password" class="label label_black">Mot de passe <span class="red">*</span></label>
                                                <span id="inputuser_password_error" class="error_form"></span><br/>
						<input type="password" id="inputuser_password" name="users_password" class="form_connexion" value=""  placeholder="Mot de passe">
					</div>
					<div class="col-md-12">
						<label for="inputuser_password_verif" class="label label_black">Resaisissez votre mot de passe <span class="red">*</span></label>
                                                <span id="inputuser_password_verif_error" class="error_form"></span><br/>
						<input type="password" id="inputuser_password_verif" name="users_password_verif" class="form_connexion" value=""  placeholder="Mot de passe">
					</div>
                                        (<span class="red">*</span>) Champs obligatoires
					<div class="col-md-12 form_connexion_btn">
						<div class="col-md-6">
                                                    <button type="submit" id="submit_btn" class="connexion_btn"><i class="fa fa-check-circle" aria-hidden="true"></i> Créer</button>
						</div>
						<div class="col-md-6">
							<button type="button" data-dismiss="modal" aria-label="Close" class="connexion_btn"><i class="fa fa-ban" aria-hidden="true"></i> Annuler</button>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>
</div>
<script>
        $(function(){
            $("#submit_btn").click(function(){
                valid = true;
                //test sur le nom
                if($('#inputuser_nom').val() === ""){
                    $('#inputuser_nom').css("border","1px solid red");
                    $('#inputuser_nom_error').fadeIn().text("Veuillez renseigner votre nom");
                    valid = false;
                }else if(!$('#inputuser_nom').val().match(/^[a-zéèêëçäà]+[-]?[[a-zéèêëçäà]+[-]?]*[a-zéèêëçäà]+$/i)){
                    $('#inputuser_nom').css("border","1px solid red");
                    $('#inputuser_nom_error').fadeIn().text("Veuillez renseigner un nom valide");
                    valid = false;                 
                }else{
                    $('#inputuser_nom').css("border","1px solid black");
                    $('#inputuser_nom_error').fadeOut();
                }
                
                //test sur le prenom
                if($('#inputuser_prenom').val() === ""){
                    $('#inputuser_prenom').css("border","1px solid red");
                    $('#inputuser_prenom_error').fadeIn().text("Veuillez renseigner votre prénom");
                    valid = false;
                }else if(!$('#inputuser_prenom').val().match(/^[a-zéèêëçäà]+[-]?[[a-zéèêëçäà]+[-]?]*[a-zéèêëçäà]+$/i)){
                    $('#inputuser_prenom').css("border","1px solid red");
                    $('#inputuser_prenom_error').fadeIn().text("Veuillez renseigner un prénom valide");
                    valid = false;                 
                }else{
                    $('#inputuser_prenom').css("border","1px solid black");
                    $('#inputuser_prenom_error').fadeOut();
                }
                
                //test sur l'adresse mail
                if($('#inputuser_mail').val() === ""){
                    $('#inputuser_mail').css("border","1px solid red");
                    $('#inputuser_mail_error').fadeIn().text("Veuillez renseigner votre adresse mail");
                    valid = false;
                }else if(!$('#inputuser_mail').val().match(/^[a-z][\w\.-]*[a-z0-9]@[a-z0-9][\w\.-]*[a-z0-9]\.[a-z][a-z\.]*[a-z]$/i)){
                    $('#inputuser_mail').css("border","1px solid red");
                    $('#inputuser_mail_error').fadeIn().text("Veuillez renseigner une adresse valide");
                    valid = false;                 
                }else{
                    $('#inputuser_mail').css("border","1px solid black");
                    $('#inputuser_mail_error').fadeOut();
                }
                
                //test sur le mot de passe
                if($('#inputuser_password').val() === ""){
                    $('#inputuser_password').css("border","1px solid red");
                    $('#inputuser_password_error').fadeIn().text("Veuillez renseigner votre mot de passe");
                    valid = false;
                }else if(!$('#inputuser_password').val().match(/^[a-z0-9]{8,}$/i)){
                    $('#inputuser_password').css("border","1px solid red");
                    $('#inputuser_password_error').fadeIn().text("Veuillez renseigner un mot de passe valide (8 caractères minimum)");
                    valid = false;                 
                }else{
                    $('#inputuser_password').css("border","1px solid black");
                    $('#inputuser_password_error').fadeOut();
                }
                
                //test sur la vérification du mot de passe
                if($('#inputuser_password').val() !== $('#inputuser_password_verif').val()){
                    $('#inputuser_password_verif').css("border","1px solid red");
                    $('#inputuser_password_verif_error').fadeIn().text("La confirmation du mot de passe est invalide");
                    valid = false;
                }else{
                    $('#inputuser_password_verif').css("border","1px solid black");
                    $('#inputuser_password_verif_error').fadeOut();
                }
                
                return valid;
            });
        });
        
	var menuRight = document.getElementById( 'cbp-spmenu-s2' ),				
		newCompte = document.getElementById( 'cbp-spmenu-s3' ),				
		body = document.body;
		var showC = false;
	
	$( ".show_panel" ).click( function() {
		classie.toggle( this, 'active' );
		classie.toggle( menuRight, 'cbp-spmenu-open' );
	});
	$( ".connexion" ).click( function() {
		classie.toggle( this, 'active' );
		classie.toggle( newCompte, 'cbp-spmenu-open' );
		if(showC){
			classie.toggle( this, 'active' );
			classie.toggle( menuRight, 'cbp-spmenu-open' );
			showC=false;
		}
		else{
			showC=true;
		}
	});
	function nouveauCpte(){
		$('#myModal').on('show.bs.modal', function (e) {
			 $('#myInput').focus();
		})
	}
</script>