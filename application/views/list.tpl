<div class="movie_list"
	
	<?php foreach ($list as $movie): ?>
    <div class="movie_list_item">
		<div class="movie_list_poster">
			<img src="<?= $movie->poster ?>" border="0">
		</div>
		<div class="movie_list_info">
		<h5><?= $movie->title ?></h5>
		<?= $movie->genres ?>
		<?= $movie->release_date ?>
		
		<?= $movie->director ?>
		<?= $movie->actors ?>	
		</div>
		
		
	
	</div>
	<?php endforeach; ?>	
	
</div>