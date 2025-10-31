<?php
require_once '../utils/db/connection.php';
session_start();
if(isset($_GET['username'])){
    $usernameParam = $_GET['username'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$usernameParam]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$user){
        die("Utilisateur introuvable.");
    }
}
elseif(isset($_SESSION['user'])){
    $user_id = $_SESSION['user']['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
else {
    die("Aucun profil à afficher.");
}

$username = $user['username'];
$avatar = !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : '../assets/img/default-avatar.png';
?> <!-- j'ai utiliser Chatbt GPT iciii -->
<!-- 
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../index.php");
    exit();
}
require_once '../utils/db/connection.php';
 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>MyInsta Profile</title>
</head>
<body class="bg-black text-white min-h-screen relative">
    <?php include '../partials/header.php'; ?>
    <main class="p-4">
        <h1 class="text-xl font-bold">Welcome to MyInsta</h1>
        <?php
            $username = $user['username'] ?? 'Utilisateur';
            $avatar = !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : '../assets/img/default-avatar.png';
        ?>

        <section class="w-full max-w-md bg-white rounded-xl p-6 mb-8 text-gray-900 mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-5">
                    <img src="<?= $avatar ?>" alt="Avatar" class="w-24 h-24 rounded-full border border-gray-300 object-cover">
                    <div>
                        <h2 class="text-xl font-bold"><?= htmlspecialchars($username) ?></h2>
                        <p class="text-sm text-gray-500 mt-1"> Photos : <span class="font-medium">0</span> &nbsp;|&nbsp; Likes : <span class="font-medium">0</span>
                        </p>
                    </div>
                </div>
                <button type="button" class="bg-gray-800 text-white text-sm py-2 px-4 rounded-lg font-medium">
                    Modifier le profil
                </button>
            </div>

            <button type="button" class="w-full bg-gray-700 text-white text-sm py-2 font-medium rounded-lg hover:bg-gray-600">
                Ajouter une photo
            </button>
        </section>       
       
        <div class="grid grid-cols-3 gap-2">
            <?php
                require_once '../utils/photos/get_photo.php';
                $user_id = $user['id'];
                $photos = getUserPhotos($userId, $pdo);

                $count = 0;
                foreach ($photos as $photo) {
                    if ($count >= 9) break;
                    echo '<div class="bg-black rounded-lg overflow-hidden aspect-square">';
                    echo '<img src="../assets/img/users/photos/' . htmlspecialchars($photo['link']) . '" alt="' . htmlspecialchars($photo['description']) . '" class="w-full h-full object-cover">';
                    echo '</div>';
                    $count++;
                }
            ?>
        </div>

        <button onclick="location.href='../process/logout.php'">
            <img class="cursor-pointer h-10 w-10" src="../assets/img/icons/buttons/logout.svg" alt="logout">
        </button>
    </main>
    <?php include '../partials/phone_menu.php'; ?>
    <?php include '../partials/footer.php'; ?>
</body>
</html>