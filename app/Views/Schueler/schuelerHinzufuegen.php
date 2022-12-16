<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/containers.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/forms.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1 id="title">Schüler registrieren:</h1>

        <div class="box-container">
            <h2>Schüler Daten</h2>

            <div class="box-container-top">
            <?= form_open('add-schueler/' . esc($schuelerId)) ?>
                <?php
                    if(!empty(session()->getFlashData('fail')))
                    {
                    ?>
                        <div class="alert">
                            <?= session()->getFlashData('fail') ?>
                        </div>
                    <?php
                    }
                ?>

                <label for="id"><b>Schüler ID</b></label>
                <span class="text-danger"><?= isset($validation) ? '<br>' . display_form_errors($validation, 'id') : '' ?></span>
                <?php 
                    $data = [
                        'name'      => 'id',
                        'value'     => esc($schuelerId),
                        'disabled'     => 'true',
                    ];
                    echo form_input($data);
                ?>

                <label for="name"><b>Name</b></label>
                <span class="text-danger"><?= isset($validation) ? '<br>' . display_form_errors($validation, 'name') : '' ?></span>
                <?= form_input('name', set_value('name'), ['placeholder'=>'Namen eingeben'], 'text') ?>
                
                <label for="mail"><b>Mail</b></label>
                <span class="text-danger"><?= isset($validation) ? '<br>' . display_form_errors($validation, 'mail') : '' ?></span>
                <?= form_input('mail', set_value('mail'), ['placeholder'=>'Mail eingeben'], 'text') ?>
                
                <input type="submit" value="Hinzufügen"/>
            <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>