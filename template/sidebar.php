<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $nama_user; ?></p>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">NAVIGASI UTAMA</li>
      <?php
      $sql =
      "SELECT
        a.kode,
        a.grup
      FROM
        tb_master_navigasi AS a";
      $sql .= " GROUP BY a.kode";
      $res = mysqli_query($db,$sql) OR die('error 29');
      if(mysqli_num_rows($res) != 0)
      {
        while($row = mysqli_fetch_assoc($res))
        {
          $kode = $row['kode'];
          $grup = $row['grup'];
        ?>
      <li class="<?php if (isset($_GET['k']) AND $_GET['k'] == $kode) {echo 'nav-expanded nav-active';}?>">
        <a href="navigasi.php?kode=<?php echo $kode; ?>">
          <i class="fa fa-th"></i> <span><?php echo ucwords(strtolower($grup)); ?></span>
        </a>
      </li>
      <?php
        }
      }
      ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>