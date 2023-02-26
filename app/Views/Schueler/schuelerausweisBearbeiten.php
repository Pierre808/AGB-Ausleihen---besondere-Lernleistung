<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/waiting.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/warning.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/forms.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1 id="title">Neuen Schülerausweis zuweisen:</h1>

        <div class="warning ">
            <p>
                Um einen Schülerausweis zu scannen wird ein Barcode-reader benötigt. <br>
                Öffne diese Seite an dem Rechner im A-Turm Keller und scanne den 
                Schülerausweis des Schülers ein.
                <!--Bitte öffne diese Seite an dem Rechner im A-Turm Keller und scanne den 
                Schülerausweis des Schülers ein.-->
            </p>
        </div>
        
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
            console.log('<?=getenv('SCHUELER_PREFIX')?>');
            if(currentCode == code) {
                console.log("finished code: " + code);

                window.location.href = "<?= base_url("edit-schueler/" . esc($schuelerId)) ?>/" + code;
            }
        }

        <?php 
            if(esc($newId) != false)
            {
                if(esc($error == ""))
                {
                    echo("success()");
                }
                else
                {
                    echo("fail()");
                }
            }
        ?>

        async function success()
        {
            var success = document.getElementById("success-animation");
            var loading = document.getElementById("loading-box");

            loading.style.display = "none";

            success.innerHTML += 
                '<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" /> <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" /> </svg>';

            await new Promise(resolve => setTimeout(resolve, 1000));

            window.location.href = "<?= base_url("show-schueler/" . esc($newId)) ?>/" + code;
        }

        async function fail()
        {
            var success = document.getElementById("success-animation");
            var loading = document.getElementById("loading-box");
            var notFoundDiv = document.getElementById("gegenstandNotFoundDiv");


            loading.style.display = "none";

            success.innerHTML += 
            '<div class="fail-container"> <div class="circle-border"></div> <div class="circle"> <div class="error"></div> </div> </div>';
            
            
            await new Promise(resolve => setTimeout(resolve, 500));

            notFoundDiv.innerHTML = "<p><?= esc($error) ?> <br> <a href='<?= base_url("edit-schueler/" . esc($schuelerId)) ?>'>erneut scannen</a> </p> <img src='<?= base_url("public/imgs/warning_white.png") ?>'/>";

            notFoundDiv.classList.add("warning");
            notFoundDiv.classList.add("warning-with-img");
        }

    </script>
<?= $this->endSection() ?>