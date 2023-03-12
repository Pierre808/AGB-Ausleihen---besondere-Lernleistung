<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/containers.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/warning.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/buttons.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1>Schnellzugriff:</h1>
        <div class="buttonlist">
            <button onclick="location.href='<?= base_url('select-method') ?>'">Gegenstand verleihen</button>
            <button onclick="location.href='<?= base_url('gegenstand-zurueckgeben') ?>'">Gegenstand zurückgeben</button>
            <button onclick="location.href='<?= base_url('schuelerdaten-anzeigen') ?>'">Schülerdaten anzeigen</button>
        </div>

        <h1>Überfällige Leihgaben:</h1>
        <div class="containers-list">
            <?php 
            if(count(esc($leihgaben)) != 0)
            {
                for($i = 0; $i < count(esc($leihgaben)); $i++)
                { ?>
                    <a href="<?= base_url('show-leihgabe/' . esc($leihgaben[$i]['id'])) ?>">
                        <div class="container">
                            <p><span  class="big">Name Schüler: </span><?= esc($leihgaben[$i]['schueler_name']) ?></p>
                            <p><span  class="big">Gegenstand: </span><?= esc($leihgaben[$i]['gegenstand_bezeichnung']) ?></p>
                            <p><span  class="big">Überfällig seit: </span><?= esc($leihgaben[$i]['formated_datum_ende']) ?></p>
                        </div>
                    </a>
                <?php }
            }
            else
            { ?>
                <div class="warning warning-green">
                    <p>
                        Keine überfälligen Leihgaben.
                    </p>
                </div>
            <?php }
            ?>
        </div>
    </div>
<?= $this->endSection() ?>