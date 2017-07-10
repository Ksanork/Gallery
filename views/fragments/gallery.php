<section class="content">
	<div class="content-top"></div>
	<article>
		 <?php foreach ($this->variables['publicgallery'] as $i): ?>
		<div class="image">
			<a class="image" href="images/<?= $i['_id'] . '.' . $i['ext']?>">
				<img src="images/<?= $i['_id'] . '-thumb.' . $i['ext']?>" /><br />
				<span class="author"><?= $i['author'] ?></span><br />
				<span><?= $i['title'] ?></span><br />
			</a>
		</div>
		<?php endforeach ?>
	</article>
	<div class="content-bottom"></div>
</section>