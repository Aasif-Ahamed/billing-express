<?php
ob_start();
include 'config.php';
include 'logout.php';
$validateUserID = $_SESSION['userid'];
$fetchtoVal = "SELECT * FROM `users` WHERE `id`='$validateUserID'";
$fetchtoValres = $connection->query($fetchtoVal);
if ($fetchtoValres->num_rows > 0) {
    while ($uservalrow = $fetchtoValres->fetch_assoc()) {
        if ($uservalrow['bills'] == '0') {
            header("Location:dashboard.php");
        }
    }
}
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Bills</title>
    <?php include 'btrpcss.php'; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
</head>

<body>
    <?php
    include 'navbar.php';
    if (isset($_POST['generateInv'])) {
        $generateInv = $_POST['generateInv'];
        echo $generateInv;
        $query = "SELECT * FROM invdetails INNER JOIN invoices ON invdetails.invNo = invoices.invNo WHERE invdetails.`invNo` = ?;";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('s', $generateInv);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();

        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Invoice</title>
</head>
<body>
    <main>
    <div style="text-align:center;">
    <p style="text-align:center; font-weight: bold; color: #4CAF50;">Invoice Created On - ' . date('jS F Y') . '</p>
    </div>
    <h1 style="background-color: #3498db; color: #fff; text-align: center; padding: 10px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"><b style="font-size: 1.5em;">-PURCHASE INVOICE-</b></h1>

       <table style="width: 100%;">
       <thead style="background-color: #3498db; color: #fff; text-align: left;">
       <tr>
           <th style="padding: 15px;">ITEM</th>
           <th style="padding: 15px;">QUANTITY</th>
           <th style="padding: 15px;">PURCHASE PRICE</th>
       </tr>
   </thead>
   
            <tbody>
';

        foreach ($rows as $row) {
            $html .= '
            <tr>
            <td style="font-weight: bold;">' . $row['pName'] . '</td>
            <td style="text-align:center;">' . $row['quantity'] . '</td>
            <td style="text-align:center;">Rs. ' . number_format($row['purcPrice']) . '</td>
        </tr>';
        }
        $html .= '
        <tr>
        <td colspan="2" style="text-align:right; padding-top:20px; font-weight: bold;">GRAND TOTAL</td>
        <td style="text-align:center; padding-top:20px; font-weight: bold;">Rs. ' . number_format($row['totalPay']) . '</td>
    </tr>
        </tbody>
        </table>
        <hr>
        </main>
        <footer style="text-align: center; padding-top: 20px; font-style: italic; color: #555;">
            <p>Thank you for your business!</p>
            <p>This invoice is auto-generated for your convenience.</p>
            <p style="font-size: 0.8em;">System generated invoice and is valid without the signature and seal.</p>
        </footer>
    </body>
    </html>';
        function generateRandomString($length = 5)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $dompdf = new Dompdf();
        $options = new Options();
        $dompdf->load_html($html);
        $dompdf->setPaper('A4', 'Portrait');
        $options->set('isRemoteEnabled', true);
        $dompdf->render();
        ob_end_clean();
        $dompdf->stream('Invoice_' . generateRandomString() . '.pdf', array('Attachment' => 0));

        $logDescInv = "User Id " . $validateUserID . " has generated an Invoice [" . $generateInv . "]";
        $logDescInvQur = "INSERT INTO `sitelogs` (`siteAction`,`description`,`userId`) VALUES ('GENERATE / INVOICE','$logDescInv','$validateUserID')";
        $connection->query($logDescInvQur);
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3 mb-3">
                <table class="table table-striped table-hover align-middle" id="billTbl">
                    <caption>Invoices - End of list</caption>
                    <thead>
                        <tr>
                            <td>Invoice No</td>
                            <td>Customer</td>
                            <td class="text-center">#</td>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        $selectinvoices = "SELECT * FROM `invoices`";
                        $selectinvoicesres = $connection->query($selectinvoices);
                        if ($selectinvoicesres->num_rows > 0) {
                            while ($invRow = $selectinvoicesres->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $invRow['invNo']; ?></td>
                                    <td><?php echo $invRow['cxName']; ?></td>
                                    <td class="text-center">
                                        <form action="" method="post">
                                            <button formtarget="_blank" type="submit" name="generateInv" class="btn btn-success" value="<?php echo $invRow['invNo']; ?>">
                                                <i class="fa-solid fa-file-invoice"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include 'btrpjs.php'; ?>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#billTbl').DataTable({
            scrollCollapse: true,
            scrollY: '50vh'
        });
    });
</script>