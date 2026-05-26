<?php

function getUserByUsername(string $username, PDO $pdo): array|false {
    $stmt = $pdo->prepare("SELECT id, username, avatar, bio FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserById(int $id, PDO $pdo): array|false {
    $stmt = $pdo->prepare("SELECT id, username, avatar, bio FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Génère le HTML de l'avatar d'un utilisateur.
 * – Si l'utilisateur a une photo de profil, on l'affiche.
 * – Sinon, un cercle coloré avec son initiale (comme avant).
 *
 * @param array  $user   Tableau user avec au moins 'username' et optionnellement 'avatar'
 * @param int    $size   Diamètre en pixels
 * @param string $extra  Classes CSS supplémentaires
 */
function renderAvatar(array $user, int $size = 40, string $extra = ''): string {
    $px      = $size . 'px';
    $fsize   = (int)($size * 0.42) . 'px';
    $initial = strtoupper(mb_substr($user['username'] ?? '?', 0, 1));
    $base    = "width:{$px};height:{$px};border-radius:50%;flex-shrink:0;object-fit:cover;";

    if (!empty($user['avatar'])) {
        return sprintf(
            '<img src="/MyInsta/assets/img/users/avatars/%s" alt="" style="%s" class="%s">',
            htmlspecialchars($user['avatar']),
            $base,
            $extra
        );
    }

    return sprintf(
        '<div class="ig-bg %s" style="%sdisplay:flex;align-items:center;justify-content:center;font-weight:700;font-size:%s">%s</div>',
        $extra, $base, $fsize, $initial
    );
}
