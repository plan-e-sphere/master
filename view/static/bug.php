<link rel="stylesheet" href="<?php echo CSS.'/style_contact.css'; ?>"/>
<link rel="stylesheet" href="<?php echo CSS.'/style_bug.css'; ?>"/>
<div class="bloc_gen">
	<div class="bloc_contact">
		<h3 class="titre_section">Signaler un bug</h3>
		<p>
		Vous avez repéré un bug sur le site ? Une faute d'orthographe ou de grammaire ? Des messages d'erreurs récurrents et anormaux ?... N'hésitez pas à nous le signaler.
		<br/>
		Attention ! Les messages seront transmis directement aux développeurs ! Nous lirons tous les messages, mais nous n'y répondrons pas. Ce formulaire a uniquement pour but de signaler des problèmes sur le site.
		</p>
		<form id="formulaire_bug" method="post" action="/traitement_bug">
			<label for="sujet">Sujet :</label>
				<input type="text" name="sujet" id="sujet_bug" class="zone_texte" />
			<label for="message">Message :</label>
				<textarea name="message" id="message" class="zone_texte"></textarea>
					<input type="submit" name="submit" id="submit" value="Envoyer" />
		</form>
	</div>
</div>