<?php
session_start();

$homepath = isset($_SERVER['HOME']) ? ($_SERVER['HOME']) : ($_SERVER['DOCUMENT_ROOT']);
require 'koneksi.php';

$uname = $_POST['uname'];
$pwd = $_POST['pwd'];

if ((($uname == 'kasir') and ($pwd == 'kasir')) or 
    (($uname == 'budi') and ($pwd == '1234'))) {
    echo 'Login valid kasir';
    $_SESSION['islogin'] = true;
    $_SESSION['nama'] = $uname;
    $_SESSION['level'] = 'kasir';

    echo '<script>window.location.href = "index.php";</script>';
} 
elseif ((($uname == 'admin') and ($pwd == 'admin')) or 
        (($uname == 'bos') and ($pwd == '1234'))) {
    echo 'Login valid admin';
    $_SESSION['islogin'] = true;
    $_SESSION['nama'] = $uname;
    $_SESSION['level'] = 'admin';

    echo '<script>window.location.href = "index.php";</script>';
}
else {
    echo 'Password salah';
    if (isset($_SESSION['islogin'])) $_SESSION['islogin'] = false;
    if (isset($_SESSION['nama'])) $_SESSION['nama'] = '';
    if (isset($_SESSION['level'])) $_SESSION['level'] = '';
}
?>
