</main>
<footer>
<!--	<div class="page">
		Page :
		<ul>
			<li>1</li>
			<li>2</li>
			<li>3</li>
			<li>4</li>
			<li>5</li>
			<li>6</li>
			<li>7</li>
			<li>8</li>
			<li>9</li>
			<li>10</li>
		</ul>
	</div> -->
	<ul class="footList">
<?php foreach ($headList as $key => $value): ?>
		<li class="navList" title="<?=$headList[$key]['category']?>"><a href="thread.php?id=<?=$headList[$key]['id']?>">/<?=$headList[$key]['type']?></a></li>
<?php endforeach; ?>
	</ul>
	<nav class="footNav">
		<a href="http://www.taylorswift.com">Queen Taytay official</a>
		<a href="index.php">Home</a>
	</nav>
</footer>