<?php
include 'config.php';
include 'logout.php';
$validateUserID = $_SESSION['userid'];
$fetchtoVal = "SELECT * FROM `users` WHERE `id`='$validateUserID'";
$fetchtoValres = $connection->query($fetchtoVal);
if ($fetchtoValres->num_rows > 0) {
    while ($uservalrow = $fetchtoValres->fetch_assoc()) {
        if ($uservalrow['stocks'] == '0') {
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
    <title>Welcome | Stock Inventory</title>
    <?php include 'btrpcss.php'; ?>
</head>

<body>
    <?php
    include 'navbar.php';

    if (isset($_POST['btnAddProd'])) {
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
        try {
            $conn = new PDO(sprintf('mysql:host=%s; dbname=%s', $host, $dbname), $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $addProds = "INSERT INTO `stockinv` (`name`,`quantity`,`price`,`purchasePrice`,`netprofit`) VALUES ('$pname','$pquantity','$sprice','$pprice','$netprofit')";

            if ($conn->exec($addProds) === 1) {
    ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> New Product Added
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
    <?php
            } else {
                echo 'Error Trying To Process Your Request';
            }
        } catch (PDOException $pe) {
            echo $addProds . "<br>" . $pe->getMessage();
        }
    }
    ?>

    <div class="container">
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-header">
                        Total Products
                    </div>
                    <div class="card-body">
                        <h3 class="card-title text-center">
                            <?php
                            $totalProduct = "SELECT COUNT(`id`) as TotalProducts FROM `stockinv`";
                            $totalProductres = $connection->query($totalProduct);
                            if ($totalProductres->num_rows >= 1) {
                                while ($totalPRow = $totalProductres->fetch_assoc()) {
                                    echo '<span class="badge text-bg-primary border border-light rounded-circle"> ' . $totalPRow['TotalProducts'] . '</span>';
                                }
                            } else {
                                echo '<span class="badge text-bg-danger border border-light rounded-circle"> 0 </span>';
                            }
                            ?>
                        </h3>
                        <hr>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-layer-group"></i> New</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Total InStock
                    </div>
                    <div class="card-body">
                        <h3 class="card-title text-center">
                            <?php
                            $totalStock = "SELECT sum(`quantity`) as TotalStock FROM `stockinv`";
                            $totalStockres = $connection->query($totalStock);
                            if ($totalStockres->num_rows > 0) {
                                while ($totalSRow = $totalStockres->fetch_assoc()) {
                                    echo '<span class="badge text-bg-primary p-2 border border-light "> ' . number_format($totalSRow['TotalStock']) . '</span>';
                                }
                            }
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-striped table-sm table-responsive" id="stockTbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>P. Price</th>
                    <th>S. Price</th>
                    <th>N. Profit</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $fetchProducts = "SELECT * FROM `stockinv` ORDER BY `createtime` DESC";
                $fetchProductsres = $connection->query($fetchProducts);
                if ($fetchProductsres->num_rows > 0) {
                    while ($productRow = $fetchProductsres->fetch_assoc()) {
                ?>
                        <tr>
                            <td>
                                <form action="updaterec.php" method="post">
                                    <a class="btn btn-sm btn-danger" href="delrec.php?stid=<?php echo $productRow['id']; ?>&returnurl=stocks&reqtype=delstock"><i class="fa-solid fa-trash"></i></a>
                                    <button type="submit" name="btnUpdRec" value="<?php echo $productRow['id']; ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></button>
                                </form>
                            </td>
                            <td><?php echo $productRow['name']; ?></td>
                            <td><?php echo number_format($productRow['quantity']); ?></td>
                            <td><?php echo 'Rs. ' . number_format($productRow['purchasePrice'], 2); ?></td>
                            <td><?php echo 'Rs. ' . number_format($productRow['price'], 2); ?></td>
                            <td><?php echo 'Rs. ' . number_format($productRow['netprofit'], 2); ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <!-- Modal New Product -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="pname" class="form-control" id="floatingInputProduct" placeholder="Product Name">
                                        <label for="floatingInputProduct">Product Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="pquantity" class="form-control" id="floatingInputQuantity" placeholder="Quantity">
                                        <label for="floatingInputQuantity">Quantity</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="pprice" class="form-control" id="floatingInputPurchPrice" placeholder="Purchase Price">
                                        <label for="floatingInputPurchPrice">Purchase Price</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="sprice" class="form-control" id="floatingInputPrice" placeholder="Selling Price">
                                        <label for="floatingInputPrice">Selling Price</label>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="btnAddProd" class="btn btn-primary">Save changes</button>
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
        $('#stockTbl').DataTable();
    });
</script>