<?php
ob_start();
include 'config.php';
include 'logout.php';
$actionID = $_SESSION['userid'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Record</title>
    <?php include 'btrpcss.php'; ?>
</head>

<body>
    <?php
    include 'navbar.php';
    /* Page Queries */
    if (isset($_POST['btnUpdateStock'])) {
        $btnUpdateStock = $_POST['btnUpdateStock'];
        $pname = $_POST['pname'];
        $pquantity = $_POST['pquantity'];
        $sprice = $_POST['sprice'];
        $pprice = $_POST['pprice'];
        $netprofit = '';
        if ($sprice == '' || $sprice == null || $pprice == '' || $pprice == null) {
            $sprice = '0';
            $pprice = '0';
            $netprofit = '0';
        } else {
            $netprofit = $sprice - $pprice;
        }
        $updateStockRec = "UPDATE `stockinv` SET `name`='$pname', `quantity`='$pquantity', `price`='$sprice', `purchasePrice`='$pprice', `netprofit`='$netprofit' WHERE `id`='$btnUpdateStock'";

        if ($connection->query($updateStockRec) === TRUE) {
            $logDescUtStk = 'User id ' . $_SESSION['userid'] . ' has updated a stock detail';
            $logQueryUtStk = "INSERT INTO `sitelogs` (`siteAction`,`description`,`userId`) VALUES ('UPDATE / STOCK','$logDescUtStk','$actionID')";
            $connection->query($logQueryUtStk);
            sleep(3);
            header("Location:stocks.php");
        } else {
    ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Whoops</strong> An Error Occured
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
        }
    }
    if (isset($_POST['btnUpdateUsers'])) {
        $name = $_POST['uname'];
        $email = $_POST['uemail'];
        $contact = $_POST['ucontact'];
        $usertype = $_POST['usertype'];
        @$billaccess = $_POST['billaccess'];
        @$stockaccess = $_POST['stockaccess'];
        @$accessaccess = $_POST['accessaccess'];
        @$reportaccess = $_POST['reportaccess'];
        @$dailyaccess = $_POST['dailyaccess'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $btnUpdateUsers = $_POST['btnUpdateUsers'];

        $updateUsers = "UPDATE `users` SET `name`='$name',`email`='$email',`contact`='$contact',`usertype`='$usertype',`username`='$username',`password`='$password',`daily`='$dailyaccess',`stocks`='$stockaccess',`bills`='$billaccess',`access`='$accessaccess',`reports`='$reportaccess' WHERE `id`= '$btnUpdateUsers'";

        if ($connection->query($updateUsers) === TRUE) {
            header("Location:access.php");
        } else {
            echo 'Error ' . $connection->error;
        }
    }
    /* END */

    /* Requests */
    if (isset($_POST['btnUpdRec'])) {
        $btnUpdRec = $_POST['btnUpdRec'];
        $fetchRec = "SELECT * FROM `stockinv` WHERE `id` ='$btnUpdRec'";
        $fetchRecRes = $connection->query($fetchRec);
        if ($fetchRecRes->num_rows > 0) {
            while ($fetchRecRow = $fetchRecRes->fetch_assoc()) {
            ?>
                <div class="container pt-5">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="pname" class="form-control" id="floatingInputProduct" placeholder="Product Name" value="<?php echo $fetchRecRow['name']; ?>">
                                    <label for="floatingInputProduct">Product Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" name="pquantity" class="form-control" id="floatingInputQuantity" placeholder="Quantity" value="<?php echo $fetchRecRow['quantity']; ?>">
                                    <label for="floatingInputQuantity">Quantity</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" name="pprice" class="form-control" id="floatingInputPurchasePrice" placeholder="Purchase Price" value="<?php echo $fetchRecRow['purchasePrice']; ?>">
                                    <label for="floatingInputPurchasePrice">Purchase Price</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" name="sprice" class="form-control" id="floatingInputSellingPrice" placeholder="Selling Price" value="<?php echo $fetchRecRow['price']; ?>">
                                    <label for="floatingInputSellingPrice">Selling Price</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" value="<?php echo $fetchRecRow['id']; ?>" name="btnUpdateStock" class="btn btn-success w-100">Update</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-warning w-100" onclick="window.location.href='stocks.php'">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php
            }
        }
    }

    if (isset($_POST['userUpdate'])) {
        $userUpdate = $_POST['userUpdate'];
        $fetchUser = "SELECT * FROM `users` WHERE `id` ='$userUpdate'";
        $fetchUserRes = $connection->query($fetchUser);
        if ($fetchUserRes->num_rows > 0) {
            while ($fetchUserRow = $fetchUserRes->fetch_assoc()) {
            ?>
                <div class="container pt-5">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="uname" class="form-control" id="inputName" placeholder="Name" value="<?php echo $fetchUserRow['name']; ?>">
                                    <label for="inputName">Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" name="uemail" class="form-control" id="userEmail" placeholder="Email" value="<?php echo $fetchUserRow['email']; ?>">
                                    <label for="userEmail">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" name="ucontact" class="form-control" id="uContact" placeholder="Contact" value="<?php echo $fetchUserRow['contact']; ?>">
                                    <label for="uContact">Contact</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" name="usertype" id="floatingSelect" aria-label="Floating label select example">
                                        <option value="<?php echo $fetchUserRow['usertype']; ?>" selected><?php echo $fetchUserRow['usertype']; ?></option>
                                        <hr>
                                        <option value="User">User</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                    <label for="floatingSelect">User Type</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="username" class="form-control" id="uSername" placeholder="Username" value="<?php echo $fetchUserRow['username']; ?>">
                                    <label for="uSername">Username</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="password" class="form-control" id="pAssword" placeholder="Password" value="<?php echo $fetchUserRow['password']; ?>">
                                    <label for="pAssword">Password</label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3 mb-4 text-center">
                                <?php
                                if ($fetchUserRow['bills'] == 1) {
                                ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="billaccess" type="checkbox" checked id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Bills</label>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="billaccess" type="checkbox" id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Bills</label>
                                    </div>
                                <?php
                                }

                                if ($fetchUserRow['stocks'] == 1) {
                                ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="stockaccess" checked type="checkbox" id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Stock</label>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="stockaccess" type="checkbox" id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Stock</label>
                                    </div>
                                <?php
                                }

                                if ($fetchUserRow['access'] == 1) {
                                ?>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="accessaccess" type="checkbox" id="inlineCheckbox1" value="1" checked>
                                        <label class="form-check-label" for="inlineCheckbox1">Access</label>
                                    </div>
                                <?php
                                } else {
                                ?>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="accessaccess" type="checkbox" id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Access</label>
                                    </div>
                                <?php
                                }

                                if ($fetchUserRow['daily'] == 1) {
                                ?>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="dailyaccess" type="checkbox" id="inlineCheckbox1" value="1" checked>
                                        <label class="form-check-label" for="inlineCheckbox1">Daily</label>
                                    </div>
                                <?php
                                } else {
                                ?>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="dailyaccess" type="checkbox" id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Daily</label>
                                    </div>
                                <?php
                                }
                                if ($fetchUserRow['reports'] == 1) {
                                ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="reportaccess" type="checkbox" id="inlineCheckbox1" value="1" checked>
                                        <label class="form-check-label" for="inlineCheckbox1">Report</label>
                                    </div>
                                <?php
                                } else {
                                ?>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="reportaccess" type="checkbox" id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Report</label>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                            <div class="col-md-6">
                                <button type="submit" value="<?php echo $fetchUserRow['id']; ?>" name="btnUpdateUsers" class="btn btn-success w-100">Update</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-warning w-100" onclick="window.location.href='stocks.php'">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
    <?php
            }
        }
    }
    ?>
    <?php include 'btrpjs.php'; ?>
</body>

</html>