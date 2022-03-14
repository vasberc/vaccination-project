//Συνάρτηση που ελέγχει τα πεδία της φόρμας
function validateForm(form) {
    let myForm = document.forms[form]//Παίρνει την φόρμα ανάλογα το όρισμα
    let isCorrect = true //Αρχικά θεωρούμε ότι δεν έχει κάποιο σφάλμα στις τιμές

    //Για κάθε πεδία κάνε έλεγχο και ανανέωσε την τιμή σφάλματος
    for(element of myForm.elements){
        //Το γενικό σφάλμα θα ελεγχθεί με βάση την τρέχουσα τιμή του
        isCorrect = validateField(element, isCorrect, form)
    }

    //επέστρεψε αν υπήρχε σφάλμα γενικά
    return isCorrect;
}

//Ελέγχει ένα πεδίο και επιστρέφει την τρέχουσα τιμή σφάλματος αν δεν βρει σφάλμα ή αλλιώς false
//Με αυτόν τον τρόπο αποφεύγουμε την περίπτωση να προηγείται ένα πεδία με σφάλμα και μετά ένα πεδίο
//χωρίς σφάλμα να αλλάξει το γενικό isCorrect σε true και να υποβληθεί η φόρμα ενώ έχουμε σφάλματα
function validateField(field, currentIsCorrect, form) {
    let isCorrect = currentIsCorrect//Αρχική τιμή γίνεται η τρέχουσα τιμή σφάλματος
    let string = "" //Το μήνυμα που θα εμφανιστεί στο πεδίο σφάλματος, αρχικά κενό

    //Έλεγχος σε σχέση με το id του πεδίου
    switch (field.id) {

        // Πεδίο ΑΜΚΑ:
        //Υλοποίηση του html validation: pattern="[0-9]+" maxlength="11" required
        //Το οποίο υπήρχε στην προηγούμενη εργασία για το πεδίο ΑΜΚΑ
        case 'amka':
        case 'amka1' :
            //Αντί το required
            if(field.value == "") {
                string = "Παρακαλώ συμπληρώστε το ΑΜΚΑ"
                isCorrect = false
            //Αντί οτ maxlength, βελτίωση και έλεγχος να είναι πάντα 11
            } else if (field.value.length != 11) {
                string = "Το ΑΜΚΑ πρέπει να είναι 11 χαρακτήρες,</br>παρακαλώ συμπληρώστε το ξανά"
                isCorrect = false
            //Αντί το pattern που ζητούσε αριθμούς
            //Η λογική είναι ότι αν είναι αριθμός και τον πολλαπλασιάσουμε με 1 η js τον κάνει αυτόματα cast σε number,
            //έτσι με την isNaN(is not a number) η οποία επιστρέφει true αν δεν είναι number μπορούμε να ελέγξουμε το πεδίο
            } else if (isNaN(field.value * 1)) {
                string = "Το ΑΜΚΑ πρέπει να αποτελείται από αριθμούς"
                isCorrect = false
            }
            //Τέλος εισάγουμε το μήνυμα σφάλματος στο κατάλληλο html element
            document.getElementById(form+"AmkaError").innerHTML = string
            break;

        // Πεδίο ΑΦΜ:
        //Ίδια ακριβώς λογική για το ΑΦΜ με html validation: pattern="[0-9]+" maxlength="9" required
        case 'afm' :
        case 'afm1' :
            if(field.value == "") {
                string = "Παρακαλώ συμπληρώστε το ΑΦΜ"
                isCorrect = false
            } else if (field.value.length != 9) {
                string = "Το ΑΦΜ πρέπει να είναι 9 χαρακτήρες,</br>παρακαλώ συμπληρώστε το ξανά"
                isCorrect = false
            } else if (isNaN(field.value * 1)) {
                string = "Το ΑΦΜ πρέπει να αποτελείται από αριθμούς"
                isCorrect = false
            }

            document.getElementById(form+"AfmError").innerHTML = string

            break;
        // Πεδίο Όνομα:
        //Ίδια ακριβώς λογική με html validation: required
        case 'name' :
            if(field.value == "") {
                string = "Παρακαλώ συμπληρώστε το όνομά σας"
                isCorrect = false
            }

            document.getElementById(form+"NameError").innerHTML = string//signUpFormNameError signUpFormNameError

            break;

        // Πεδίο Επώνυμο:
        //Ίδια ακριβώς λογική με html validation: required
        case 'surname' :
            if(field.value == "") {
                string = "Παρακαλώ συμπληρώστε το επώνυμό σας"
                isCorrect = false
            }

            document.getElementById(form+"SurnameError").innerHTML = string

            break;

        // Πεδίο Ηλικία:
        //Ίδια ακριβώς λογική με html validation: required
        case 'adt' :
            if(field.value == "") {
                string = "Παρακαλώ συμπληρώστε τον αριθμό της ταυτότητάς σας"
                isCorrect = false
            }
            
            document.getElementById(form+"AdtError").innerHTML = string

            break;

        // Πεδίο Ηλικία:
        //Ίδια ακριβώς λογική με html validation: pattern="[0-9]+" min="18" max="150" required
        case 'age' :
            if(field.value == "") {
                string = "Παρακαλώ συμπληρώστε την ηλικία σας"
                isCorrect = false
            } else if (isNaN(field.value * 1)) {
                string = "Η ηλικία σας πρέπει να αποτελείται από αριθμούς"
                isCorrect = false
            } else if (field.value < 18 || field.value > 150) {
                string = "Το επιτρεπτό όριο ηλικίας είναι από 18 έως 150"
                isCorrect = false
            }

            document.getElementById(form+"AgeError").innerHTML = string

            break;

        // Πεδίο email:
        //Εδώ ζητείται αν εισαχθεί να περιέχει το @
        case 'email' :
            if(field.value.length > 0 && field.value.indexOf('@') == -1) {
                string = "Παρακαλώ συμπληρώστε σωστά το email σας"
                isCorrect = false
            }

            document.getElementById(form+"ΕmailError").innerHTML = string

            break;
        
        // Πεδίο Κινητό τηλέφωνο:
        //Ίδια ακριβώς λογική με το ΑΜΚΑ με html validation: pattern="[0-9]+" maxlength="10" minlength="10" required
        case 'mobile' :

            if(field.value == "") {
                string = "Παρακαλώ συμπληρώστε το κινητό σας τηλέφωνο"
                isCorrect = false
            } else if (field.value.length != 10) {
                string = "Το κινητό τηλέφωνο πρέπει να είναι 10</br>χαρακτήρες, παρακαλώ συμπληρώστε το ξανά"
                isCorrect = false
            } else if (isNaN(field.value * 1)) {
                string = "Το κινητό τηλέφωνο πρέπει να αποτελείται από αριθμούς"
                isCorrect = false
            }

            document.getElementById(form+"MobileError").innerHTML = string

            break;

        // Πεδίο Ρόλος:
        //Ίδια ακριβώς λογική με html validation: required
        case 'role' :

            if(field.value == "") {
                string = "Παρακαλώ επιλέξτε ρόλο"
                isCorrect = false
            }

            document.getElementById(form+"RoleError").innerHTML = string

            break;

    }

    return isCorrect
}