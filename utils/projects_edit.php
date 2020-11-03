<?php 
    if ($_POST['project_name'] != "") { // Check if Project name has been entered
        $sql = 'SELECT * FROM projects WHERE project_name = "' . $_POST['project_name'] . '";'; // Check if duplicate entry does not already exist
        $result = $conn->query($sql);

        // ADD NEW PROJECT TO TABLE
        if (mysqli_num_rows($result) == 0 && $_GET['action'] == 'add') {
            $sql = 'INSERT INTO projects (project_name) VALUES ("' . $_POST['project_name'] . '");';
            $conn->query($sql);
            unset($_POST['project_name']);
            header('location:./?path=' . $_GET['path']);
            exit;
        } // UPDATE EXISTING PROJECT
        else
        if ( $_GET['action'] == 'update') {
            $sql = 'UPDATE projects SET project_name = "' . $_POST['project_name'] . '" WHERE id = '. $_GET['id'] . ';';
            print $sql;
            $conn->query($sql);
            unset($_POST['project_name']);
            header('location:./?path=' . $_GET['path']);
            exit;
        }
    }
?>