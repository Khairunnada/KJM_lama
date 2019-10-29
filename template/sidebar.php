<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header" style="color:white !important;">NAVIGASI UTAMA</li>
      <li>
        <a href="dashboard.php">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
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