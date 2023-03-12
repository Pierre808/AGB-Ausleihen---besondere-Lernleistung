<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/waiting.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/warning.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/buttons.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1 id="title">Leihgabe erstellen:</h1>

        <div class="buttonlist-vertical">
            <button onclick="location.href='<?= base_url('add-leihgabe/') ?>'" class="button100 buttonhundred">Schüler mit Schülerausweis registrieren</button>
            
            <h3>oder: </h3>

            <button onclick="location.href='<?= base_url('add-temp-schueler/') ?>'" class="button100 buttonhundred">Schüler temporär ohne Schülerausweis registrieren</button>
        </div>
        <div class="warning">
            <p>
                Diese Funktion soll nur als Übergangslösung verwendet werden (beispielsweise, wenn der/die Schüler*in keinen Schülerausweis mit sich hat).
                <br> Es sollte möglichst zeitnah der Schülerausweis nachgereicht werden, damit dieser dem Schüler zugeordnet werden kann. 
            </p>
        </div>
    </div>
<?= $this->endSection() ?>