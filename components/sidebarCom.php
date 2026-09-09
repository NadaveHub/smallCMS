<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary sticky">
  <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu">
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto" style="height: calc(100vh - 48px);">

      <ul class="nav flex-column mb-auto">
        <?php $userId = $_SESSION['activeUser'];

         if (checkRole($db, $userId, "dash")) { ?>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'dashboard' ? 'active' : '' ?>" href="index.php?page=dashboard">
              <i class="bi bi-house-door"></i> Dashboard
            </a>
          </li>
        <?php } ?>

        <?php if (checkRole($db, $userId, "acco")) { ?>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'accounts' ? 'active' : '' ?>" href="index.php?page=accounts">
              <i class="bi bi-people"></i> Accounts
            </a>
          </li>
        <?php } ?>

        <?php if (checkRole($db, $userId, "admi")) { ?>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'adminAccounts' ? 'active' : '' ?>" href="index.php?page=adminAccounts">
              <i class="bi bi-people"></i> Admin Accounts
            </a>
          </li>
        <?php } ?>

        <?php /*if (checkRole($db, $userId, "bans")) { ?>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'bans' ? 'active' : '' ?>" href="index.php?page=bans">
              <i class="bi bi-slash-circle"></i> Bans
            </a>
          </li>
        <?php } */?>

        <?php if (checkRole($db, $userId, "addC")) { ?>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'addContent' ? 'active' : '' ?>" href="index.php?page=addContent">
              <i class="bi bi-file-earmark-text"></i> Add Content
            </a>
          </li>
        <?php } ?>

        <?php if (checkRole($db, $userId, "ediC")) { ?>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'editContent' ? 'active' : '' ?>" href="index.php?page=editContent">
              <i class="bi bi-file-earmark-text"></i> Edit Content
            </a>
          </li>
        <?php } ?>

        <?php if (checkRole($db, $userId, "otSe")) { ?>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'otherSettings' ? 'active' : '' ?>" href="index.php?page=otherSettings">
              <i class="bi bi-gear"></i> Other Settings
            </a>
          </li>
        <?php } ?>
      </ul>

      <hr class="my-3" />

      <ul class="nav flex-column mb-3">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 text-danger" href="/composables/logout.php">
            <i class="bi bi-door-closed"></i> Sign out
          </a>
        </li>
      </ul>

    </div>
  </div>
</div>

<style>
  .sticky {
    position: sticky;
    top: 90px;
  }
</style>