<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Upcoming Movies</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/upcoming.css" type="text/css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

    <body>
    <div class="container">    
        <div class="jumbotron text-center">
            <h1><a href="/">Upcoming Movies</a></h1>
        </div>
        <div class="content">
            <?php if (isset($months)): ?>
            <div class="month_list text-center">
                <?php foreach ($months as $month): ?>
                <a href="/month/<?= $month->text_month ?>" class="btn btn-primary btn-lg <?php if ($filter_month == $month->numeric_month): ?>active<?php endif; ?>" role="button"><?= $month->text_month ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif;?>
            <div class="movie_list">