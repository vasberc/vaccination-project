<?php 
    include("./controllers/sessionController.php");
    include("./controllers/signinSignupController.php");
    include("./utils/strings.php");
    if($isLoggedIn) {
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
            <!--Tag με το βασικό περιεχόμενο της σελίδας --> 
            <main class="singcol">               
            <?php  if($hasError) { ?>
                    <p class="warning"><a class='child' id='close' href="?">x</a><?php echo $_ERROR_MESSAGES[$_GET['message']]; ?></p>
            <?php  } ?>
                    
                
                
                <div class="side">
                    <section>
                        <h1>Είσοδος χρήστη</h1>
                        <!-- Στην φόρμα προστέθηκε το χαρακτηριστικό onsubmtit, το οποίο όταν επιστρέψει 
                        τιμή true μόνο αφήνει να προχωρήσει η υποβολή της φόρμας -->
                    <form name="loginForm" action="" onsubmit="return validateForm('loginForm')" method="post">
                            <div class="field">
                                <label for="amka">A.M.K.A.*:</label>
                                <input type="text" id="amka" name="amka" placeholder="Eισαγάγετε το ΑΜΚΑ σας">                            
                            </div>
                            <!-- Σε κάθε πεδίο που θέλουμε validation προστέθηκε ένα άδειο span 
                            για να υποδεχθεί το μήνυμα σε περίπτωση λάθους -->
                            <span id="loginFormAmkaError" class="error"></span>
                            <div class="field">
                                <label for="afm">Α.Φ.Μ.*:</label>
                                <input type="text" id="afm" name="afm" placeholder="Eισαγάγετε το Αφμ σας" >                            
                            </div>
                            <span id="loginFormAfmError" class="error"></span>
                            
                            <input type="submit" value="Υποβολή">
                        </form>
                        
                    </section>
                    <section>
                        <h1>Εγγραφή χρήστη</h1>
                        <form name="signUpForm" action="" onsubmit="return validateForm('signUpForm')" method="post">
                            <div class="field">
                                <label for="name">Όνομα*:</label>
                                <input type="text" id="name" name="name" placeholder="Eισαγάγετε το Όνομά σας"><br>
                            </div>
                            <span id="signUpFormNameError" class="error"></span>

                            <div class="field">
                                <label for="surname">Επώνυμο*:</label>
                                <input type="text" id="surname" name="surname" placeholder="Eισαγάγετε το Επώνυμό σας"><br>
                            </div>
                            <span id="signUpFormSurnameError" class="error"></span>
                            <div class="field">
                                <label for="amka1">A.M.K.A.*:</label>
                                <input type="text" id="amka1" name="amka1" placeholder="Eισαγάγετε το ΑΜΚΑ σας"><br>
                            </div>
                            <span id="signUpFormAmkaError" class="error"></span>
                            <div class="field">
                                <label for="afm1">Α.Φ.Μ.*:</label>
                                <input type="text" id="afm1" name="afm1" placeholder="Eισαγάγετε το Αφμ σας"><br>
                            </div>
                            <span id="signUpFormAfmError" class="error"></span>
                            <div class="field">
                                <label for="adt">Αριθ. ταυτότητας*:</label>
                                <input type="text" id="adt" name="adt" placeholder="Eισαγάγετε τον αριθμό ταυτότητάς σας"><br>
                            </div>
                            <span id="signUpFormAdtError" class="error"></span>
                            <div class="field">
                                <label for="age">Ηλικία*:</label>
                                <input type="text" id="age" name="age" placeholder="Eισαγάγετε την ηλικία σας"  width="100px"><br>
                            </div>
                            <span id="signUpFormAgeError" class="error"></span>
                            <div class="field">
                                <label >Φύλλο:</label>                            
                                <label for="male">
                                    <input type="radio" id="male" name="sex" value="male">
                                    Άνδρας</label>                            
                                <label for="female">
                                    <input type="radio" id="female" name="sex" value="female">
                                    Γυναίκα</label>  
                            </div>
                            <div class="field">
                                <label for="email">Email:</label>
                                <input type="text" id="email" name="email" placeholder="Eισαγάγετε το email σας" ><br>
                            </div>
                            <span id="signUpFormΕmailError" class="error"></span>

                            <div class="field">
                                <label for="mobile">Κινητό τηλέφωνο*:</label>
                                <input type="text" id="mobile" name="mobile" placeholder="Eισαγάγετε το κινητό σας"><br>
                            </div> 
                            <span id="signUpFormMobileError" class="error"></span>
                            <div class="field select">
                                <label for="role">Ρόλος*:</label>
                                <select name="role" id="role" >
                                    <option value=""></option>
                                    <option value="civilian">Πολίτης</option>
                                    <option value="doctor">Γιατρός</option>
                                </select>
                            </div>  
                            <span id="signUpFormRoleError" class="error"></span>
                            <input type="submit" value="Υποβολή">
                        </form>
                    
                    </section>                      
                </div>
                  
            </main>
        </div>
        <!--Tag όπου περιέχει τα στοιχεία του footer -->  
        <footer>
            <a href="./docs/terms.pdf">Όροι χρήσης</a>
            <div>|</div>
            <a href="./docs/privacy-policy.pdf">Πολιτική προστασίας</a>
        </footer>

        <script src="./js/scripts.js"></script>
    </body>
</html>