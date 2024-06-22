<?php
require("functions.php");

if (isset($_POST["add"])) {
    $safe = true;

    $nomorRuangan = $_POST["nomor_ruangan"];
    $namaRuangan = $_POST["nama_ruangan"];
    $console = $_POST["console"];

    if ($nomorRuangan == "" || $namaRuangan == "") {
        $safe = false;
        alert("Semua Field Harus Terisi!");
    } else if (is_numeric($nomorRuangan) == false) {
        $safe = false;
        alert("Nomor Ruangan Harus Berupa Angka!");
    }

    $rooms = query("SELECT * FROM room");
    foreach ($rooms as $room) {
        $tempNomorRuangan = $room["nomor_ruangan"];
        if ($nomorRuangan == $tempNomorRuangan) {
            $safe = false;
            alert("Nomor Sudah Terdaftar!");
            break;
        }
    }

    $data = [
        "nomor_ruangan" => $nomorRuangan,
        "nama_ruangan" => $namaRuangan,
        "console" => $console
    ];

    if ($safe) {
        if (insertRoom($data) > 0) {
            alert("Room Berhasil Ditambahkan!");
            echo "<script> document.location.href = 'adminHome.php'; </script>";
        } else {
            alert("Room Gagal Ditambahkan!");
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
    <title>Add Room</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="tambahRoomStyle.css">
</head>

<body>
    <div class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form action="" method="post" class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Add Room</h2>
                                <p class="text-white-50 mb-5">Please Enter Room's Data!</p>

                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="nomor_ruangan" class="form-control form-control-lg" placeholder="Nomor Ruangan" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="nama_ruangan" class="form-control form-control-lg" placeholder="Nama Ruangan" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <select name="console" class="form-control form-control-lg">
                                        <option value="PS5">PS5</option>
                                        <option value="PS4">PS4</option>
                                        <option value="XBOX">XBOX</option>
                                        <option value="Switch">Switch</option>
                                    </select>
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit" name="add">Add</button>
                            </form>

                            <div>
                                <p class="mb-0">Have you changed your mind? <a href="adminHome.php" class="text-white-50 fw-bold">Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

</html>