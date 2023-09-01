<?php
require 'config/constants.php';

// Kill all session & take user to the home page
session_destroy();
header('location: ' . ROOT_URL);
die();
