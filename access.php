<?php
ob_start();
include 'config.php';
include 'logout.php';
$validateUserID = $_SESSION['userid'];
$fetchtoVal = "SELECT * FROM `users` WHERE `id`='$validateUserID'";
$fetchtoValres = $connection->query($fetchtoVal);
if ($fetchtoValres->num_rows > 0) {
    while ($uservalrow = $fetchtoValres->fetch_assoc()) {
        if ($uservalrow['access'] == '0') {
            header("Location:dashboard.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Access</title>
    <?php include 'btrpcss.php'; ?>
</head>

<body>
    <?php
    include 'navbar.php';
    if (isset($_POST['addNewUser'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $usertype = $_POST['usertype'];
        $billaccess = $_POST['billaccess'];
        $stockaccess = $_POST['stockaccess'];
        $accessaccess = $_POST['accessaccess'];
        $reportaccess = $_POST['reportaccess'];
        $dailyaccess = $_POST['dailyaccess'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (isset($_POST["billaccess"])) {
            $billaccess = '1';
        } else {
            $billaccess = '0';
        }

        if (isset($_POST["stockaccess"])) {
            $stockaccess = '1';
        } else {
            $stockaccess = '0';
        }
        if (isset($_POST["accessaccess"])) {
            $accessaccess = '1';
        } else {
            $accessaccess = '0';
        }
        if (isset($_POST["reportaccess"])) {
            $reportaccess = '1';
        } else {
            $reportaccess = '0';
        }
        if (isset($_POST["dailyaccess"])) {
            $dailyaccess = '1';
        } else {
            $dailyaccess = '0';
        }


        $insertstmt = "INSERT INTO `users`( `name`, `email`, `contact`, `usertype`, `username`, `password`, `daily`, `stocks`, `bills`, `access`,`reports`) VALUES ('$name','$email','$contact','$usertype','$username','$password','$dailyaccess','$stockaccess','$billaccess','$dailyaccess','$reportaccess')";

        if ($connection->query($insertstmt) === TRUE) {
            $logDesc = 'User id ' . $_SESSION['userid'] . ' has added a new user ' . $name . '';
            $usersid = $_SESSION['userid'];
            $logQuery = "INSERT INTO `sitelogs` (`siteAction`,`description`,`userId`) VALUES ('NEW USER / ADD','$logDesc','$usersid')";
            $connection->query($logQuery);
            header("Location:access.php");
        } else {
            echo $connection->error;
        }
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-header">
                        Total Users
                    </div>
                    <div class="card-body">
                        <h3 class="card-title text-center">
                            <?php
                            $totalUsers = "SELECT COUNT(`id`) as TotalUsers FROM `users`";
                            $totalUsersres = $connection->query($totalUsers);
                            if ($totalUsersres->num_rows > 0) {
                                while ($totalRow = $totalUsersres->fetch_assoc()) {
                                    echo '<span class="badge text-bg-primary border border-light rounded-circle"> ' . $totalRow['TotalUsers'] . '</span>';
                                }
                            }
                            ?>
                        </h3>
                        <hr>
                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalNew"><i class="fa-solid fa-user-plus"></i> New</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-striped table-responsive table-sm" id="accessTbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Access</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $accessBlock = '<span class="badge text-bg-danger p-2 border border-light rounded-circle">
                <i class="fa-solid fa-circle-xmark"></i>
                </span>';
                $accessSuccess = '<span class="badge text-bg-success p-2 border border-light rounded-circle"><i class="fa-solid fa-check"></i></span>';
                $fetchUsers = "SELECT * FROM `users`";
                $fetchUsersres = $connection->query($fetchUsers);
                if ($fetchUsersres->num_rows > 0) {
                    while ($usersRow = $fetchUsersres->fetch_assoc()) {
                ?>
                        <tr>
                            <td>
                                <form action="updaterec.php" method="post">
                                    <a href="delrec.php?recid=<?php echo $usersRow['id']; ?>&returnurl=access&restype=delusr" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    <button type="submit" name="userUpdate" class="btn btn-sm btn-warning" value="<?php echo $usersRow['id']; ?>"><i class="fa-solid fa-pen-nib"></i></button>
                                </form>
                            </td>
                            <td><?php echo $usersRow['name']; ?></td>
                            <td><?php echo $usersRow['email']; ?></td>
                            <td><?php echo $usersRow['contact']; ?></td>
                            <td>
                                <?php echo $usersRow['usertype']; ?>
                                <hr>
                                Daily - <?php
                                        if ($usersRow['daily'] == 0) {
                                            echo $accessBlock;
                                        } else {
                                            echo $accessSuccess;
                                        }

                                        ?>
                                |
                                Stocks - <?php
                                            if ($usersRow['stocks'] == 0) {
                                                echo $accessBlock;
                                            } else {
                                                echo $accessSuccess;
                                            }

                                            ?>
                                |
                                Bills - <?php
                                        if ($usersRow['bills'] == 0) {
                                            echo $accessBlock;
                                        } else {
                                            echo $accessSuccess;
                                        }

                                        ?>
                                |
                                Access - <?php
                                            if ($usersRow['access'] == 0) {
                                                echo $accessBlock;
                                            } else {
                                                echo $accessSuccess;
                                            }

                                            ?>
                                |
                                Reports - <?php
                                            if ($usersRow['reports'] == 0) {
                                                echo $accessBlock;
                                            } else {
                                                echo $accessSuccess;
                                            }

                                            ?>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalNew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name" class="form-control" id="textUserName" placeholder="Name">
                                        <label for="textUserName">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="contact" class="form-control" id="ContactLabel" placeholder="Contact">
                                        <label for="ContactLabel">Contact</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="username" class="form-control" id="UserName" placeholder="Username">
                                        <label for="UserName">Username</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password" class="form-control" id="Password" placeholder="Password">
                                        <label for="Password">Password</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <select class="form-select" name="usertype" id="floatingSelect" aria-label="Floating label select example">
                                            <option value="User" selected>User</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                        <label for="floatingSelect">User Type</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="billaccess" type="checkbox" checked id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Bills</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="stockaccess" type="checkbox" id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Stock</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="accessaccess" type="checkbox" id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Access</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="dailyaccess" type="checkbox" id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Daily</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="reportaccess" type="checkbox" id="inlineCheckbox1" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Report</label>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="addNewUser" class="btn btn-primary">Add User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'btrpjs.php'; ?>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#accessTbl').DataTable();
    });
</script>