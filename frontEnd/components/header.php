<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title><?=$title?> | Serprosep</title>

    
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="<?=$root?>css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="<?=$root?>css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?=$root?>css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?=$root?>css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="<?=$root?>css/app-dark.css" id="darkTheme" disabled>

    <?php if(isset($links)):?>
          <?php foreach($links as $link): ?>
              <link rel="stylesheet" href="<?=$root?><?= $link;?>">
          <?php endforeach;?>
      <?php endif;?>

  </head>
  <body class="vertical  light  ">
   