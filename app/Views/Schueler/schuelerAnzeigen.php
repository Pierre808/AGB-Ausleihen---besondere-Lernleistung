<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/containers.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/forms.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/warning.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1>Schüler: <?= esc($schueler['name']) ?></h1>

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
            
            <div class=container>
                <h2>Bearbeiten</h2>
                <div class="pList">
                    <p class="big">Name:</p>
                    <?= form_open('show-schueler/'.esc($schueler['schueler_id'])) ?>
                        <?= form_input('name', esc($schueler['name']), ['placeholder'=>esc($schueler['name']), 'id'=>'inputNoMargin'], 'text') ?>
                        <input id="smallInputBtn" type="submit" value="Speichern"/>
                    <?= form_close() ?>

                    <br>
                    
                    <p class="big">Schueler-Id:</p>
                    <button onclick="location.href='<?= base_url('edit-schueler/' . esc($schueler['schueler_id'])) ?>'">Neuen Schülerausweis zuweisen</button>
                </div>
            </div>
        </div>
<?= $this->endSection() ?>