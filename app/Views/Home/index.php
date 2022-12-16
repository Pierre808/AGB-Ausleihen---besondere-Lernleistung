<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/containers.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1>Überfällige Leihgaben:</h1>

        <div class="containers-list">
            <div class="container">
                <p><span  class="big">Name Schüler: </span> Max Mustermann</p>
                <p><span  class="big">Gegenstand: </span> Kamera</p>
                <p><span  class="big">Überfällig seit: </span> 12.11.2022</p>
            </div>
            
        </div>
    </div>
<?= $this->endSection() ?>