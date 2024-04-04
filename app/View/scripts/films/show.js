let deleteButton = document.getElementById('delete');
let cancelButton = document.getElementById('cancel-deletion');
let deleteForm = document.getElementById('delete-form-container');

deleteButton.addEventListener('click', showConfirmation);
cancelButton.addEventListener('click', hideConfirmation);


function showConfirmation(){
    deleteForm.style.display = "flex";
    deleteButton.style.display = "none"
}
function hideConfirmation(){
    deleteForm.style.display = "none";
    deleteButton.style.display = "block"
}