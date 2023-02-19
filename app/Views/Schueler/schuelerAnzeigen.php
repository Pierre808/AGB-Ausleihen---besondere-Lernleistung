<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/containers.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/forms.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/warning.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1>Schüler:</h1>

        <div class="container-list">
            <div class="container">
                <p><span  class="big">Name: </span><?= esc($schueler['name']) ?></p>
                <p><span  class="big">Mail: </span><?php 
                    if($schueler['mail'] == "")
                    {
                        echo("/");
                    }
                    else
                    {
                        echo($schueler['mail']);
                    }
                ?></p>
                <p><span  class="big">Schueler-Id: </span><?= esc($schueler['schueler_id']) ?></p>
            </div>

        </div>
<?= $this->endSection() ?>