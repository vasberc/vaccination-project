<?php 
    include("./controllers/sessionController.php");
    include("./controllers/userPageController.php");
    include("./utils/strings.php");
    if(!$isLoggedIn) {
        header("Location: ./signin-signup.php");
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
            <?php  if($hasError or $hasSucceed) { ?>
                    <p class=<?php if($hasError) echo '"warning"'; else echo '"success"'; ?>><?php if($hasError) echo $_ERROR_MESSAGES[$_GET['message']]; else echo $_SUCCESS_MESSAGES[$_GET['message']]?></p>
            <?php  } ?>
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
                        <td><?php echo $_SESSION['user']->sex; ?></td>
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
                </table>
                    <form class="hiddenForms" name="appointment" action="" method="post">                            
                        <input type="hidden" id="action" name="action" value=<?php if(isset($_SESSION['user']->appointment)) echo '"delete"'; else echo '"create"'; ?>>
                        <input class="button" type="submit" value=<?php if(isset($_SESSION['user']->appointment)) echo '"Ακυρώστε το ραντεβού σας"'; else echo '"Κλείστε το ραντεβού σας"'; ?>>
                    </form>

                    <form class="hiddenForms" name="appointment" action="" method="post">                            
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
    </body>
</html>