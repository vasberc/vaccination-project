//Script που διαχειρίζεται το modal επιλογής εμβολιαστικού κέντρου

//Το στοιχείο myModal περιλαμβάνει και το διαφανές background γύρω από το modal
var modal = document.getElementById("myModal");

//Το στοιχείο που κλείνει το modal
var span = document.getElementsByClassName("closeModal")[0];

//Function που εμφανίζει το modal
function displayModal() {
    modal.style.display = "block";
}

//Click στο span κλείνει το Modal
span.onclick = function() {
    modal.style.display = "none";
}

//Όταν ο χρήστης κάνει κλικ έξω από το modal στο διαφανές background κλείνει το Modal 
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
/**
 * Function Που καλείται στην onchange του drop down,
 * θέτει σε ένα hidden form το value στο id του επιλεγμένου
 * vaccination center και υποβάλει την φόρμα
 */ 
function handleSelected(selectedId) {
    var input = document.getElementById("register_vaccination_center_with_id");
    input.value = selectedId;
    var form = document.getElementById("hidden_modal_form");
    form.submit();
}