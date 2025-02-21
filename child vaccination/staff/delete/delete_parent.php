<?php

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $parent_id = $_GET["parent_id"];

    $stmt = $pdo->prepare("SELECT * FROM child_tbl WHERE parent_id = $parent_id");
    $stmt->execute();
    $child = $stmt->fetchAll(PDO::FETCH_ASSOC);

    try {

        if (!empty($child)) {
            foreach ($child as $children) {
                $child_id = $children['child_id'];

                $stmt = $pdo->prepare("DELETE FROM immunization_tbl WHERE child_id = :child_id");
                $stmt->bindParam(':child_id', $child_id);
                $stmt->execute();

                $stmt = $pdo->prepare("DELETE FROM checkup_findings_tbl WHERE child_id = :child_id");
                $stmt->bindParam(':child_id', $child_id);
                $stmt->execute();

                $stmt = $pdo->prepare("DELETE FROM child_tbl WHERE child_id = :child_id");
                $stmt->bindParam(':child_id', $child_id);
                $stmt->execute();
            }
        }

        $stmt = $pdo->prepare("DELETE FROM appointment_tbl WHERE parent_id = :parent_id");
        $stmt->bindParam(':parent_id', $parent_id);
        $stmt->execute();

        // Now delete parent
        $stmt = $pdo->prepare("DELETE FROM user_tbl WHERE user_id = :parent_id");
        $stmt->bindParam(':parent_id', $parent_id);
        $stmt->execute();

        header("Location: ../list_parent_table.php?form_status=deleted_successfully");
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        // header("Location: ../list_parent.php?status=error");
        echo "Database error: " . $e->getMessage();
        exit();
    }
}


?>