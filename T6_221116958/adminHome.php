<?php
require("functions.php");

$rooms = query("SELECT * FROM room");

if (isset($_POST["detailRoom"])) {
    $nomorRuangan = $_POST["nomorRuangan"];
    header("Location: detailRoom.php?nomorRuangan=$nomorRuangan");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="adminHomeStyle.css">
</head>

<body>
    <div class="gradient-custom min-vh-100">
        <div class="container min-vh-100 bg-dark">
            <nav class="navbar navbar-expand-lg bg-dark pt-4">
                <div class="container-fluid">
                    <div class="navbar-brand text-white ms-5 font2em">Welcome, Admin!</div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item gradient-custom border-lengkung">
                                <a class="nav-link text-white font15em active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white font15em active" aria-current="page" href="adminUsers.php">Users</a>
                            </li>
                        </ul>
                        <form action="login.php" class="d-flex justify-content-end">
                            <button class=" btnLogout me-5 gradient-custom">Logout</button>
                        </form>
                    </div>
                </div>
            </nav>

            <div class="row d-flex justify-content-center align-item-center mt-4">
                <hr class="gradient-custom" style="width: 100%; height: 5px;">
            </div>

            <h1 class="text-white ms-4 mt-4">Rooms</h1>
            <form action="tambahRoom.php" class="d-flex justify-content-end">
                <button class="btnTambah border-lengkung gradient-custom d-flex justify-content-center align-item-center me-4">Add Room</button>
            </form>


            <div class="row ms-3 h-100">
                <div class="row d-flex justify-content-center align-item-center mt-5 pb-5 ps-2">
                    <?php
                    $Cardid = 1;
                    foreach ($rooms as $room) :
                        $nomor = $room["nomor_ruangan"];
                        $nama = $room["nama_ruangan"];
                        $console = $room["console"];
                        $id = "card" . $Cardid;
                        $Cardid++;
                    ?>
                        <form action="" method="post" class="col-md-3">
                            <input type="hidden" name="nomorRuangan" value="<?= $nomor ?>">
                            <button class="p-0 mt-3 bgTrans" name="detailRoom">
                                <div id="<?= $id ?>" class="card border-lengkung" style="width: 18rem;">
                                    <?php
                                    if ($console == "PS5") {
                                        echo "<script>
                                                var element = document.getElementById('$id');
                                                element.classList.add('bgMerah');
                                            </script>";
                                    } else if ($console == "PS4") {
                                        echo "<script>
                                                var element = document.getElementById('$id');
                                                element.classList.add('bgBiru');
                                            </script>";
                                    } else if ($console == "XBOX") {
                                        echo "<script>
                                                var element = document.getElementById('$id');
                                                element.classList.add('bgHijau');
                                            </script>";
                                    } else if ($console == "Switch") {
                                        echo "<script>
                                                var element = document.getElementById('$id');
                                                element.classList.add('bgOrange');
                                            </script>";
                                    }
                                    ?>
                                    <div class="card-top d-flex justify-content-center align-item-center">
                                        <span class="nomor"><?= $nomor ?></span>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><?= $nama ?></h3>
                                        <?php
                                        $rents = query("SELECT * FROM rents WHERE nomor_ruangan = $nomor");

                                        if (count($rents) > 0) {
                                            $jumlah = $rents[0]["jumlah_customer"];
                                        } else {
                                            $jumlah = 0;
                                        }

                                        ?>
                                        <p class="card-text display-6 d-flex justify-content-end"><?= $jumlah ?>/4</p>
                                    </div>
                                </div>
                            </button>
                        </form>

                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

</html>