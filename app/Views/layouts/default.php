<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <base href="<?= base_url() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STG <?= $this->renderSection("title") ?> </title>
    <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/nav.css') ?>">

    <?= $this->renderSection("headerLinks") ?>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div id="navbar">
        <div id="navTitle">
            <a href="<?= base_url() ?>">
                <h1>AGB - Ausleihen</h1>
            </a>
        </div>

        <div id="navMenu">
            <a onclick="showMenu()">
                <img src="<?= base_url('public/imgs/menu.png') ?>">
            </a>
        </div>
    </div>

    <div id="menu">
        <div class="menu-links">
            <a href="<?= base_url('alle-ausleihen') ?>">Alle Ausleihen anzeigen</a>
                
            <a href="<?= base_url('add-ausleihe') ?>">Neue Ausleihe hinzufügen</a>
        </div>
    </div>



    <script>
        function showMenu() {
            var navMenu = document.getElementById("navMenu");
            var menu = document.getElementById("menu");


            if (navMenu.classList.contains("rotate")) {
                navMenu.classList.remove("rotate");
                menu.style.top = "-100vh";
                document.body.style.overflow = "auto"
            } 
            else {
                navMenu.classList.add("rotate");
                menu.style.top = "10vh";
                document.body.style.overflow = "hidden"
            }
        }

    </script>
    

    <?= $this->renderSection("content") ?>

</body>
</html>
