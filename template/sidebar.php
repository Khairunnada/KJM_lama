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
        a.id,
        a.ikon,
        a.nama
      FROM
        tb_master_navigasi AS a
      JOIN
      (
        SELECT
          a.id_navigasi
        FROM
          tb_master_user_detail AS a
        WHERE
          a.id = '".$id_user."'
        GROUP BY a.id_navigasi
      ) ta
      ON ta.id_navigasi = a.id
      WHERE
        a.aktif = 1";
      $sql .= " ORDER BY a.posisi";
      $res = mysqli_query($db,$sql) OR die('error 34');
      if(mysqli_num_rows($res) != 0)
      {
        while($row = mysqli_fetch_assoc($res))
        {
        ?>
      <li>
        <a href="navigasi.php?id_nav=<?php echo $row['id']; ?>">
          <i class="fa <?php echo $row['ikon']; ?>"></i> <span><?php echo ucwords(strtolower($row['nama'])); ?></span>
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