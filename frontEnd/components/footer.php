 
 </div> <!-- .wrapper -->
    <script src="<?=$root?>js/jquery.min.js"></script>
    <script src="<?=$root?>js/popper.min.js"></script>
    <script src="<?=$root?>js/moment.min.js"></script>
    <script src="<?=$root?>js/bootstrap.min.js"></script>
    <script src="<?=$root?>js/simplebar.min.js"></script>
    <script src='<?=$root?>js/daterangepicker.js'></script>
    <script src='<?=$root?>js/jquery.stickOnScroll.js'></script>
    <script src="<?=$root?>js/tinycolor-min.js"></script>
    <script src="<?=$root?>js/config.js"></script>
    <script src="<?=$root?>js/apps.js"></script>
    <script src="<?=$root?>js/buscador.js"></script>
    <?php if( isset( $scripts ) ) : ?>
        <?php foreach( $scripts as $script ) : ?>
            <script src="<?=$script; ?>"></script>
        <?php endforeach;?>
    <?php endif;?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
  </body>
</html>