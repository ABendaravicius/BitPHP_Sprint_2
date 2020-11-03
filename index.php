<?php
    include_once 'utils/db.php'; // Database connection and setup

    // Table entry delete action (works for both: people and projects)
    if ($_GET['action'] == 'delete') {
        $sql = 'DELETE FROM ' . $_GET['path'] . ' WHERE id = ' . $_GET['id'];
        $conn->query($sql);
        header('location:./?path=' . $_GET['path']);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Sprint_2</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a href="./?path=projects">Projects</a><br>
    <a href="./?path=people">People</a>

    <?php
        $path = $_GET['path'] ?? 'people';
        if ($path == 'people') {
            include 'utils/people.php'; // Loads people data
        } else if ($path == 'projects') {
            include 'utils/projects.php'; // Loads projects data
        }
    ?>
</body>
</html>