<?php
session_start();    
require_once 'db.php';
if (!isset($_SESSION['user_id'])) { 
    header('Location: index.php');// http
    exit();
} 
$user_id = $_SESSION['user_id']; // recuperer l'id de uszer
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC); 
$username = $user['username'] ?? 'Utilisateur';

?>
<!DOCTYPE html>
<html lang="fr">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - MyInsta</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-8">
  <section class="w-full max-w-md bg-white rounded-xl p-6">
    <div class="flex items-center justify-between mb-6">
      <div class="flex items-center gap-5"> 
        <img src="<?= htmlspecialchars($user['avatar']) ?" alt="Avatar" class="w-24 h-24 rounded-full border border-gray-300">
        <div>
          <h2 class="text-xl text-gray-800 font-bold">
            <?= htmlspecialchars($username) ?>
          </h2>
          <p class="text-sm text-gray-500 mt-1">
            Photos : <span class="font-medium">0</span> &nbsp;|&nbsp; Likes : <span class="font-medium">0</span>
          </p>
        </div>
      </div>
      <button type="button" class="bg-gray-600 text-white text-sm py-2 px-4 rounded-lg font-medium">
        Modifier le profil
      </button>
    </div>
</section>
  <section class="photo-grid">
    <button type="button" class="w-full bg-gray-600 text-white text-sm py-2 font-medium rounded-lg">
      ajouter une photo
    </button>
  </section>
</body>
</html>

