<?php
require("functions.php");

$username = $_GET["username"];

$user = query("SELECT * FROM users WHERE username = '$username'")[0];
$nama = $user["nama"];

$idRent = $user["id_rents"];
if ($idRent != "") {
    header("Location: userRoom.php?username=$username");
}

$rooms = query("SELECT * FROM room");

if (isset($_POST["join"])) {
    $nomorRuangan = $_POST["nomor_ruangan"];

    $exist = false;

    $rents = query("SELECT * FROM rents");
    foreach ($rents as $rent) {
        $rentNomorRuangan = $rent["nomor_ruangan"];
        if ($nomorRuangan == $rentNomorRuangan) {
            $exist = true;
        }
    }

    if ($exist == false) {
        //CREATE
        $idRent = "RE" . $nomorRuangan;
        $jumlah = 0;

        $data = [
            "id_rent" => $idRent,
            "nomor_ruangan" => $nomorRuangan,
            "jumlah_customer" => $jumlah
        ];

        if (insertRent($data) > 0) {
            alert("Success Create Rent!");
        } else {
            alert("Gagal Create Rent!");
        }
    }

    $rent = query("SELECT * FROM rents WHERE nomor_ruangan = '$nomorRuangan'")[0];
    $idRent = $rent["id_rent"];
    $nomorRuangan = $rent["nomor_ruangan"];
    $jumlah = $rent["jumlah_customer"];
    $jumlah++;

    $data = [
        "id_rent" => $idRent,
        "nomor_ruangan" => $nomorRuangan,
        "jumlah_customer" => $jumlah
    ];

    if (updateRent($data) > 0) {
        $user = query("SELECT * FROM users WHERE username = '$username'")[0];
        $username = $user["username"];
        $nama = $user["nama"];
        $email = $user["email"];
        $password = $user["password"];
        $idRent = "RE" . $nomorRuangan;

        $data = [
            "username" => $username,
            "nama" => $nama,
            "email" => $email,
            "password" => $password,
            "id_rents" => $idRent
        ];

        if (updateUser($data) > 0) {
            alert("Updated!");
            echo "<script> document.location.href = 'userRoom.php?username=$username'; </script>";
        } else {
            alert("Gagal Update!");
        }
    } else {
        alert("Gagal Update!");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="userStyle.css">
</head>

<body>
    <div class="gradient-custom min-vh-100">
        <div class="container min-vh-100 bg-dark">
            <nav class="navbar navbar-expand-lg bg-dark pt-4">
                <div class="container-fluid">
                    <div class="navbar-brand text-white ms-5 font2em">Welcome, <?= $nama ?>!</div>
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

            <h1 class="text-white ms-4 mt-4">Rooms</h1>

            <div class="row mt-5 w-80 d-flex justify-content-center align-item-center">
                <table class="caseTable w-70 mb-2 moreMargin">
                    <tr class="pb-4">
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Isi Ruangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    <?php
                    $nomor = 1;
                    foreach ($rooms as $room) :
                        $nomorRuangan = $room["nomor_ruangan"];
                        $namaRuangan = $room["nama_ruangan"];
                        $console = $room["console"];

                    ?>
                        <form action="" method="post">
                            <input type="hidden" name="nomor_ruangan" value="<?= $nomorRuangan ?>">
                            <tr>
                                <td class="text-center pt-4"><?= $nomor ?></td>
                                <td class="text-center pt-4"><?= $namaRuangan ?></td>
                                <?php
                                $rents = query("SELECT * FROM rents WHERE nomor_ruangan = '$nomorRuangan'");

                                if (count($rents) > 0) {
                                    $jumlah = $rents[0]["jumlah_customer"];
                                } else {
                                    $jumlah = 0;
                                }
                                ?>
                                <td class="text-center pt-4"><?= $jumlah ?>/4</td>
                                <?php
                                if ($jumlah < 4) {
                                ?>
                                    <td class="text-center pt-4 fontGreen">Open</td>
                                    <td class="text-center pt-4 d-flex justify-content-center align-item-center">
                                        <button class=" btnJoin gradient-custom" name="join">Join</button>
                                    </td>
                                <?php
                                } else {
                                ?>
                                    <td class="text-center pt-4 fontRed">Penuh</td>
                                    <td class="text-center pt-4 d-flex justify-content-center align-item-center">
                                        -
                                    </td>
                                <?php
                                }
                                ?>

                            </tr>
                        </form>
                    <?php
                        $nomor++;
                    endforeach;
                    ?>
                </table>
            </div>
            <div class="filler"></div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

</html>