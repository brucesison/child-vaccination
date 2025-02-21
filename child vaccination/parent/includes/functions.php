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

  public function getAllStaff()
  {
    $stmt = $this->con->prepare('SELECT * FROM staff_tbl');
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function childImmunization($child_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM immunization_tbl WHERE child_id = ? ORDER BY date DESC');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function childFindings($child_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM checkup_findings_tbl WHERE child_id = ?');
    $stmt->execute([$child_id]);

    return $stmt->fetchAll();
  }

  public function showMyChild($parent_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl WHERE parent_id = ?');
    $stmt->execute([$parent_id]);

    return $stmt->fetchAll();
  }

  public function showUpcomingApp($parent_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE parent_id = ? AND status = "Upcoming"');
    $stmt->execute([$parent_id]);

    return $stmt->fetch();
  }

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

  public function getRequestCount($parent_id)
  {
    $stmt = $this->con->prepare('SELECT COUNT(*) FROM appointment_tbl WHERE parent_id = ? AND status = "pending"');
    $stmt->execute([$parent_id]);

    if (!$stmt->rowCount()) {
      return [];
    }
    return $stmt->fetchAll();
  }

  public function showRequestApp($parent_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE parent_id = ? AND status = "pending"');
    $stmt->execute([$parent_id]);

    return $stmt->fetch();
  }

  public function showAppointmentHistory($parent_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE parent_id = ? AND status IN ("done", "cancelled", "rejected")');
    $stmt->execute([$parent_id]);

    return $stmt->fetchAll();
  }

  public function getAppointmentHistory($appointment_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM appointment_tbl WHERE appointment_id = ?');
    $stmt->execute([$appointment_id]);

    return $stmt->fetch();
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

  public function parentInfo($parent_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE user_id = ?');
    $stmt->execute([$parent_id]);

    return $stmt->fetch();
  }

  public function getChild($child_id)
  {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl WHERE child_id = ?');
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

  public function checkParentDetails($email, $contact_no)
  {
    $stmt = $this->con->prepare('SELECT * FROM user_tbl WHERE email = ? OR contact_no = ?');
    $stmt->execute([$email, $contact_no]);

    return $stmt->fetchAll();
  }

  public function checkChildDetails($c_fname, $c_m_initial, $c_lname, $f_fname, $f_m_initial, $f_lname, $m_fname, $m_m_initial, $m_lname)
  {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl WHERE c_fname = ? AND c_m_initial = ? AND c_lname = ? AND f_fname = ? AND f_m_initial = ? AND f_lname = ? AND m_fname = ? AND m_m_initial = ? AND m_lname = ?');
    $stmt->execute([$c_fname, $c_m_initial, $c_lname, $f_fname, $f_m_initial, $f_lname, $m_fname, $m_m_initial, $m_lname]);

    return $stmt->fetchAll();
  }

  public function checkChildDetails2($c_fname, $f_fname, $m_fname)
  {
    $stmt = $this->con->prepare('SELECT * FROM child_tbl WHERE c_fname = ? AND f_fname = ? AND m_fname = ?');
    $stmt->execute([$c_fname, $f_fname, $m_fname]);

    return $stmt->fetchAll();
  }

  public function getResponse()
  {
    return $this->response;
  }

}

$functions = new Functions($db);

?>