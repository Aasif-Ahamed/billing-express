<?php
include 'config.php';
include 'logout.php';
$validateUserID = $_SESSION['userid'];
$fetchtoVal = "SELECT * FROM `users` WHERE `id`='$validateUserID'";
$fetchtoValres = $connection->query($fetchtoVal);
if ($fetchtoValres->num_rows > 0) {
    while ($uservalrow = $fetchtoValres->fetch_assoc()) {
        if ($uservalrow['daily'] == '0') {
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
    <title>Welcome | Daily</title>
    <?php require 'btrpcss.php'; ?>
</head>

<body>
    <?php

    include 'navbar.php';

    if (isset($_POST['invoiceBill'])) {
        //print_r($_POST);

        $invNo = $_POST['invoiceNumber'];
        $cxName = $_POST['invoicee'];
        $productID = $_POST['productID'];
        $astk = $_POST['availStock'];
        $names = $_POST['name'];
        $quantities = $_POST['quantity'];
        $price = $_POST['price'];
        $nettotal = $_POST['nettotal'];
        $totalPay = $_POST['totalPay'];
        $purchPrice = $_POST['purchPrice'];

        if (count($productID) == count($names) && count($productID) == count($quantities) && count($productID) == count($astk) && count($productID) == count($price) && count($productID) == count($purchPrice)) {
            $totalItems = count($productID);

            $initialQuery = "INSERT INTO `invoices` (`invNo`,`cxName`,`totalPay`) VALUES ('$invNo','$cxName','$totalPay')";
            if ($connection->query($initialQuery) === TRUE) {
                for ($i = 0; $i < $totalItems; $i++) {
                    $newPID = mysqli_escape_string($connection, $productID[$i]);
                    $newNames = mysqli_escape_string($connection, $names[$i]);
                    $newQuant = mysqli_escape_string($connection, $quantities[$i]);
                    $astk2 = mysqli_escape_string($connection, $astk[$i]);
                    $pricenew = mysqli_escape_string($connection, $price[$i]);
                    $purchPricenew = mysqli_escape_string($connection, $purchPrice[$i]);
                    $deductquant = "UPDATE `stockinv` SET `quantity`= $astk2 - $newQuant WHERE `id`='$newPID'";
                    $deductres = $connection->query($deductquant);

                    $netprofit = ($pricenew - $purchPricenew) * $newQuant;

                    $secondaryQuery = "INSERT INTO `invdetails` (`invNo`,`pid`,`pName`,`quantity`,`purcPrice`,`shopPurchasePrice`) VALUES ('$invNo','$newPID','$newNames','$newQuant',$pricenew, $netprofit)";
                    $results = $connection->query($secondaryQuery);
                }
                if ($deductres == 1) {
                    if ($results == 1) {
                        $logDesc = 'User id ' . $_SESSION['userid'] . ' has created a bill';
                        $usersid = $_SESSION['userid'];
                        $logQuery = "INSERT INTO `sitelogs` (`siteAction`,`description`,`userId`) VALUES ('BILLING / INVOICE','$logDesc','$usersid')";
                        $connection->query($logQuery);
    ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success</strong> Invoice No <b><?php echo $invNo; ?></b> Saved Successfully
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
    <?php
                    } else {
                        echo 'Error - ' . $connection->error;
                    }
                } else {
                    echo 'An error occured while trying to adjust new stock availability';
                }
            } else {
                echo 'Inital Failed - ' . $connection->error;
            }
        } else {
            echo 'Invoice Fields Incomplete - Please review the bill';
        }
    }
    ?>
    <div class="container mt-5">
        <form name="add_name" action="" method="post" id="add_name">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="invoiceNumber" class="form-control" id="invoiceNumber" placeholder="Invoice Number" value="<?php echo "INV-" . date('Y') . "-" . bin2hex(random_bytes(2)); ?>">
                        <label for="invoiceNumber">Invoice Number</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="invoicee" class="form-control" id="invoiceName" placeholder="Name">
                        <label for="invoiceName">Name</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table w-100 table-striped table-responsive" id="dynamic_field">
                        <tr>
                            <td>
                                <div class="form-floating mb-3"><input type="text" class="form-control productName" name="name[]" id="productName" list="datalistOptions" placeholder="Search Product"><label for="productName">Product</label></div>
                            </td>

                            <td>
                                <div class="form-floating mb-3"><input type="number" min="1" max="" name="quantity[]" class="form-control productQuantity" id="productQuantity" placeholder="Quantity"><label for="productQuantity">Quantity</label></div>
                            </td>

                            <td>
                                <div class="form-floating mb-3">
                                    <input type="text" name="price[]" class="form-control productPrice" id="productPrice" placeholder="Price" readonly><label for="productPrice">Price</label>
                                </div>
                                <input type="hidden" name="productID[]" id="productID" class="productID">
                                <input type="hidden" name="availStock[]" id="availStock" class="availStock">
                                <input type="hidden" name="purchPrice[]" id="pruchasingPrice" class="pruchasingPrice">
                                <input type="hidden" name="nettotal[]" class="form-control totalPrice" id="totalPrice" placeholder="Net Total" readonly>
                            </td>

                            <!--                             <td>
                                <div class="form-floating mb-3">
                                    <input type="text" name="nettotal[]" class="form-control totalPrice" id="totalPrice" placeholder="Net Total" readonly><label for="totalPrice">Net Total</label>
                                </div>
                            </td> -->

                            <td class="text-center">
                                <button type="button" name="add" id="add" class="btn btn-success mt-1"><i class="fa-solid fa-circle-plus"></i></button>
                            </td>
                        </tr>
                    </table>
                    <div class="row" style="width: 100%;">
                        <div class="col-md-8" style="text-align: right;">
                            <h1 style="font-size: large;">Total Payable</h1>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center text-center">

                            <input type="text" name="totalPay" readonly value="0" class="finalTotalPay form-control w-75 text-center" id="finalTotalPay">

                        </div>
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-4 mt-3" style="text-align: center;">
                            <input type="submit" name="invoiceBill" id="submit" class="btn btn-success w-75" value="Bill Now" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <datalist id="datalistOptions">
            <?php
            $fetchStockDetails = "SELECT * FROM `stockinv`";
            $fetchStockDetailsres = $connection->query($fetchStockDetails);
            if ($fetchStockDetailsres->num_rows > 0) {
                while ($fetchedStocks = $fetchStockDetailsres->fetch_assoc()) {
            ?>
                    <option value="<?php echo $fetchedStocks['name']; ?>">
                <?php
                }
            }
                ?>
        </datalist>
    </div>

    <?php require 'btrpjs.php'; ?>
</body>

</html>
<script>
    $(document).ready(function() {
        var i = 1;

        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '">' +
                '<td><div class="form-floating mb-3"><input type="text" class="form-control productName" name="name[]" list="datalistOptions" placeholder="Search Product"><label for="productName">Search Product</label></div></td>' +
                '<td><div class="form-floating mb-3"><input type="number" name="quantity[]"  class="form-control productQuantity" placeholder="Quantity"><label for="productQuantity">Quantity</label></div></td>' +
                '<td><div class="form-floating mb-3"><input type="text" name="price[]" class="form-control productPrice" readonly placeholder="Price"><label for="productPrice">Price</label></div><input type="hidden" name="productID[]" id="productID" class="productID"><input type="hidden" name="availStock[]" id="availStock" class="availStock"><input type="hidden" name="purchPrice[]" id="pruchasingPrice" class="pruchasingPrice">                                <input type="hidden" name="nettotal[]" class="form-control totalPrice" id="totalPrice" placeholder="Net Total" readonly></td>' +
                '<td class="text-center"><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fa-solid fa-rectangle-xmark"></i></button></td>' +
                '</tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

        $('#submit').click(function() {
            $.ajax({
                url: "name.php",
                method: "POST",
                data: $('#add_name').serialize(),
                success: function(data) {
                    alert(data);
                    $('#add_name')[0].reset();
                }
            });
        });

        // Event delegation for dynamically added rows
        $('#dynamic_field').on('change', '.productName', function() {
            var selectedProduct = $(this).val();
            var currentRow = $(this).closest('tr');

            // AJAX request to fetch data from the server
            $.ajax({
                url: 'fetch_product_details.php',
                method: 'POST',
                data: {
                    product: selectedProduct
                },
                success: function(response) {
                    try {
                        var data = JSON.parse(response);

                        // Convert product_price to a number and check for validity
                        var productPrice = parseFloat(data.product_price);
                        var fpid = data.pid;
                        var actualStock = data.actlStk;
                        var acpnew = data.acp;

                        if (!isNaN(productPrice)) {
                            // Update the product price input field in the current row
                            currentRow.find('.productPrice').val(productPrice);
                            currentRow.find('.productID').val(fpid)
                            currentRow.find('.availStock').val(actualStock);
                            currentRow.find('.pruchasingPrice').val(acpnew);
                        } else {
                            console.error('Invalid product price:', data.product_price);
                        }
                    } catch (error) {
                        console.error('Error parsing JSON response:', error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                }
            });


        });

        $(document).on('change', '.productQuantity', function() {
            var currentRow = $(this).closest('tr');
            var totalQuantity = $(this).val();
            var unitPrice = currentRow.find('.productPrice').val();

            var totalFinal = unitPrice * totalQuantity;
            currentRow.find('.totalPrice').val(totalFinal.toFixed(2));
        });
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
            document.getElementById('finalTotalPay').value = total.toFixed(2);
        }
    });
</script>