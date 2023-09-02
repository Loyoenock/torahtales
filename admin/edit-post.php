<?php
include 'partials/header.php'
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="" enctype="multipart/form-data">
            <input type="text" placeholder="Title">
            <select>
                <option value="1">Torah Study and Commentary</option>
                <option value="2">
                    Hebrew Traditions and Rituals</option>
                <option value="3">Personal Stories and Reflections</option>
                <option value="4">Ethical and Moral Discussionsy</option>
            </select>
            <textarea rows="10" placeholder="Body"></textarea>
            <div class="form__control inline">

                <input type="checkbox" id="is__featured" checked>
                <label for="is__featured">Featured</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" id="thumbnail">
            </div>
            <button class="btn" type="submit"> Update Post </button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php'
?>