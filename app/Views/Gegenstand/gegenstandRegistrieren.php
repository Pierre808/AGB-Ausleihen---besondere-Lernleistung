<?= $this->extend("layouts/default") ?>

<?= $this->section("title")?> | <?= esc($page_title) ?> <?= $this->endSection() ?>


<?= $this->section("headerLinks")?> 
<link rel="stylesheet" href="<?= base_url('public/css/waiting.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/warning.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/forms.css') ?>">
<?= $this->endSection() ?>


<?= $this->section("content") ?>
    <div id="main">
        <h1>Gegenstand registrieren:</h1>
        
        <div class="warning ">
            <p>
                Um einen Barcode scannen zu können, wird ein Barcode-reader benötigt, welcher sich im A-Turm Keller befindet.
            </p>
        </div>

        
        <div id="gegenstandAlreadyRegisteredDiv">
            
        </div>
        
        <div class="waiting-success-cointainer">
            <div id="loading-box">
                <h2>Jetzt Gegenstand mit Barcode-reader einscannen</h2>
                <div class="loader">
                    <span class="loader-element"></span>
                    <span class="loader-element"></span>
                    <span class="loader-element"></span>
                </div>
            </div>

            <div id="success-animation">
                
            </div>
        </div>

        <script>

        <?php
        if(esc($gegenstandId))
        {
            echo('console.log("not false")');
            if(esc($gegenstand) == null && esc($wrongprefix) == false)
            {
                ?>

                success();

                async function success()
                {
                    var success = document.getElementById("success-animation");
                    var loading = document.getElementById("loading-box");

                    loading.style.display = "none";

                    success.innerHTML += 
                    '<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" /> <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" /> </svg>';
                    
                    
                    await new Promise(resolve => setTimeout(resolve, 1800));

                    window.location.href = "<?= esc($redirect) ?>"
                }

                <?php
            }
            else
            {
                ?>

                fail();

                async function fail()
                {
                    var success = document.getElementById("success-animation");
                    var loading = document.getElementById("loading-box");
                    var alreadyDiv = document.getElementById("gegenstandAlreadyRegisteredDiv");


                    loading.style.display = "none";

                    success.innerHTML += 
                    '<div class="fail-container"> <div class="circle-border"></div> <div class="circle"> <div class="error"></div> </div> </div>';
                    
                    
                    await new Promise(resolve => setTimeout(resolve, 500));

                    <?php
                    if(esc($wrongprefix))
                    {
                    ?>
                        alreadyDiv.innerHTML = 
                        '<p> Der Barcode entspricht nicht den Voraussetzungen eines Gegenstandes. <br> <a href="<?= base_url("add-gegenstand") ?>"> erneut scannen </a> </p> <img src="<?= base_url('public/imgs/warning_white.png') ?>"/>';
                    <?php
                    }
                    else
                    {
                    ?>
                        alreadyDiv.innerHTML = 
                        '<p> Der Gegenstand ist bereits registriert. <br> <a href="<?= base_url("add-gegenstand") ?>"> erneut scannen </a> oder <a href="<?= base_url("show-gegenstand/" . esc($gegenstandId)) ?>"> Gegenstand anzeigen </a> </p> <img src="<?= base_url('public/imgs/warning_white.png') ?>"/>';
                    <?php
                    }
                    ?>
                        
                    alreadyDiv.classList.add("warning");
                    alreadyDiv.classList.add("warning-with-img");
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
                
                if(currentCode == code && currentCode != " ") {
                    console.log("finished code: " + code);

                    var bezeichnung = document.getElementsByTagName("input")[0].value;


                    window.location.href = "<?= base_url("add-gegenstand/") ?>/" + code + "/" + bezeichnung;
                }
            }

            <?php
            }
        ?>
    </script>
<?= $this->endSection() ?>