<section class="content">
	<div class="content-top"></div>
	<article>
		<form method="post">
			 <?php foreach ($this->variables['favouritegallery'] as $i): ?>
				<div class="image">
					<input class="check" type="checkbox" name="rem_img[]" value="<?= $i['_id'] ?>" />
					<a class="image" href="images/<?= $i['_id'] . '.' . $i['ext']?>">
						<img src="images/<?= $i['_id'] . '-thumb.' . $i['ext']?>" /><br />
						<span class="author"><?= $i['author'] ?></span><br />
						<span><?= $i['title'] ?></span><br />
					</a>
				</div>
			<?php endforeach ?>
			<br /><br />
			<input type="submit" value="Usuń z zapamiętanych" />
		</form>
	</article>
	<div class="content-bottom"></div>
</section>