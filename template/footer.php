<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <?php
    sleep(1);
    $time = number_format(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"],2);    
    ?>
    Process Time : <b><?php echo $time; ?> s</b>
  </div>
  <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
  reserved.
</footer>