<?php
include "lib/lib.php";
include "composables/checkCalls.php";

session_start();
val();

$page = $_GET['page'] ?? 'dashboard';
$page = basename($page);

include 'components/headerCom.php'; 
?>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"></script>
<script src="dashboard.js"></script>
</body>
</html>