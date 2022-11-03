<?php


use Entity\Comment;

interface CommentRepository{

    function insert (Comment $comment) : Comment;

    function findById(int $id) : ?Comment;

    function findAll() : array;
}