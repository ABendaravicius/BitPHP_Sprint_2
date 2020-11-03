<?php 
    if ($_POST['first_name'] != "" && $_POST['last_name'] != "") { // Check if First and Last names have been entered
        $sql = 'SELECT * FROM people WHERE first_name = "' . $_POST['first_name'] . '" AND last_name = "' . $_POST['last_name'] . '";'; // Check if duplicate entries does not already exist
        $result = $conn->query($sql);
        var_dump(mysqli_num_rows($result));

        // ADD NEW PERSON TO TABLE
        if (mysqli_num_rows($result) == 0 && $_GET['action'] == 'add') {
            $sql = 'INSERT INTO people (first_name, last_name) VALUES ("' . $_POST['first_name'] . '", "' . $_POST['last_name'] . '");';
            $conn->query($sql);
            unset($_POST['first_name']);
            unset($_POST['last_name']);
            header('location:./?path=' . $_GET['path']);
            exit;
        } // UPDATE EXISTING PERSON
        elseif ( $_GET['action'] == 'update') {
            echo 'works';
            $sql = 'UPDATE people SET first_name = "' . $_POST['first_name'] . '", last_name = "' . $_POST['last_name'] . '" WHERE id = '. $_GET['id'] . ';';
            print $sql;
            $conn->query($sql);
            unset($_POST['first_name']);
            unset($_POST['last_name']);
            header('location:./?path=' . $_GET['path']);
            exit;
        }
    }
?>