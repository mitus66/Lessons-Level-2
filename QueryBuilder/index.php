<?php

include 'functions.php';
$db = include 'database/start.php';

$posts = $db->getAll('posts');

include 'index.view.php';
