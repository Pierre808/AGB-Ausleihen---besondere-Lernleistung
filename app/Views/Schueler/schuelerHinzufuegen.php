<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/containers.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/forms.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/spancolors.css') ?>">
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
                <?php 
                    $data = [
                        'name'      => 'id',
                        'value'     => esc($schuelerId),
                        'disabled'     => 'true',
                    ];
                    echo form_input($data);
                ?>

                <label for="name"><b>Name <span class="red">*</span></b></label>
                <?php 
                if(null != esc($errors) && array_key_exists('name', esc($errors)))
                {
                    echo("<br><p class='red'>" . esc($errors['name']) . "</p>");
                }
                ?>
                <span class="text-danger"><?= isset($validation) ? '<br>' . display_form_errors($validation, 'name') : '' ?></span>
                <?= form_input('name', set_value('name'), ['placeholder'=>'Namen eingeben'], 'text') ?>
                
                <label for="mail"><b>Mail</b></label>
                
                <?php 
                if(null != esc($errors) && array_key_exists('mail', esc($errors)))
                {
                    echo("<br><p class='red'>" . esc($errors['mail']) . "</p>");
                }
                ?>
                <?= form_input('mail', set_value('mail'), ['placeholder'=>'Mail eingeben'], 'text') ?>
                
                <input type="submit" value="Hinzufügen"/>
            <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>