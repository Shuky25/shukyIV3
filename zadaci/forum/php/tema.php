<!DOCTYPE html>
<?php
session_start();
if (empty($_SESSION['ime'])) {
    $stanje = $email = $psw = $ime = $prezime = $_SESSION['ime'] = $_SESSION['prezime'] = $_SESSION['mejl'] = $_SESSION['sifra'] = "";
} else {
    $stanje = $email = $psw = $ime = $prezime = "";
}

function izlogujSe()
{
    $email = $psw = $ime = $prezime = $_SESSION['ime'] = $_SESSION['prezime'] = "";
    session_destroy();
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link rel="stylesheet" href="../layout/style.css">

    <title>Teme</title>
</head>

<body>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        require './konekcija.php';
        $naslov = $_POST['naziv_teme'];
        $opis = $_POST['opis_teme'];
        $datum = date("H:i:s d.m.Y");
        $email = $_SESSION['mejl'];

        $sql = "INSERT INTO teme(naziv_teme, opis_teme, datum_kreiranja, email) VALUES('$naslov', '$opis', '$datum', '$email')";
        if (mysqli_query($conn, $sql)) {
            header('location: tema.php');
            exit();
        } else {
            $stanje = "Tema nije usena!";
        }
    }
    ?>

    <header>
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-expand-lg">
                    <div class="col-md-6">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                            <li class="nav-item">
                                <a class="nav-link" href="../index.php">Pocetna</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./register.php">Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./tema.php">Teme</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../../index.php">Pocetak</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <a style="color: #fff" href="./nalog.php"><?php echo $_SESSION['ime'] . " " . $_SESSION['prezime']; ?></a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <section id="tema" data-aos="fade-up">
        <div class="container">
            <h1>Teme</h1>
            <hr>
            <div class="row">

                <?php
                if (!empty($_SESSION['ime']) || $_SESSION['ime'] != "") {
                    echo '<section id="forma" data-aos="fade-up">
                    <div class="container">
                        <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="POST">
                            <div class="form-control">
                                <label for="email">Naslov teme:</label><br>
                                <input type="text" placeholder="Unesite temu" name="naziv_teme"><br>
                            </div>
                            <div class="form-control">
                                <label for="email">Opis teme:</label><br>
                                <textarea name="opis_teme" id="opis_teme" cols="30" rows="10" style="width: 90%; padding: 20px; border: 1px solid #333; background-color: #fff; color: black;" placeholder="Unesi opis"></textarea><br>
                            </div>
                            <button type="submit" class="btn btn-primary">Objavi temu</button>
                            ' . $stanje . '
                        </form>
                    </div>
                </section>';
                } else {
                    echo '<p>Morate se <a href="./login.php">ulogovati</a> da bi dodali temu!</p>';
                }
                ?>
            </div>

            <div class="row" id="teme">
                <?php
                
                if (!empty($_SESSION['ime']) || $_SESSION['ime'] != "") {
                    require './konekcija.php';
                    $mejl = $_SESSION['mejl'];
                    $sql = "SELECT * FROM teme WHERE email = '$mejl'";
                    $res = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo '<div style="border: 2px solid #d3d3d3; border-radius: 10px; margin: 20px; padding: 20px;">';
                            echo  '<a href="#"><h2>' . $row['naziv_teme'] . '</h2></a>';
                            echo '<hr style="width: 90%; margin: 10px auto 30px auto;">';
                            echo   '<p> ' . $row['opis_teme'] . ' </p>';
                            echo    '</div>';
                        }
                    } else {
                        echo '<p>Ovaj korisnik nema dodatih tema</p>';
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <?php include "./components/footer.php"; ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>