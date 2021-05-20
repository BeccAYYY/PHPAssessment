<?php
$root_path = "../";
$page_title = "Add Author";
include "header.php";
?>

<main>
    <form action="../controller/addauthorcontroller.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Add a New Author</legend>
            <div class="field">
                <label for="Name">Name</label>
                <input type="text" name="Name">
            </div>
            <div class="field">
                <label for="BirthYear">Birth Year</label>
                <input type="number" name="BirthYear">
            </div>
            <div class="field">
                <label for="DeathYear">Death Year</label>
                <label for="Alive">Still Living?</label>
                <input type="Checkbox" id="Alive" checked>
                <input type="number" name="DeathYear" id="DeathYear" value="">
            </div>
            <div class="field">
                <label for="Bio">Bio</label>
                <textarea name="Bio" id="Bio" cols="30" rows="10"></textarea>
            </div>
            <div class="field">
                <input type="file" name="ImagePath">
            </div>
            <input type="submit" value="Create">
        </fieldset>
    </form>
</main>


<?php
include "footer.php";
?>