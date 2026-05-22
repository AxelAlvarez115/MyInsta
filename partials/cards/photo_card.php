<article class="flex flex-col gap-4 justify-center relative mt-[2%] md-[5%] w-full">
    <p class="absolute top-2 left-4 text-white"><?php echo $user['username']; ?></p>
    <img class="rounded-[12px] w-full" src="/MyInsta/assets/img/users/photos/<?php echo $photo['link']; ?>" alt="<?php echo $photo['description']; ?>">
    <div class="flex gap-4 items-center justify-start">
        <button onclick="like(<?php echo $photo['id']; ?>, <?php echo $_SESSION['user']['id']; ?>)" class="text-white text-2xl font-bold flex items-center gap-2"><img class="fill-red-500" src="/MyInsta/assets/img/icons/buttons/favorite.svg" alt=""><span id="like-count-<?php echo $photo['id']; ?>"><?= $likes ?></span></button>
        <button onclick="createPopUp('add_comment_form'); document.getElementById('comment_photo_id').value = <?php echo $photo['id']; ?>;" class="text-white text-2xl font-bold flex items-center gap-2"><img class="w-6 h-6" src="/MyInsta/assets/img/icons/buttons/add_comment.svg" alt=""><?= $comments ?></button>
    </div>
</article>