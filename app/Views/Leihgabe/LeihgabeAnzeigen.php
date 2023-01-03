<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/containers.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/spancolors.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1>Infos zu der Leihgabe:</h1>

        <!--TODO: database data-->
        <!--TODO: container links-->

        <div class="container-list">
            <div class="container">
                <h2>Schüler</h2>
                <div class="pList">
                    <p class="big">Name: <span class="standart left-margin">/</span></p>
                    <p class="big">Mail: <span class="standart left-margin">/</span></p>
                    <p class="big">Schüler-Id: <span class="standart left-margin">asdfjklö</span></p>
                </div>
            </div>

            <div class="container">
                <h2>Gegenstand</h2>
                <div class="pList">
                    <p class="big">Bezeichnung: <span class="standart left-margin">asdfasdf</span></p>
                    <p class="big">Id: <span class="standart left-margin">jklöjklö</span></p>
                </div>
            </div>

            <div class="container">
                <h2>Leihgabe</h2>
                <div class="pList">
                    <p class="big">Ausgeliehen am: <span class="standart left-margin">01.01.0001</span></p>
                    <p class="big">Ausgeliehen bis: <span class="standart left-margin">01.01.0001</span></p>
                    <p class="big">Zurückgegeben: <span class="standart left-margin red">Nein</span></p>
                    <p class="big">Ausgeliehen bei: <span class="standart left-margin">adsfjklö</span></p>
                </div>
            </div>
        </div>

<?= $this->endSection() ?>