function dismiss(e) {
    e.style = "display: none;";
}
function exitEditForm() {

    document.getElementById("edit-box").style = "display: none;";
    document.getElementById("edit-overlay").style = "display: none;";

    if (document.getElementById("username-edit-form")) {
        document.getElementById("username-edit-form").reset();
    } if (document.getElementById("name-edit-form")) {
        document.getElementById("name-edit-form").reset();
    } if (document.getElementById("role-edit-form")) {
        document.getElementById("role-edit-form").reset();
    } if (document.getElementById("password-edit-form")) {  
        document.getElementById("password-edit-form").reset();
    } if (document.getElementById("username-edit")) {    
        document.getElementById("username-edit").style = "display: none;";
    } if (document.getElementById("name-edit")) {    
        document.getElementById("name-edit").style = "display: none;";
    } if (document.getElementById("role-edit")) {    
        document.getElementById("role-edit").style = "display: none;";
    } if (document.getElementById("password-edit")) {    
        document.getElementById("password-edit").style = "display: none;";
    } if (document.getElementById("delete-confirm")) {
        document.getElementById("delete-confirm").style = "display: none;";
    } if (document.getElementById("birth-edit")) {
        document.getElementById("birth-edit").style = "display: none;"
    } if (document.getElementById("image-edit")) {
        document.getElementById("image-edit").style = "display: none;"
    } if (document.getElementById("bio-edit")) {
        document.getElementById("bio-edit").style = "display: none;"
    } if (document.getElementById("title-edit")) {
        document.getElementById("title-edit").style = "display: none;"
    } if (document.getElementById("author-edit")) {
        document.getElementById("author-edit").style = "display: none;"
    } if (document.getElementById("published-edit")) {
        document.getElementById("published-edit").style = "display: none;"
    } if (document.getElementById("sold-edit")) {
        document.getElementById("sold-edit").style = "display: none;"
    } if (document.getElementById("summary-edit")) {
        document.getElementById("summary-edit").style = "display: none;"
    }
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
    } else if (e.id == "birth-div") {
        document.getElementById("birth-edit").style = "display: block;"
    } else if (e.id == "image-div") {
        document.getElementById("image-edit").style = "display: block;"
    } else if (e.id == "bio-div") {
        document.getElementById("bio-edit").style = "display: block;"
    } else if (e.id == "title-div") {
        document.getElementById("title-edit").style = "display: block;"
    } else if (e.id == "author-div") {
        document.getElementById("author-edit").style = "display: block;"
    } else if (e.id == "published-div") {
        document.getElementById("published-edit").style = "display: block;"
    } else if (e.id == "sold-div") {
        document.getElementById("sold-edit").style = "display: block;"
    } else if (e.id == "summary-div") {
        document.getElementById("summary-edit").style = "display: block;"
    }
}

function bookFormSelector() {
    if (document.getElementById("select-option").selected) {
        document.getElementById("book-form").style = "display: none;";
        document.getElementById("author-form").style = "display: none;";
    } else if (document.getElementById("new-option").selected) {
        document.getElementById("book-form").style = "display: none;";
        document.getElementById("author-form").style = "display: block;";
    } else {
        document.getElementById("book-form").style = "display: block;";
        document.getElementById("author-form").style = "display: none;";
    }
}

if (document.getElementById("select-option")) {
    bookFormSelector();
}