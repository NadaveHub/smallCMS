<?php
include "lib/lib.php";
session_start();
val();

$page = $_GET['page'] ?? 'dashboard';
$page = basename($page);

include 'components/headerCom.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

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
</body>

</html>