<?php
require("functions.php");

$users = query("SELECT * FROM users");

if (isset($_POST["delete"])) {
    $username = $_POST["username"];

    $safe = true;

    foreach ($users as $user) {
        $tempUsername = $user["username"];
        if ($username == $tempUsername) {
            $safe = true;
            $idRent = $user["id_rents"];
            break;
        } else {
            $safe = false;
        }
    }

    if ($safe) {

        if (deleteUser($username) > 0) {
            alert("User Deleted!");
        } else {
            alert("Gagal Delete dalem!");
        }

        if ($idRent != "") {
            $rent = query("SELECT * FROM rents WHERE id_rent = '$idRent'")[0];

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
                        alert("Gagal deleteUpdate!");
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
                        alert("Gagal updateUpdate!");
                    }
                }
            }
        }

        $users = query("SELECT * FROM users");
    } else {
        alert("Gagal Delete!");
    }
}

if (isset($_POST["reset"])) {
    $username = $_POST["username"];

    $user = query("SELECT * FROM users WHERE username = '$username'")[0];
    $username = $user["username"];
    $nama = $user["nama"];
    $email = $user["email"];
    $password = "dibawahkarpet";
    $idRent = $user["id_rents"];

    $data = [
        "username" => $username,
        "nama" => $nama,
        "email" => $email,
        "password" => $password,
        "id_rents" => $idRent
    ];

    if (updateUser($data) > 0) {
        alert("User Updated!");
    } else {
        alert("Gagal Update User!");
    }
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
    <link rel="stylesheet" href="adminUsersStyle.css">
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
                            <li class="nav-item gradient-custom border-lengkung">
                                <a class="nav-link text-white font15em active" aria-current="page" href="#">Users</a>
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

            <h1 class="text-white ms-4 mt-4">Users</h1>

            <div class="row mt-5 w-80 d-flex justify-content-center align-item-center">
                <table class="caseTable w-70 mb-2 moreMargin">
                    <tr class="pb-4">
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    <?php
                    $nomor = 1;
                    foreach ($users as $user) :
                        $username = $user["username"];
                        $nama = $user["nama"];
                        $idRent = $user["id_rents"];
                    ?>
                        <form action="" method="post">
                            <input type="hidden" name="username" value="<?= $username ?>">
                            <tr>
                                <td class="text-center pt-4"><?= $nomor ?></td>
                                <td class="text-center pt-4"><?= $nama ?></td>
                                <?php
                                if ($idRent == "") {
                                ?>
                                    <td class="text-center pt-4">Not Playing</td>
                                <?php
                                } else {
                                ?>
                                    <td class="text-center pt-4">Playing</td>
                                <?php
                                }
                                ?>
                                <td class="text-center pt-4 d-flex justify-content-center align-item-center">
                                    <button class=" btnDelete gradient-custom" name="delete">Delete</button>
                                    <button class=" btnReset gradient-custom" name="reset">Reset Password</button>
                                </td>
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