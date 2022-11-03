<?php

require_once __DIR__ . '/helper/Connected.php';
require_once __DIR__ . '/repository/Comment.php';
require_once __DIR__ . '/repository/CommentRepository.php';
require_once __DIR__ . '/repository/CommentRepositoryImpl.php';

use Repository\CommentRepositoryImpl;
use Entity\Comment;

$connection = getConnection();
$repository = new CommentRepositoryImpl($connection);

$comment = new Comment(email: "repository@test.com" , comment: "Test repository");
$newComment = $repository->insert($comment);

//$comment = $repository->findById(3);
//var_dump($comment);

//$comments = $repository->findAll();
//var_dump($comments);


$connection = null;