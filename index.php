<?php
session_start();

require_once('fonction/fonction.php');
if (isset($_POST["reset"])) {
    session_destroy();
    header("location: index.php");
}


if (!isset($_SESSION["mot"]) || $_SESSION["nbError"] === 7) {
    if (isset($_SESSION["nbError"]) && $_SESSION["nbError"] === 7) {
        session_destroy();
        header("location: index.php");
    }
    
    $arrayMot = file("mots.txt");
    $nombreDeMot =  count($arrayMot)-1 ;

   
    $numrand = rand(0, $nombreDeMot);
    $_SESSION["mot"] = $arrayMot[$numrand];
}

$alphabet = "abcdefghijklmnopqrstuvwxyz";
$_SESSION["motAffiche"] = "";
$_SESSION["tiret"] = "-";
$_SESSION["nbError"] = 0;


$nombreDeLettre = strlen($_SESSION["mot"]);
for ($i =0; $i < $nombreDeLettre -2 ; $i++)
    $_SESSION["motAffiche"][$i] = $_SESSION["tiret"] ;

if (isset($_GET["a"]) && strlen($_GET["a"]) == 1 && strpos($alphabet, $_GET["a"]) !== false) {
    $char = "";
    $char = htmlspecialchars($_GET["a"]);
    if (!isset($_SESSION["history"]) && empty($_SESSION["history"])) {
        $_SESSION["history"]  = $char;
    } 
    else {
        $_SESSION["history"] .= $char;
    }

    $found = false;
    for ($j = 0; $j < strlen($_SESSION["history"]); $j++) {
        for ($i = 0; $i < strlen($_SESSION['mot']); $i++) {
            if ($_SESSION['mot'][$i] == $_SESSION["history"][$j] && $_SESSION["mot"] !== $_SESSION["motAffiche"]) {
                $_SESSION['motAffiche'][$i] = $_SESSION["history"][$j];
                if ($_SESSION["mot"][$i] == $char) {
                    $found = true;
                   
                    if ($_SESSION["motAffiche"] !== $_SESSION["mot"]) {
                        $msg = "Bravo , '$char' est dans le mot";
                    } else {
                        $msg = "Tu as gagné bravo";
                    }
                }
            }
        }
    }
    if (!$found) {

        if (!isset($_SESSION["error"]) && empty($_SESSION["error"])) {
            $_SESSION["error"] = $char;
            $msg = "Désolé , '$char' n'est pas dans le mot";
        } 
        else {
            $_SESSION['error'] .= $char;
            $msg = "Désolé , '$char' n'est pas dans le mot";
        }
    }
}
if (isset($_SESSION["error"]))
    $_SESSION["nbError"] = strlen($_SESSION["error"]);

// si la partie est finit
if ($_SESSION["nbError"] === 7)
    $msg = "Vous avez perdu!!! Rejouez ?";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu du pendu</title>

    <link rel="stylesheet" href="index.css">
</head>

<body>
    <header>
    <h1>HANGMAN</h1>
    <a class="addWord" href="admin.php">Ajouter un mot</a>
    </header>
        
    <main class='principal'>

       
            
            <article>
                <?php if (isset($msg)) {
                    echo $msg;
                } else {
                    echo "Essaye de gagner !";
                }
                ?>
                <img src="asset/image/<?= $_SESSION['nbError'].".png"?>"> 
                <h1 class="jeu"><?= $_SESSION["motAffiche"] ?></h1>

                
                
                <div>
                    <?php
                    //Affichage de l'alphabet si la partie n'est pas finis 
                    if ($_SESSION["nbError"] <= 6 && $_SESSION['mot'] !== $_SESSION['motAffiche']) {

                        for ($i = 0; $i < strlen($alphabet); $i++) {

                            if (isset($_SESSION['history']) && strpos($_SESSION['history'], $alphabet[$i]) === false) {

                                echo " <a class='alphabet' href='index.php?a=$alphabet[$i]'>$alphabet[$i]</a> ";
                            } else if (!isset($_SESSION["history"])) {

                                echo " <a class='alphabet' href='index.php?a=$alphabet[$i]'>$alphabet[$i]</a> ";
                            }
                        }
                    }
                    ?>
                </div>

                <form action="" method="POST">

                    <input class="newGame" type="submit" name="reset" value="Nouvelle partie">
                </form>

                
            </article>
   
    </main>
    <footer>
            <a href="https://github.com/damien-verschaere/pendu">GITHUB</a>
    </footer>
</body>

</html>