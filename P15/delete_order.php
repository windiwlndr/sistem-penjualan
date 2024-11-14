<?php
    include 'koneksi.php';

    if (isset($_GET['id'])) {
        $id_order_to_delete = $_GET['id'];

        // SQL query to delete the order
        $delete_query = "DELETE FROM order_table WHERE id_order=$id_order_to_delete";

        if ($conn->query($delete_query) === TRUE) {
            echo "<p class='text-success'>Order deleted successfully!</p>";
            echo "<script>
            setTimeout(function(){
                window.location.href = 'order.php';
            }, 2000);
                </script>";
    // Redirect setelah 2 detik menggunakan JavaScript
        } else {
        echo "<p class='text-danger'>Error: " . $conn->error . "</p>";
        }
    }
?>