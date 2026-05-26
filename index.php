<?php
require_once './utils/db/connection.php';
require_once './utils/photos/get_photo.php';
require_once './utils/users/get_user.php';
require_once './utils/likes/get_like.php';
require_once './utils/comments/get_comment.php';
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="/MyInsta/assets/css/style.css">
    <title>MyInsta</title>
</head>
<body class="min-h-screen">

    <?php require_once './partials/header.php'; ?>

    <main class="pb-24">

        <?php if (isset($_SESSION['user'])): ?>

            <!-- ── Fil d'actualités ── -->
            <?php $photos = getAllPhotos($pdo); ?>

            <?php if (empty($photos)): ?>
                <div class="flex flex-col items-center justify-center mt-20 gap-4 px-6 text-center">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center"
                         style="border:2px solid var(--ig-border)">
                        <img src="/MyInsta/assets/img/icons/buttons/add.svg" class="w-8 h-8 invert opacity-40" alt="">
                    </div>
                    <p style="color:var(--ig-muted)" class="text-sm">
                        Aucune photo pour l'instant.<br>Sois le premier à publier !
                    </p>
                    <button onclick="createPopUp('add_photo_form')"
                            class="ig-btn text-sm px-6 py-2">
                        Ajouter une photo
                    </button>
                </div>

            <?php else: ?>
                <div class="flex flex-col items-center pt-2">
                <?php foreach ($photos as $photo):
                    $user     = getUserById($photo['user_id'], $pdo);
                    $likesArr = getLikesByPhotoId($photo['id'], $pdo);
                    $isLiked  = false;
                    foreach ($likesArr as $l) {
                        if ((int)$l['user_id'] === (int)$_SESSION['user']['id']) {
                            $isLiked = true;
                            break;
                        }
                    }
                    $likes    = count($likesArr);
                    $comments = getCommentsCountByPhotoId($photo['id'], $pdo);
                    include './partials/cards/photo_card.php';
                endforeach; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <!-- ── Page de bienvenue ── -->
            <section class="flex flex-col items-center justify-center min-h-[88vh] px-6 text-center gap-7">

                <!-- Icône décorative -->
                <div class="relative">
                    <div class="w-24 h-24 rounded-3xl ig-bg flex items-center justify-center shadow-2xl">
                        <img src="/MyInsta/assets/img/icons/buttons/favorite.svg"
                             class="w-10 h-10 invert" alt="">
                    </div>
                    <div class="absolute -top-1 -right-1 w-5 h-5 rounded-full"
                         style="background:var(--ig-grad)"></div>
                </div>

                <!-- Titre -->
                <div>
                    <h1 class="ig-text text-5xl font-bold tracking-tight mb-3">MyInsta</h1>
                    <p style="color:var(--ig-muted)" class="text-base max-w-xs leading-relaxed">
                        Partage tes photos, découvre celles des autres,<br>
                        like et commente en temps réel.
                    </p>
                </div>

                <!-- Formulaire pseudo -->
                <form action="/MyInsta/process/login.php" method="POST"
                      class="flex flex-col gap-3 w-full max-w-xs">
                    <input
                        type="text"
                        name="username"
                        autocomplete="username"
                        placeholder="Ton pseudo…"
                        required
                        class="input-dark text-center text-base">
                    <button type="submit" class="ig-btn text-base py-3 rounded-xl w-full">
                        Se connecter · S'inscrire
                    </button>
                </form>

                <p class="text-xs" style="color:var(--ig-muted)">
                    Pas de mot de passe. Nouveau pseudo = compte créé automatiquement.
                </p>

            </section>

        <?php endif; ?>

        <!-- ── Flash message ── -->
        <?php
        $flash = null;
        if (isset($_GET['success'])) {
            $map = [
                'loggedin'   => '👋 Content de te revoir !',
                'registered' => '🎉 Bienvenue sur MyInsta !',
                'loggedout'  => 'À bientôt 👋',
            ];
            $flash = ['type' => 'ok', 'msg' => $map[$_GET['success']] ?? 'Succès'];
        } elseif (isset($_GET['error'])) {
            $map = [
                'emptyusername'   => 'Le pseudo ne peut pas être vide.',
                'invalidinput'    => 'Données invalides.',
                'notloggedin'     => 'Tu dois être connecté.',
                'uploadfailed'    => 'Erreur lors de l\'envoi.',
                'invalidfiletype' => 'Format de fichier non supporté.',
                'filetoolarge'    => 'Fichier trop volumineux (max 5 Mo).',
                'movefailed'      => 'Impossible de sauvegarder le fichier.',
                'dberror'         => 'Erreur base de données.',
            ];
            $flash = ['type' => 'err', 'msg' => $map[$_GET['error']] ?? 'Une erreur est survenue.'];
        }

        if ($flash):
            $bg = $flash['type'] === 'ok' ? '#166534' : '#7f1d1d';
        ?>
        <div id="flash" class="flash-enter fixed bottom-24 left-1/2 -translate-x-1/2
             px-5 py-3 rounded-xl text-sm font-semibold shadow-2xl z-50 whitespace-nowrap"
             style="background:<?= $bg ?>; border:1px solid rgba(255,255,255,0.1)">
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
        <script>
            setTimeout(() => {
                const f = document.getElementById('flash');
                if (f) { f.style.opacity = '0'; f.style.transition = 'opacity .4s'; setTimeout(() => f.remove(), 400); }
            }, 3000);
        </script>
        <?php endif; ?>

    </main>

    <?php require_once './partials/phone_menu.php'; ?>
    <?php require_once './partials/footer.php'; ?>
    <script src="/MyInsta/assets/js/like.js"></script>

</body>
</html>
