<?php 
    include("./controllers/sessionController.php");    

    //Σε περίπτωση που κάποιος χρήστης πατήσει το λινκ της σελίδας ενώ για κάποια από τις παρακάτω περιπτώσεις θα γίνεται redirect
    if(!$isLoggedIn) {
        header("Location: ./signin-signup.php");
        exit();
    } else if($_SESSION['user']->isDoctor == false) {
        header("Location: ./userpage.php");
        exit();
    } else if($_SESSION['user']->vaccinationCenter == null) {
        header("Location: ./doctor-page.php");
        exit();
    }
    
    include("./controllers/scheduledAppointmentsController.php");
    include("./utils/strings.php");
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
            <button id="signin_signup" 
                    onclick=<?php   /**
                                     *Εάν έχει γίνει login ανάλογα τον ρόλο, το κουμπί να οδηγεί στην σελίδα του χρήστη
                                     *αλλιώς οδηγεί στην σελίδα με τις φόρμες εισόδου και εγγραφής
                                     */
                                    if($isLoggedIn) {
                                        if(!$_SESSION['user']->isDoctor) 
                                            echo "location.href='userpage.php'"; 
                                        else 
                                            echo "location.href='doctor-page.php'"; 
                                    } else { 
                                        echo "location.href='signin-signup.php'"; 
                                    } 
                            ?>
                ><?php if(!$isLoggedIn) { echo  'Είσοδος / Εγγραφή'; } else { echo 'Σελίδα χρήστη'; }?>
            </button>
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
            <!-- Ελεγχος για την εμφάνιση error message ή success message  -->
<?php       if($hasError or $hasSucceed) { ?>
                <p class=<?php if($hasError) echo '"warning"'; else echo '"success"'; ?>><a class='child' id='close' href="?">x</a><?php if($hasError) echo $_ERROR_MESSAGES[$_GET['message']]; else echo $_SUCCESS_MESSAGES[$_GET['message']]?></p>
<?php       } ?>
                <h3 class="col_item">Προγραμματισμένα Ραντεβού στο <?php echo $_SESSION['user']->vaccinationCenter->name; ?></h3> 
                
<?php       /**
             * Εάν υπάρχουν προγραμματισμένα ραντεβού για το εμβολιαστικό κέντρο που εργάζεται ο Γιατρός
             * θα εμφανιστεί πίνακας με τα ραντεβού, στο πεδίο κατάσταση υπάρχει drop down που στην 
             * αρχική του εμφάνιση δείχνει την παρούσα κατάσταση του ραντεβού και με αλλαγή στην
             * τιμή του αλλάζει και την κατάσταση του ραντεβού στην βάση δεδομένων 
             */
            if($scheduledAppointments) { ?>
                <table class="col_table" id="appointments_table">
                    <tr>
                        <th>Κωδικός ραντεβού</th>
                        <th>Ονοματεπώνυμο πολίτη</th>
                        <th>Ημερομηνία</th>
                        <th>Ώρα</th>
                        <th>Κατάσταση</th>
                    </tr>
<?php           foreach($scheduledAppointments as $item) { 
                    $user = $dbManager->getUserFromDbById($item->user); ?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $user->surname." ".$user->name; ?></td>
                        <td><?php echo date("d-m-Y", strtotime($item->date)); ?></td>
                        <td><?php echo date("H:i", strtotime($item->time)); ?></td>
                        <td class=<?php if($item->completed) echo "row_completed"; else echo "row_incomplete" ?>>
                            <select name="forma" onchange="location = this.value;">
                                <option value="?"><?php if($item->completed) echo "Ολοκληρώθηκε"; else echo "Μη ολοκληρωμένο" ?></option>
                                <option value=<?php if($item->completed) echo "\"?appointment_id=$item->id&completed=".!$item->completed."\""; else echo "\"?appointment_id=$item->id&completed=".!$item->completed."\""; ?>><?php if($item->completed) echo "Μη ολοκληρωμένο"; else echo "Ολοκληρώθηκε" ?></option>
                            </select>
                        </td>
                    </tr>
<?php           } ?>
                </table>
<?php            } else { ?>
                <P class="warning">Δεν υπάρχουν προγραμματισμένα ραντεβού, για το διάστημα 1/4/2022-2/4/2022</p>
<?php       } ?> 
                <form class="hidden_forms" name="back" action="./doctor-page.php">
                    <input class="button" type="submit" value="Πίσω">
                </form>
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