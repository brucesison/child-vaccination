<?php
$my_unseenchat = $functions->getChat($unique_id);
$unseen_chat = $functions->getChatCount($unique_id);
$request2 = $functions->getRequestCount($parent_id);
$app_request = $functions->showRequestApp($parent_id);

if (empty($app_request)) {
  $badge = 'd-none';
}

if (empty($my_unseenchat)) {
  $unseen_badge = 'd-none';
}

?>

<!-- Sidebar -->
<ul class="navbar-nav bg-main sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img class="rounded-circle logo-dashboard" src="./img/Clinic logo.png" alt="...">
    </div>
    <!-- <div class="sidebar-brand-text mx-3">Parent</div> -->
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item <?php echo $active; ?>">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-home"></i>
      <span>Home</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Nav Item - Appointments -->
  <li class="nav-item <?php echo $appointment_menu; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
      aria-controls="collapseTwo">
      <i class="fas fa-fw fa-calendar"></i>
      <span>Appointment</span>
      <span class="badge badge-danger badge-counter <?php echo $badge; ?>">!</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-light py-2 collapse-inner rounded">
        <!-- <a class="collapse-item text-dark border-bottom" href="app_upcoming.php">Upcoming</a> -->
        <a class="collapse-item text-dark border-bottom" href="app_request.php">Request
          <span class="badge badge-danger badge-counter <?php echo $badge; ?>">
            <?php foreach ($request2 as $count) {
              foreach ($count as $key => $val)
                echo $val;
            } ?>
          </span>
        </a>
        <a class="collapse-item text-dark border-bottom" href="app_history.php">History</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - calendar -->
  <li class="nav-item <?php echo $calendar_active; ?>">
    <a class="nav-link" href="calendar.php">
      <i class="fas fa-fw fa-calendar"></i>
      <span>Calendar</span></a>
  </li>

  <!-- Nav Item - Child Records -->
  <li class="nav-item <?php echo $my_child; ?>">
    <a class="nav-link" href="my_child.php">
      <i class="fas fa-fw fa-child"></i>
      <span>My Child</span></a>
  </li>

  <!-- Nav Item - Message -->
  <li class="nav-item <?php echo $chat; ?>">
    <a class="nav-link" href="chats.php">
      <i class="fas fa-fw fa-comment"></i>
      <span>Chats</span>
      <span class="badge badge-danger badge-counter <?php echo $unseen_badge; ?>">
        <?php foreach ($unseen_chat as $count) {
          foreach ($count as $key => $val)
            echo $val;
        } ?>
      </span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->