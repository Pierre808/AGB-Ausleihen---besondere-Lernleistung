<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/waiting.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/warning.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1 id="title">Schüler registrieren:</h1>

    </div>
<?= $this->endSection() ?>