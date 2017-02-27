<main>
	<div class="thForm">
<?php
	if (isset($_GET['id'])):
		
?>
	<h2>/<?=$getTitle['0']?> - <?=$getTitle['1']?></h2>
	<!-- Envoi du formulaire en JS (l.81), pas besoin de submit, ni d'action -->
		<h3 id="formTitle">Post a new <?=$whatForm?></h3>
		<form id="dropper" class="newThread" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="8388608"> 
			<div class="formLine">
				<span class="what">Name :</span>
				<input class="formContent" type="text" name="name" placeholder="Anonymous">
			</div>
			<?php if ($id == 'category_id'): ?>
				<div class="formLine">
					<span class="what">Title :</span>
					<input class="checkClass formContent" type="text" name="title" placeholder="required" required="required">
				</div>
			<?php endif; ?>
			<div class="textarea">
				<span class="what">Comment :</span>
				<textarea class="formContent" name="comment" maxlength="4208" rows="10" placeholder="required" selectionDirection="none" required="required"></textarea>
			</div>
			<div class="formLine">
				<span class="what">File :</span>
				<label for="file" class="browse">Browse...</label>
				<input id="file" class="imgSent" type="file" accept="image/*" <?php if($whatForm=='thread'):?>required="required"<?php endif;?>>
			</div>
			<div class="formLine">
				<div class="temp" id="host">
				</div>
			</div>
			<div class="formLine">
				<label id="button" class="post">Post</label>
			</div>
		</form>
	</div>
<?php 
	endif;

?>
