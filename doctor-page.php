<?php 
    include("./controllers/sessionController.php");
    include("./controllers/doctorPageController.php");
    include("./utils/strings.php");
    if(!$isLoggedIn) {
        header("Location: ./signin-signup.php");
        exit();
    } else if(!$_SESSION['user']->isDoctor) {
        header("Location: ./userpage.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Tag όπου εμφανίζει κείμενο στην καρτέλα του web browser -->
        <title>
            Πλατφόρμα Εμβολιασμού - Υπουργείο Υγείας
        </title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <!-- Modal Που θα εμφανίζεται για την καταχώρηση εμβολιαστικού κέντρου  πηγή: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_modal -->
        <div id="myModal" class="modal">
            <!-- Περιεχόμενο του Modal -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <?php if($vaccinationCenters) { ?>
                <h3 class="col_item">Διαθέσιμα εμβολιαστικά κέντρα</h3>
                <select class="col_item" name="forma" onchange="location = this.value;">
                    <option value="?">Επιλέξτε εμβολιαστικό κέντρο</option>
                <?php foreach($vaccinationCenters as $item) { ?> 
                    <option value="?vaccination_center_id=<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                <?php } ?>
                </select>
                <?php } ?>
            </div>
        </div>
        <!--Tag όπου περιέχει τα στοιχεία του header -->
        <header>
            <!--εικόνα μέσα σε λίνκ ώστε να είναι clickable -->
            <a href="index.php"><img src="img/logo.jpg" alt="logo" id="logo"></a>
            <div id="title">
                <!--κεντρικός τίτλος -->
                <h1>Πλατφόρμα Εμβολιασμού</h1>
                <h2>Υπουργείο Υγείας</h2>
            </div>            
            <!--Κουμπί όπου στην Onclick χρησιμοποιεί την location.href η οποία θέτει το url της τρέχουσας σελίδας-->
            <button id="signin_signup" onclick=<?php if($isLoggedIn) { echo "location.href='userpage.php'"; } else { echo "location.href='signin-signup.php'"; } ?>><?php if(!$isLoggedIn) { echo  'Είσοδος / Εγγραφή'; } else { echo 'Σελίδα χρήστη'; }?></button>
        </header> 
        <div class="side">
            <!--Tag όπου περιέχει τα στοιχεία του μενού -->       
            <nav id="nav_li">
                <a href="index.php">Αρχική σελίδα</a>
                <a href="vaccination-centers.php">Κέντρα εμβολιασμού</a>
                <a href="vaccination-instractions.php">Οδηγίες εμβολιασμού</a>
                <a href="signup-signin-instractions.php">Οδηγίες εγγραφής / εισόδου</a>
                <a href="announcements.php">Ανακοινώσεις</a>            
            </nav>
            <!--Tag με το βασικό περιεχόμενο τησ σελίδας --> 
            <main class="col">
            <?php  if($hasError or $hasSucceed) { ?>
                    <p class=<?php if($hasError) echo '"warning"'; else echo '"success"'; ?>><a class='child' id='close' href="?">x</a><?php if($hasError) echo $_ERROR_MESSAGES[$_GET['message']]; else echo $_SUCCESS_MESSAGES[$_GET['message']]?></p>
            <?php  } ?>
            <h3 class="col_item">Προσωπικά στοιχεία Γιατρού</h3>
                <table class="col_table">
                    <tr>
                        <th>Όνομα:</th>
                        <td><?php echo $_SESSION['user']->name; ?></td>
                        <th>ΑΔΤ:</th>
                        <td><?php echo $_SESSION['user']->adt; ?></td>                        
                    </tr>
                    <tr>
                        <th>Επώνυμο:</th>
                        <td><?php echo $_SESSION['user']->surname; ?></td>
                        <th>Φύλο:</th>
                        <td><?php if($_SESSION['user']->sex == 'male') echo 'Άνδρας'; else if($_SESSION['user']->sex == 'female') echo 'Γυναίκα'; ?></td>
                    </tr>
                    <tr>
                        <th>ΑΜΚΑ:</th>
                        <td><?php echo $_SESSION['user']->amka; ?></td>
                        <th>Ηλικία:</th>
                        <td><?php echo $_SESSION['user']->age; ?></td>
                    </tr>
                    <tr>
                        <th>ΑΦΜ:</th>
                        <td><?php echo $_SESSION['user']->afm; ?></td>
                        <th>Κιν. Τηλέφωνο:</th>
                        <td><?php echo $_SESSION['user']->mobile; ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td colspan="3"><?php echo $_SESSION['user']->email; ?></td>
                    </tr>
                    <tr>
                        <th>Εμβολιαστικό κέντρο:</th>
                        <td colspan="3"><?php if($_SESSION['user']->vaccinationCenter == null) echo 'Δεν καταχωρήθηκε'; else echo $_SESSION['user']->vaccinationCenter->name ?></td>
                    </tr>
                </table>
                <!-- action="javascript:handleClick()" -->
                    <section class="side" id="sideHiddenForms">
                        <form class="hidden_forms" name="vaccination_center" action=<?php if($_SESSION['user']->vaccinationCenter == null) echo "javascript:displayModal()"; else echo ""; ?> method="post">                            
                            <input type="hidden" id="action" name="action" value=<?php if($_SESSION['user']->vaccinationCenter != null) echo '"registered"'; ?>>
                            <input class="button" type="submit" value="Καταχωρήστε το εμβολιαστικό κέντρο που εργάζεστε">
                        </form>
                        <form class="hidden_forms" name="scheduled_appointments" action="" method="post">                            
                            <input type="hidden" id="action" name="action" value=<?php if($_SESSION['user']->vaccinationCenter == null) echo '"notRegistered"'; else echo '"scheduledAppointments"'; ?>>
                            <input class="button" type="submit" value="Προγραμματισμένα ραντεβού">
                        </form>
                    </section>                   

                    <form class="hidden_forms" name="sing_out" action="" method="post">                            
                        <input type="hidden" id="action" name="action" value="logout">
                        <input class="button" type="submit" value="Αποσύνδεση χρήστη">
                    </form>
            </main>
        </div>
        <!--Tag όπου περιέχει τα στοιχεία του footer -->  
        <footer>
            <a href="./docs/terms.pdf">Όροι χρήσης</a>
            <div>|</div>
            <a href="./docs/privacy-policy.pdf">Πολιτική προστασίας</a>
        </footer>
        <script src="./js/modal.js"></script>
    </body>
</html>