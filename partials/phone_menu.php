<?php
// Détermine la page active pour la surbrillance
$currentPage = basename($_SERVER['PHP_SELF']);
$currentDir  = basename(dirname($_SERVER['PHP_SELF']));

function navActive(string $page, string $currentPage, string $currentDir = ''): string {
    if ($page === $currentPage) return 'opacity-100';
    return 'opacity-40 hover:opacity-70';
}
?>

<nav class="fixed bottom-0 left-0 right-0 z-30 glass border-t" style="border-color:var(--ig-border)">
    <div class="max-w-xl mx-auto flex items-center justify-around px-2 h-14">

        <!-- Accueil -->
        <a href="/MyInsta/index.php"
           class="btn-icon flex flex-col items-center transition <?= navActive('index.php', $currentPage) ?>">
            <img src="/MyInsta/assets/img/icons/buttons/home.svg" alt="Accueil" class="w-6 h-6 invert">
        </a>

        <!-- Recherche -->
        <a href="/MyInsta/views/search.php"
           class="btn-icon flex flex-col items-center transition <?= navActive('search.php', $currentPage) ?>">
            <img src="/MyInsta/assets/img/icons/buttons/search.svg" alt="Recherche" class="w-6 h-6 invert">
        </a>

        <?php if (isset($_SESSION['user'])): ?>

        <!-- Ajouter une photo -->
        <button onclick="createPopUp('add_photo_form')"
                class="btn-icon transition opacity-80 hover:opacity-100">
            <div class="w-8 h-8 rounded-lg ig-bg flex items-center justify-center">
                <img src="/MyInsta/assets/img/icons/buttons/add.svg" alt="Ajouter" class="w-5 h-5 invert">
            </div>
        </button>

        <!-- Profil -->
        <a href="/MyInsta/views/profile.php"
           class="btn-icon flex flex-col items-center transition <?= navActive('profile.php', $currentPage) ?>">
            <img src="/MyInsta/assets/img/icons/buttons/account_circle.svg" alt="Profil" class="w-6 h-6 invert">
        </a>

        <?php else: ?>

        <!-- Connexion -->
        <button onclick="createPopUp('login_form')"
                class="btn-icon transition opacity-60 hover:opacity-100">
            <img src="/MyInsta/assets/img/icons/buttons/login.svg" alt="Connexion" class="w-6 h-6 invert">
        </button>

        <?php endif; ?>
    </div>
</nav>

<script src="/MyInsta/assets/js/popUp.js"></script>
