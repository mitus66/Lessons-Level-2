<?php

include 'functions.php';
$db = include 'database/start.php';

$db->create('posts', [
    'title' => $_POST['title']
]);

header('Location: index.php');