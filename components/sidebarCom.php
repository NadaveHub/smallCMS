<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary sticky">
  <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu">
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto" style="height: calc(100vh - 48px);">

      <ul class="nav flex-column mb-auto">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'dashboard' ? 'active' : '' ?>" href="index.php?page=dashboard">
            <i class="bi bi-house-door"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'accounts' ? 'active' : '' ?>" href="index.php?page=accounts">
            <i class="bi bi-people"></i> Accounts
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'bans' ? 'active' : '' ?>" href="index.php?page=bans">
            <i class="bi bi-slash-circle"></i> Bans
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'content' ? 'active' : '' ?>" href="index.php?page=content">
            <i class="bi bi-file-earmark-text"></i> Content
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'db_settings' ? 'active' : '' ?>" href="index.php?page=db_settings">
            <i class="bi bi-gear"></i> DB Settings
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 <?= $page === 'other_settings' ? 'active' : '' ?>" href="index.php?page=other_settings">
            <i class="bi bi-gear"></i> other Settings
          </a>
        </li>
      </ul>

      <hr class="my-3" />

      <ul class="nav flex-column mb-3">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2 text-warning" href="/composables/logoutMain.php">
            <i class="bi bi-door-closed"></i> Go to main Page
          </a>
        </li>
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