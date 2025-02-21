<?php
// PDO DB
include_once "Pdo.php";

class Functions
{

  private $con;
  private string $response;

  public function __construct($db)
  {
    $this->con = $db;
  }

  public function getAllDoctors()
  {
    $stmt = $this->con->prepare('SELECT * FROM staff_tbl WHERE user_type = "doctor" ORDER BY name ASC');
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function getAllSecretary()
  {
    $stmt = $this->con->prepare('SELECT * FROM staff_tbl WHERE user_type = "secretary" ORDER BY s_fname ASC');
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function getAllParent()
  {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl ORDER BY u_fname ASC');
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function getAllChild()
  {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl ORDER BY c_fname ASC');
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function getImmunizationCount($child_id)
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM immunization_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function childImmunization($child_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM immunization_tbl WHERE child_id = ? ORDER BY date ASC');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childFindings($child_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childWeight($child_id)
  {
    $stmt = $this->con->prepare('SELECT weight FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childHeight($child_id)
  {
    $stmt = $this->con->prepare('SELECT height FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childHead($child_id)
  {
    $stmt = $this->con->prepare('SELECT head_circumference FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childChest($child_id)
  {
    $stmt = $this->con->prepare('SELECT chest_circumference FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childImmunizationStatus($child_id)
  {
    $stmt = $this->con->prepare('SELECT immunization_status FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childDevelopmentalMilestones($child_id)
  {
    $stmt = $this->con->prepare('SELECT developmental_milestones FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childPhysicalExam($child_id)
  {
    $stmt = $this->con->prepare('SELECT physical_exam FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childMedicalHistory($child_id)
  {
    $stmt = $this->con->prepare('SELECT medical_history FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childAssessmentRecommendations($child_id)
  {
    $stmt = $this->con->prepare('SELECT assessment_recommendations FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function staffInfo($staff_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM staff_tbl WHERE staff_id = ?');
    $stmt->execute([$staff_id]);

    return $stmt->fetch();
  }

  public function getUpcomingAppointment()
  {
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE status = "upcoming"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getAppointmentRequest()
  {
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE status = "pending"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getDoneAppointment()
  {
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE status = "Done"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getAppointmentFHistory($appointment_date, $child_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM checkup_findings_tbl WHERE checkup_date = ? AND child_id = ?');
    $stmt->execute([$appointment_date, $child_id]);

    return $stmt->fetchALL();
  }

  public function getAppointmentVHistory($appointment_date, $child_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM immunization_tbl WHERE date = ? AND child_id = ?');
    $stmt->execute([$appointment_date, $child_id]);

    return $stmt->fetchALL();
  }

  public function getFromChild($parent_id)
  {
    $stmt = $this->con->prepare('SELECT child_id FROM child_tbl WHERE parent_id = ?');
    $stmt->execute([$parent_id]);

    return $stmt->fetchALL();
  }

  public function getChildName($child_id)
  {
    $stmt = $this->con->prepare('SELECT c_fname FROM child_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetch();
  }

  public function getFindings($checkup_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM checkup_findings_tbl WHERE checkup_id = ?');
    $stmt->execute([$checkup_id]);

    return $stmt->fetch();
  }

  public function getImmunization($immunization_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM immunization_tbl WHERE immunization_id = ?');
    $stmt->execute([$immunization_id]);

    return $stmt->fetch();
  }

  public function checkallContact($contact_no)
  {
    $stmt = $this->con->prepare('
        SELECT contact_no FROM user_tbl WHERE contact_no = ?
        UNION
        SELECT contact_no FROM staff_tbl WHERE contact_no = ?
    ');

    // Bind the contact_no parameter twice (for both queries)
    $stmt->execute([$contact_no, $contact_no]);

    return $stmt->fetchAll();  // Return the results
  }

  public function checkallEmail($email)
  {
    $stmt = $this->con->prepare('
        SELECT email FROM user_tbl WHERE email = ?
        UNION
        SELECT email FROM staff_tbl WHERE email = ?
    ');

    // Bind the email parameter twice (for both queries)
    $stmt->execute([$email, $email]);

    return $stmt->fetchAll();  // Return the results
  }


  public function checkpEmail($email)
  {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE email = ?');
    $stmt->execute([$email]);

    return $stmt->fetchAll();
  }

  public function checkpContact($contact_no)
  {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE contact_no = ?');
    $stmt->execute([$contact_no]);

    return $stmt->fetchAll();
  }

  public function checkParentDetails($email, $contact_no)
  {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE email = ? OR contact_no = ?');
    $stmt->execute([$email, $contact_no]);

    return $stmt->fetchAll();
  }

  public function checkChildDetails($c_fname, $c_m_name, $c_lname, $f_fname, $f_m_name, $f_lname, $m_fname, $m_m_name, $m_lname)
  {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl WHERE c_fname = ? AND c_m_name = ? AND c_lname = ? AND f_fname = ? AND f_m_name = ? AND f_lname = ? AND m_fname = ? AND m_m_name = ? AND m_lname = ?');
    $stmt->execute([$c_fname, $c_m_name, $c_lname, $f_fname, $f_m_name, $f_lname, $m_fname, $m_m_name, $m_lname]);

    return $stmt->fetchAll();
  }

  public function checkChildDetails2($c_fname, $f_fname, $m_fname)
  {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl WHERE c_fname = ? AND f_fname = ? AND m_fname = ?');
    $stmt->execute([$c_fname, $f_fname, $m_fname]);

    return $stmt->fetchAll();
  }

  public function checkVaccine($vaccine_name)
  {
    $stmt = $this->con->prepare('SELECT * FROM vaccine_tbl WHERE vaccine_name = ?');
    $stmt->execute([$vaccine_name]);

    return $stmt->fetchAll();
  }

  public function checkBreak($break_date, $reason)
  {
    $stmt = $this->con->prepare('SELECT * FROM break_tbl WHERE break_date = ? AND reason = ?');
    $stmt->execute([$break_date, $reason]);

    return $stmt->fetchAll();
  }

  public function checkSecretaryDetails($email, $contact_no)
  {
    $stmt = $this->con->prepare('SELECT * FROM staff_tbl WHERE email = ? OR contact_no = ?');
    $stmt->execute([$email, $contact_no]);

    return $stmt->fetchAll();
  }

  public function getAllParents()
  {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_type = "user" ORDER BY u_fname ASC');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getAllDoctor()
  {
    $stmt = $this->con->prepare('SELECT * FROM staff_tbl WHERE user_type = "doctor"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getAvailableVaccine()
  {
    $stmt = $this->con->prepare('SELECT * FROM vaccine_tbl WHERE quantity >= 1');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getAllVaccine()
  {
    $stmt = $this->con->prepare('SELECT * FROM vaccine_tbl');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getAllBreak()
  {
    $stmt = $this->con->prepare('SELECT * FROM break_tbl ORDER BY break_date ASC');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getParents($offset = 0, $limit = 6)
  {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_type = "user" LIMIT :offset, :limit');
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getPaginatedAppointmentHistory($pdo, $parent_id, $page, $limit = 8)
  {
    // Calculate the starting point for the LIMIT clause
    $start = ($page - 1) * $limit;

    // Get the total number of appointment histories
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointment_tbl WHERE parent_id = :parent_id");
    $stmt->execute(['parent_id' => $parent_id]);
    $total_results = $stmt->fetchColumn();
    $total_pages = ceil($total_results / $limit);

    // Fetch the current page's appointment history
    $stmt = $pdo->prepare("SELECT * FROM appointment_tbl WHERE parent_id = :parent_id LIMIT :start, :limit");
    $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      'history' => $history,
      'total_pages' => $total_pages
    ];
  }

  // public function getPaginatedTodayAppointment($pdo, $page, $limit = 8)
  // {
  //   // Calculate the starting point for the LIMIT clause
  //   $start = ($page - 1) * $limit;

  //   // Get the total number of appointment histories
  //   $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointment_tbl WHERE DATE(appointment_date) = CURDATE() AND status = 'upcoming'");
  //   $stmt->execute();
  //   $total_results = $stmt->fetchColumn();
  //   $total_pages = ceil($total_results / $limit);

  //   // Fetch the current page's appointment history
  //   $stmt = $pdo->prepare("SELECT * FROM appointment_tbl WHERE DATE(appointment_date) = CURDATE() AND status = 'upcoming' LIMIT :start, :limit");
  //   $stmt->bindParam(':start', $start, PDO::PARAM_INT);
  //   $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
  //   $stmt->execute();
  //   $today = $stmt->fetchAll(PDO::FETCH_ASSOC);

  //   return [
  //     'today' => $today,
  //     'total_pages' => $total_pages
  //   ];
  // }

  public function getChat($unique_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM messages WHERE incoming_msg_id = ? AND status = "not seen"');
    $stmt->execute([$unique_id]);

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetch();
  }

  public function getChatCount($unique_id)
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM messages WHERE incoming_msg_id = ? AND status = "not seen"');
    $stmt->execute([$unique_id]);

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getTodayUpcoming()
  {
    // Prepare the SQL statement to count appointments for the current day
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM appointment_tbl WHERE DATE(appointment_date) = CURDATE() AND status = "Upcoming"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getDoctor($offset = 0, $limit = 6)
  {
    $stmt = $this->con->prepare('SELECT * FROM staff_tbl WHERE user_type = "doctor" LIMIT :offset, :limit');
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getChild($offset = 0, $limit = 6)
  {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl LIMIT :offset, :limit');
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function searchParents($search_query)
  {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_type = "user" AND (name LIKE :name_query OR email LIKE :email_query)');
    $search_value = '%' . $search_query . '%';
    $stmt->bindValue(':name_query', $search_value);
    $stmt->bindValue(':email_query', $search_value);
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function searchParents2($searchTerm)
  {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_type = "user" AND u_fname LIKE :search');

    $stmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function searchChild($search_query)
  {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl WHERE (child_name LIKE :name_query)');
    $search_value = '%' . $search_query . '%';
    $stmt->bindValue(':name_query', $search_value);
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function searchDoctor($search_query)
  {
    $stmt = $this->con->prepare('SELECT * FROM staff_tbl WHERE (name LIKE :name_query OR email LIKE :email_query) AND user_type = "doctor"');
    $search_value = '%' . $search_query . '%';
    $stmt->bindValue(':name_query', $search_value);
    $stmt->bindValue(':email_query', $search_value);
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getRequestCount()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM appointment_tbl WHERE status = "pending"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getRequestCount2()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM appointment_tbl WHERE status = "pending"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getUpcomingCount()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM appointment_tbl WHERE status = "upcoming"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getUpcomingCount2()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM appointment_tbl WHERE status = "upcoming"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getChildCount()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) AS total FROM child_tbl');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($result['total']) ? (int) $result['total'] : 0;
  }

  public function getParentCount()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) AS total FROM user_tbl WHERE user_type = "user"');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($result['total']) ? (int) $result['total'] : 0;
  }

  public function getDoctorCount()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) AS total FROM staff_tbl WHERE user_type = "doctor"');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($result['total']) ? (int) $result['total'] : 0;
  }

  public function getCountParent()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM user_tbl WHERE user_type = "user"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getCountSecretary()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM staff_tbl WHERE user_type = "secretary"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getCountAdmin()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM staff_tbl WHERE user_type = "doctor"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getCountChild()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM child_tbl');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function getPendingParentCount()
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM user_tbl WHERE user_type = "user" AND status = "not-verified"');
    $stmt->execute();

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function responseSQL($stmt)
  {
    if ($stmt->rowCount()) {
      $this->response = 'success';
    }
    $this->response = 'failed';
  }

  public function getThisUpcomingAppointment($upcoming_appointment_id)
  {
    if (!$upcoming_appointment_id)
      return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE appointment_id = ?');
    $stmt->execute([$upcoming_appointment_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getThisRequestAppointment($appointment_req_id)
  {
    if (!$appointment_req_id)
      return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE appointment_id = ?');
    $stmt->execute([$appointment_req_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getThisDoneAppointment($done_appointment_id)
  {
    if (!$done_appointment_id)
      return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE appointment_id = ?');
    $stmt->execute([$done_appointment_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function showAppointmentHistory($parent_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE parent_id = ? AND status IN ("Done", "Cancelled", "Rejected")');
    $stmt->execute([$parent_id]);

    return $stmt->fetchAll();
  }

  public function getThisParent($parent_id)
  {
    if (!$parent_id)
      return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_id = ?');
    $stmt->execute([$parent_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getThisChild($child_id)
  {
    if (!$child_id)
      return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM child_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getThisDoctorAdmin($doctor_id)
  {
    if (!$doctor_id)
      return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM staff_tbl WHERE staff_id = ?');
    $stmt->execute([$doctor_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getThisSecretary($secretary_id)
  {
    if (!$secretary_id)
      return 0;
    // Query here
    $stmt = $this->con->prepare('SELECT * FROM staff_tbl WHERE staff_id = ?');
    $stmt->execute([$secretary_id]);
    return $stmt->rowCount() ? $stmt->fetch() : 0;
    // return appointment
  }

  public function getResponse()
  {
    return $this->response;
  }

}

$functions = new Functions($db);

?>