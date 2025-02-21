<?php
// Include the functions file
require_once "includes/functions.php";

// Check if the search term is provided
if (isset($_GET['search'])) {
    // Sanitize the search term
    $searchTerm = htmlspecialchars($_GET['search']);

    // Call the function to search for parents
    $parents = $functions->searchParents2($searchTerm);

    // Return the results in JSON format
    ob_clean(); // This clears any previous output that might have been sent accidentally
    header('Content-Type: application/json');
    echo json_encode($parents);
}
?>