<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../utils/db/connection.php';
require_once '../utils/users/get_user.php';
require_once '../utils/photos/get_photo.php';

$targetId    = isset($_GET['id']) ? (int) $_GET['id'] : (int) $_SESSION['user']['id'];
$profileUser = getUserById($targetId, $pdo);

if (!$profileUser) {
    header("Location: ../index.php?error=usernotfound");
    exit();
}

$isOwnProfile = ($targetId === (int) $_SESSION['user']['id']);
$photos       = getUserPhotos($targetId, $pdo);
$photoCount   = count($photos);

// Données sérialisées pour le popup d'édition (transmission sûre vers JS)
$editData = json_encode([
    'username' => $profileUser['username'],
    'bio'      => $profileUser['bio']      ?? '',
    'avatar'   => $profileUser['avatar']   ?? '',
]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="/MyInsta/assets/css/style.css">
    <title><?= htmlspecialchars($profileUser['username']) ?> — MyInsta</title>
</head>
<body class="min-h-screen">

    <?php include '../partials/header.php'; ?>

    <main class="pb-28">

        <!-- ── En-tête profil ── -->
        <section class="max-w-xl mx-auto px-4 pt-8 pb-5">
            <div class="flex items-center gap-6 mb-5">

                <!-- Avatar (ring gradient si photo, sinon initiale) -->
                <div class="avatar-ring shrink-0"
                     style="width:<?= $isOwnProfile ? '90px' : '74px' ?>;height:<?= $isOwnProfile ? '90px' : '74px' ?>">
                    <div class="avatar-inner" style="padding:3px">
                        <?= renderAvatar($profileUser, $isOwnProfile ? 84 : 68) ?>
                    </div>
                </div>

                <!-- Infos + actions -->
                <div class="flex flex-col gap-1.5 min-w-0">
                    <h1 class="text-lg font-semibold truncate">
                        <?= htmlspecialchars($profileUser['username']) ?>
                    </h1>

                    <?php if (!empty($profileUser['bio'])): ?>
                    <p class="text-sm leading-snug" style="color:#d4d4d4;max-width:220px">
                        <?= htmlspecialchars($profileUser['bio']) ?>
                    </p>
                    <?php endif; ?>

                    <p class="text-xs" style="color:var(--ig-muted)">
                        <?= $photoCount ?> publication<?= $photoCount > 1 ? 's' : '' ?>
                    </p>

                    <?php if ($isOwnProfile): ?>
                    <div class="flex gap-2 flex-wrap mt-1">
                        <!-- Bouton Modifier le profil -->
                        <!-- Le JSON est stocké dans data-profile (les " deviennent &quot;)  -->
                        <!-- puis relu via JSON.parse côté JS — pas de casse dans onclick="" -->
                        <button data-profile='<?= htmlspecialchars($editData, ENT_QUOTES, "UTF-8") ?>'
                                onclick="openEditProfile(this)"
                                class="text-xs font-semibold px-4 py-1.5 rounded-lg transition"
                                style="background:var(--ig-surface2);border:1px solid var(--ig-border)">
                            Modifier le profil
                        </button>
                        <a href="../process/logout.php"
                           class="text-xs font-semibold px-4 py-1.5 rounded-lg transition"
                           style="background:var(--ig-surface2);border:1px solid var(--ig-border);color:inherit;text-decoration:none">
                            Déconnexion
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <hr class="section-divider">
        </section>

        <!-- ── Grille de photos ── -->
        <section class="max-w-xl mx-auto px-1">
            <?php if ($photoCount === 0): ?>
                <div class="flex flex-col items-center gap-4 mt-16 text-center px-6">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center"
                         style="border:2px solid var(--ig-border)">
                        <img src="/MyInsta/assets/img/icons/buttons/add.svg"
                             class="w-7 h-7 invert opacity-30" alt="">
                    </div>
                    <p class="text-sm" style="color:var(--ig-muted)">
                        <?= $isOwnProfile ? 'Publie ta première photo !' : 'Aucune photo pour l\'instant.' ?>
                    </p>
                    <?php if ($isOwnProfile): ?>
                    <button onclick="createPopUp('add_photo_form')" class="ig-btn text-sm px-6 py-2">
                        Partager une photo
                    </button>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-3 gap-0.5">
                    <?php foreach ($photos as $photo): ?>
                    <div class="photo-thumb aspect-square" style="background:var(--ig-surface)">
                        <img src="../assets/img/users/photos/<?= htmlspecialchars($photo['link']) ?>"
                             alt="<?= htmlspecialchars($photo['description']) ?>"
                             class="w-full h-full object-cover">
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- ── Flashes ── -->
        <?php
        $flash = null;
        if (isset($_GET['success'])) {
            $map = [
                'photoadded'     => '✅ Photo publiée !',
                'profileupdated' => '✅ Profil mis à jour !',
            ];
            $flash = ['ok', $map[$_GET['success']] ?? 'Succès'];
        } elseif (isset($_GET['error'])) {
            $map = [
                'emptyusername'  => 'Le pseudo ne peut pas être vide.',
                'usernametoolong'=> 'Pseudo trop long (max 50 caractères).',
                'usernametaken'  => 'Ce pseudo est déjà pris.',
                'uploadfailed'   => 'Erreur lors de l\'envoi du fichier.',
                'invalidfiletype'=> 'Format de fichier non supporté.',
                'filetoolarge'   => 'Image trop lourde (max 2 Mo).',
            ];
            $flash = ['err', $map[$_GET['error']] ?? 'Une erreur est survenue.'];
        }
        if ($flash):
            $bg = $flash[0] === 'ok' ? '#166534' : '#7f1d1d';
        ?>
        <div id="flash" class="flash-enter fixed bottom-24 left-1/2 -translate-x-1/2
             px-5 py-3 rounded-xl text-sm font-semibold shadow-2xl z-50 whitespace-nowrap"
             style="background:<?= $bg ?>;border:1px solid rgba(255,255,255,.1)">
            <?= htmlspecialchars($flash[1]) ?>
        </div>
        <script>
            setTimeout(() => {
                const f = document.getElementById('flash');
                if (f) { f.style.opacity='0'; f.style.transition='opacity .4s'; setTimeout(()=>f.remove(),400); }
            }, 3000);
        </script>
        <?php endif; ?>

    </main>

    <?php include '../partials/phone_menu.php'; ?>
    <?php include '../partials/footer.php'; ?>

</body>
</html>
