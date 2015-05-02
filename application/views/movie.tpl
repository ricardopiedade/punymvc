<?php if (isset($movie)): ?>
<div class="row">
    <h2><?= $movie->title ?></h2>

    <div class="pull-left">
        <img src="<?= $movie->poster ?>"/>
    </div>
    <div class="movie_detail">
    
    <div><strong>Release Date</Strong> <?= $movie->release_date ?></div>
    <div><strong>Genres</strong> <?= $movie->genres ?></div>
    <div><strong>Directed By</strong> <?= $movie->director ?></div>
    <div><strong>Written By</strong> <?= $movie->writer ?></div>
    <div><strong>Stars</strong> <?= $movie->actors ?></div>
    
    <div class="plot">
        <?= $movie->plot ?>    
    </div>
    <?php if (isset($movieInfo->Website) && filter_Var($movieInfo->Website, FILTER_VALIDATE_URL)): ?>
    <h5><a href="<?= $movieInfo->Website ?>"><?= $movieInfo->Website ?></a></h5>
    <?php endif; ?>     

    </div>
</div>
<?php else: ?>
<p>That movie does not seem to exist...</p>
<?php endif; ?>