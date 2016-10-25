<link rel="stylesheet" href="<?php echo CSS.'/style_users.css';?>"/>
<h1><?php echo isset($title)?$title:'Mes Amis'; ?></h1>

<?php foreach ($users as $k => $v): ?>
	<div class="col-md-3 profile_friend">
		<a href=<?php echo Router::url('users/profil/'.$v->users_id);?> class="link_head">
			<img src="<?php echo $v->users_photo; ?>" class="photo_arrondie"/>
		</a>
		<?php if(trim($v->users_pseudo)!=""):echo $v->users_pseudo;else: echo $v->users_prenom." ".$v->users_nom; endif ?>
	</div>
<?php endforeach ?>