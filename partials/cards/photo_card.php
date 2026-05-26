<article class="w-full max-w-lg mx-auto" style="border-bottom:1px solid var(--ig-border); padding-bottom: 1.5rem; margin-bottom: 0.5rem;">

    <!-- ── En-tête : avatar + pseudo ── -->
    <div class="flex items-center justify-between px-3 py-3">
        <a href="/MyInsta/views/profile.php?id=<?= $user['id'] ?>"
           class="flex items-center gap-3 group">

            <!-- Avatar cercle avec ring gradient -->
            <div class="avatar-ring shrink-0" style="width:36px;height:36px">
                <div class="avatar-inner" style="padding:2px">
                    <?= renderAvatar($user, 32) ?>
                </div>
            </div>

            <span class="font-semibold text-[0.93rem] group-hover:opacity-70 transition">
                <?= htmlspecialchars($user['username']) ?>
            </span>
        </a>
    </div>

    <!-- ── Photo ── -->
    <div class="photo-thumb w-full" style="background:var(--ig-surface)">
        <img src="/MyInsta/assets/img/users/photos/<?= htmlspecialchars($photo['link']) ?>"
             alt="<?= htmlspecialchars($photo['description']) ?>"
             class="w-full object-cover"
             style="max-height: 600px;">
    </div>

    <!-- ── Actions ── -->
    <div class="flex items-center gap-1 px-3 pt-3 pb-1">

        <!-- Like -->
        <button data-like="<?= $photo['id'] ?>"
                onclick="handleLike(<?= $photo['id'] ?>, this)"
                class="btn-icon flex items-center gap-1.5 -ml-2">
            <img src="/MyInsta/assets/img/icons/buttons/favorite.svg"
                 alt="like"
                 id="like-icon-<?= $photo['id'] ?>"
                 class="w-7 h-7"
                 style="<?= $isLiked
                     ? 'filter:invert(27%) sepia(99%) saturate(2000%) hue-rotate(330deg)'
                     : 'filter:invert(1)' ?>">
            <span id="like-count-<?= $photo['id'] ?>"
                  class="text-sm font-semibold"><?= $likes ?></span>
        </button>

        <!-- Commentaire -->
        <button onclick="createPopUp('add_comment_form', { photoId: <?= $photo['id'] ?> })"
                class="btn-icon flex items-center gap-1.5">
            <img src="/MyInsta/assets/img/icons/buttons/add_comment.svg"
                 alt="commenter" class="w-6 h-6 invert opacity-90">
            <span id="comment-count-<?= $photo['id'] ?>"
                  class="text-sm font-semibold"><?= $comments ?></span>
        </button>

    </div>

    <!-- ── Légende ── -->
    <?php if (!empty($photo['description'])): ?>
    <p class="px-3 text-[0.9rem] leading-snug">
        <a href="/MyInsta/views/profile.php?id=<?= $user['id'] ?>"
           class="font-semibold mr-1 hover:opacity-70 transition">
            <?= htmlspecialchars($user['username']) ?>
        </a>
        <span style="color:#e5e5e5"><?= htmlspecialchars($photo['description']) ?></span>
    </p>
    <?php endif; ?>

</article>
