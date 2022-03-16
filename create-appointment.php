<?php 
    include("./controllers/sessionController.php");
    include("./controllers/createAppointmentController.php");
    include("./utils/strings.php");

    //Σε περίπτωση που κάποιος χρήστης πατήσει το λινκ της σελίδας ενώ για κάποια από τις παρακάτω περιπτώσεις θα γίνεται redirect
    if(!$isLoggedIn) {
        header("Location: ./signin-signup.php");
    } else if($_SESSION['user']->age < 40 or $_SESSION['user']->age > 65) {
        header("Location: ./userpage.php");
    } else if($_SESSION['user']->appointment != null) {
        header("Location: ./userpage.php");
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
        <!--Tag όπου περιέχει τα στοιχεία του header -->
        <header>
            <!--εικόνα μέσα σε λίνκ ώστε να είναι clicable -->
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
            <?php if($vaccinationCenters) { ?>
                <h3 class="col_item"><?php if($selectedVaccinationCenter) echo $selectedVaccinationCenter->name; else echo "Διαθέσιμα εμβολιαστικά κέντρα"; ?></h3>
                <select class="col_item" name="forma" onchange="location = this.value;">
                    <option value="?">Επιλέξτε εμβολιαστικό κέντρο</option>
                <?php foreach($vaccinationCenters as $item) { ?> 
                    <option value="?vaccination_center_id=<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                <?php } ?>
                </select>
                <?php if($selectedVaccinationCenter != false) { ?>
                <table class="col_table">
                    <tr>
                        <th>Διεύθυνση:</th>
                        <td><?php echo $selectedVaccinationCenter->address; ?></td>                                         
                    </tr>
                    <tr>
                        <th>Ταχυδρομικός Κωδικός:</th>
                        <td><?php echo $selectedVaccinationCenter->postCode; ?></td>
                    </tr>
                    <tr>
                        <th>Τηλέφωνο:</th>
                        <td><?php echo $selectedVaccinationCenter->telephoneNumber; ?></td>
                    </tr>                    
                </table>
                <h3 class="col_item"><?php if($reservedAppointments != false && count($reservedAppointments) == 6) echo "Λυπόμαστε δεν υπάρχουν διαθέσιμα ραντεβού την τρέχουσα περίοδο"; else echo "Επιλέξτε ένα από τα διαθέσιμα ραντεβού"; ?></h3>
                    <?php if($reservedAppointments == false or ($reservedAppointments != false && count($reservedAppointments) < 6)) { ?>
                <table class="col_table">
                    <tr>
                        <th>Ώρα\Ημ/νία</th>
                        <th>01/04/2022</th>
                        <th>02/04/2022</th>                           
                    </tr>
                    <tr>
                        <th>08:00</th>
                        <td class="timeslot"><?php if($slotOneAvailable != false) { ?><a class="slot link_slot" href="?vaccination_center_id=<?php echo $item->id; ?>&timeslot=1">Επιλογή</a><?php } else echo '<a class="slot">Μη διαθέσιμο</a>'; ?></td>
                        <td class="timeslot"><?php if($slotFourAvailable != false) { ?><a class="slot link_slot" href="?vaccination_center_id=<?php echo $item->id; ?>&timeslot=4">Επιλογή</a><?php } else echo '<a class="slot">Μη διαθέσιμο</a>'; ?></td>
                    </tr>
                    <tr>
                        <th>09:00</th>
                        <td class="timeslot"><?php if($slotTwoAvailable != false) { ?><a class="slot link_slot" href="?vaccination_center_id=<?php echo $item->id; ?>&timeslot=2">Επιλογή</a><?php } else echo '<a class="slot ">Μη διαθέσιμο</a>'; ?></td>
                        <td class="timeslot"><?php if($slotFiveAvailable != false) { ?><a class="slot link_slot" href="?vaccination_center_id=<?php echo $item->id; ?>&timeslot=5">Επιλογή</a><?php } else echo '<a class="slot">Μη διαθέσιμο</a>'; ?></td>
                    </tr>    
                    <tr>
                        <th>10:00</th>
                        <td class="timeslot"><?php if($slotThreeAvailable != false) { ?><a class="slot link_slot" href="?vaccination_center_id=<?php echo $item->id; ?>&timeslot=3">Επιλογή</a><?php } else echo '<a class="slot">Μη διαθέσιμο</a>'; ?></td>
                        <td class="timeslot"><?php if($slotSixAvailable != false) { ?><a class="slot link_slot" href="?vaccination_center_id=<?php echo $item->id; ?>&timeslot=6">Επιλογή</a><?php } else echo '<a class="slot">Μη διαθέσιμο</a>'; ?></td>
                    </tr>                    
                </table>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
                
            </main>
        </div>
        <!--Tag όπου περιέχει τα στοιχεία του footer -->  
        <footer>
            <a href="./docs/terms.pdf">Όροι χρήσης</a>
            <div>|</div>
            <a href="./docs/privacy-policy.pdf">Πολιτική προστασίας</a>
        </footer>
    </body>
</html>