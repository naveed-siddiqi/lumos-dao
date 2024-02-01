<?php
        //to config db
        $dbhostcompany = "localhost";
        $dbusername = $DATABASE_USERNAME;
        $dbpassword = $DATABASE_PASSWORD;
        $db = $DATABASE_NAME;
        // host, user, password, database
        $conn = mysqli_connect($dbhostcompany,$dbusername,$dbpassword,$db);
        
?>