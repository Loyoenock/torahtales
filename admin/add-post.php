<?php
include 'partials/header.php'
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Post</h2>
        <div class="alert__message error">
            <p>This is an error message</p>
        </div>
        <form action="" enctype="multipart/form-data">
            <input type="text" placeholder="Title">
            <select>
                <option value="1">Travel</option>
                <option value="2">Art</option>
                <option value="3">Travel</option>
                <option value="4">Sci & tech</option>
            </select>
            <textarea rows="10" placeholder="Body"></textarea>
            <div class="form__control inline">

                <input type="checkbox" id="is__featured" checked>
                <label for="is__featured">Featured</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" id="thumbnail">
            </div>
            <button class="btn" type="submit"> Add Post </button>
        </form>
    </div>
</section>


<?php
include '../partials/footer.php'
?>