<?php
session_start();
require_once '../utils/db/connection.php';

// Recherche via GET pour une URL partageable
$query  = isset($_GET['q']) ? trim($_GET['q']) : '';
$users  = [];
$photos = [];

if ($query !== '') {
    // Recherche d'utilisateurs par pseudo
    $stmt = $pdo->prepare(
        "SELECT id, username FROM users WHERE username LIKE :q ORDER BY username LIMIT 15"
    );
    $stmt->execute([':q' => '%' . $query . '%']);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Recherche de photos par description
    $stmt = $pdo->prepare(
        "SELECT p.id, p.link, p.description, u.id AS user_id, u.username
         FROM photos p
         JOIN users u ON u.id = p.user_id
         WHERE p.description LIKE :q
         ORDER BY p.id DESC LIMIT 20"
    );
    $stmt->execute([':q' => '%' . $query . '%']);
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="/MyInsta/assets/css/style.css">
    <title>Recherche — MyInsta</title>
</head>
<body class="min-h-screen">

    <?php include '../partials/header.php'; ?>

    <main class="pb-24 max-w-xl mx-auto px-4 pt-4">

        <!-- ── Barre de recherche ── -->
        <form action="" method="GET" class="flex gap-2 mb-6">
            <div class="relative flex-1">
                <img src="/MyInsta/assets/img/icons/buttons/search.svg"
                     class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 invert opacity-40" alt="">
                <input
                    type="text"
                    name="q"
                    value="<?= htmlspecialchars($query) ?>"
                    placeholder="Rechercher un utilisateur ou une photo…"
                    autofocus
                    class="input-dark pl-9">
            </div>
            <button type="submit"
                    class="px-4 py-2.5 rounded-lg text-sm font-semibold transition"
                    style="background:var(--ig-surface2); border:1px solid var(--ig-border)">
                OK
            </button>
        </form>

        <?php if ($query === ''): ?>

            <!-- ── État vide ── -->
            <div class="flex flex-col items-center gap-3 mt-16 text-center">
                <img src="/MyInsta/assets/img/icons/buttons/search.svg"
                     class="w-12 h-12 invert opacity-20" alt="">
                <p class="text-sm" style="color:var(--ig-muted)">
                    Cherche un utilisateur ou un mot-clé.
                </p>
            </div>

        <?php else: ?>

            <!-- ── Résultats utilisateurs ── -->
            <?php if (!empty($users)): ?>
            <section class="mb-6">
                <h2 class="text-xs font-semibold uppercase tracking-widest mb-3"
                    style="color:var(--ig-muted)">Utilisateurs</h2>
                <div class="flex flex-col gap-1">
                    <?php foreach ($users as $u):
                        $initial = strtoupper(mb_substr($u['username'], 0, 1));
                    ?>
                    <a href="/MyInsta/views/profile.php?id=<?= $u['id'] ?>"
                       class="flex items-center gap-3 p-3 rounded-xl transition"
                       style="border:1px solid transparent"
                       onmouseover="this.style.borderColor='var(--ig-border)'; this.style.background='var(--ig-surface)'"
                       onmouseout="this.style.borderColor='transparent'; this.style.background='transparent'">
                        <!-- Avatar -->
                        <div class="avatar-ring shrink-0" style="width:44px;height:44px">
                            <div class="avatar-inner" style="padding:2px">
                                <div class="w-full h-full rounded-full ig-bg flex items-center
                                            justify-content-center font-bold text-base
                                            flex items-center justify-center">
                                    <?= $initial ?>
                                </div>
                            </div>
                        </div>
                        <span class="font-semibold text-sm"><?= htmlspecialchars($u['username']) ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- ── Résultats photos ── -->
            <?php if (!empty($photos)): ?>
            <section class="mb-4">
                <h2 class="text-xs font-semibold uppercase tracking-widest mb-3"
                    style="color:var(--ig-muted)">Photos</h2>
                <div class="grid grid-cols-3 gap-0.5">
                    <?php foreach ($photos as $p): ?>
                    <div class="photo-thumb aspect-square" style="background:var(--ig-surface)">
                        <a href="/MyInsta/views/profile.php?id=<?= $p['user_id'] ?>">
                            <img src="../assets/img/users/photos/<?= htmlspecialchars($p['link']) ?>"
                                 alt="<?= htmlspecialchars($p['description']) ?>"
                                 title="Par <?= htmlspecialchars($p['username']) ?>"
                                 class="w-full h-full object-cover">
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- ── Aucun résultat ── -->
            <?php if (empty($users) && empty($photos)): ?>
            <div class="flex flex-col items-center gap-3 mt-12 text-center">
                <p class="text-sm" style="color:var(--ig-muted)">
                    Aucun résultat pour <strong class="text-white">"<?= htmlspecialchars($query) ?>"</strong>.
                </p>
            </div>
            <?php endif; ?>

        <?php endif; ?>
    </main>

    <?php include '../partials/phone_menu.php'; ?>
    <?php include '../partials/footer.php'; ?>
</body>
</html>
