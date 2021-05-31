function dismiss(e) {
    e.style = "display: none;";
}
function exitEditForm() {
    document.getElementById("username-edit-form").reset();
    document.getElementById("name-edit-form").reset();
    document.getElementById("role-edit-form").reset();
    document.getElementById("password-edit-form").reset();
    document.getElementById("edit-box").style = "display: none;";
    document.getElementById("username-edit").style = "display: none;";
    document.getElementById("name-edit").style = "display: none;";
    document.getElementById("role-edit").style = "display: none;";
    document.getElementById("password-edit").style = "display: none;";
    document.getElementById("delete-confirm").style = "display: none;";
    document.getElementById("edit-overlay").style = "display: none;";
}

function editBox(e) {
    document.getElementById("edit-overlay").style = "display: block;";
    document.getElementById("edit-box").style = "display: block;";
    if (e.id == "username-div") {
        document.getElementById("username-edit").style = "display: block;"
    } else if (e.id == "name-div") {
        document.getElementById("name-edit").style = "display: block;"
    } else if (e.id == "role-div") {
        document.getElementById("role-edit").style = "display: block;"
    } else if (e.id == "password-btn") {
        document.getElementById("password-edit").style = "display: block;"
    } else if (e.id == "delete-btn") {
        document.getElementById("delete-confirm").style = "display: block;"
    }
}