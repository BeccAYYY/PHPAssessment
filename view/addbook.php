<?php
$root_path = "../";
$page_title = "Add Book";
include "header.php";

if ($sRole !== "Admin" && $sRole !== "User") {
    header("location:../index.php?msg=unauthorised");
}

?>

<main>
    <form action="../controller/addbookcontroller.php">
        <fieldset>
            <legend>Add a New Book</legend>
            <div class="field">
                <label for="Title">Title</label>
                <input type="text" name="Title">
            </div>
            <div class="field">
                <label for="">Author</label>
                AUTHOR DROPDOWN WITH "NEW AUTHOR" BUTTON
            </div>
            <div class="field">
                <label for="PublishedYear">Year Published</label>
                <input type="text" name="PublishedYear">
            </div>
            <div class="field">
                <label for="Image">Cover Photo</label>
                <input type="file" name="Image">
            </div>
            <div class="field">
                <label for="CopiesSold">Copies Sold</label>
                <input type="text" name="CopiesSold">
            </div>
            <div class="field">
                <label for="Summary">Summary</label>
                <textarea name="Summary" cols="30" rows="10"></textarea>
            </div>
            <input type="submit">
        </fieldset>
    </form>
</main>


<?php
include "footer.php";
?>