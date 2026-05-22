<?php
    require_once './utils/db/connection.php';
    require_once './utils/photos/get_photo.php';
    require_once './utils/users/get_user.php';
    require_once './utils/likes/get_like.php';
    require_once './utils/comments/get_comment.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>MyInsta</title>
</head>
<body class="bg-black text-white min-h-screen relative">
    <?php require_once './partials/header.php'; ?>
    <main class="p-4">
        <?php 
        if(isset($_SESSION['user'])) {
            $photos = getAllPhotos($pdo);
            foreach ($photos as $photo) {
                $user = getUserById($photo['user_id'], $pdo);
                $likes = getLikesByPhotoId($photo['id'], $pdo);
                $isLiked = false;
                foreach ($likes as $like) {
                    if($like['user_id'] == $_SESSION['user']['id']) {
                        $isLiked = true;
                        break;
                    }
                }
                $likes = count($likes);
                $comments = getCommentsCountByPhotoId($photo['id'], $pdo);
                include './partials/cards/photo_card.php';
            }}
            else {
                echo '<form action="/action_page.php">
                        <h1 class="flex gap-4 items-center justify-center mt-[2%] md-[5%] w-full
                        text-[5vh] font-bold text-white">Hello, who are you?</h1>
                            <div class="flex gap-4 items-center justify-center mt-[2%] md-[5%] w-full">
                                <input
                                class="bg-blue-50 rounded-[12px] text-black text-xl font-semibold text-[5vh]"
                                type="text"
                                id="uname"
                                name="name"
                                placeholder="Connection..." />
                            </div>
                        </form>';
            }
        ?>
    </main>
    <?php require_once './partials/phone_menu.php'; ?>
    <?php require_once './partials/footer.php'; ?>
    <script src="/MyInsta/assets/js/like.js"></script>
</body>
</html>