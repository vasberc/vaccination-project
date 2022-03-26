<?php 
    include("./controllers/sessionController.php");
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
                <a class="current" href="signup-signin-instractions.php">Οδηγίες εγγραφής / εισόδου</a>
                <a href="announcements.php">Ανακοινώσεις</a>            
            </nav>
            <!--Tag με το βασικό περιεχόμενο τησ σελίδας --> 
            <main class="col">
                <section>
                    <h1>Οδηγίες εγγραφής στην πλατφόρμα</h1>
                    <p class="clarification">Πολίτες κάτω των 18 ετών θα μπορούν να κλείνουν ραντεβού, την περίοδο που θα τους επιτραπεί, από τον λογαριασμό των κηδεμόνων τους</p>
                    <p>Η εγγραφές στην πλατφόρμα, είναι ανοικτές για πολίτες ηλικίας από 18 ετών και πάνω. Επισημαίνεται ότι μπορεί να γίνει εγγραφή, ανεξάρτητα από την ηλικιακή ομάδα που εμβολιάζεται την τρέχουσα περίοδο.</p>
                    <p>Τα στοιχεία που πρέπει να συμπληρώσετε για την εγγραφή σας στην πλατφόρμα είναι τα παρακάτω:</p>
                    <ul>
                        <li>Όνομα (υποχρεωτικό)</li>
                        <li>Επώνυμο (υποχρεωτικό)</li>
                        <li>Α.Μ.Κ.Α. (υποχρεωτικό)</li>
                        <li>Α.Φ.Μ. (υποχρεωτικό)</li>
                        <li>Αριθμός ταυτότητας (υποχρεωτικό)</li>
                        <li>Ηλικία (υποχρεωτικό)</li>
                        <li>Φύλο</li>
                        <li>Email</li>
                        <li>Κινητό τηλέφωνο (υποχρεωτικό)</li>
                    </ul>
                </section> 
                <section>
                    <h1>Οδηγίες εισόδου στην πλατφόρμα</h1>
                    <p>Μετά την επιτυχή εγγραφή σας στην πλατφόρμα, θα έχετε δυνατότητα εισόδου πατώντας στο κουμπί είσοδος και συμπληρώνοντας τα στοιχεία:</p>
                    <ul>
                        <li>Α.Μ.Κ.Α. (υποχρεωτικό)</li>
                        <li>Α.Φ.Μ. (υποχρεωτικό)</li>
                    </ul>
                    <button id="signin_signup" 
                            onclick=<?php   if($isLoggedIn) {
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
                </section>               
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