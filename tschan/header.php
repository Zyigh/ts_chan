	<header class="page">
		<a href="index.php"><img src="content/logoSwift.png" class="logo"></a>
		<ul class="headList">
	<?php foreach ($headList as $key => $value): ?>
			<li class="navList" title="<?=$headList[$key]['category']?>"><a href="thread.php?id=<?=$headList[$key]['id']?>">/<?=$headList[$key]['type']?></a></li>
	<?php endforeach; ?>
		</ul>
		<nav class="headNav">
			<a href="http://www.taylorswift.com">Queen Taytay official</a>
			<a href="index.php">Home</a>
		</nav>
	</header>

