<?php
include 'config.php';
include 'logout.php';
/* Stock Delete Request */
if (isset($_GET['reqtype']) == 'delstock') {
    $stockid = $_GET['stid'];
    $returnurl = $_GET['returnurl'];

    $stockDelete = "DELETE FROM `stockinv` WHERE `id` = '$stockid'";
    if ($connection->query($stockDelete) === TRUE) {
        echo 'Deleted';
        header('Location: ' . $returnurl);
        die();
    } else {
        echo 'An Error Occured - Please Contact Admin ' . $connection->error;
    }
}
/* END */
/* Access */
if (isset($_GET['restype']) == 'delusr') {
    $recid = $_GET['recid'];
    $returnurl = $_GET['returnurl'];

    $userDel = "DELETE FROM `users` WHERE `id` = '$recid'";
    if ($connection->query($userDel) === TRUE) {
        $logDescdel = 'User id ' . $_SESSION['userid'] . ' has delete user ' . $recid . '';
        $usersid = $_SESSION['userid'];
        $delQuery = "INSERT INTO `sitelogs` (`siteAction`,`description`,`userId`) VALUES ('NEW USER / ADD','$logDescdel','$usersid')";
        $connection->query($delQuery);
        header('Location: ' . $returnurl);
        die();
    } else {
        echo 'An Error Occured - Please Contact Admin ' . $connection->error;
    }
}
/* END */