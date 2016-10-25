<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"> 
    <head> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
		<title><?php echo isset($title_for_layout)?$title_for_layout:'Plan e Sphere'; ?></title> 	
		<link rel="shortcut icon" href="img/logo_small.png" type="image/x-icon"/> 
		<link rel="icon" href="img/e-logo.png" type="image/x-icon"/>
		<link rel="stylesheet" href="css/jquery-ui.min.css"/>
		<link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/font-awesome.min.css"/>
		<link rel="stylesheet" href="css/jquery.webui-popover.css">
		<link rel="stylesheet" href="css/style.css"/>
		<link rel="stylesheet" href="css/style_layout_connexion.css"/>
		<link rel="stylesheet" href="<?php echo CSS.'/style_contact.css'; ?>"/>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="js/jquery.parallax-1.1.3.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.webui-popover.js"></script>
		<script type="text/javascript">	
    $(document).ready(function(){		
        $('#slide1').parallax("center", 0, 0.1, true);
        $('#slide2').parallax("center", 900, 0.1, true);
        $('#slide3').parallax("center", 2900, 0.1, true);
    })
		</script>
    </head> 
    <body>    
        <div id="topbar" class="topbar"> 
			<ul class="nav navbar-nav">
                            <h1 id="title">Plan<span id="e_logo" class="e_logo">E</span>Sphere</h1>
			</ul>
			<ul class="nav navbar-right">
				<li><button id="btn_connexion" href="#" class="show_panel btn_connexion">CONNEXION</button></li>
			</ul>
        </div>
		<div id="container">
			<div id="slide1">
				<div class="slide_inside">
					<h2 class="titre_section">PLAN-E-SPHERE, C'EST QUOI?</h2>
					<h2 id="pgf_inside">Vous devez organiser un événement ? C'est trop compliqué ?</h2>
					<h3 id="pgf_inside">Fini la recherche de date qui convient à tout le monde !<br/>Fini le "Qui vient et qui ne vient pas ?" !<br/>Fini le "Qui apporte quoi ?" !<br/>Fini le "Qui emmène qui ?" !</h3>
					<h2 id="pgf_inside">Plan-E-Sphere vous permet de gérer tous ces soucis SIMPLEMENT !</h2>
					</p>
				</div>	
				<div class="slide_inside">
					<h2 class="titre_section">CRÉER VOTRE ÉVÉNEMENT EN QUELQUES CLICS !</h2>
					<ul class="explication">
						<li>
							<h1 class="icons_clic"><i class="fa fa-user-plus fa-4x" aria-hidden="true"></i></h1>
							<h3>Invite tes amis !</h3>
						</li>
						<li>
							<p class="icons_clic"><i class="fa fa-cogs fa-5x" aria-hidden="true"></i></p>
							<p class="icons_clic">
							<i id="icons_orga" class="fa fa-shopping-basket fa-5x" aria-hidden="true"></i>						
							<i id="icons_orga" class="fa fa-car fa-5x" aria-hidden="true"></i>
							</p>
							<h3>Chacun participe à l'organisation !</h3>
						</li>
						<li>
							<h1 class="icons_clic"><i class="fa fa-thumbs-up fa-4x" aria-hidden="true"></i></h1>
							<h3>Amusez-vous !</h3>
						</li>
					</ul>
				</div>
			</div>
			<div id="slide2">
				<div class="slide_inside">
					<h2 class="titre_section">COMMENT ÇA MARCHE ?</h2>
					<p>petits dessins explicatifs de chaque étape</p>
				</div>
				<div class="slide_inside">
					<h2 class="titre_section">FONCTIONNALITÉS À VENIR</h2>
					<p id="pgf_inside">Création de sondage<br/>Partage de photos et de vidéos<br/>Et bien d'autres !</p>
				</div>
			</div>
			<div id="slide3">
				<div class="slide_inside">
					<h2 class="titre_section">VOTRE ÉVÉNEMENT</h2>
					<p>petit tableau simplifié pour créer un événement, avec un bouton "c'est parti !". En cliquant, un pop-in apparait, proposant de s'inscrire.</p>
				</div>		
			</div>
			<div id="explain">
				<?php echo $this->Session->flash(); ?>
				<div id="container_message_notif" class="col-md-12"><div id="message_notif"></div></div>
				<?php echo $content_for_layout; ?>
			</div>
			<div id="footer">
				<hr/>
				Développé par Pahul & Winni / Design par Winni - &copy; Tous droits réservés
				 </br> 
                                <a href="<?php echo Router::url('about'); ?>" class="link_head white">À propos</a> - 
                                <a href="#" class="link_head white">Signaler un bug</a> - 
                                <a href="<?php echo Router::url('mentions-legales'); ?>" class="link_head white">Mentions légales</a> -
                                <a href="<?php echo Router::url('cgu'); ?>" class="link_head white">CGU</a> - 
                                <a href="<?php echo Router::url('faqs'); ?>" class="link_head white">FAQ</a> - 
                                <a href="<?php echo Router::url('contact'); ?>" class="link_footer" class="link_head white">Contact</a>
			</div>
		</div>
    </body> 
</html>
<script>
$(window).scroll(function (event) {
    var scroll = $(window).scrollTop();
    // Do something
	if(scroll>0){
		$("#topbar").removeClass("topbar").addClass("topbar_black");
		$(".white").css("color","black");
		$("#e_logo").removeClass("e_logo").addClass("e_logo_black");

                $("#btn_connexion").removeClass("btn_connexion").addClass("btn_connexion_black");
	}else{
		$("#topbar").removeClass("topbar_black").addClass("topbar");
		$(".white").css("color","white");
		$("#e_logo").removeClass("e_logo_black").addClass("e_logo");
		
		
		$("#btn_connexion").removeClass("btn_connexion_black").addClass("btn_connexion");
	}
});
</script>