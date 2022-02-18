<?php

require_once('fonction/fonction.php');

if (!isset($arrayMot)) {
    $arrayMot = file("mots.txt");
    $nombreDeMot =  count($arrayMot) - 1;
}

if (isset($_GET["leMot"])) {

    if (!isset($arrayMot[1])) {
        $msg = "Le jeu doit contenir 1 mot";
        header("Refresh:5; url=admin.php");
    } else {

        $key = strip_tags(htmlspecialchars($_GET["leMot"]));

        unset($arrayMot[$key]);
        file_put_contents("mots.txt", $arrayMot);
        header("location: admin.php");
    }
}

if (isset($_POST["newMot"])) {

    $Nouveaumot =htmlspecialchars($_POST["newMot"]);

    $newMot = deleteSpecialChar(strtolower($Nouveaumot));


    if (strlen($_POST["newMot"]) >= 20) {
        $msg = "Votre mot doit faire moins de 20 caractères";
    } 
    foreach (trimTab($arrayMot) as $key => $mot) { // ça marche pas idk

        if ($mot == $newMot) {

            $msg = "Le mot n'est pas disponible";
        }
    }

    if (!isset($msg)) {

        $fichierMot = fopen('mots.txt', 'a+');
        fputs($fichierMot, $newMot . "\n");
        $goodMsg = "Votre mot a bien ete enregistre";
    }
    header("Refresh:5; url=admin.php");
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/pendu.css">
</head>

<body>
    <header>

    </header>
    <main>

        <section class="container">
            <article>
                <h1>Entre un nouveau mot !</h1>

                <form action="" method="POST">
                    <label for="newMot">Voulez vous ajouter un nouveau mot ? (<i>caractère spéciaux et les nombres sont interdit</i>)</label>
                    <input type="text" id="newMot" name="newMot">
                    <input class="btn btn-primary" type="submit" name="enoyer" value="envoyer">

                </form>
                <a class="btn btn-primary" href="index.php">Retourner jouer !</a>

                <h2 class="pb-3">Listes des mots</h2>
                <?php
                if (isset($msg)) { ?>
                    <span class="alert alert-danger ">
                        <?php

                        echo $msg;

                        ?>
                    </span>
                <?php
                } else if (isset($goodMsg)) {
                ?>
                    <span class="alert alert-success">
                        <?php
                        echo $goodMsg;
                        ?>
                    </span>
                <?php
                }
                ?>

                <ul class="pt-3">
                    <?php
                    foreach ($arrayMot as $key => $mot) {


                    ?>

                        <li>Numéro : <?= $key . " " . $mot ?></li>

                        <a class="btn btn-danger" href="./admin.php?leMot=<?= $key ?>">supprimer</a>
                    <?php
                    }
                    ?>

                    <ul>

            </article>
        </section>
    </main>
    <footer>

    </footer>
</body>

</html>