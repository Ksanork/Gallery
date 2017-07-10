<section class="content">
	<div class="content-top"></div>
	<article>
		<form method="post">
			 <?php foreach ($this->variables['publicgallery'] as $i): ?>
				<div class="image">
					<?php if(in_array($i, $this->variables['favouritegallery'])): ?>
						<input class="check" type="checkbox" name="check_img[]" value="<?= $i['_id'] ?>" checked="checked" />
					<?php else: ?>
						<input class="check" type="checkbox" name="check_img[]" value="<?= $i['_id'] ?>" />
					<?php endif ?>
					<a class="image" href="images/<?= $i['_id'] . '.' . $i['ext']?>">
						<img src="images/<?= $i['_id'] . '-thumb.' . $i['ext']?>" /><br />
						<span class="author"><?= $i['author'] ?></span><br />
						<span><?= $i['title'] ?></span><br />
					</a>
				</div>
			<?php endforeach ?>
			
			<?php if ($this->variables['privategallery']->count()): ?>
				<h1 class="private-h">Prywatne:</h1>
				<?php foreach ($this->variables['privategallery'] as $i): ?>
					<div class="image">
						<?php if(in_array($i, $this->variables['favouritegallery'])): ?>
							<input class="check" type="checkbox" name="check_img[]" value="<?= $i['_id'] ?>" checked="checked" />
						<?php else: ?>
							<input class="check" type="checkbox" name="check_img[]" value="<?= $i['_id'] ?>" />
						<?php endif ?>
						<a class="image" href="images/<?= $i['_id'] . '.' . $i['ext']?>">
							<img src="images/<?= $i['_id'] . '-thumb.' . $i['ext']?>" /><br />
							<span class="author"><?= $i['author'] ?></span><br />
							<span><?= $i['title'] ?></span><br />
						</a>
					</div>
				<?php endforeach ?>
			<?php endif ?>
			<br /><br />
			<input type="submit" value="Dodaj do zapamiętanych" />
		</form>
	</article>
	<div class="content-bottom"></div>
</section>