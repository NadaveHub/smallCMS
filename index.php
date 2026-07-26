<?php
include "lib/lib.php";
session_start();
val();



$page = $_GET['page'] ?? 'dashboard';
$page = basename($page);
?>

<?php include 'components/headerCom.php'; ?>

<div class="container-fluid">
  <div class="row">

    <?php include 'components/sidebarCom.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
      <?php
      $pagePath = "subpages/{$page}Page.php";

      if (file_exists($pagePath)) {
        include $pagePath;
      } else {
        echo "<h2>404 - Component Not Found</h2><p>Create a file at subpages/{$page}Page.php</p>";
      }
      ?>
    </main>

  </div>
</div>

<?php include 'components/footerCom.php'; ?>