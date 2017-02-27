<?php 
	require_once 'connect.php';

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
?>
<!DOCTYPE html>
<html>
<head>
<main>
	<meta charset="utf-8">
	<title>It's all about Queen Taytay</title>
	<link rel="stylesheet" type="text/css" href="styles/tschan.css">
</head>
<body>
	<header class="headerMain">
		<div class="headImg">
			<a href="http://taylorswift.com/"><img src="content/swift.jpg" class="swiftMain" alt="Taylor Swift"></a>
		</div>
	</header>
	<main class="index">
		<section class="categoryIndex">
			<div class="col">
				<ul class="categoryList">
					<?php foreach ($headList as $key => $value):
							if ($key<4): ?>
						<li><a href="thread.php?id=<?=$headList[$key]['id']?>"><?=$headList[$key]['category']?></a></li>
					<?php 	endif;
						endforeach; ?>
				</ul>
			</div>
			<div class="col">
				<ul class="categoryList">
					<?php foreach ($headList as $key => $value):
							if ($key>3 && $key<8): ?>
						<li><a href="thread.php?id=<?=$headList[$key]['id']?>"><?=$headList[$key]['category']?></a></li>
					<?php 	endif;
						endforeach; ?>
				</ul>
			</div>
			<div class="col">
				<ul class="categoryList">
					<?php foreach ($headList as $key => $value):
							if ($key>7): ?>
						<li><a href="thread.php?id=<?=$headList[$key]['id']?>"><?=$headList[$key]['category']?></a></li>
					<?php 	endif;
						endforeach; ?>
				</ul>
			</div>
		</section>
	</main>
<?php
	require_once 'footer.php';
?>


</body>
</html>