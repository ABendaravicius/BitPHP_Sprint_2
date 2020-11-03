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
        <?php
            $sql = 'SELECT people.id, concat(people.first_name," ", people.last_name), projects.project_name
                    FROM people
                    CROSS JOIN projects
                    LEFT JOIN projects_people
                    ON people.id = projects_people.pers_id AND projects.id = projects_people.prj_id
                    WHERE people.id = projects_people.pers_id
                    ORDER BY people.id;';
            $result = $conn->query($sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    for ($i = 0; $i < count($row); $i++) {
                        echo '<td>';
                        echo $row[array_keys($row)[$i]];
                        echo '</td>';
                    }
                    echo '<td><button><a href="?path=people&action=update&id=' . $row['id'] . '">Update</a></button><button><a href="?path=people&action=delete&id=' . $row['id'] . '">Delete</a></button></td>';
                    echo '</tr>';
                }
            }
            echo '<tr><td></td><td><button><a href="?path=people&action=add" class="add-btn">+</a></button></td></tr>';
        ?>
    </tbody>
</table>
<?php
    if ($_GET['action'] == 'add') {
        include 'utils/people_add.php';
    }
?>