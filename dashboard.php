<?php
include 'config.php';
include 'logout.php';
$validateUserID = $_SESSION['userid'];
$fetchtoVal = "SELECT * FROM `users` WHERE `id`='$validateUserID'";
$fetchtoValres = $connection->query($fetchtoVal);
if ($fetchtoValres->num_rows > 0) {
    while ($uservalrow = $fetchtoValres->fetch_assoc()) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Welcome | Dashboard</title>
            <?php include 'btrpcss.php'; ?>
        </head>

        <body>
            <?php include 'navbar.php'; ?>
            <div class="container mt-1 ">
                <div class="row">
                    <?php
                    if ($uservalrow['daily'] == '0') {
                    ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="custombackground card-header text-center pt-4 pb-4">
                                    <span class="badge bg-danger" style="padding-left: 15px; padding-right:15px;">
                                        <h3><i class="fa-solid fa-person-circle-exclamation"></i></i><br>Restricted Access</h3>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="custombackground card-header text-center pt-4 pb-4">
                                    <i class="card-icon fas fa-barcode"></i>
                                    <button type="button" class="btn btn-outline-light" onclick="window.location.href='daily.php'">DAILY</button>
                                </div>
                            </div>
                        </div>
                    <?php
                    }

                    if ($uservalrow['stocks'] == '0') {
                    ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="custombackground card-header text-center pt-4 pb-4">
                                    <span class="badge bg-danger" style="padding-left: 15px; padding-right:15px;">
                                        <h3><i class="fa-solid fa-person-circle-exclamation"></i></i><br>Restricted Access</h3>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="custombackground card-header text-center pt-4 pb-4">
                                    <i class="card-icon fas fa-cubes"></i>
                                    <button type="button" onclick="window.location.href='stocks.php'" class="btn btn-outline-light">STOCKS</button>
                                </div>
                            </div>
                        </div>
                    <?php
                    }

                    if ($uservalrow['access'] == '0') {
                    ?>
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="custombackground2 card-header text-center pt-4 pb-4">
                                    <span class="badge bg-danger" style="padding-left: 15px; padding-right:15px;">
                                        <h3><i class="fa-solid fa-person-circle-exclamation"></i></i><br>Restricted Access</h3>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="custombackground2 card-header text-center pt-4 pb-4">
                                    <i class="card-icon fas fa-circle-question"></i>
                                    <button type="button" onclick="window.location.href='access.php'" class="btn btn-outline-light">ACCESS</button>
                                </div>
                            </div>
                        </div>
                    <?php
                    }

                    if ($uservalrow['bills'] == '0') {
                    ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="custombackground card-header text-center pt-4 pb-4">
                                    <span class="badge bg-danger" style="padding-left: 15px; padding-right:15px;">
                                        <h3><i class="fa-solid fa-person-circle-exclamation"></i></i><br>Restricted Access</h3>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="custombackground card-header text-center pt-4 pb-4">
                                    <i class="card-icon fas fa-file-invoice"></i>
                                    <button type="button" onclick="window.location.href='bill.php'" class="btn btn-outline-light">BILLS</button>
                                </div>
                            </div>
                        </div>
                    <?php
                    }

                    if ($uservalrow['reports'] == '0') {
                    ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="custombackground card-header text-center pt-4 pb-4">
                                    <span class="badge bg-danger" style="padding-left: 15px; padding-right:15px;">
                                        <h3><i class="fa-solid fa-person-circle-exclamation"></i></i><br>Restricted Access</h3>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="custombackground card-header text-center pt-4 pb-4">
                                    <i class="card-icon fas fa-briefcase"></i>
                                    <button type="button" class="btn btn-outline-light">REPORT</button>
                                </div>
                            </div>
                        </div>
                    <?php
                    }

                    ?>
                </div>
            </div>
            <?php include 'btrpjs.php'; ?>
        </body>

        </html>
<?php
    }
} else {
    header("Location:index.php");
}
?>