<?php
$destinataire='contact@plan-e-sphere.fr';
$copie='non';
$message_envoye = "Votre message nous est bien parvenu !";
$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
$message_erreur_formulaire = "Vous devez d'abord remplir le formulaire.";
$message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis.";

// on teste si le formulaire a été soumis
if (!isset($_POST['envoi']))
{
// formulaire non envoyé
echo '<p>'.$message_erreur_formulaire.'</p>'."\n";
}
else
{
//cette fonction sert à nettoyer et enregistrer un texte
function Rec($text)
	{
		$text = htmlspecialchars(trim($text), ENT_QUOTES);
		if (1 === get_magic_quotes_gpc())
		{
			$text = stripslashes($text);
		}
 
		$text = nl2br($text);
		return $text;
	};
// formulaire envoyé, on récupère tous les champs.
	$sujet   = (isset($_POST['sujet']))   ? Rec($_POST['sujet'])   : '';
	$message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
	
if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
{
// Remplacement de certains caractères spéciaux
		$message = str_replace("&#039;","'",$message);
		$message = str_replace("&#8217;","'",$message);
		$message = str_replace("&quot;",'"',$message);
		$message = str_replace('<br>','',$message);
		$message = str_replace('<br />','',$message);
		$message = str_replace("&lt;","<",$message);
		$message = str_replace("&gt;",">",$message);
		$message = str_replace("&amp;","&",$message);
}
else
	{
// une des variables (ou plus) est vide ...
		echo '<p>'.$message_formulaire_invalide.' <a href="contact.php">Retour au formulaire</a></p>'."\n";
	};
}; // fin du if (!isset($_POST['envoi']))
?>
	