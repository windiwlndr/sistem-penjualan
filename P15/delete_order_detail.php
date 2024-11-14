<!DOCTYPE html>
<html>
    <head>
        <title>Delete Order Detail</title>
        <!-- Add Bootstrap CSS link -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-4">
            <h1>Delete Order Detail</h1>
            <?php
            include 'koneksi.php';

            if (isset($_GET['id'])) {
                $id_order_detail_to_delete = $_GET['id'];

                // Fetch the order detail data from the database, including the food item's name
                $delete_query = "SELECT * FROM order_detil od
                                JOIN order_table ot ON od.id_order = ot.id_order 
                                JOIN menu m ON od.id_menu = m.id_menu 
                                WHERE od.pk = $id_order_detail_to_delete";
                $delete_result = $conn->query($delete_query);

                if ($delete_result->num_rows > 0) {
                    $row = $delete_result->fetch_assoc();
                } else {
                    echo "<p class='text-danger'>Detail pesanan tidak ditemukan.</p>";
                    exit;
                }
            } else {
                echo "<p class='text-danger'>Permintaan tidak valid.</p>";
                exit;
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Handle form submission to delete the order detail
                $id_order_detail = $_POST['id_order_detail']; // Retrieve the order detail ID from the form

                // SQL query to delete the order detail
                $delete_query = "DELETE FROM order_detil WHERE pk = $id_order_detail";

                if ($conn->query($delete_query) === TRUE) {
                    echo "<p class='text-success'>Detail pesanan berhasil dihapus!</p>";
                    echo "<script>
                            setTimeout(function(){
                                window.location.href = 'order_detail.php?id=" . $row['id_order'] . "';
                            }, 2000);
                        </script>";
                    // Redirect setelah 2 detik menggunakan JavaScript
                } else {
                    echo "<p class='text-danger'>Error: " . $conn->error . "</p>";
                }
            }
            ?>
            <table class="table">
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Makanan</th>
                    <th>Jumlah Makanan</th>
                </tr>
                <tr>
                    <td><?php echo $row['id_order']; ?></td>
                    <td><?php echo $row['nama_menu']; ?></td>
                    <td><?php echo $row['jumlah']; ?></td>
                </tr>
            </table>
            <form method="post" action=""> 
                <input type="hidden" name="id_order_detail" value="<?php echo $id_order_detail_to_delete; ?>">
                <button type="submit" class="btn btn-danger">Hapus</button>
                <a href="order_detail.php?id=<?php echo $row['id_order']; ?>" class="btn btn-primary">Batal</a>
            </form>
        </div>
        <!-- Add Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>


<!-- ini di hostingnya -->
<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_order_detail_to_delete = $_GET['id'];

    // Fetch the order detail data from the database, including the food item's name
    $delete_query = "SELECT * FROM order_detil od
                    JOIN order_table ot ON od.id_order = ot.id_order 
                    JOIN menu m ON od.id_menu = m.id_menu 
                    WHERE od.pk = $id_order_detail_to_delete";
    $delete_result = $conn->query($delete_query);

    if ($delete_result->num_rows > 0) {
        $row = $delete_result->fetch_assoc();
    } else {
        echo "Order detail not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to delete the order detail
    $id_order_detail = $_POST['id_order_detail']; // Retrieve the order detail ID from the form

    // SQL query to delete the order detail
    $delete_query = "DELETE FROM order_detil WHERE pk = $id_order_detail";

    if ($conn->query($delete_query) === TRUE) {
        echo "Order detail deleted successfully!";
?>
        <meta http-equiv="refresh" content="0;URL='order_detail.php?id=<?php echo $row['id_order']; ?>'" />
<?php
    } else {
        echo "Error: " . $conn->error;
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Order Detail</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Delete Order Detail</h1>
        <p>Are you sure you want to delete the following order detail?</p>
        <table class="table">
            <tr>
                <th>ID Order</th>
                <th>Nama Makanan</th>
                <th>Jumlah Makanan</th>
            </tr>
            <tr>
                <td><?php echo $row['id_order']; ?></td>
                <td><?php echo $row['nama_menu']; ?></td>
                <td><?php echo $row['jumlah']; ?></td>
            </tr>
        </table>
        <form method="post" action=""> 
            <input type="hidden" name="id_order_detail" value="<?php echo $id_order_detail_to_delete; ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="order_detail.php?id=<?php echo $row['id_order']; ?>" class="btn btn-primary">Cancel</a>
        </form>
    </div>
    <!-- Add Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
