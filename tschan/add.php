<?php
	require_once 'connect.php';
//security
	$_GET = secureGet($_GET);
/*
//récupérer les clés de _GET
// get['0'] == category_id || thread_id
//get['1'] == where
// $_GET[$get['0']] renvoie le nom de la colonne qui change entre les deux tables
*/
	$get = array_keys($_GET);

//Si une image a été envoyée
	if (isset($_FILES)):
//traitement des fichiers
//où on stocke
		$place = 'content/';
//on récupère le nom
		$imgName = basename($_FILES['pic']['name']);
//set max weight, again
		$maxSize = 8388608;
//On récupère la taille du fichier pour comparer après
		$fileSize = filesize($_FILES['pic']['tmp_name']);
//On stocke dans un tableau les extensions acceptées pour pouvoir les comparer
//Evite de se retrouver avec un .php dans la db
		$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.bmp', '.tiff');
//on récupère l'extension du fichier envoyé pour pouvoir comparer
		$extension = strrchr($_FILES['pic']['name'], '.');
//On commence les vérifications (extension && taille)
		if(!in_array($extension, $extensions)||$fileSize>$maxSize):
			die('hi');
		else:
//On met devant le nom de l'image, l'id et la catégorie dans laquelle le fichier 
//va s'afficher, pour éviter les doublons 
			$img = 'SELECT
			`id`
			FROM
			`'.$_GET['where'].'`
			ORDER BY
			id DESC
			;';
			$smth = $pdo->prepare($img);
			$smth->execute();	
			$rowImg = $smth->fetch(PDO::FETCH_ASSOC);
			$id = $rowImg['id'];
			$id+=1;
			$prefix = $_GET['where']['0'].$id;
//remplacement des caractères spéciaux
			$imgName = strtr($imgName, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
			$imgName = preg_replace('/([^.a-z0-9]+)/i', '-', $imgName);
//on concatène le préfix et le nom de l'image
	     	$imgName = $prefix.$imgName;
//on tente de mettre l'image dans notre fichier, sinon taylorSwift()
			if (!move_uploaded_file($_FILES['pic']['tmp_name'], $place.$imgName)):
				die('hi2');
			endif;
		endif;
	endif;
//sécuriser les données qu'on va récupérer
//	$_FILES = secureGet($_FILES);
//Assigner Anonymous comme name en automatique
	if ($_POST['name'] == "")
	{
		$_POST['name'] = 'Anonymous';
	}
	
//Si on a deux index en _GET on prend en compte le formulaire
	if (isset($get['0']) && isset($get['1']))
	{
//une seule requete sql
//seule différence entre `reply` et `request`, c'est l'id du niveau au dessus
		$sql = 'INSERT INTO `'.$_GET['where'].'`
		(`'.$get['0'].'`, `name`, `comment`, `date`';
//si on a category_id en _GET, on a `title` à remplir en plus
		if ($get['0'] == 'category_id')
		{
			$sql .= ', `title`';
		}
//si on a une image
		if (isset($_FILES))
		{
			$sql .= ', `file`';
		}
		$sql .= ')
		VALUES
		(:category_id, :name, :comment, :date
		';
//si on a category_id en _GET, il faudra assigner :title
		if ($get['0'] == 'category_id')
		{
			$sql .= ', :title';
		}
//si on a une image
		if (isset($_FILES))
		{
			$sql .= ', :file';
		}
		$sql .= ');';
	
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':category_id', $_GET[$get['0']], PDO::PARAM_INT);
		$stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
		$stmt->bindValue(':comment', $_POST['comment'], PDO::PARAM_STR);
		$stmt->bindValue(':date', formatDate(date(c)), PDO::PARAM_STR);
//si category_id, on bind title
		if ($get['0'] == 'category_id')
		{
			$stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
		}
//si on a une image
		if (isset($_FILES))
		{
			$stmt->bindValue(':file', $imgName, PDO::PARAM_STR);
		}
		$stmt->execute();
		header('Location: '.$_GET['where'].'.php?id='.$_GET[$get['0']]);
	}
//sinon visite a Queen Taytay
	else
	{
		header('Location: http://www.taylorswift.com/');
	}
?>