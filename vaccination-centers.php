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
                <a class="current" href="vaccination-centers.php">Κέντρα εμβολιασμού</a>
                <a href="vaccination-instractions.php">Οδηγίες εμβολιασμού</a>
                <a href="signup-signin-instractions.php">Οδηγίες εγγραφής / εισόδου</a>
                <a href="announcements.php">Ανακοινώσεις</a> 
            </nav>
            <!--Tag με το βασικό περιεχόμενο τησ σελίδας --> 
            <main class="side">
                <section>
                    <h1>Εμβολιαστικό κέντρο Αθήνας</h1>
                    <address>
                        <p><span class="text-titles">Διεύθυνση: </span>Εβεργέτου Γιάβαση, Αγία Παρασκευή</p>
                        <p><span class="text-titles">Τ.Κ.: </span>15342</p>
                        <p><span class="text-titles">Τηλέφωνο: </span>210210210210</p>
                    </address>
                    <iframe width="500" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Evergetou%20Giavasi,%20Ag.%20Paraskevi%20153%2042&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </section>
                <section>
                    <h1>Εμβολιαστικό κέντρο Θεσσαλονίκης</h1>
                    <address>
                        <p><span class="text-titles">Διεύθυνση: </span>Εγνατία 144</p>
                        <p><span class="text-titles">Τ.Κ.: </span>54622</p>
                        <p><span class="text-titles">Τηλέφωνο: </span>23102310231</p>
                    </address>
                    <iframe width="500" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=thessaloniki%20kamara&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>                        
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