<?php
require("functions.php");

$usernameMaster = $_GET["username"];

$user = query("SELECT * FROM users WHERE username = '$usernameMaster'")[0];
$idRent = $user["id_rents"];

$roomMate = query("SELECT * FROM users WHERE id_rents = '$idRent'");

$rent = query("SELECT * FROM rents WHERE id_rent = '$idRent'")[0];
$nomorRuangan = $rent["nomor_ruangan"];

$room = query("SELECT * FROM room WHERE nomor_ruangan = '$nomorRuangan'")[0];
$nomorRuangan = $room["nomor_ruangan"];
$namaRuangan = $room["nama_ruangan"];
$console = $room["console"];

if (isset($_GET["leave"])) {
    $username = $_GET["username"];

    $user = query("SELECT * FROM users WHERE username = '$username'")[0];

    if (count($user) > 0) {
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
                            echo "<script> document.location.href = 'user.php?username=$username'; </script>";
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
                            echo "<script> document.location.href = 'user.php?username=$username'; </script>";
                        } else {
                            alert("Gagal Update!");
                        }
                    }
                }
            } else {
                alert("Gagal Update!");
            }
        } else {
            alert("Gagal Update!");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="userRoomStyle.css">
</head>

<body>
    <div class="gradient-custom min-vh-100">
        <div class="container min-vh-100 bg-dark">
            <nav class="navbar navbar-expand-lg bg-dark pt-4">
                <div class="container-fluid">
                    <div class="navbar-brand text-white ms-5 font2em">Welcome to <?= $namaRuangan ?>!</div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

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

            <h1 class="text-white ms-5 mt-4 colorCustom">Rooms</h1>
            <h2 class="text-white ms-5 mt-4 ">Console : <?= $console ?></h2>

            <div class="row mt-5 w-50 d-flex justify-content-center align-item-center mb-5">
                <table class="caseTable w-70 mb-2 moreMargin">
                    <tr class="pb-4">
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                    </tr>
                    <?php
                    $nomor = 1;
                    foreach ($roomMate as $mate) :
                        $username = $mate["username"];
                        $nama = $mate["nama"];
                    ?>
                        <form action="" method="post">
                            <tr>
                                <td class="text-center pt-4"><?= $nomor ?></td>
                                <td class="text-center pt-4"><?= $nama ?></td>
                            </tr>
                        </form>
                    <?php
                        $nomor++;
                    endforeach;
                    ?>
                </table>
            </div>

            <form action="" method="get" class="d-flex justify-content-center mt-5">
                <input type="hidden" name="username" value="<?= $usernameMaster ?>">
                <button class="btnLeave border-lengkung gradient-custom d-flex justify-content-center align-item-center me-4" name="leave">Leave Room</button>
            </form>

            <div class="filler"></div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

</html>