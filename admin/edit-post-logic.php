<?php
require 'config/database.php';

// Ensure edit post button was clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // If is_featured is not checked, set it to 0;
    $is_featured = $is_featured == 1 ?: 0;

    // Input value validation and check
    if (!$title) {
        $_SESSION['edit-post'] = "Couldn't update post,Invalid form data on edit post page.";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Couldn't update post,Invalid form data on edit post page.";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Couldn't update post,Invalid form data on edit post page.";
    } else {
        // Delete previous thumbnail if new thumbnail is available
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }
            // Work on new thumbnail
            // Rename image
            $time  = time(); // Ensure each new image uploaded has a unique name using the current timestamp
            $previous_thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $previous_thumbnail_name;

            // Ensure file is an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);
            if (in_array($extension, $allowed_files)) {
                // Ensure avatar is not more than 2mb
                if ($thumbnail['size'] < 2000000) {
                    // upload thumbnail
                    move_uploaded_file($thumbnail_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "Could not update post, Thumbnail should less than 2mb";
                }
            } else {
                $_SESSION['edit-post'] = "Couldn't update post. Thubnail should be png, jpg or jpeg";
            }
        }
    }

    if ($_SESSION['edit-post']) {
        // Redirect to manage form page if from was invalid
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        // set is featured of all posts to 0 if is featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // Set thumbnail name if a new thumbnail was uploaded, else keep the old one
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', cattegory_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
    }

    if (!mysqli_errno($connection)) {
        $_SESSION['edit-post-success'] = "Post updated successfully";
    }
}
header('location: ' . ROOT_URL . 'admin/');
die();