<?php
    include 'utils/projects_edit.php'
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Project</th>
            <th>People Involved</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php // READ PEOPLE TABLE IN DATABASE
            $sql = 'SELECT projects.id, project_name, group_concat(concat(first_name, " ", last_name) SEPARATOR "<br>")
                    FROM projects
                    LEFT JOIN projects_people
                    ON projects.id = prj_id
                    LEFT JOIN people
                    ON pers_id = people.id
                    GROUP BY projects.id;';
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
                    echo '<td><button><a href="?path=projects&action=update&id=' . $row['id'] . '">Update</a></button>'; // Update button
                    echo '<button><a href="?path=projects&action=delete&id=' . $row['id'] . '">Delete</a></button></td>'; // Delete button
                    echo '</tr>';
                }
            }
            echo '<tr><td></td><td><button><a href="?path=projects&action=add" class="add-btn">+</a></button></td></tr>'; // Inserting add button at the last table row
        ?>
    </tbody>
</table>

<?php // ADD NEW PERSON FORM
    if ($_GET['action'] == 'add') {
        echo '<form method="POST">
            <h3>Add new project</h3>
            <label for="project_name">Project name:</label>
            <input type="text" name="project_name" id="project_name">
            <button type="submit">Add</button>
        </form>';
    } // UPDATE EXISTING PERSON FORM
    elseif ($_GET['action'] == 'update') {
        
        $sql = 'SELECT project_name FROM projects WHERE id = ' . $_GET['id'];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $_POST['project_name'] = $row['project_name'];

        echo '<form method="POST">
            <h3>Update project</h3>
            <label for="project_name">Project name:</label>
            <input type="text" name="project_name" id="project_name" value="' . $row['project_name'] . '">
            <button type="submit">Update</button>
        </form>';
    }
?>