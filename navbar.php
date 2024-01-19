<!-- <button class="btn btn-primary rounded-circle floating-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
    <i class="fa-solid fa-bars"></i>
</button>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Navigation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <button type="button" onclick="window.location.href='dashboard.php'" class="btn btn-outline-success w-75 mt-2 mb-2"><i class="fa-solid fa-house"></i> Home</button>
        <button type="button" onclick="window.location.href='daily.php'" class="btn btn-outline-success w-75 mt-2 mb-2"><i class="fa-solid fa-bars"></i> Daily</button>
        <button type="button" onclick="window.location.href='stocks.php'" class="btn btn-outline-success w-75 mt-2 mb-2"><i class="fa-solid fa-bars"></i> Stocks</button>
        <button type="button" onclick="window.location.href='access.php'" class="btn btn-outline-success w-75 mt-2 mb-2"><i class="fa-solid fa-bars"></i> Access</button>
        <button type="button" onclick="window.location.href='bill.php'" class="btn btn-outline-success w-75 mt-2 mb-2"><i class="fa-solid fa-bars"></i> Bills</button>
        <button type="button" onclick="window.location.href='report.php'" class="btn btn-outline-success w-75 mt-2 mb-2"><i class="fa-solid fa-bars"></i> Report</button>
        <form action="" method="post">
            <button type="submit" name="btnLogout" onclick="window.location.href='logout.php'" class="btn btn-outline-success w-75 mt-2 mb-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </form>
    </div>
</div> -->

<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Welcome</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".storenavBar" aria-controls="storenavBar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse storenavBar justify-content-center text-center" id="storenavBar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button type="button" onclick="window.location.href='dashboard.php'" class="btn btn-outline-success mt-2 mb-2 nav-link"><i class="fa-solid fa-house"></i> Home</button>
                </li>
                <li class="nav-item">
                    <button type="button" onclick="window.location.href='daily.php'" class="btn btn-outline-success nav-link  mt-2 mb-2"><i class="fa-solid fa-bars"></i> Daily</button>
                </li>
                <li class="nav-item">
                    <button type="button" onclick="window.location.href='stocks.php'" class="btn btn-outline-success nav-link mt-2 mb-2"><i class="fa-solid fa-bars"></i> Stocks</button>
                </li>
                <li class="nav-item">
                    <button type="button" onclick="window.location.href='access.php'" class="btn btn-outline-success nav-link mt-2 mb-2"><i class="fa-solid fa-bars"></i> Access</button>
                </li>

                <li class="nav-item">
                    <button type="button" onclick="window.location.href='bill.php'" class="btn btn-outline-success  mt-2 mb-2 nav-link"><i class="fa-solid fa-bars"></i> Bills</button>
                </li>
                <li class="nav-item">
                    <button type="button" onclick="window.location.href='report.php'" class="btn btn-outline-success nav-link mt-2 mb-2"><i class="fa-solid fa-bars"></i> Report</button>
                </li>
                <li class="nav-item">
                    <form action="" method="post">
                        <button type="submit" name="btnLogout" onclick="window.location.href='logout.php'" class="btn btn-outline-success nav-link mt-2 mb-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>