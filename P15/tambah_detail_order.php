<?php
session_start();
include 'koneksi.php';

if (isset($_GET["id_order"])) {
    $id_order = $_GET["id_order"];
} else {
    echo '<script>window.location.href = "tambah_order.php";</script>';
    exit();
}

// Initialize $total
$total = 0;

// Kode untuk menyimpan data detail pesanan ke dalam tabel "order_detail"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_menu = $_POST["nama_menu"];
    $jumlah = $_POST["jumlah"];

    // Ambil harga menu dari tabel "menu" berdasarkan nama menu
    $sql_harga = "SELECT id_menu, harga FROM menu WHERE nama_menu = '$nama_menu'";
    $result_harga = mysqli_query($conn, $sql_harga);

    if ($result_harga) {
        $menu_data = mysqli_fetch_assoc($result_harga);
        $id_menu = $menu_data["id_menu"]; // Ambil ID menu
        $harga = $menu_data["harga"];

        $sub_total = $harga * $jumlah;

        $sql = "INSERT INTO order_detil (id_order, id_menu, jumlah, sub_total) VALUES ('$id_order', '$id_menu', '$jumlah', '$sub_total')";
        if (mysqli_query($conn, $sql)) {
            // Data detail pesanan berhasil disimpan
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $sql_harga . "<br>" . mysqli_error($conn);
    }

}

// Kode untuk menampilkan data order_detail untuk pesanan yang dipilih
$sql = "SELECT * FROM order_detil WHERE id_order = $id_order";
$result = mysqli_query($conn, $sql);

// Kode untuk mengambil daftar menu dan harga dari tabel "menu"
$sql_menu = "SELECT nama_menu, harga FROM menu";
$result_menu = mysqli_query($conn, $sql_menu);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
            background-color: #5598df;
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
            .navbar-collapse {
                border-top: 1px solid #fff;
                padding-top: 10px;
            }

            .navbar-nav {
                flex-direction: column;
                align-items: flex-start;
                background-color: #212529;
            }

            .navbar-nav .nav-item {
                margin-bottom: 0;
            }

            .navbar-nav .nav-link {
                padding: 0.5rem 1rem;
                color: #fff !important;
            }

            .navbar-toggler-icon {
                background-color: #fff;
            }
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }

        
        .table-responsive {
            overflow-x: auto;
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
                if (isset($_SESSION['level']) && $_SESSION['level'] == 'admin') {
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
                    <?php
                    if (isset($_SESSION['level']) && isset($_SESSION['nama'])) {
                        echo '<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle white-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                    </svg>
                                    <span></span> ' . $_SESSION['nama'] . ' <b class="caret"></b>
                                </a>
    
                                <div class="card" style="width: 18rem; margin-top: 10px;">
                                    <div class="card-body">
                                        <h5 class="card-title">anda : ' . $_SESSION['nama'] . '</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">level : ' . $_SESSION['level'] . '</h6>
                                    </div>
                                </div>';
                    } else {
                        // Guest
                        echo '<a class="nav-link" href="tambah_order.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                </svg>
                                Tambah Order
                            </a>';
                    }
                    ?>
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
    <div class="container mt-5">
        <h1>Detail Pesanan</h1>
        <h2>Nomor Pesanan: <?php echo $id_order; ?></h2>

        <form action="tambah_detail_order.php?id_order=<?php echo $id_order; ?>" method="post">
            <div class="form-group">
                <label for="nama_menu">Nama Menu</label>
                <select name="nama_menu" class="form-control" required>
                    <!-- Menampilkan daftar menu dan harga dari tabel "menu" -->
                    <?php
                    while ($row = mysqli_fetch_assoc($result_menu)) {
                        echo "<option value='" . $row["nama_menu"] . "'>" . $row["nama_menu"] . " (Harga: " . $row["harga"] . ")</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group ">
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" required>
            </div>
            <div class="form-group ">
                <button type="submit" class="btn btn-primary form-control">Tambahkan Pesanan</button>
            </div>
        </form>
        
        <br><br>
        <!-- Menampilkan data detail pesanan untuk pesanan yang dipilih -->
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    // Ambil nama menu berdasarkan ID menu
                    $id_menu = $row["id_menu"];
                    $sql_menu_name = "SELECT nama_menu FROM menu WHERE id_menu = $id_menu";
                    $result_menu_name = mysqli_query($conn, $sql_menu_name);
                    $menu_name = mysqli_fetch_assoc($result_menu_name)["nama_menu"];

                    echo "<tr>";
                    echo "<td>" . $menu_name . "</td>";
                    echo "<td>" . $row["jumlah"] . "</td>";
                    echo "<td>" . $row["sub_total"] . "</td>";
                    echo "</tr>";

                    $sub_total = $row["sub_total"];
                    $total += $sub_total;
                }

                // Update total in order_table
                $sql_update_total = "UPDATE order_table SET total = $total WHERE id_order = $id_order";
                if ($conn->query($sql_update_total) === TRUE) {
                    // Total successfully updated
                } else {
                    echo "Error updating total: " . $conn->error;
                }
                ?>
            </tbody>
        </table>
        
<!-- Tombol Selesai dan Batal untuk Admin -->
<?php
if (isset($_SESSION['level']) && $_SESSION['level'] == 'admin') {
    echo '<a href="order.php" class="btn btn-success">Selesai</a>';
}
else{
     echo '<a href="table_guest.php" class="btn btn-success">Selesai</a>';
}


// <!-- Tombol Lihat Detail Orderan untuk Pengguna -->
// if (isset($_SESSION['level']) && $_SESSION['level'] == 'guest') {
//     echo '<a href="order_detail.php" class="btn btn-success">Selesai</a>';
// }
?>

<!-- Tombol Batal -->
<a href="tambah_order.php" class="btn btn-secondary">Batal</a>

    </div>

</body>
</html>
