<?php define('phone_menu', realpath(__DIR__)); ?>


<div class="fixed bg-black bottom-0 left-0 right-0 text-center border-t mx-4 p-4 flex justify-evenly">
    <button onclick="location.href='/MyInsta/index.php'" class="cursor-pointer">
        <img class="h-10 w-10" src="/MyInsta/assets/img/icons/buttons/home.svg" alt="home">
    </button>
    <button onclick="location.href='/MyInsta/views/search.php'" class="cursor-pointer">
        <img class="h-10 w-10" src="/MyInsta/assets/img/icons/buttons/search.svg" alt="search">
    </button>
    <?php if (isset($_SESSION['user'])): ?>
    <button onclick="createPopUp('add_photo_form')" class="cursor-pointer">
        <img class="h-10 w-10" src="/MyInsta/assets/img/icons/buttons/add.svg" alt="add">
    </button>
    <?php endif; ?>
    <?php if (isset($_SESSION['user'])): ?>
    <button class="cursor-pointer">
        <img onclick="location.href='/MyInsta/views/profile.php'" class="h-10 w-10" src="/MyInsta/assets/img/icons/buttons/account_circle.svg" alt="account">
    </button>
    <?php else: ?>
    <button onclick="createPopUp('login_form')" class="cursor-pointer">
        <img class="h-10 w-10" src="/MyInsta/assets/img/icons/buttons/login.svg" alt="login">
    </button>
    <?php endif; ?>
</div>
<script src="/MyInsta/assets/js/popUp.js"></script>
