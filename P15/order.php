<?php
session_start();
include 'koneksi.php';


// Initialize variables for sorting
$sortColumn = isset($_POST['sort']) ? $_POST['sort'] : 'total';
$sortOrder = isset($_POST['order']) ? $_POST['order'] : 'asc'; 

// Initialize variables for search
$searchKeyword = isset($_POST['search']) ? $_POST['search'] : '';

$batas = 5;
$halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

$previous = $halaman - 1;
$next = $halaman + 1;


// Construct the SQL query based on sorting and searching preferences
$query = "SELECT * FROM order_table WHERE (id_order LIKE '%$searchKeyword%' OR tgl_jam LIKE '%$searchKeyword%' OR pelayan LIKE '%$searchKeyword%' OR no_meja LIKE '%$searchKeyword%') ORDER BY id_order $sortOrder LIMIT $halaman_awal, $batas";
$result = $conn->query($query);


$data = mysqli_query($conn, "SELECT * FROM order_table WHERE (id_order LIKE '%$searchKeyword%' OR tgl_jam LIKE '%$searchKeyword%' OR pelayan LIKE '%$searchKeyword%' OR no_meja LIKE '%$searchKeyword%')");
$jumlah_data = mysqli_num_rows($data);
$total_halaman = ceil($jumlah_data / $batas);

$no = $halaman_awal + 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pesanan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <i class="bi bi-person-fill"></i>
    <style>
        body {
            background-color: #f8f9fa;
        }

        nav {
            background: transparent !important;
            padding: 10px 0;
        }

        .navbar {
            background-color: #227fe3 !important;
        }

        .navbar-brand {
            font-family: 'Pacifico', cursive;
            font-size: 36px;
            color: #fff !important;
        }

        .nav-item.active,
        .nav-item:hover {
            background-color: #5598df; /* Sesuaikan warnanya sesuai kebutuhan */
        }

        .navbar-nav .nav-link.active,
        .navbar-nav .nav-link:hover {
            color: #fff !important;
        }

        .navbar-dark .navbar-toggler-icon {
            background-color: #fff;
        }

        .navbar-dark .navbar-toggler:focus,
        .navbar-dark .navbar-toggler:hover {
            background-color: #fff;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 18px;
        }

        .navbar-nav .nav-link:hover {
            color: #ddd;
        }

        .white-text {
            color: #fff !important;
        }

        .welcome-container {
            text-align: center;
            margin-top: 100px;
        }

        .welcome-text {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        transform: translate3d(0, 0, 0);
        opacity: 1;
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    .dropdown-menu {
        transform: translate3d(0, -20px, 0);
        opacity: 0;
        display: none;
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    .dropdown-menu a {
        color: #333 !important;
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: none;
        position: absolute;
        top: 100%;
        left: -8px;
        z-index: 999;
        display: none;
    }

    .card-title {
        color: #007bff;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .card-subtitle {
        color: #555;
        font-size: 1rem;
    }

    .navbar-nav .dropdown {
        position: relative;
    }
    
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
    }

    .nav-item:hover .card {
        display: block;
    }

        @media (max-width: 768px) {
            .navbar {
                background-color: #212529;
            }
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }

        h3 {
            color: #007bff;
        }

        .form-inline {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .form-group {
            margin-right: 10px;
        }

        .input-group {
            flex: 1;
        }

        .btn-primary-search {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-primary-search:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        
    </style>
</head>
<body>
    <?php
        $newURL = "login.php";
        if(isset($_SESSION['islogin']) && $_SESSION['islogin'] == true ) {
            // Tidak melakukan apa-apa jika sudah login
        } else {
            // Script JavaScript untuk melakukan redirect
            echo "<script>window.location.href = '{$newURL}';</script>";
            exit;  // Pastikan untuk keluar setelah script JavaScript
        }
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Warung Busit</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
        <?php
            if ($_SESSION['level'] == 'admin') {
                echo '<li class="nav-item ' . (basename($_SERVER['PHP_SELF']) == 'menu.php' ? 'active' : '') . '">
                        <a class="nav-link" href="menu.php">Menu</a>
                    </li>';
            }
        ?>
        <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'order.php' ? 'active' : ''); ?>">
            <a class="nav-link" href="order.php">Pesan</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle white-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                        <span></span> <?= $_SESSION['nama'] ?> <b class="caret"></b>
                    </a>

                    <div class="card" style="width: 18rem; margin-top: 10px;">
                        <div class="card-body">
                            <h5 class="card-title">anda : <?= $_SESSION['nama'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">level : <?= $_SESSION['level'] ?></h6>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16" style="color: white;">
                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                        </svg>
                        Log out
                    </a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container">
        <h3 class="mb-4">Daftar Pesanan</h3>
        
        <!-- Sorting and Searching Form with Bootstrap styling -->
        <form method="post" action="order.php" class="form-inline mb-3">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari..." value="<?php echo $searchKeyword; ?>" />
                </div>
            </div>

            <div class="form-group ml-md-2">
                <label for="sort" class="mr-2">Urutkan berdasarkan:</label>
                <select name="sort" id="sort" class="form-control">
                    <option value="total" <?php if ($sortColumn === 'total') echo 'selected'; ?>>Total</option>
                </select>
            </div>

            <div class="form-group ml-md-2">
                <label for="order" class="mr-2">Urutan:</label>
                <select name="order" id="order" class="form-control">
                    <option value="asc" <?php if ($sortOrder === 'asc') echo 'selected'; ?>>asc</option>
                    <option value="desc" <?php if ($sortOrder === 'desc') echo 'selected'; ?>>desc</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary ml-md-2">Cari & Urutkan</button>
        </form>

        <!-- Table with Bootstrap styling -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="bagianTh">
                    <tr>
                        <th>No.</th>
                        <th>ID Order</th>
                        <th>Waktu</th>
                        <th>Pelayan</th>
                        <th>No. Meja</th>
                        <th>Total</th>
                        <th colspan="2">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++ . "."; ?></td>
                            <td><?php echo $row['id_order']; ?></td>
                            <td><?php echo $row['tgl_jam']; ?></td>
                            <td><?php echo $row['pelayan']; ?></td>
                            <td><?php echo $row['no_meja']; ?></td>
                            <td><?php echo $row['total']; ?></td>
                            <td><a href='order_detail.php?id=<?php echo $row['id_order']; ?>' class='btn btn-primary'>Lihat Detail</a></td>
                            
                            <?php if ($_SESSION['level'] == 'admin'): ?>
                                
                            <td><a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id_order']; ?>);" class="btn btn-danger">Delete</a></td>
                            <?php endif; ?>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination with Bootstrap styling -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php echo ($halaman <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" <?php echo ($halaman > 1) ? "href='?halaman=$previous'" : ''; ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($x = 1; $x <= $total_halaman; $x++) : ?>
                    <li class="page-item <?php echo ($x == $halaman) ? 'active' : ''; ?>">
                        <a class="page-link" href="?halaman=<?php echo $x; ?>"><?php echo $x; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
                    <a class="page-link" <?php echo ($halaman < $total_halaman) ? "href='?halaman=$next'" : ''; ?> aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Buttons with Bootstrap styling -->
        <a href="tambah_order.php" class="btn btn-success">Tambah Pesanan</a>
        <br>
        <br>
        <br>
        <br>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>