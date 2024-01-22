<?php
include 'config.php';
include 'logout.php';
$validateUserID = $_SESSION['userid'];
$fetchtoVal = "SELECT * FROM `users` WHERE `id`='$validateUserID'";
$fetchtoValres = $connection->query($fetchtoVal);
if ($fetchtoValres->num_rows > 0) {
    while ($uservalrow = $fetchtoValres->fetch_assoc()) {
        if ($uservalrow['reports'] == '0') {
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
    <title>Welcome | Reports</title>
    <?php include 'btrpcss.php'; ?>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="row mt-3 mb-3">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Total Earnings
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php
                            $totalEarn = "SELECT SUM(`totalPay`) AS TotalEarnings FROM `invoices`";
                            $totalEarnRes = $connection->query($totalEarn);
                            if ($totalEarnRes->num_rows > 0) {
                                while ($earnings = $totalEarnRes->fetch_assoc()) {
                                    echo 'Rs.' . number_format($earnings['TotalEarnings']);
                                }
                            }
                            ?>
                        </h5>
                        <p class="card-text">This is your total earnings summary as of now</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Total N. Profit
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php
                            $totalNetProfit = "SELECT SUM(`shopPurchasePrice`) AS totalNetProfits FROM `invdetails`;";
                            $totalNetProfitRes = $connection->query($totalNetProfit);
                            if ($totalNetProfitRes->num_rows > 0) {
                                while ($sales = $totalNetProfitRes->fetch_assoc()) {
                                    echo number_format($sales['totalNetProfits']) . ' N. Profit';
                                }
                            }
                            ?>
                        </h5>
                        <p class="card-text">This is your total net profit as of now</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Products Sold
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php
                            $totalSale = "SELECT SUM(quantity) AS TotalSales FROM `invdetails`;";
                            $totalSaleRes = $connection->query($totalSale);
                            if ($totalSaleRes->num_rows > 0) {
                                while ($sales = $totalSaleRes->fetch_assoc()) {
                                    echo number_format($sales['TotalSales']) . ' Products Sold';
                                }
                            }
                            ?>
                        </h5>
                        <p class="card-text">This is your total number of units sold as of now</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Stock Availability
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php
                            $totalStocks = "SELECT SUM(quantity) AS TotalStock from `stockinv`;";
                            $totalStocksRes = $connection->query($totalStocks);
                            if ($totalStocksRes->num_rows > 0) {
                                while ($stocks = $totalStocksRes->fetch_assoc()) {
                                    echo number_format($stocks['TotalStock']) . ' Products In Stock';
                                }
                            }
                            ?>
                        </h5>
                        <button type="button" class="btn btn-outline-success mt-1" data-bs-toggle="modal" data-bs-target="#stockModal">More Details</button>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3 mb-3">
                <table class="table table-striped table-sm" id="salesSummary">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Total Sales</th>
                            <th scope="col" class="text-center">Units Sold</th>
                            <th scope="col" class="text-center">Total Revenue</th>
                            <th scope="col" class="text-center">N. Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $t = 1;
                        $fetchSalesSummary = "SELECT stockinv.id, stockinv.name, COUNT(DISTINCT invoices.invNo) AS total_sales, SUM(invdetails.quantity) AS total_quantity_sold, SUM(stockinv.price * invdetails.quantity) AS total_revenue, SUM((COALESCE(stockinv.price, 0) - COALESCE(stockinv.purchasePrice, 0)) * invdetails.quantity) AS NetProfitPerSale FROM stockinv LEFT JOIN invdetails ON stockinv.id = invdetails.pid LEFT JOIN invoices ON invdetails.invNo = invoices.invNo GROUP BY stockinv.id, stockinv.name ORDER BY total_sales DESC;";
                        $fetchSalesSummaryres = $connection->query($fetchSalesSummary);
                        if ($fetchSalesSummaryres->num_rows > 0) {
                            while ($fr = $fetchSalesSummaryres->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $t++ ?></td>
                                    <td><?php echo $fr['name']; ?></td>
                                    <td class="text-center"><?php echo number_format($fr['total_sales']); ?></td>
                                    <td class="text-center"><?php echo number_format($fr['total_quantity_sold']); ?></td>
                                    <td class="text-center totalPrice"><?php echo 'Rs. ' . number_format($fr['total_revenue'], 2); ?></td>
                                    <td class="text-center"><?php echo 'Rs. ' . number_format($fr['NetProfitPerSale'], 2); ?></td>

                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="alert alert-warning" role="alert">
                                Insufficient Data For Sales Summary
                            </div>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>



        <!-- Stock Modal -->
        <div class="modal modal-lg fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="stockModalLabel">Stock Availability</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-sm" id="moreStockDtlTbl">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">In Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $moreDtlStock = "SELECT * FROM `stockinv`";
                                $moreDtlStockRes = $connection->query($moreDtlStock);
                                if ($moreDtlStockRes->num_rows > 0) {
                                    while ($moreDtlStocks = $moreDtlStockRes->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?php echo $i++ ?></td>
                                            <td><?php echo $moreDtlStocks['name']; ?></td>
                                            <td><?php echo  $moreDtlStocks['quantity']; ?></td>

                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END -->
    </div>
    <?php include 'btrpjs.php'; ?>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#moreStockDtlTbl').DataTable({});
    });

    $(document).ready(function() {
        $('#salesSummary').DataTable({});
    });

    document.addEventListener('DOMContentLoaded', function() {
        setInterval(function() {
            calculateTotal();
        }, 500); // Adjust the interval (in milliseconds) based on your needs

        function calculateTotal() {
            var total = 0;

            // Loop through each input with class "totalPrice"
            var totalPriceInputs = document.querySelectorAll('.totalPrice');
            totalPriceInputs.forEach(function(input) {
                // Parse the value as a float and add it to the total
                var value = parseFloat(input.value) || 0;
                total += parseFloat(value.toFixed(2));
            });

            // Update the value of the element with ID "finalTotalPay"
            document.getElementById('nprofitfinal').value = total.toFixed(2);
        }
    });
</script>