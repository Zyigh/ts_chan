<?php
//variables pour le formulaire
	$whatForm = 'reply';
	$id = 'thread_id';

	require_once 'connect.php';
	$thread = 'SELECT 
	`category_id`,
	`title`,
	`name`,
	`date`,
	`id`,
	`file`,
	`comment`
	FROM 
	`thread`
	WHERE
	`id`= :id
	;';
	$getThread = $pdo->prepare($thread);
    $getThread->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $getThread->execute();
    $rowThread = $getThread->fetch(PDO::FETCH_ASSOC);
//sécurité
    $rowThread = secureGet($rowThread);

	$reply = 'SELECT
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
   	$getReply->bindValue(':thread_id', $_GET['id'], PDO::PARAM_INT);
   	$getReply->execute();

    $title = 'SELECT
    `id`, 
	`type`,
	`category`
	FROM 
	`category`	
	;';

	$stmt = $pdo->prepare($title);
    $stmt->execute();

    $headList = $stmt->fetchAll();
    
    $getTitle = array();
    foreach ($headList as $key => $value) {
    	if($headList[$key]['id']==$rowThread['category_id'])
    	{
    		array_push($getTitle, $headList[$key]['type'], $headList[$key]['category'], $headList[$key]['id']);
    	}
    }
        if (!isset($getTitle['0']) || !isset($getTitle['1']))
    {
    	header('Location: index.php');
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>/<?=$getTitle['0']?> - <?=$rowThread['title']?> - <?=$getTitle['1']?></title>
	<link rel="stylesheet" type="text/css" href="styles/tschan.css">
</head>
<body>
	<?php 
		require_once('header.php'); 
		require_once('form.php');
	?>
		<article class="article">
			<div class="op">			
				<ul class="info">
					<li><span class="title"><?=$rowThread['title']?></span></li>
					<li><strong><?=$rowThread['name']?></strong></li>
					<li><em><?=$rowThread['date']?></em></li>
				</ul>
				<?php if ($rowThread['file']!=""): ?>
					<img src="content/<?=$rowThread['file']?>" class="resize medium">
				<?php endif; ?>
				<p>
					<?=$rowThread['comment']?> 
				</p>
			</div>
		</article>
		<?php
			while ($rowReply = $getReply->fetch(PDO::FETCH_ASSOC)):
//sécurité
				$rowReply = secureGet($rowReply);
		?>
			<section class="reply onreply">
				<ul class="info">
					<li><strong><?=$rowReply['name']?></strong></li>
					<li><em><?=$rowReply['date']?></em></li>
				</ul>
				<?php if ($rowReply['file']!=""): ?>
					<img src="content/<?=$rowReply['file']?>" class="resize tiny">
				<?php endif; ?>
				<p>
					<?=$rowReply['comment']?>				
				</p>
			</section>
	<?php
		endwhile;
		require_once('footer.php');
		require_once('js/javascript.php')
	?>
</body>
</html>