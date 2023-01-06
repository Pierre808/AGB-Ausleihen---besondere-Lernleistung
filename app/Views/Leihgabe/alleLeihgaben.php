<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/containers.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1>Alle Leihgaben:</h1>

        
        <div class="container-list">
            <?php
                for($i = 0; $i < count(esc($active)); $i++)
                { 
                    $infos = esc($active[$i])
                    ?>

                    <a class="block width100" href="<?= base_url("show-leihgabe/" . $infos['id']) ?>">
                    <div class="container">
                        <div class="pList">
                            <p class="big">Name Schüler: <span class="standart left-margin"><?= $infos['schueler_name'] ?></span></p>
                            <p class="big">Gegenstand: <span class="standart left-margin"><?= $infos['gegenstand_bezeichnung'] ?></span></p>
                            <p class="big">Ausgeliehen am: <span class="standart left-margin"><?= $infos['formated_datum_start'] ?></span></p>
                        </div>
                    </div>
                    </a>
                <?php }
            ?>
        </div>
<?= $this->endSection() ?>