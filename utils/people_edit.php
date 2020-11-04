<?php 
    if ($_POST['first_name'] != "" && $_POST['last_name'] != "") { // Check if First and Last names have been entered
        $sql = 'SELECT * FROM people WHERE first_name = "' . $_POST['first_name'] . '" AND last_name = "' . $_POST['last_name'] . '";'; // Check if duplicate entries does not already exist
        $result = $conn->query($sql);
        var_dump(mysqli_num_rows($result));

        // ADD NEW PERSON TO TABLE
        if (mysqli_num_rows($result) == 0 && $_GET['action'] == 'add') {
            // People table update
            $sql = 'INSERT INTO people (first_name, last_name) VALUES ("' . $_POST['first_name'] . '", "' . $_POST['last_name'] . '");';
            $conn->query($sql);
            unset($_POST['first_name']);
            unset($_POST['last_name']);

            // Projects_People table update
            $sql = 'SET SESSION information_schema_stats_expiry=0;';
            $conn->query($sql);
            $sql = 'SHOW TABLE STATUS LIKE "people";';
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $next_id = $row['Auto_increment'] - 1;
            $sql = 'INSERT INTO projects_people VALUES (' . $_POST['project_id'] . ', ' . $next_id . ');';
            $conn->query($sql);

            header('location:./?path=' . $_GET['path']);
            exit;
        } // UPDATE EXISTING PERSON
        elseif ( $_GET['action'] == 'update') {
            // People table update
            $sql = 'UPDATE people SET first_name = "' . $_POST['first_name'] . '", last_name = "' . $_POST['last_name'] . '" WHERE id = '. $_GET['id'] . ';';
            print $sql;
            $conn->query($sql);
            unset($_POST['first_name']);
            unset($_POST['last_name']);

            // Projects_People table update
            $sql = 'DELETE FROM projects_people WHERE pers_id = ' . $_GET['id'] . ';';
            $conn->query($sql);
            $sql = 'INSERT INTO projects_people VALUES (' . $_POST['project_id'] . ', ' . $_GET['id'] . ');';
            $conn->query($sql);
            
            unset($_POST['project_name']);

            header('location:./?path=' . $_GET['path']);
            exit;
        }
    }
?>