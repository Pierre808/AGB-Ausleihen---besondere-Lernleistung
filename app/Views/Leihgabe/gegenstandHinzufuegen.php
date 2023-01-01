<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/waiting.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/warning.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/forms.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1 id="title">Leihgabe erstellen:</h1>

        <!--<div class="warning ">
            <p>
                Um einen Gegenstand einscannen zu können wird ebebfalls ein Barcode-reader benötigt.
            </p>
        </div>-->

        <?= form_open() ?>
            <label for="id"><b>Schüler ID</b></label>
            <?php 
                $data = [
                    'name'      => 'id',
                    'value'     => esc($schuelerId),
                    'disabled'     => 'true',
                ];
                echo form_input($data);
            ?>

            <label for="name"><b>Name</b></label>
            <?php 
                $data = [
                    'name'      => 'name',
                    'value'     => esc($schuelerName),
                    'disabled'     => 'true',
                ];
                echo form_input($data);
            ?>
            
            <label for="mail"><b>Mail</b></label>
            <?php 
                $data = [
                    'name'      => 'mail',
                    'value'     => esc($schuelerMail),
                    'disabled'     => 'true',
                ];
                echo form_input($data);
            ?>
        <?= form_close() ?>
        
        <div id="gegenstandNotFoundDiv">
            
        </div>
        
        <div class="waiting-success-cointainer">
            <div id="loading-box">
                <h2>Gegenstand mit Barcode-reader einscannen</h2>
                <div class="loader">
                    <span class="loader-element"></span>
                    <span class="loader-element"></span>
                    <span class="loader-element"></span>
                </div>
            </div>

            <div id="success-animation">
                
            </div>
        </div>

        
    </div>

    <script>

        <?php
        if(esc($gegenstandId))
        {
            echo('console.log("not false")');
            if(esc($gegenstand) != null && esc($alreadyInDb) == false)
            {
                ?>

                var success = document.getElementById("success-animation");
                var loading = document.getElementById("loading-box");

                loading.style.display = "none";

                success.innerHTML += 
                '<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" /> <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" /> </svg>';
                
                <?php
                //await new Promise(resolve => setTimeout(resolve, 1800));
            }
            else
            {
                ?>

                fail();

                async function fail()
                {
                    var success = document.getElementById("success-animation");
                    var loading = document.getElementById("loading-box");
                    var notFoundDiv = document.getElementById("gegenstandNotFoundDiv");


                    loading.style.display = "none";

                    success.innerHTML += 
                    '<div class="fail-container"> <div class="circle-border"></div> <div class="circle"> <div class="error"></div> </div> </div>';
                    
                    
                    await new Promise(resolve => setTimeout(resolve, 500));

                    <?php 
                    if(esc($alreadyInDb))
                    { 
                    ?>
                        notFoundDiv.innerHTML = 
                        '<p> Der Schüler leiht diesen Gegenstand bereits aus <br> <a href="<?= base_url('add-gegenstand-to-leihgabe/' . esc($schuelerId)) ?>">erneut scannen</a> </p> <img src="<?= base_url('public/imgs/warning_white.png') ?>"/>';
                    <?php 
                    }
                    else
                    { 
                    ?>
                        notFoundDiv.innerHTML = 
                        '<p> Der Gegenstand ist nicht im System registriert <br> <a href="<?= base_url('add-gegenstand') ?>">Gegenstand registrieren</a> oder <br> <a href="<?= base_url('add-gegenstand-to-leihgabe/' . esc($schuelerId)) ?>">erneut scannen</a> </p> <img src="<?= base_url('public/imgs/warning_white.png') ?>"/>';
                    <?php 
                    } 
                    ?>
                    
                    notFoundDiv.classList.add("warning");
                    notFoundDiv.classList.add("warning-with-img");
                }

                <?php
            }
        }
        else
        {
            ?>

            let code = '';
            document.addEventListener("keydown", e => {
                if(e.key != "Shift" && e.key != "Enter" && e.key != "Control") {
                    code = code + e.key;
                    console.log("code: " + code);

                    codeScanned();
                }
            });

            /**
             * prueft, ob Barcode zuende eingegeben ist bzw. keine Eingabe mehr folgt
             * (500 ms keine Eingabe)
             */
            async function codeScanned() {
                var currentCode = code;

                await new Promise(resolve => setTimeout(resolve, 500));
                
                if(currentCode == code) {
                    console.log("finished code: " + code);

                    

                    window.location.href = "<?= base_url("add-gegenstand-to-leihgabe/" . esc($schuelerId)) ?>/" + code;
                }
            }

            <?php
            }
        ?>
    </script>
<?= $this->endSection() ?>