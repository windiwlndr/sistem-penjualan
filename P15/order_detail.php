<?php
session_start();
include 'koneksi.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    echo "error";
}

// Ambil data order detail berdasarkan ID order
$sql_order_detail = "SELECT * FROM order_detil od
                    JOIN order_table ot ON od.id_order = ot.id_order 
                    JOIN menu m ON od.id_menu = m.id_menu 
                    WHERE od.id_order = $id";
$result_order_detail = $conn->query($sql_order_detail);

// Inisialisasi variabel total
$total = 0;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Order Detail</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <i class="bi bi-person-fill"></i>
    <style>
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
    </style>
</head>
<body>
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
    <div class="container mt-4">
        <h2>Detail Pesanan</h2>
        <p>ID Order: <?php echo $id; ?></p>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Makanan</th>
                    <th>Jumlah Makanan</th>
                    <th>Sub Total</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row_order_detail = $result_order_detail->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>$no</td>";
                    echo "<td>" . $row_order_detail['nama_menu'] . "</td>";
                    echo "<td>" . $row_order_detail['jumlah'] . "</td>";
                    echo "<td>" . $row_order_detail['sub_total'] . "</td>";
                    
                    if ($_SESSION['level'] == 'admin'){
                                
                    echo "<td><a href='delete_order_detail.php?id=" . $row_order_detail['pk'] . "' class='btn btn-danger'>Delete</a></td>";
                    }
                            
                    echo "</tr>";
                    $no++;

                    $total += $row_order_detail['sub_total'];

                    // Update total pesanan ke dalam tabel order_table
                    $sql_update_total = "UPDATE order_table SET total = $total WHERE id_order = $id";
                    if ($conn->query($sql_update_total) === TRUE) {
                        // Total berhasil diupdate
                    } else {
                        echo "Error updating total: " . $conn->error;
                    }
                                        
                }
                ?>
                <tr>
                    <td colspan="3">Total</td>
                    <td colspan="2">
                        <?php echo $total; 
                    
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="tambah_pesanan.php?id=<?php echo $id; ?>" class="btn btn-primary">Tambah Pesanan</a>
        <a href="order.php" class="btn btn-secondary">Kembali</a>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
