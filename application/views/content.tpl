<p>Hello PunyMVC!</p>
<p>This is a view called from a controller!</p>
<p>And this is a template variable: <?=$templateVar ?></p>
<ul>
    <?php foreach($games as $game): ?>
   <li><?= $game ?></li> 
   <?php endforeach ?>
</ul>

 