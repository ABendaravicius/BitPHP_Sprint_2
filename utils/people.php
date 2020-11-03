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
                    ON projects_people.prj_id = projects.id;';
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
            <button type="submit">Update</button>
        </form>';
    }
?>