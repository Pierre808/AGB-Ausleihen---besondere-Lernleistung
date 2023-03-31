<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <base href="<?= base_url() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGB Leihgaben-Verwaltung <?= $this->renderSection("title") ?> </title>
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
                <h1>AGB Leihgaben-Verwaltung</h1>
            </a>
        </div>

        <div id="navMenu">
            <a onclick="showMenu()">
                <img src="<?= base_url('public/imgs/menu.png') ?>">
            </a>
        </div>
    </div>

    <div id="menu">
        <div id="closeBtn" class="close">
            <img src="<?= base_url("public/imgs/close.png") ?>" onclick="hideMenu()"/>
        </div>

        <div class="menu-links">
            <a href="<?= base_url() ?>">
                <div id="home" class="menu-link <?php if(esc($menuName) == "home"){echo("active");} ?>">
                    <img src="<?= base_url("public/imgs/home.png") ?>"/>
                    <p>Start Seite</p>
                </div>
            </a>

            <a href="<?= base_url("all-leihgabe") ?>">
                <div class="menu-link <?php if(esc($menuName) == "leihgaben"){echo("active");} ?>">
                    <img src="<?= base_url("public/imgs/leihgaben3.png") ?>"/>
                    <p>Alle Leihgaben</p>
                </div>
            </a>

            <a href="<?= base_url("all-schueler") ?>">
                <div class="menu-link <?php if(esc($menuName) == "schueler"){echo("active");} ?>">
                    <img src="<?= base_url("public/imgs/account.png") ?>"/>
                    <p>Registrierte Schüler</p>
                </div>
            <a>

            <a href="<?= base_url("all-gegenstande") ?>">
                <div class="menu-link <?php if(esc($menuName) == "gegenstande"){echo("active");} ?>">
                    <img src="<?= base_url("public/imgs/gegenstand.png") ?>"/>
                    <p>Registrierte Gegenstände</p>
                </div>
            <a>

            
            <div id="addBtn" class="menu-link <?php if(esc($menuName) == "add"){echo("active");} ?>" 
            onclick="calcMenu()">
                <img src="<?= base_url("public/imgs/add.png") ?>"/>
                <p>Hinzufügen</p>
            </div>

            <div id="ausleiheBtn" class="subordered <?php if(esc($menuName) == "add"){
                if(esc($menuTextName) == "leihgabe"){
                    echo("active-text");
                }
            } ?>">
                <a href="<?= base_url("select-method") ?>">    
                    <p>Leihgabe erstellen</p>
                </a>        
            </div>
            
            <div id="gegenstandBtn" class="subordered <?php if(esc($menuName) == "add"){
                if(esc($menuTextName) == "gegenstand"){
                    echo("active-text");
                }
            } ?>">
                <a href="<?= base_url("add-gegenstand") ?>">
                    <p>Gegenstand hinzufügen</p>
                </a>
            </div>
        </div>
        
        <div class="menu-footer">
            <p>Ein Programm von Pierre Equit - Pierre.equit@gmail.com</p>
        </div>
    </div>



    <script>
        var closeBtn = document.getElementById("closeBtn");

        var navMenu = document.getElementById("navMenu");
        var menu = document.getElementById("menu");

        
        var addBtn = document.getElementById("addBtn");
        var ausleiheBtn = document.getElementById("ausleiheBtn");
        var gegenstandBtn = document.getElementById("gegenstandBtn");
        var lastActive = "home";

        async function showMenu() {
            menu.style.display = "block";
            navMenu.classList.add("rotate");

            await new Promise(resolve => setTimeout(resolve, 50));

            menu.style.top = "0vh";
            document.body.style.overflow = "hidden"

            <?php if(esc($menuName) == "add"){
            ?>
                showAddLinks();
            <?php
            } ?>
        }

        async function hideMenu() {
            closeBtn.classList.add("rotate");

            await new Promise(resolve => setTimeout(resolve, 100));

            menu.style.top = "-100vh";
            document.body.style.overflow = "auto"

            hideAddLinks();
            
            await new Promise(resolve => setTimeout(resolve, 700));

            menu.style.display = "none";

            closeBtn.classList.remove("rotate");
            navMenu.classList.remove("rotate");
        }

        function calcMenu(){
            if(ausleiheBtn.style.display == "block"){
                hideAddLinks();
            }
            else{
                showAddLinks();
            }
        }

        function showAddLinks() {

            //addBtn.classList.add("active");
            ausleiheBtn.style.display = "block";
            gegenstandBtn.style.display = "block";
        }

        function hideAddLinks() {
            //addBtn.classList.remove("active");
            ausleiheBtn.style.display = "none";
            gegenstandBtn.style.display = "none";
        }
    </script>
    

    <?= $this->renderSection("content") ?>

</body>
</html>

