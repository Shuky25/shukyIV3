<!DOCTYPE html>
<?php
session_start();
$mejlErr = $pswErr = $imeErr = $prezErr = $prijavaErr = "";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./layout/style.css">
    <title>Forum</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./index.php">Pocetna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/contact.php">Kontakt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">O nama</a>
                        </li>
                    </ul>
                    <button class="navPrijava" id="reg" onclick="document.getElementById('id02').style.display='block'">Registruj se</button>
                    <button class="navLogin" id="log" onclick="document.getElementById('id01').style.display='block'">Prijavi se</button>
                    <!-- <input type="submit" class="navOdjava" id="log" style="display: none;" value="Odjavi se" name="odjaviSe"> -->
                    <button class="navOdjava" id="log" onclick="document.getElementById('id03').style.display='block'" style="display: none;">Odjavi se</button>
                </div>
            </div>
        </nav>
    </header>

    <!-- modul 1 -->
    <div id="id01" class="modal">

        <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                <h2>Login</h2>
            </div>

            <div class="container">
                <label for="email"><b>E mail:</b></label>
                <input type="email" placeholder="Unesi email" name="emailp" required>

                <label for="psw"><b>Password: </b></label>
                <input type="password" placeholder="Unesi sifru" name="passwordp" required>

                <input id="prijava" type="submit" name="prijava" value="Prijavi se" />
            </div>
            <?php echo $prijavaErr; ?>
        </form>
    </div>

    <!-- modul 2 -->
    <div id="id02" class="modal">

        <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                <h2>Register</h2>
            </div>

            <div class="container">
                <label for="email"><b>E mail:</b></label>
                <input type="email" placeholder="Unesi email" name="email" required><?php echo $mejlErr; ?>

                <label for="psw"><b>Password: </b></label>
                <input type="password" placeholder="Unesi sifru" name="password" required> <?php echo $pswErr; ?>

                <label for="psw"><b>Ponovi password: </b></label>
                <input type="password" placeholder="Ponovi sifru" name="password1" required> <?php echo $pswErr; ?>

                <label for="psw"><b>Ime: </b></label>
                <input type="text" placeholder="Unesi ime" name="ime" require> <?php echo $imeErr; ?>

                <label for="psw"><b>Prezime: </b></label>
                <input type="text" placeholder="Unesi prezime" name="prezime" require> <?php echo $prezErr; ?>

                <input id="prijava" type="submit" value="Registruj se" name="registracija" />
                <button id="log" onclick="PrijaviSe()">Prijavi se</button>
            </div>
        </form>
    </div>

    <!-- modul 3 -->
    <div id="id03" class="modal">

        <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
                <h2>Odjava</h2>
            </div>

            <div class="container" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <label for="odjaviSe" style="text-align: center;"><b>Da li ste sigurni da zelite da se odjavite?</b></label>
                <input type="submit" name="odjaviSe" value="Odjavi se" id="reg" class="navLogin" >
            </div>
        </form>
    </div>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        /* === registracija === */
        if (isset($_POST['registracija'])) {
            $email = "";
            $psw = "";
            $ime = "";
            $prezime = "";
            $password1 = "";
            /* unos u polja */
            if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password1']) && !empty($_POST['ime']) && !empty($_POST['prezime'])) {

                $email = $_POST['email'];
                $psw = $_POST['password'];
                $password1 = $_POST['password1'];
                $ime = $_POST['ime'];
                $prezime = $_POST['prezime'];

                if ($psw != $password1) {
                    echo "<script>alert('Sifre se ne podudaraju');</script>";
                } else {
                    require './baza/konekcija.php';
                    $sql = "SELECT * FROM korisnik WHERE email = '$email'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) == 0) {
                        
                        $sql = "INSERT INTO korisnik(email, password, ime, prezime) VALUES('$email', '$psw', '$ime', '$prezime')";
                        if (mysqli_query($conn, $sql)) {
                            echo "<script>alert('Polje uneseno u bazu');</script>";
                        } else {
                            echo "<script>alert('Greska pri unosu');</script>";
                        }
                    } else {
                        echo "<script>alert('Kornisk postoji u bazi');</script>";
                    }
                    
                }
            }
        }


        /* === logovanje === */
        if (isset($_POST['prijava'])) {
            require './baza/konekcija.php';
            $email = "";
            $psw = "";
            $ime = "";
            $prezime = "";
            if (!empty($_POST['emailp']) && !empty($_POST['passwordp'])) {
                $email = $_POST['emailp'];
                $psw = $_POST['passwordp'];

                $sql = "SELECT * FROM korisnik WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) != 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        //echo "id: " . $row["email"] . " " . $row["password"]. "<br>";
                        if ($psw == $row['password']) {
                            $_SESSION['ime'] = $row['ime'];
                            $_SESSION['prezime'] = $row['prezime'];
                            echo "<script>
                                alert('Uspesno ulogovan');
                                let prijava = document.querySelector('.navPrijava');
                                let login = document.querySelector('.navLogin');
                                let odjava = document.querySelector('.navOdjava');
                                prijava.style.display = 'none';
                                login.style.display = 'none';
                                odjava.style.display = 'block';
                            </script>";
                            include "./pages/tema.php";
                        } else
                            echo "<script>alert('Pogresna lozinka, pokusajte ponovo!');</script>";
                    }
                } else {
                    echo "<script>alert('Ovaj korisnik ne postoji, registrujte se!');</script>";
                }
            }
        }

        /* === odjava === */
        if(isset($_POST['odjaviSe'])) {
            session_destroy();
            echo "<script>alert('Uspesno ste se odjavili');
            document.querySelector('.navPrijava').style.display = 'block';
            document.querySelector('.navLogin').style.display = 'block';
            document.querySelector('.navOdjava').style.display = 'none';
            </script>";
        }
    }

    ?>

    <section id="home">

    </section>

    <footer>
        <p>&copy; by Vojin Sundovic</p>
    </footer>

    <script src="./script/script.js"></script>

    <!-- JavaScript Bundle with Popper  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>