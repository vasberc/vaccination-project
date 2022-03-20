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
        </header> 
        <div class="side">
            <!--Tag όπου περιέχει τα στοιχεία του μενού -->       
            <nav id="nav_li">
                <a class="current" href="index.php">Αρχική σελίδα</a>
                <a href="vaccination-centers.php">Κέντρα εμβολιασμού</a>
                <a href="vaccination-instractions.php">Οδηγίες εμβολιασμού</a>
                <a href="signup-signin-instractions.php">Οδηγίες εγγραφής / εισόδου</a>
                <a href="announcements.php">Ανακοινώσεις</a>            
            </nav>
            <!--Tag με το βασικό περιεχόμενο τησ σελίδας --> 
            <main>
                <h1>Τελευταίες Ανακοινώσεις</h1>
                <h3>31/01/2022</h3>
                <h2><a href="./announcements/announcement1.php">Ανακοίνωση 1</a></h2>
                <h3>30/01/2022</h3>
                <h2><a href="./announcements/announcement2.php">Ανακοίνωση 2</a></h2>
                <h3>29/01/2022</h3>
                <h2><a href="./announcements/announcement3.php">Ανακοίνωση 3</a></h2>
                <button id="announcements-btn" onclick="location.href='announcements.php'">ΔΕΙΤΕ ΟΛΕΣ ΤΙΣ ΑΝΑΚΟΙΝΩΣΕΙΣ</button>
                <h1>Εκστρατεία Εμβολιασμού</h1>
                <p>Ο εμβολιασμός προστατεύει τα άτομα που έχουν εμβολιαστεί και τους γύρω τους που είναι ευάλωτοι στις ασθένειες, μειώνοντας τον κίνδυνο εξάπλωσης ασθενειών μεταξύ των μελών της οικογένειας, των συμμαθητών ή των συναδέλφων, των φίλων, των γειτόνων και άλλων ατόμων της κοινότητας.

                    Όταν μεγάλο μέρος του πληθυσμού έχει αποκτήσει ανοσία σε μια λοιμώδη νόσο, τότε είναι μάλλον απίθανο να εξαπλωθεί η νόσος από άτομο σε άτομο. Αυτό είναι γνωστό ως «συλλογική ανοσία» (επίσης γνωστή ως «ανοσία της αγέλης»).</p>
                
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