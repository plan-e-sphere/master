<link rel="stylesheet" href="<?php echo CSS.'/style_contact.css'; ?>"/>
<div class="bloc_gen">
<div class="bloc_contact">
	<h3 class="titre_section">Contactez-nous</h3>
	<p id="pgf_contact">
	Besoin d’aide ? Une question ? Vous n'avez pas trouvé votre bonheur dans la <a href="<?php echo Router::url('faqs'); ?>">FAQ</a>?
	<br/>N’hésitez pas à nous contacter par courrier à l'adresse suivante:<br/>
	ADRESSE DU SIEGE SOCIAL
	</p>
</div>
<div class="bloc_contact">
	<h3 class="titre_section">Par téléphone</h3>
	<p id="pgf_contact">Vous pouvez également nous joindre au : 0000000000 (coût d'un appel local).</p>
</div>
<div class="bloc_contact">
	<h3 class="titre_section">Par mail</h3>
		<form id="formulaire_contact" method="post" action="/traitement">
			<label for="nom">Nom :</label>
				<input type="text" name="nom" id="nom" class="zone_texte" />
			<label for="adresse">Adresse mail :</label>
				<input type="email" name="adresse" id="adresse" class="zone_texte" />
			<label for="objet">Objet :</label>
				<input type="text" name="objet" id="objet" class="zone_texte" />
			<label for="message">Message :</label>
				<textarea name="message" id="message" class="zone_texte"></textarea>
					<input type="submit" name="submit" id="submit" value="Envoyer" />
		</form>
</div>
</div>