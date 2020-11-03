<?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $databasename = "projectsdb";
    
    $conn = mysqli_connect($servername, $username, $password); // Create connection
    $conn->select_db($databasename); // Selecting database if already exists

    if (!$conn) { // Connection status check
        die("Connection failed: " . mysqli_connect_error());
    }

    // Database setup 
    if ($conn->select_db($databasename) === false) { // Runs only if database has not been created yet
        $sql = 'CREATE SCHEMA IF NOT EXISTS projectsdb;'; 
        $conn->query($sql); // Creating database

        $conn->select_db($databasename); // Selecting database

        $sql = 'CREATE TABLE IF NOT EXISTS projects (
                id INT AUTO_INCREMENT PRIMARY KEY,
                project_name VARCHAR(30) NOT NULL);';
        $conn->query($sql); // Creating 'projects' table

        $sql = 'INSERT INTO projects (project_name)
                VALUES ("JAVA"), ("JavaScript"), ("Python"), ("PHP");';
        $conn->query($sql); // Adding example data to 'projects' table

        $sql = 'CREATE TABLE IF NOT EXISTS people (
                id INT auto_increment primary key,
                first_name VARCHAR(30) NOT NULL,
                last_name VARCHAR(30) NOT NULL);';
        $conn->query($sql); // Creating 'people' table

        $sql = 'INSERT INTO people (first_name, last_name)
                VALUES ("Tomas","Jonaitis"), ("Petras","Tomaitis"), ("Jonas","Petraitis"), ("Emilija","Onytė"), ("Ieva","Petraitytė");';
        $conn->query($sql); // Adding example data to 'people' table

        $sql = 'CREATE TABLE IF NOT EXISTS projects_people (
                prj_id INT,
                pers_id INT,
                FOREIGN KEY (prj_id) REFERENCES projects(id) ON UPDATE CASCADE ON DELETE CASCADE,
                FOREIGN KEY (pers_id) REFERENCES people(id) ON UPDATE CASCADE ON DELETE CASCADE);';
        $conn->query($sql); // Creating id reference table ('projects_people')

        $sql = 'INSERT INTO projects_people (prj_id, pers_id)
                VALUES (1,2), (1,4), (2,1), (2,5), (3,3);';
        $conn->query($sql); // Adding example data to id reference table ('projects_people')
    }
?>