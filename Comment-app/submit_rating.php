<?php

// Établir une connexion à la base de données MySQL en utilisant l'objet PDO
$connect = new PDO("mysql:host=localhost;dbname=comment", "root", "");

// Vérifier si des données de notation ont été envoyées via la méthode POST
if(isset($_POST["rating_data"]))
{
	// Préparer les données à insérer dans la base de données
	$data = array(
		':user_name'		=>	$_POST["user_name"],
		':user_rating'		=>	$_POST["rating_data"],
		':user_review'		=>	$_POST["user_review"],
		':datetime'			=>	time()
	);

	// Requête SQL pour insérer les données dans la table de commentaires
	$query = "
	INSERT INTO review_table 
	(user_name, user_rating, user_review, datetime) 
	VALUES (:user_name, :user_rating, :user_review, :datetime)
	";

	// Préparer la requête
	$statement = $connect->prepare($query);

	// Exécuter la requête avec les données préparées
	$statement->execute($data);

	// Afficher un message de confirmation
	echo "Votre commentaire et votre évaluation ont été soumis avec succès";
}

// Vérifier si une action a été envoyée via la méthode POST
if(isset($_POST["action"]))
{
	// Initialisation des variables de calcul des statistiques de notation
	$average_rating = 0;
	$total_review = 0;
	$five_star_review = 0;
	$four_star_review = 0;
	$three_star_review = 0;
	$two_star_review = 0;
	$one_star_review = 0;
	$total_user_rating = 0;
	$review_content = array();

	// Requête SQL pour sélectionner toutes les entrées de la table de commentaires, triées par ordre décroissant d'identifiant
	$query = "
	SELECT * FROM review_table 
	ORDER BY review_id DESC
	";

	// Exécuter la requête et récupérer le résultat sous forme de tableau associatif
	$result = $connect->query($query, PDO::FETCH_ASSOC);

	// Parcourir les entrées de la base de données pour calculer les statistiques
	foreach($result as $row)
	{
		// Ajouter les détails du commentaire actuel dans le tableau des contenus de commentaires
		$review_content[] = array(
			'user_name'		=>	$row["user_name"],
			'user_review'	=>	$row["user_review"],
			'rating'		=>	$row["user_rating"],
			'datetime'		=>	date('l jS, F Y h:i:s A', $row["datetime"])
		);

		// Compter les commentaires en fonction de leur note
		if($row["user_rating"] == '5')
		{
			$five_star_review++;
		}

		if($row["user_rating"] == '4')
		{
			$four_star_review++;
		}

		if($row["user_rating"] == '3')
		{
			$three_star_review++;
		}

		if($row["user_rating"] == '2')
		{
			$two_star_review++;
		}

		if($row["user_rating"] == '1')
		{
			$one_star_review++;
		}

		// Compter le nombre total d'avis
		$total_review++;

		// Calculer le total des notes données par les utilisateurs
		$total_user_rating = $total_user_rating + $row["user_rating"];
	}

	// Calculer la note moyenne en divisant le total des notes par le nombre total d'avis
	$average_rating = $total_user_rating / $total_review;

	// Créer un tableau de sortie contenant les statistiques et les contenus des commentaires
	$output = array(
		'average_rating'	=>	number_format($average_rating, 1),
		'total_review'		=>	$total_review,
		'five_star_review'	=>	$five_star_review,
		'four_star_review'	=>	$four_star_review,
		'three_star_review'	=>	$three_star_review,
		'two_star_review'	=>	$two_star_review,
		'one_star_review'	=>	$one_star_review,
		'review_data'		=>	$review_content
	);

	// Convertir le tableau de sortie en format JSON et l'afficher
	echo json_encode($output);
}

?>
