<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/main.css">
    <title><?= $title ?></title>
</head>
<body>
    <header>
        <nav>
            <h1>CINEMA</h1>
            <ul class="ul-nav">
                <li class="li-nav"><a href="index.php?action=Accueil">ACCUEIL</a></li>
                <li class="li-nav"><a href="index.php?action=listMovie">LISTE FILMS</a></li>
                <li class="li-nav"><a href="index.php?action=listActors">LISTE ACTEURS</a></li>
                <li class="li-nav"><a href="index.php?action=listProducers">LISTE PRODUCTEURS</a></li>
                <li class="li-nav"><a href="index.php?action=listGenres">LISTE GENRES</a></li>
                <li class="li-nav"><a href="index.php?action=listRoles">LISTE ROLES</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>
        <span>GitHub</span>
    </footer>
</body>
</html>