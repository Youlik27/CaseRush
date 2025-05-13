function showModeratorButtons() {
    const buttons = document.querySelectorAll('.moderator-button');
    buttons.forEach(button => button.classList.toggle('hidden'));
}
function showCreateSection() {
    document.getElementById("add_section_form").classList.toggle("hidden");
    document.getElementById("add_button").classList.toggle("hidden");
}
function changeSectionName(id_sections) {
    showModeratorButtons();
    const form = document.getElementById(`change_section_name_form_${id_sections}`);
    form.classList.toggle("hidden");
}
function showAddItemForm() {
    document.getElementById('addItemModal').classList.add('show');
}

function hideAddItemForm() {
    document.getElementById('addItemModal').classList.remove('show');
}
function navigateToCase(event, url) {
    if (event.target.closest('form')) {
        return;
    }
    window.location = url;
}
