<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // Retrive form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title) {
        $_SESSION['add-category'] = "Enter category title";
    } elseif (!$description) {
        $_SESSION['add-category'] = "Enter category description";
    }

    // Redirect to add category page when the input is invalid
    if (isset($_SESSION['add-category'])) {
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        die();
    } else {
        // Insert category into the database
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)) {
            $_SESSION['add-category'] = "Could not add category";
            header('location: ' . ROOT_URL . 'admin/add-category.php');
        } else {
            $_SESSION['add-category-success'] = "Category $title added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
        }
    }
}
