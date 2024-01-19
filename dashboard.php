<?php
include 'config.php';
include 'logout.php';
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
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="custombackground card-header text-center pt-4 pb-4">
                        <i class="card-icon fas fa-barcode"></i>
                        <button type="button" class="btn btn-outline-light" onclick="window.location.href='daily.php'">DAILY</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="custombackground card-header text-center pt-4 pb-4">
                        <i class="card-icon fas fa-cubes"></i>
                        <button type="button" onclick="window.location.href='stocks.php'" class="btn btn-outline-light">STOCKS</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="custombackground2 card-header text-center pt-4 pb-4">
                        <i class="card-icon fas fa-circle-question"></i>
                        <button type="button" onclick="window.location.href='access.php'" class="btn btn-outline-light">ACCESS</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="custombackground card-header text-center pt-4 pb-4">
                        <i class="card-icon fas fa-file-invoice"></i>
                        <button type="button" onclick="window.location.href='bill.php'" class="btn btn-outline-light">BILLS</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="custombackground card-header text-center pt-4 pb-4">
                        <i class="card-icon fas fa-briefcase"></i>
                        <button type="button" class="btn btn-outline-light">REPORT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'btrpjs.php'; ?>
</body>

</html>