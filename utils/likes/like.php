<?php
session_start();
require_once '../db/connection.php';
$userId = $_SESSION['user']['id'];
function like($photoId, $userId, $pdo) {
    require_once './utils/likes/create_like.php';
    require_once './utils/likes/delete_like.php';
    require_once './utils/likes/get_like.php';
    $existingLike = getLikeByPhotoIdUserId($photoId, $userId, $pdo);
    if ($existingLike) {
        deleteLike($userId, $photoId, $pdo);
        return ['liked' => false];
    }
    createLike($userId, $photoId, $pdo);
    return ['liked' => true];
}
like($_POST['photoId'], $userId, $pdo);