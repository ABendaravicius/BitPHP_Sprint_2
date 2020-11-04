<?php
    include 'utils/people_edit.php'
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Project</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php // READ PEOPLE TABLE IN DATABASE
            $sql = 'SELECT people.id, concat(first_name," ", last_name) as full_name, project_name
                    FROM people
                    LEFT JOIN projects_people
                    ON people.id = projects_people.pers_id
                    LEFT JOIN projects
                    ON projects_people.prj_id = projects.id
                    ORDER BY people.id;';
            $result = $conn->query($sql);

            if (mysqli_num_rows($result) > 0) { // Forming table with read data
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    for ($i = 0; $i < count($row); $i++) {
                        echo '<td>';
                        echo $row[array_keys($row)[$i]];
                        echo '</td>';
                    }
                    // Adding action buttons to each table entry
                    echo '<td><button><a href="?path=people&action=update&id=' . $row['id'] . '">Update</a></button>'; // Update button
                    echo '<button><a href="?path=people&action=delete&id=' . $row['id'] . '">Delete</a></button></td>'; // Delete button
                    echo '</tr>';
                }
            }
            echo '<tr><td></td><td><button><a href="?path=people&action=add" class="add-btn">+</a></button></td></tr>'; // Inserting add button at the last table row
        ?>
    </tbody>
</table>

<?php // ADD NEW PERSON FORM
    if ($_GET['action'] == 'add') {
        echo '<form method="POST">
            <h3>Add new person</h3>
            <label for="first_name">First name:</label>
            <input type="text" name="first_name" id="first_name">
            <label for="last_name">Last name:</label>
            <input type="text" name="last_name" id="last_name">
            <label for="project">Asigned project:</label>
            <select name="project_id" id="project">
                <option value="0">None</option>';
        $sql = 'SELECT DISTINCT projects.id, project_name FROM projects;';
        $conn->query($sql);
        $result = $conn->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()){
                echo '<option value=' . $row['id'] . '>' . $row['project_name'] . '</option>';
            }
        }
                
        echo '  </select>
            <button type="submit">Add</button>
        </form>';
    } // UPDATE EXISTING PERSON FORM
    elseif ($_GET['action'] == 'update') {
        
        $sql = 'SELECT first_name, last_name FROM people WHERE id = ' . $_GET['id'];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $_POST['first_name'] = $row['first_name'];
        $_POST['last_name'] = $row['last_name'];

        echo '<form method="POST">
                <h3>Update person</h3>
                <label for="first_name">First name:</label>
                <input type="text" name="first_name" id="first_name" value="' . $row['first_name'] . '">
                <label for="last_name">Last name:</label>
                <input type="text" name="last_name" id="last_name" value="' . $row['last_name'] . '">
                <label for="project">Asigned project:</label>
                <select name="project_id" id="project">
                    <option value="0">None</option>';
        $sql = 'SELECT DISTINCT projects.id, project_name FROM projects;';
        $conn->query($sql);
        $result = $conn->query($sql);

        $sql = 'SELECT DISTINCT id, project_name FROM projects LEFT JOIN projects_people ON id = prj_id WHERE pers_id = ' . $_GET['id'] . ';';
        $result_p = $conn->query($sql);
        $asigned_project = $result_p->fetch_assoc();

        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()){
                if ($row['project_name'] == $asigned_project['project_name']) {
                    echo '<option value=' . $row['id'] . ' selected>' . $row['project_name'] . '</option>';
                    $_POST['asigned_project_id'] = $asigned_project['id'];
                } else {
                    echo '<option value=' . $row['id'] . '>' . $row['project_name'] . '</option>';
                }
            }
        }
                
        echo '  </select>   
                <button type="submit">Update</button>
            </form>';
    }
?>