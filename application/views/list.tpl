
<?php foreach ($list as $movie): ?>
<div class="row movie_list_item">
	<div class="pull-left movie_list_poster">
		<img width="150" height="200" src="<?= $movie->poster ?>" border="0">
	</div>
	<div class="movie_list_info">
	<h2><a href="/movie/<?= $movie->slug ?>"><?= $movie->title ?></a></h2>
	
	<div><strong>Release Date</Strong> <?= $movie->release_date ?></div>
	<div><strong>Genres</strong> <?= $movie->genres ?></div>
	<div><strong>Director</strong> <?= $movie->director ?></div>
	<div><strong>Actors</strong> <?= $movie->actors ?></div>
	 
	</div>
</div>
<?php endforeach; ?>