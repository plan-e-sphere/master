<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"> 
    <head> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
		<link rel="shortcut icon" href="<?php echo IMG.'/globe.ico';?>" type="image/x-icon"/> 
		<link rel="icon" href="<?php echo IMG.'/e-logo.png';?>" type="image/x-icon"/>
		
		<title><?php echo isset($title_for_layout)?$title_for_layout:'Plan-e-Sphere'; ?></title> 	
		<link rel="stylesheet" href="<?php echo CSS.'/jquery-ui.min.css';?>"/>
		<link rel="stylesheet" href="<?php echo CSS.'/bootstrap-theme.min.css';?>"/>
		<link rel="stylesheet" href="<?php echo CSS.'/bootstrap.min.css';?>"/>
		<link rel="stylesheet" href="<?php echo CSS.'/font-awesome.min.css';?>"/>
		<link rel="stylesheet" href="<?php echo CSS.'/jquery.webui-popover.css';?>">
		<link rel="stylesheet" href="<?php echo CSS."/jquery.datetimepicker.css"; ?>">
		<link rel="stylesheet" href="<?php echo CSS.'/style.css';?>"/>
                <link rel="stylesheet" href="<?php echo CSS.'/style_layout_default.css';?>"/>
		<script type="text/javascript" src="<?php echo JS.'/jquery-1.11.2.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo JS.'/jquery-ui.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo JS.'/jquery.datetimepicker.js';?>"></script>
		<script type="text/javascript" src="<?php echo JS.'/bootstrap.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo JS.'/jquery.webui-popover.js';?>"></script>
                <script type="text/javascript" src="<?php echo JS.'/javascript.js';?>"></script>
    </head> 
	<script>
                var show_menu=1;
                function reloadNotif(){
                    $.ajax({
                            method: "POST",
                            url: "<?php echo Router::url('notifications/verifNotif'); ?>",	
                    })
                    .done(function(request) {
                            var data_content=request.split('|');
                            var iconeNotif;
                            if(data_content[1]>0){
                                iconeNotif='<i class="fa fa-bell-o red" aria-hidden="true"></i><span class="red text_notif">'+data_content[1]+'</span>';
                            }else{
                                iconeNotif='<i class="fa fa-bell-o" aria-hidden="true"></i><span class="text_notif"></span>';
                            }
                            var content='<a href="#" id="notification" data-toggle="popover" data-content="'+data_content[0]+'">'+iconeNotif+'</a>';
                            $("#notification").html(content);
                            loadPopover();
                    });
                };
                function showMessage(){
                    $("#message_alert").fadeIn('slow');
                };
                function hideMessage(){
                    $("#message_alert").fadeOut(function(){$("#div_message_alert").html("");});
                };
		setInterval(
			function(){
                            reloadNotif();
                            hideMessage();
                        }, 
			5000);
		$(document).ready(
			reloadNotif()
		);
		function notif_lu(id_notif){
			$.ajax({
					method: "POST",
					url: "<?php echo Router::url('notifications/lectureNotif'); ?>/"+id_notif,	
				})
				.done(function() {
				});
		}
		$(function() {
                    $(".language").click(function(){
                        alert("toto")
                        //var locale=$(this).attr('id');
                        //alert(locale);
                        /*$.ajax({
                                method: "POST",
                                url: "<?php echo Router::url('static/changeLocale'); ?>/"+locale,	
                        })
                        .done(function() {
                            window.location.reload();
                        });*/
                    });
                    $('#popoverBtn').popover();
                    $('[data-toggle="tooltip"]').tooltip();
                    $("#icone_menu").click(function(){
                        if(show_menu==1){
                            $("#menu").fadeOut(400,function(){
                                $("#container").removeClass("col-md-10").removeClass("col-md-offset-2").addClass("col-md-12");
                                $(".block_event").removeClass("col-md-3").addClass("col-md-2");
                            });
                            show_menu=0;
                        }else{
                            $("#container").removeClass("col-md-12").addClass("col-md-10").addClass("col-md-offset-2");
                            $(".block_event").removeClass("col-md-2").addClass("col-md-3");
                            $("#menu").fadeIn();
                            show_menu=1;
                        }
                    });  
                    $("#div_message_alert").click(function(){
                        hideMessage();
                    });
                    showMessage();
                    $('[data-toggle="popover"]').webuiPopover({
                            html: true,
                            trigger: 'click',
                            placement: 'bottom-left',
                            delay: {show : 140000,	hide : 300000000},
                            padding:false,
                            animation:'fade'
                    });
		});
                function changeLanguage(language){
                    $.ajax({
                                method: "POST",
                                url: "<?php echo Router::url('static/changeLocale'); ?>/"+language,	
                        })
                        .done(function() {
                            window.location.reload();
                        });
                }
		function loadPopover(taille){
			$('[data-toggle="popover"]').webuiPopover({
				html: true,
				trigger: 'click',
				placement: 'bottom-left',
				delay: {show : 140000,	hide : 3000000000000},
				padding:false,
				width: taille,
				animation:'fade'
			})
		};
	</script>
    <body>    
        <div id="div_message_alert"><?php echo $this->Session->flash(); ?></div>
        <div id="topbar"> 
            <ul id="icone_menu" class="nav navbar-nav">
                <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
            </ul>
            <ul class="nav navbar-nav">
                <a href="<?php echo Router::url('events/index'); ?>" class="link_head"><h2 id="title">Plan<span id="e_logo" class="e_logo_black">E</span>Sphere</h2></a>
            </ul>
            <form action="<?php echo Router::url('recherches/index'); ?>" method="post" class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                            <input type="text" class="form-control" name="recherche" placeholder="<?php echo ApplicationResourceBundle::getConstant("menu.search", $this->Session->read('locale')); ?>">
                    </div>
                    <button type="submit" class="btn btn-default"><?php echo ApplicationResourceBundle::getConstant("menu.search", $this->Session->read('locale')); ?></button>
            </form>	
            <ul class="navbar-nav navbar-right">
                   <?php if($this->Session->user('users_statut')=="admin"){?>
                        <span id="panel_admin" class=""><a href="<?php echo Router::url('panelAdmin/index') ?>">Panel Admin</a></span>
                   <?php } ?>
                        <span id="notification" class="lien_profil"><a href="#" data-toggle="popover" data-content=""></a></span>
                    <?php if($this->Session->user('users_pseudo')!=""){
                        $pseudo=$this->Session->user('users_pseudo');
                    } else {
                        $pseudo=$this->Session->user('users_prenom');
                    }?>
                    <span class="lien_profil"><?php echo ApplicationResourceBundle::getConstant("header.hello", $this->Session->read('locale'), array($pseudo)); ?></span>
                    <a href="<?php echo Router::url('users/monProfil') ?>" class="lien_profil"><img src="<?php echo $this->Session->user('users_photo'); ?>" class="photo_arrondie_petite" alt="Mon profil" data-toggle="tooltip" data-placement="bottom" title="Mon profil"/></a>
                    <a href="<?php echo Router::url('users/logout'); ?>" class="lien_profil" alt="Se déconnecter"><i class="fa fa-lg fa-power-off" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Se déconnecter"></i></a>
                    <a id='containerElem'>
                        <button id="popoverBtn" type="button" class="btn btn-default"
					data-html="true" data-trigger="click"
                                        data-container="#containerElem"
                                        data-content="
                                            <?php foreach (Conf::$language as $key => $value) { ?>
                                                <div id='<?php echo $key;?>' class='language' onclick='changeLanguage(`<?php echo $key;?>`);'><img src='<?php echo IMG.'/'.$key.'.png';?>' title='<?php echo $value;?>' width='20px'/></div>
                                            <?php }?>"
					data-placement="bottom">Choisir langue
			</button>
                    </a>
            </ul>
        </div>
        <div id="wrapper">
            <div class='row col-md-12'>
                <div id="menu" class="col-md-2">
                                <span><?php echo ApplicationResourceBundle::getConstant("menu.events", $this->Session->read('locale')); ?></span>
                                <a href="<?php echo Router::url('events/index'); ?>" class="lien_menu">
                                    <i class="fa fa-calendar-o"></i> <?php echo ApplicationResourceBundle::getConstant("menu.events.myEvents", $this->Session->read('locale')); ?>
                                </a>
                                <a href="<?php echo Router::url('events/index/public'); ?>" class="lien_menu">
                                    <i class="fa fa-calendar"></i> <?php echo ApplicationResourceBundle::getConstant("menu.events.publicEvents", $this->Session->read('locale')); ?>
                                </a>
                                <a href="<?php echo Router::url('events/newEvent'); ?>" class="lien_menu">
                                    <i class="fa fa-calendar-plus-o"></i> <?php echo ApplicationResourceBundle::getConstant("menu.events.createEvent", $this->Session->read('locale')); ?>
                                </a>
				<br/>
                                <span><?php echo ApplicationResourceBundle::getConstant("menu.sphere", $this->Session->read('locale')); ?></span>
                                <a href="<?php echo Router::url('groupes/index'); ?>" class="lien_menu">
                                    <i class="fa fa-users"></i> <?php echo ApplicationResourceBundle::getConstant("menu.sphere.mySpheres", $this->Session->read('locale')); ?>
                                </a>
                                <a href="<?php echo Router::url('groupes/newGroupe'); ?>" class="lien_menu">
                                    <i class="fa fa-plus-circle"></i> <?php echo ApplicationResourceBundle::getConstant("menu.sphere.createSphere", $this->Session->read('locale')); ?>
                                </a>
                                <a href="<?php echo Router::url('users/index'); ?>" class="lien_menu">
                                    <i class="fa fa-user"></i> <?php echo ApplicationResourceBundle::getConstant("menu.sphere.myFriends", $this->Session->read('locale')); ?>
                                </a>
                                <hr/>
                                <!--<span>Filtres</span>-->
                                <?php echo $menu_for_layout; ?>
                </div>
                <div id="container" class="col-md-10 col-md-offset-2">
                        <div class="container col-md-10 col-md-offset-1">
                                <div id="container_message_notif" class="col-md-12"><div id="message_notif"></div></div>
                                <?php echo $content_for_layout; ?>
                        </div>
                </div>
            </div>
            <div class="clear"></div>
            <div id="footer">
                Développé par Pahul & Winni / Design par Winni - &copy; Tous droits réservés 
                </br> 
                <a href="<?php echo Router::url('about'); ?>" class="link_footer"><?php echo ApplicationResourceBundle::getConstant("footer.aPropos", $this->Session->read('locale')); ?></a> - 
                <a href="<?php echo Router::url('bug'); ?>" class="link_footer"><?php echo ApplicationResourceBundle::getConstant("footer.bug", $this->Session->read('locale')); ?></a> - 
				<a href="<?php echo Router::url('mentions-legales'); ?>" class="link_footer">Mentions légales</a> -
                <a href="<?php echo Router::url('cgu'); ?>" class="link_footer">CGU</a> - 
				<a href="<?php echo Router::url('faqs'); ?>" class="link_footer">FAQ</a> - 
				<a href="<?php echo Router::url('contact'); ?>" class="link_footer" class="link_footer">Contact</a>
            </div> 
        </div>     
    </body> 
</html>