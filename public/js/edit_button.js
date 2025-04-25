const editButton = document.getElementById('editButton');
const saveButton = document.getElementById('saveButton');
const formFields = document.querySelectorAll('#profileForm input');

// Function to enable editing of fields
editButton.addEventListener('click', function() {
    formFields.forEach(field => {
        field.disabled = false;  // Enable input fields
    });
    saveButton.disabled = false; // Enable the save button
    editButton.disabled = true; // Disable the edit button after clicking
});
