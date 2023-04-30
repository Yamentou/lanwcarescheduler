<?php
//This function accepts a message string, formats it and displays it.
function showMsg(string $msg, string $status) {
    if($status == "success") {
        echo "<p>It worked! ".$msg."</p>";
    } else {
        echo "<p>Ooops! ".$msg."</p>";
    }
    echo "<hr/>";
}

function getClientNameFromId($clientId) {
    global $conn; //The $conn variable is defined outside this function.
    //To use $conn, we need to access it through the global keyword
    $query = "SELECT firstname, lastname FROM clients WHERE client_id = '".$clientId."'";
    $results = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($results)) {
        return $row["lastname"].", ".$row['firstname'];
    }
}

function getCategoryNameFromId($categoryId) {
    global $conn; //The $conn variable is defined outside this function.
    //To use $conn, we need to access it through the global keyword
    $query = "SELECT * FROM categories WHERE categoryID = '".$categoryId."'";
    $results = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($results)) {
        echo $row["categoryName"];
    }
}
?>