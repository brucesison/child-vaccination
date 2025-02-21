<!-- Sidebar -->
<ul class="navbar-nav bg-main sidebar sidebar-dark accordion nonprint" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img class="rounded-circle logo-dashboard" src="./img/Clinic logo.png" alt="...">
    </div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item <?php echo $active; ?>">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <?php
  $my_unseenchat = $functions->getChat($unique_id);
  $unseen_chat = $functions->getChatCount($unique_id);
  // $request2 = $functions->getRequestCount2();
  $upcoming2 = $functions->getUpcomingCount2();
  // $app_req = $functions->getAppointmentRequest();
  $app_upcoming = $functions->getUpcomingAppointment();

  // if (empty($app_req) && empty($app_upcoming)) {
  //   $badge = 'd-none';
  // }
  if (empty($app_upcoming)) {
    $badge1 = 'd-none';
  }

  if (empty($my_unseenchat)) {
    $unseen_badge = 'd-none';
  }
  // if (empty($app_req)) {
  //   $badge2 = 'd-none';
  // }
  ?>

  <!-- Nav Item - message -->
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

  <!-- Nav Item - Appointments -->
  <li class="nav-item <?php echo $active_appointment; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
      aria-controls="collapseTwo">
      <i class="fas fa-fw fa-calendar"></i>
      <span>Appointment</span>
      <span id="rt-badge">

      </span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-light py-2 collapse-inner rounded">
        <a class="collapse-item text-dark border-bottom" href="app_upcoming.php">Upcoming
          <span class="badge badge-danger badge-counter <?php echo $badge1; ?>">
            <?php foreach ($upcoming2 as $count) {
              foreach ($count as $key => $val)
                echo $val;
            } ?>
          </span>
        </a>
        <a class="collapse-item text-dark border-bottom" href="app_request.php">Requests
          <span id="rt-count">

          </span>
        </a>
        <a class="collapse-item text-dark border-bottom" href="app_done.php">Done</a>
        <a class="collapse-item text-dark" href="app_break.php">Break</a>
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
  <li class="nav-item <?php echo $active_child_list; ?>">
    <a class="nav-link" href="list_child_table.php">
      <i class="fas fa-fw fa-child"></i>
      <span>Child List</span></a>
  </li>

  <!-- Nav Item - Parent List -->
  <li class="nav-item <?php echo $active_parent_list; ?>">
    <a class="nav-link" href="list_parent_table.php">
      <i class="fas fa-fw fa-user"></i>
      <span>Parent / Guardian List</span></a>
  </li>

  <!-- Nav Item - Doctor List -->
  <li class="nav-item 
    <?php echo $active_secretary_list; ?>
    <?php echo $admin_access; ?>">
    <a class="nav-link" href="list_secretary_table.php">
      <i class="fas fa-fw fa-user-nurse"></i>
      <span>Secretary List</span></a>
  </li>

  <!-- Nav Item - vaccine -->
  <li class="nav-item <?php echo $active_vaccine_list; ?>">
    <a class="nav-link" href="list_vaccine.php">
      <i class="fas fa-fw fa-syringe"></i>
      <span>Vaccine</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->