<?php
    session_start();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Halaman Depan</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <i class="bi bi-box-arrow-left"></i>
        <style>
            body {
                background-image: url('gambar.png');
                background-size: cover;
                background-attachment: fixed;
                color: #fff;
                margin: 0;
                padding: 0;
                font-family: 'Arial', sans-serif;
            }


            nav {
                background: transparent !important;
                padding: 10px 0;
            }

            .navbar {
                background-color: transparent !important;
            }

            .navbar-brand {
                font-family: 'Pacifico', cursive;
                font-size: 36px;
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

            @media (max-width: 768px) {
                .navbar {
                    background-color: #212529;
                }
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
            <ul class="navbar-nav">
                <?php
                    if ($_SESSION['level'] == 'admin') {
                        echo '<li class="nav-item active">
                                <a class="nav-link" href="menu.php">Menu</a>
                            </li>';
                    }
                ?>
                <li class="nav-item">
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
                    <ul class="dropdown-menu">
                        <li><a href="#" id="profile-link">Profile</a></li>
                        <script>
                            $(document).ready(function () {
                                $("#profile-link").click(function () {
                                    alert("Nama: <?= $_SESSION['nama'] ?>\nLevel: <?= $_SESSION['level'] ?>");
                                });
                            });
                        </script>
                    </ul>
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
    <div class="container welcome-container">
        <h1 class="welcome-text">Selamat Datang <?= $_SESSION['nama'] ?>!</h1>
        <p>Level anda: <?= $_SESSION['level'] ?></p>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>