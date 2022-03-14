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
            <button id="signin_signup" onclick=<?php if($isLoggedIn) { echo "location.href='userpage.php'"; } else { echo "location.href='signin-signup.php'"; } ?>><?php if(!$isLoggedIn) { echo  'Είσοδος / Εγγραφή'; } else { echo 'Σελίδα χρήστη'; }?></button>
        </header> 
        <div class="side">
            <!--Tag όπου περιέχει τα στοιχεία του μενού -->       
            <nav id="nav_li">
                <a href="index.php">Αρχική σελίδα</a>
                <a href="vaccination-centers.php">Κέντρα εμβολιασμού</a>
                <a class="current" href="vaccination-instractions.php">Οδηγίες εμβολιασμού</a>
                <a href="signup-signin-instractions.php">Οδηγίες εγγραφής / εισόδου</a>
                <a href="announcements.php">Ανακοινώσεις</a> 
            </nav>
            <!--Tag με το βασικό περιεχόμενο τησ σελίδας --> 
            <main class="col">
                <h1>Οδηγίες Εμβολιασμού</h1>
                <p class="clarification">Διευκρινίζεται ότι ο εμβολιασμός, την τρέχουσα χρονική περίοδο επιτρέπεται μόνο σε πολίτες μεταξύ 40 και 65 ετών</p>
                <p>Για να κλείσετε ραντεβού για εμβολιασμό πρέπει να ακολουθήσετε τα παρακάτω βήματα:</p>
                <ol>
                    <li>Εγγραφή στην πλατφόρμα (για την οποία δεν είναι απαραίτητο ο χρήστης να ανήκει στην παραπάνω ηλικιακή ομάδα)</li>
                    <li>Είσοδος στην πλατφόρμα (με βάση τα στοιχεία που εισήχθησαν κατά την εγγραφή)</li>
                    <li>Επιλογής ημερομηνίας, ώρας και Εμβολιαστικού Κέντρου (βάση των διαθέσιμων ραντεβού) εφόσον ανήκει στην ηλικιακή ομάδα 40 έως 65 ετών</li>
                </ol>
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