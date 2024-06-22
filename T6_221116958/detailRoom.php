<?php
require("functions.php");

$nomorRuangan = $_GET["nomorRuangan"];

$room = query("SELECT * FROM room WHERE nomor_ruangan = '$nomorRuangan'")[0];
$namaRuangan = $room["nama_ruangan"];
$console = $room["console"];

$rent = query("SELECT * FROM rents WHERE nomor_ruangan = '$nomorRuangan'");
if (count($rent) > 0) {
    $idRent = $rent[0]["id_rent"];
} else {
    $idRent = "";
}

$users = query("SELECT * FROM users WHERE id_rents = '$idRent'");

if (isset($_POST["kick"])) {
    $username = $_POST["username"];

    $user = query("SELECT * FROM users WHERE username = '$username'")[0];

    if (count($user) > 0) {
        $username = $user["username"];
        $nama = $user["nama"];
        $email = $user["email"];
        $password = $user["password"];
        $idRent = "NULL";

        $data = [
            "username" => $username,
            "nama" => $nama,
            "email" => $email,
            "password" => $password,
            "id_rents" => $idRent
        ];

        if (deleteUser($username) > 0) {
            if (insertUser($data) > 0) {

                $idRent = $rent["id_rent"];
                $nomorRuangan = $rent["nomor_ruangan"];
                $jumlah = $rent["jumlah_customer"];

                if (is_numeric($jumlah)) {
                    $jumlah--;

                    if ($jumlah == 0) {
                        // DELETE
                        if (deleteRent($idRent) > 0) {
                            alert("Updated!");
                        } else {
                            alert("Gagal Update!");
                        }
                    } else {
                        // UPDATE
                        $data = [
                            "id_rent" => $idRent,
                            "nomor_ruangan" => $nomorRuangan,
                            "jumlah_customer" => $jumlah
                        ];

                        if (updateRent($data)) {
                            alert("Updated!");
                        } else {
                            alert("Gagal Update!");
                        }
                    }
                }

                // Reload
                $room = query("SELECT * FROM room WHERE nomor_ruangan = $nomorRuangan")[0];
                $namaRuangan = $room["nama_ruangan"];
                $console = $room["console"];

                $rent = query("SELECT * FROM rents WHERE nomor_ruangan = $nomorRuangan")[0];
                $idRent = $rent["id_rent"];

                $users = query("SELECT * FROM users WHERE id_rents = '$idRent'");
            } else {
                alert("Gagal Update!");
            }
        } else {
            alert("Gagal Update!");
        }
    }
}

if (isset($_GET["close"])) {
    $nomorRuangan = $_GET["nomorRuangan"];

    $room = query("SELECT * FROM room WHERE nomor_ruangan = $nomorRuangan")[0];

    $rent = query("SELECT * FROM rents WHERE nomor_ruangan = $nomorRuangan")[0];
    $idRent = $rent["id_rent"];

    $users = query("SELECT * FROM users WHERE id_rents = '$idRent'");

    $safe = false;

    foreach ($users as $user) {
        $username = $user["username"];
        $nama = $user["nama"];
        $email = $user["email"];
        $password = $user["password"];

        $data = [
            "username" => $username,
            "nama" => $nama,
            "email" => $email,
            "password" => $password
        ];

        $safe = false;
        if (deleteUser($username) > 0) {
            if (insertUser($data) > 0) {
                $safe = true;
            }
        }
    }

    $safe = false;
    if (deleteRent($idRent) > 0) {
        $safe = true;
    }

    $safe = false;
    if (deleteRoom($nomorRuangan) > 0) {
        $safe = true;
    }

    if ($safe) {
        alert("Room Closed!");
        echo "<script> document.location.href = 'adminHome.php'; </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Room</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="detailRoomStyle.css">
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
                            <li class="nav-item">
                                <a class="nav-link text-white font15em active" aria-current="page" href="adminHome.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white font15em active" aria-current="page" href="adminUsers.php">Users</a>
                            </li>
                        </ul>
                        <form action="login.php" class="d-flex justify-content-end">
                            <button class=" btnLogout me-5 gradient-custom mt-3">Logout</button>
                        </form>
                    </div>
                </div>
            </nav>

            <div class="row d-flex justify-content-center align-item-center mt-4">
                <hr class="gradient-custom" style="width: 100%; height: 5px;">
            </div>

            <h1 class="text-white ms-5 mt-4"><?= $nomorRuangan ?>'s Details Room</h1>

            <form action="adminHome.php" class="d-flex justify-content-end">
                <button class="btnBack border-lengkung gradient-custom d-flex justify-content-center align-item-center me-4">Back</button>
            </form>

            <h2 class="text-white ms-5 mt-4 ">Nama : <?= $namaRuangan ?></h2>
            <h2 class="text-white ms-5 mt-4 ">Console : <?= $console ?></h2>

            <div class="row mt-5 w-80 d-flex justify-content-center align-item-center mb-5">
                <table class="caseTable w-70 mb-2 moreMargin">
                    <tr class="pb-4">
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Action</th>
                    </tr>
                    <?php
                    $nomor = 1;
                    foreach ($users as $user) :
                        $username = $user["username"];
                        $nama = $user["nama"];
                    ?>
                        <form action="" method="post">
                            <input type="hidden" name="username" value="<?= $username ?>">
                            <tr>
                                <td class="text-center pt-4"><?= $nomor ?></td>
                                <td class="text-center pt-4"><?= $nama ?></td>
                                <td class="text-center pt-4">
                                    <button class=" btnKick gradient-custom" name="kick">Kick</button>
                                </td>
                            </tr>
                        </form>
                    <?php
                        $nomor++;
                    endforeach;
                    ?>
                </table>
            </div>

            <form action="" method="get" class="d-flex justify-content-center mt-5">
                <input type="hidden" name="nomorRuangan" value="<?= $nomorRuangan ?>">
                <button class="btnBack border-lengkung gradient-custom d-flex justify-content-center align-item-center me-4" name="close">Close Room</button>
            </form>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

</html>