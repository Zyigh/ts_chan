<?php
//variables pour le formulaire
	$whatForm = 'thread';
	$id = 'category_id';

	require_once 'connect.php';
	$_GET = secureGet($_GET);
	
    $title = 'SELECT
    `id`, 
	`type`,
	`category`
	FROM 
	`category`	
	;';
	$stmt = $pdo->prepare($title);
    $stmt->execute();
//Pour afficher le bon thread, on récupère toutes les valeurs de `category`
//chaque index de $headList est un tableau qui contient chaque colonne de la table
    $headList = $stmt->fetchAll();
//on crée un tableau vide $getTitle
    $getTitle = array();
//On teste tous les index de $headList
//Si l'id correspond à l'id appelé en _GET
//on stocke toutes les données du tableau dans $getTitle
    foreach ($headList as $key => $value) {
    	if($headList[$key]['id']==$_GET['id'])
    	{
    		array_push($getTitle, $headList[$key]['type'], $headList[$key]['category'], $headList[$key]['id']);
    	}
    }
//Si $getTitle est vide, on retourne à l'index
    if (!isset($getTitle) || !isset($_GET['id']))
    {
    	header('Location: index.php');
    }

	$thread = 'SELECT 
	`title`,
	`name`,
	`date`,
	`id`,
	`file`,
	`comment`
	FROM 
	`thread`
	WHERE
	`category_id`= :category_id
	ORDER BY
	`id` desc
	;';
//grâce à $getTitle, on peut binder pour récupérer les thread d'une même catégorie
	$getThread = $pdo->prepare($thread);
    $getThread->bindValue(':category_id', $getTitle['2'], PDO::PARAM_INT);
    $getThread->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>/<?=$getTitle['0']?> - <?=$getTitle['1']?></title>
	<link rel="stylesheet" type="text/css" href="styles/tschan.css">
</head>
<body>
	<?php
		require_once 'header.php';
		require_once 'form.php';
//On affiche ligne après ligne ce qui nous intéresse des thread
		while($rowThread = $getThread->fetch(PDO::FETCH_ASSOC)):
//sécurité
			$rowThread = secureGet($rowThread);
//On ne récupère que les replies où l'id parent correspond à l'id du thread affiché
			$reply = 'SELECT 
			`id`,
			`name`,
			`date`,
			`file`,
			`comment`
			FROM 
			`reply`
			WHERE
			`thread_id`= :thread_id
			;';
			$getReply = $pdo->prepare($reply);
    		$getReply->bindValue(':thread_id', $rowThread['id'], PDO::PARAM_INT);
    		$getReply->execute();
//Compte les réponses par thread
    		$count = 'SELECT 
    		COUNT(*)
    		FROM
    		`reply`
    		WHERE
    		`thread_id`= :thread_id
    		;';
    		$getCount = $pdo->prepare($count);
    		$getCount->bindValue(':thread_id', $rowThread['id'], PDO::PARAM_INT);
    		$getCount->execute();
    		$num = $getCount->fetch();
	?>
<!-- HTML DU THREAD -->
<!-- Threads -->	
		<article class="thread">
			<div class="op onthread">
				<ul class="info">
	<!-- Titre -->
					<li><span class="title"><?=$rowThread['title']?></span></li>
	<!-- Name -->
					<li><strong><?=$rowThread['name']?></strong></li>
	<!-- Date -->
					<li><em><?=$rowThread['date']?></em></li>
	<!-- Lien vers les réponses -->
					<li><a href="reply.php?id=<?=$rowThread['id']?>">Reply</a></li>
				</ul>
	<!-- Photo -->
				<?php if ($rowThread['file']!=""): ?>
					<img src="content/<?=$rowThread['file']?>" class="resize medium" draggable="true">
				<?php endif; ?>
	<!-- Commentaire -->
				<p>
					<?=$rowThread['comment']?>
				</p>
	<!-- Nombres de réponses -->
				<ul class="info bottom">
					<li><em><?=$num['0']?> replies -</em></li>
	<!-- Lien vers les réponses -->
					<li><a href="reply.php?id=<?=$rowThread['id']?>">Click here to view</a></li>
				</ul>
			</div>
		<?php
//On n'affiche que 3 replies par thread
			for ($i=0; $i < 3; $i++):
				$rowReply = $getReply->fetch(PDO::FETCH_ASSOC);
//sécurité
				if ($rowReply) :		
					$rowReply = secureGet($rowReply);
					if (isset($rowReply['id'])):
		?>
<!-- HTML DES REPONSES -->
<!-- Replies -->
					<div class="reply onthread">
						<ul class="info">
	<!-- Nom du posteur du message -->
							<li><strong><?=$rowReply['name']?></strong></li>
	<!-- Date -->
							<li><em><?=$rowReply['date']?></em></li>
						</ul>
	<!-- Si une image a été enregistré, on l'affiche -->
						<?php if ($rowReply['file']!=""): ?>
							<img src="content/<?=$rowReply['file']?>" class="resize tiny">
						<?php endif; ?>
	<!-- Commentaire -->
						<p>
							<?=$rowReply['comment']?>
						</p>
					</div>
		<?php
					endif;
				endif;
			endfor;
		?>	
		</article>
		<?php endwhile; ?>		
	<?php 
		require_once('footer.php');
		require_once('js/javascript.php');
	?>
</body>
</html>