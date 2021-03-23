<?php
/*
 * Desc:    This file is used by adminDash.js and adminDash.php to dynamically send
 *          updates to vehicle status and receive update user and ticket tables for
 *          for the adminDash page.
 * Date:    3/1/21
 * File:    adminDash.php
 * Auth:    Ryan Rivera & Husrav Khomidov
 */

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Connect to Server
require($_SERVER['DOCUMENT_ROOT'].'/../config.php');

    //If Post data contains vehicleID and status perform the following database query to update
    //the vehicle status in the database
    if(isset($_POST['vehicleID']) && isset($_POST['status'])){
        //Create a query for the database table
        $sql = "UPDATE vehicle SET status = :status WHERE vehicleID = :vehicleID";

        //Prepare the statement
        $statement = $dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':vehicleID', $_POST['vehicleID'], PDO::PARAM_INT);
        $statement->bindParam(':status', $_POST['status'], PDO::PARAM_STR);

        //Process the results
        $statement->execute();
    }

    //If Post data contains updateUserTable perform the following database query to get a user's
    //vehicles to populate the user table
    if(isset($_POST['updateUserTable'])){
        //Create a query for the database table
        $sql = "SELECT accountID, vehicleID, firstname, lastname, year, make, model, mileage, maintenance, status FROM account NATURAL JOIN vehicle WHERE accountID = :accountID";

        //Prepare the statement
        $statement = $dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':accountID', $_POST['updateUserTable'], PDO::PARAM_INT);

        //Process the results
        $statement->execute();

        //Return the results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        //Return an updated table
        echo "<thead>";
        echo "<tr>";
        echo "<th scope=\"col\">Year</th>";
        echo "<th scope=\"col\">Make</th>";
        echo "<th scope=\"col\">Model</th>";
        echo "<th scope=\"col\">Miles</th>";
        echo "<th scope=\"col\">Service</th>";
        echo "<th scope=\"col\">Current Status</th>";
        echo "<th scope=\"col\">Options</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        foreach($results as $row){
            echo "<tr id=\"".$row['vehicleID']."\">";
            echo "<td>".$row['year']."</td>";
            echo "<td>".$row['make']."</td>";
            echo "<td>".$row['model']."</td>";
            echo "<td>".$row['mileage']."</td>";
            echo "<td>".$row['maintenance']."</td>";
            echo "<td>";
                echo "<input type=\'text\' value=\"".$row['status']."\" disabled>";
            echo "</td>";
            echo "<td>";
                echo "<div>";
                    echo "<button class='edit'>Edit</button>";
                    echo "<button class='save' disabled>Save</button>";
                echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
    }

    //If Post data contains updateTicketTable perform the following database query to get all
    //user vehicles from the database to populate the tickets table
    if(isset($_POST['updateTicketTable'])){

        //Update all-tickets-table
        //Create a query for the database table
        $sql = "SELECT accountID, firstname, lastname, year, make, model, mileage, maintenance, status 
                FROM account NATURAL JOIN vehicle ORDER BY vehicleID DESC";

        //Prepare the statement
        $statement = $dbh->prepare($sql);

        //Process results
        $statement->execute();

        //Return the results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        //Return an updated table
        echo "<thead>";
        echo "<tr>";
        echo "<th scope=\"col\">Firstname</th>";
        echo "<th scope=\"col\">Lastname</th>";
        echo "<th scope=\"col\">Year</th>";
        echo "<th scope=\"col\">Make</th>";
        echo "<th scope=\"col\">Model</th>";
        echo "<th scope=\"col\">Miles</th>";
        echo "<th scope=\"col\">Service</th>";
        echo "<th scope=\"col\">Current Status</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        foreach($results as $row){
            echo "<tr>";
            echo "<td>".$row['firstname']."</td>";
            echo "<td>".$row['lastname']."</td>";
            echo "<td>".$row['year']."</td>";
            echo "<td>".$row['make']."</td>";
            echo "<td>".$row['model']."</td>";
            echo "<td>".$row['mileage']."</td>";
            echo "<td>".$row['maintenance']."</td>";
            echo "<td>".$row['status']."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
    }