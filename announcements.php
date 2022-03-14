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
                <a href="vaccination-instractions.php">Οδηγίες εμβολιασμού</a>
                <a href="signup-signin-instractions.php">Οδηγίες εγγραφής / εισόδου</a>
                <a class="current" href="announcements.php">Ανακοινώσεις</a> 
            </nav>
            <!--Tag με το βασικό περιεχόμενο τησ σελίδας --> 
            <main class="col">
                <h1>Ανακοινώσεις</h1>
                <section class="col block">
                    <h3>31/01/2022</h3>
                    <h2><a href="./announcements/announcement1.php">Ανακοίνωση 1</a></h2>
                    <p>Περίληψη ανακοίνωσης, αυτή είναι η περίληψη της ανακ...</p>
                </section>
                <section class="col block">
                    <h3>30/01/2022</h3>
                    <h2><a href="./announcements/announcement2.php">Ανακοίνωση 2</a></h2>
                    <p>Περίληψη ανακοίνωσης, αυτή είναι η περίληψη της ανακ...</p>
                </section>
                <section class="col block">
                    <h3>29/01/2022</h3>
                    <h2><a href="./announcements/announcement3.php">Ανακοίνωση 3</a></h2>
                    <p>Περίληψη ανακοίνωσης, αυτή είναι η περίληψη της ανακ...</p>
                </section>    
                <section class="col block">
                    <h3>28/01/2022</h3>
                    <h2><a href="">Ανακοίνωση 4</a></h2>
                    <p>Περίληψη ανακοίνωσης, αυτή είναι η περίληψη της ανακ...</p>
                </section>
                <section class="col block">
                    <h3>27/01/2022</h3>
                    <h2><a href="">Ανακοίνωση 5</a></h2>
                    <p>Περίληψη ανακοίνωσης, αυτή είναι η περίληψη της ανακ...</p>
                </section>
                <section class="col block">
                    <h3>26/01/2022</h3>
                    <h2><a href="">Ανακοίνωση 6</a></h2>
                    <p>Περίληψη ανακοίνωσης, αυτή είναι η περίληψη της ανακ...</p>
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