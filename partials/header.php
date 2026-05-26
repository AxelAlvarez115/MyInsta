<header class="sticky top-0 z-30 glass border-b" style="border-color:var(--ig-border)">
    <div class="max-w-xl mx-auto flex items-center justify-between px-4 h-14">

        <!-- Logo -->
        <a href="/MyInsta/index.php" class="ig-text text-2xl font-bold tracking-tight select-none">
            MyInsta
        </a>

        <!-- Actions à droite (connecté) -->
        <?php if (isset($_SESSION['user'])): ?>
        <?php require_once dirname(__DIR__) . '/utils/users/get_user.php'; ?>
        <div class="flex items-center gap-1">
            <button onclick="createPopUp('add_photo_form')"
                    class="btn-icon"
                    title="Ajouter une photo">
                <img src="/MyInsta/assets/img/icons/buttons/add.svg" alt="Ajouter" class="w-6 h-6 invert">
            </button>
            <a href="/MyInsta/views/profile.php" class="btn-icon" title="Mon profil">
                <div class="avatar-ring" style="width:30px;height:30px">
                    <div class="avatar-inner" style="padding:2px">
                        <?= renderAvatar($_SESSION['user'], 26) ?>
                    </div>
                </div>
            </a>
        </div>
        <?php else: ?>
        <button onclick="createPopUp('login_form')"
                class="text-sm font-semibold ig-text hover:opacity-80 transition">
            Se connecter
        </button>
        <?php endif; ?>

    </div>
</header>
