<?php session_start(); 
include('assets/php/dbConfig.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients: Lawn Care Scheduler</title>
</head>
<body>
    <?php include('inc.navbar.php'); ?>
    <h3>Clients</h3>
    <hr/>
    <form method="get" action="">
        <input type="search" name="q" placeholder="search keyword(s)" value="<?php if(isset($_GET['q'])) { echo $_GET['q']; } ?>" /> 
        <input type="submit" name="search" value="Search" />
        <?php if(isset($_GET['q'])) { ?> 
        <a href="clients.php">Reset</a>
        <?php } ?>
    </form>
    <?php 
        //Code to delete a client record
        if(isset($_SESSION['username']) && isset($_GET['action']) && $_GET['action']=='delete') {
            $id = $_GET['id'];
            if(is_numeric($id)) {
                $query = "DELETE FROM `clients` WHERE `client_id` = ".$id;
                if(mysqli_query($conn, $query)) {
                    echo '<p>The selected record was deleted.</p>';
                }
            }
        }

        //if a search is being performed
        if(isset($_GET['q'])) {
            $q = $_GET['q'];
            $query = "SELECT * FROM `clients` WHERE `lastname` LIKE '%$q%' OR `firstname` LIKE '%$q%'"; //Search query string
        } else {
            //a search is not being perfomed, we return all customers
            $query = "SELECT * FROM clients"; //Query string
        }

        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) {
            //Create my HTML table structure
            ?>
            <table border="1" cellpadding="4" cellspacing="2">
                <tr><td>#</td><td>Name</td><td>Email</td><td>Phone</td><td>Address</td><td>&nbsp;</td></tr>
                <?php $c = 1;
                //Output data for each row
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?=$c?></td>
                        <td><?=$row['firstname']?> <?=$row['lastname']?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['phone']?></td>
                        <td><?=$row['street']?> <?=$row['city']?>, <?=$row['state']?><?=$row['zip']?></td>
                        <td>
                            <?php if(isset($_SESSION['username'])) { ?>
                                <a href="?id=<?=$row['client_id']?>&action=delete" onclick="javascript: return confirm('Do you really want to delete?')">Delete</a>
                                <a href="?id=<?=$row['client_id']?>&action=update">Update</a>
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