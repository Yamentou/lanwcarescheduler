<?php session_start(); 
include('assets/php/dbConfig.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments: Lawn Care Scheduler</title>
</head>
<body>
    <?php include('inc.navbar.php'); ?>
    <h3>Appointments</h3>
    <hr/>
    <form method="get" action="">
        <input type="search" name="q" placeholder="search keyword(s)" value="<?php if(isset($_GET['q'])) { echo $_GET['q']; } ?>" /> 
        <input type="submit" name="search" value="Search" />
        <?php if(isset($_GET['q'])) { ?> 
        <a href="appointments.php">Reset</a>
        <?php } ?>
    </form>
    <?php 
        //Code to delete a client record
        if(isset($_SESSION['username']) && isset($_GET['action']) && $_GET['action']=='delete') {
            $id = $_GET['id'];
            if(is_numeric($id)) {
                $query = "DELETE FROM `appointments` WHERE `appointment_id` = ".$id;
                if(mysqli_query($conn, $query)) {
                    echo '<p>The selected record was deleted.</p>';
                }
            }
        }

        //if a search is being performed
        if(isset($_GET['q'])) {
            $q = $_GET['q'];
            $query = "SELECT * FROM `appointments` WHERE `date` LIKE '%$q%' OR `location` LIKE '%$q%'"; //Search query string
        } else {
            //a search is not being perfomed, we return all customers
            $query = "SELECT * FROM appointments"; //Query string
        }

        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) {
            //Create my HTML table structure
            ?>
            <table border="1" cellpadding="4" cellspacing="2">
                <tr><td>#</td><td>Client Name</td><td>Date</td><td>Time</td><td>Location</td><td>&nbsp;</td></tr>
                <?php $c = 1;
                //Output data for each row
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?=$c?></td>
                        <td><?=getClientNameFromId($row['client_id'])?></td>
                        <td><?=$row['date']?></td>
                        <td><?=$row['time']?></td>
                        <td><?=$row['location']?></td>
                        <td>
                            <?php if(isset($_SESSION['username'])) { ?>
                                <a href="?id=<?=$row['appointment_id']?>&action=delete" onclick="javascript: return confirm('Do you really want to delete?')">Delete</a>
                                <a href="?id=<?=$row['appointment_id']?>&action=update">Update</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $c = $c + 1;
                } ?>
            </table> <?php
        }
        else {
            echo '0 results.';
        }
    ?>
</body>
</html>