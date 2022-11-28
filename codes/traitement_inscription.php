<?php
	// activation du m�canisme des sessions
	session_start();

include('bibliotheque.php');

    $mdp = $_POST['mdp'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $numTel = $_POST['tel'];
	$ville = $_POST['ville'];
	$rue = $_POST['rue'];
	$cp = $_POST['cp'];
	$pseudo = $_POST['pseudo'];
	
/*On fait une requ�te pour s�assurer que le pseudo n�existe pas dans la bdd
Requ�te qui cherche le pseudo dans la bdd*/
$requete ="SELECT pseudo
		   	FROM client
			WHERE pseudo='$pseudo'";

// connexion � la base de donn�es
	$connexion = connecter();
		
	//Ex�cution de la requ�te
	$resultat = mysqli_query($connexion, $requete);
		
	//Fermeture de la bdd
	mysqli_close($connexion);


if (mysqli_num_rows($resultat) == 0)
  { 
// si le resultat est egal a 0 alors ce pseudo n�existe pas
//Hacher le mot de passe r�cup�r� et le stocker dans une variable $mdph

$mdph = password_hash($mdp, PASSWORD_DEFAULT);
		 
	// requ�te d'ajout dans la base de donn�es
$requete = "INSERT INTO client (nom, prenom, numTel,pseudo,mdp,ville, rue, cp )
VALUES ( '$nom', '$prenom', '$numTel', '$pseudo','$mdph','$ville', '$rue', '$cp');";
	// connexion � la base de donn�es
	$connexion = connecter();
		
	//Ex�cution de la requ�te
	$resultat = mysqli_query($connexion, $requete);
		
	//Fermeture de la bdd
	mysqli_close($connexion);
	
	// Ouverture d�une session pour ce pseudo
	$_SESSION['pseudo']= $pseudo;

	// et redirection vers l'accueil			 
	header ("Location: acceuil.php");
  }
  // sinon le pseudo existe d�j�, affichage d�un message et lien de retour au formulaire
  else
	{
    echo '<a href=connexion_inscription.php >Ce pseudo est deja utilise, cliquez ici pour retourner a linscription <a> ';

	}
$_SESSION['pseudo'] = $pseudo;
?>