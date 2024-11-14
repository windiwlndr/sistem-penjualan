<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      max-width: 500px; /* Atur lebar maksimum sesuai kebutuhan */
    }

    @media (max-width: 576px) {
      .container {
        padding: 15px;
      }
    }

    button.btn-primary {
      width: 100%;
    }

    .alert {
      margin-top: 10px;
    }
  </style>
</head>
<body>


    <div class="container mt-5">
        <div class="row">
        <div class="col-md-6 col-lg-4 mx-auto">

            <div class="row mb-3">
            <div class="col">
                <h2 class="text-primary">Login</h2>
            </div>
            </div>

            <form action="login_action.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nama User</label>
                <input type="text" class="form-control" name="uname" placeholder="Nama User">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="pwd" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary mb-3" >Sign in</button>
            </form>
            atau anda sebagai <a href="tambah_order.php">guest</a> ?
        </div>
        </div>
    </div>
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"-->
        <!--integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"-->
        <!--crossorigin="anonymous">-->
        <!--</script>-->
    </body>
</html>