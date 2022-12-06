<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/waiting.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/warning.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1 id="title">Ausleihe erstellen:</h1>

        <div class="warning mobile-only">
            <p>
                Bitte öffne diese Seite an dem Rechner im A-Turm Keller und scanne den 
                Schülerausweis des Schülers ein.
            </p>
        </div>
        
        <div class="waiting-success-cointainer">
            <div id="loading-box">
                <h2>Schülerausweis mit Barcode-reader einscannen</h2>
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
            
            if(currentCode == code) {
                console.log("finished code: " + code);
                code = '';

                var success = document.getElementById("success-animation");
                var loading = document.getElementById("loading-box");

                loading.style.display = "none";

                success.innerHTML += 
                '<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" /> <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" /> </svg>';

                await new Promise(resolve => setTimeout(resolve, 1800));

                window.location.href = "<?= base_url("") ?>";
            }
        }

    </script>
<?= $this->endSection() ?>