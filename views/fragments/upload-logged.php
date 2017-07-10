<section class="content">
			<div class="content-top"></div>
			
			<article>
				<h1>Dodawanie obrazów:</h1>
				
				<form method="post" enctype="multipart/form-data" >
					<label for="image">Dodaj obraz:</label> <input name="image" type="file" accept="image/png, image/jpg, image/jpeg" /><br />
					<label for="title">Tytuł:</label> <input name="title" type="text" /><br />
					<label for="watermark">Znak wodny:</label> <input name="watermark" type="text" /><br />
					
					<label for="author">Autor:</label> <input name="author" type="text" readonly="readonly"  value="<?= $_SESSION['user'] ?>" /><br />
					<label for="private">Prywatne</label> <input type="radio" name="private" value="true" /><br />
					<label for="private">Publiczne</label> <input type="radio" name="private" value="false" checked="checked"/><br />						
					
					<input type="submit" value="Dodaj obraz" />
				</form>
				
			</article>
			<div class="content-bottom"></div>
		</section>