const main = document.querySelector('main');

/* ─────────────────────────────────────────────
   Crée / bascule un popup
   data : objet optionnel (ex. { photoId: 3 })
───────────────────────────────────────────── */
function createPopUp(action, data = {}) {
    const existing = document.getElementById('popUp');

    if (existing) {
        if (existing.classList.contains('action_' + action)) {
            deletePopUp();
            return;
        }
        deletePopUp();
    }

    const popUp = document.createElement('div');
    popUp.id = 'popUp';
    popUp.setAttribute('style',
        'position:fixed; top:50%; left:50%; transform:translate(-50%,-50%);' +
        'z-index:50; width:92vw; max-width:420px; max-height:90vh; overflow-y:auto;' +
        'background:var(--ig-surface); border:1px solid var(--ig-border);' +
        'border-radius:16px; box-shadow:0 24px 64px rgba(0,0,0,.9);'
    );
    popUp.classList.add('action_' + action);

    /* ── Connexion (pseudo uniquement) ── */
    if (action === 'login_form') {
        popUp.innerHTML = `
        <div style="padding:1.75rem">
            <h2 style="font-size:1.25rem;font-weight:700;margin-bottom:.35rem">Bienvenue sur MyInsta</h2>
            <p style="color:var(--ig-muted);font-size:.85rem;margin-bottom:1.5rem;line-height:1.5">
                Entre ton pseudo pour te connecter.<br>
                Nouveau pseudo ? Un compte est créé automatiquement.
            </p>
            <form action="/MyInsta/process/login.php" method="POST" style="display:flex;flex-direction:column;gap:.85rem">
                <input type="text" name="username" autocomplete="username"
                       class="input-dark" style="text-align:center;font-size:1rem"
                       placeholder="Ton pseudo…" required autofocus>
                <button type="submit" class="ig-btn" style="width:100%;padding:.75rem;border-radius:10px;font-size:.95rem">
                    Continuer
                </button>
            </form>
            <button onclick="deletePopUp()"
                    style="margin-top:1rem;font-size:.75rem;color:var(--ig-muted);width:100%;text-align:center;background:none;border:none;cursor:pointer">
                Fermer
            </button>
        </div>`;
    }

    /* ── Ajout de photo ── */
    else if (action === 'add_photo_form') {
        popUp.innerHTML = `
        <div style="padding:1.75rem">
            <h2 style="font-size:1.25rem;font-weight:700;margin-bottom:1.25rem">Nouvelle publication</h2>
            <form action="/MyInsta/process/add_photo.php" method="POST" enctype="multipart/form-data"
                  style="display:flex;flex-direction:column;gap:.85rem">
                <div>
                    <label style="display:block;font-size:.8rem;color:var(--ig-muted);margin-bottom:.4rem">Image</label>
                    <input type="file" name="image" accept="image/*"
                           class="input-dark" style="padding:.6rem" required>
                </div>
                <div>
                    <label style="display:block;font-size:.8rem;color:var(--ig-muted);margin-bottom:.4rem">Légende</label>
                    <input type="text" name="description" class="input-dark"
                           placeholder="Écris quelque chose…" required>
                </div>
                <button type="submit"
                        style="width:100%;padding:.75rem;border-radius:10px;font-size:.95rem;
                               background:#1d9b45;color:#fff;font-weight:600;border:none;cursor:pointer;transition:opacity .15s"
                        onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                    Publier ✓
                </button>
            </form>
            <button onclick="deletePopUp()"
                    style="margin-top:1rem;font-size:.75rem;color:var(--ig-muted);width:100%;text-align:center;background:none;border:none;cursor:pointer">
                Annuler
            </button>
        </div>`;
    }

    /* ── Commentaires ── */
    else if (action === 'add_comment_form') {
        const photoId = data.photoId || 0;
        popUp.innerHTML = `
        <div>
            <!-- En-tête popup -->
            <div style="display:flex;align-items:center;justify-content:space-between;
                        padding:1rem 1.25rem;border-bottom:1px solid var(--ig-border)">
                <span style="font-size:1rem;font-weight:700">Commentaires</span>
                <button onclick="deletePopUp()"
                        style="background:none;border:none;cursor:pointer;color:var(--ig-muted);
                               font-size:1.5rem;line-height:1;padding:0">&times;</button>
            </div>

            <!-- Liste des commentaires -->
            <div id="comments-list"
                 style="padding:1rem 1.25rem;min-height:80px;display:flex;flex-direction:column;gap:.75rem">
                <p style="color:var(--ig-muted);font-size:.85rem">Chargement…</p>
            </div>

            <!-- Formulaire -->
            <div style="border-top:1px solid var(--ig-border);padding:1rem 1.25rem">
                <form id="commentForm" style="display:flex;gap:.75rem;align-items:flex-end">
                    <input type="hidden" id="comment_photo_id" value="${photoId}">
                    <textarea name="content" rows="1"
                              class="input-dark" style="flex:1;resize:none;line-height:1.5;padding:.65rem .9rem"
                              placeholder="Ajouter un commentaire…" required></textarea>
                    <button type="submit"
                            style="padding:.6rem 1rem;border-radius:8px;font-size:.85rem;font-weight:600;
                                   background:none;border:none;cursor:pointer;color:#4d9cf8;white-space:nowrap">
                        Publier
                    </button>
                </form>
            </div>
        </div>`;

        main.appendChild(popUp);

        // Chargement des commentaires existants
        loadComments(photoId);

        // Soumission du formulaire
        document.getElementById('commentForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const content = this.querySelector('textarea').value.trim();
            if (!content) return;

            try {
                const res  = await fetch('/MyInsta/utils/comments/post_comment.php', {
                    method:  'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body:    JSON.stringify({ photoId, content })
                });
                const data = await res.json();
                if (data.error) { alert(data.error); return; }

                this.querySelector('textarea').value = '';

                // Ajoute le commentaire directement sans recharger
                appendComment(data.comment);

                // Met à jour le compteur sur la carte
                const countEl = document.getElementById(`comment-count-${photoId}`);
                if (countEl) countEl.textContent = parseInt(countEl.textContent) + 1;
            } catch (err) {
                console.error('Erreur commentaire:', err);
            }
        });

        return; // main.appendChild déjà fait
    }

    /* ── Édition du profil ── */
    else if (action === 'edit_profile_form') {
        const username = data.username || '';
        const bio      = data.bio      || '';
        const avatar   = data.avatar   || '';

        // Prévisualisation de l'avatar courant
        const avatarPreviewHtml = avatar
            ? `<img id="avatarPreview"
                    src="/MyInsta/assets/img/users/avatars/${escapeHtml(avatar)}"
                    style="width:80px;height:80px;border-radius:50%;object-fit:cover">`
            : `<div id="avatarPreview"
                    class="ig-bg"
                    style="width:80px;height:80px;border-radius:50%;display:flex;
                           align-items:center;justify-content:center;font-weight:700;font-size:2rem">
                   ${escapeHtml(username.charAt(0).toUpperCase())}
               </div>`;

        popUp.innerHTML = `
        <div style="padding:1.75rem">
            <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:1.5rem">Modifier le profil</h2>

            <form action="/MyInsta/process/update_profile.php" method="POST"
                  enctype="multipart/form-data"
                  style="display:flex;flex-direction:column;gap:1.1rem">

                <!-- Avatar cliquable -->
                <div style="display:flex;flex-direction:column;align-items:center;gap:.6rem">
                    <label for="avatarInput" style="cursor:pointer;position:relative;display:block">
                        ${avatarPreviewHtml}
                        <!-- Badge caméra -->
                        <div style="position:absolute;bottom:2px;right:2px;width:26px;height:26px;
                                    background:#333;border:2px solid #000;border-radius:50%;
                                    display:flex;align-items:center;justify-content:center;font-size:.75rem">
                            📷
                        </div>
                    </label>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*"
                           style="display:none" onchange="previewAvatarFile(this)">
                    <span style="font-size:.72rem;color:var(--ig-muted)">
                        Appuie sur la photo pour changer
                    </span>
                </div>

                <!-- Pseudo -->
                <div>
                    <label style="display:block;font-size:.8rem;color:var(--ig-muted);margin-bottom:.4rem">
                        Pseudo
                    </label>
                    <input type="text" name="username" class="input-dark"
                           value="${escapeHtml(username)}"
                           maxlength="50" required>
                </div>

                <!-- Bio -->
                <div>
                    <label style="display:block;font-size:.8rem;color:var(--ig-muted);margin-bottom:.4rem">
                        Bio
                    </label>
                    <textarea name="bio" class="input-dark"
                              style="resize:none;line-height:1.5" rows="2"
                              maxlength="250"
                              placeholder="Parle un peu de toi…">${escapeHtml(bio)}</textarea>
                </div>

                <button type="submit" class="ig-btn"
                        style="width:100%;padding:.78rem;border-radius:10px;font-size:.95rem">
                    Enregistrer les modifications
                </button>
            </form>

            <button onclick="deletePopUp()"
                    style="margin-top:.85rem;font-size:.75rem;color:var(--ig-muted);
                           width:100%;text-align:center;background:none;border:none;cursor:pointer">
                Annuler
            </button>
        </div>`;
    }

    main.appendChild(popUp);
}

/* ─────────────────────────────────────────────
   Ouvre le popup d'édition depuis un bouton
   dont data-profile contient le JSON du profil
───────────────────────────────────────────── */
function openEditProfile(btn) {
    try {
        const data = JSON.parse(btn.getAttribute('data-profile') || '{}');
        createPopUp('edit_profile_form', data);
    } catch (e) {
        console.error('Impossible de lire les données du profil :', e);
        createPopUp('edit_profile_form', {});
    }
}

/* ─────────────────────────────────────────────
   Prévisualise l'avatar sélectionné (FileReader)
───────────────────────────────────────────── */
function previewAvatarFile(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        const preview = document.getElementById('avatarPreview');
        if (!preview) return;
        // Remplace par une <img> avec le data-URL
        const img = document.createElement('img');
        img.id    = 'avatarPreview';
        img.src   = e.target.result;
        img.style.cssText = 'width:80px;height:80px;border-radius:50%;object-fit:cover';
        preview.replaceWith(img);
    };
    reader.readAsDataURL(input.files[0]);
}

/* ─────────────────────────────────────────────
   Charge et affiche les commentaires d'une photo
───────────────────────────────────────────── */
async function loadComments(photoId) {
    const container = document.getElementById('comments-list');
    if (!container) return;

    try {
        const res  = await fetch(`/MyInsta/utils/comments/get_comments.php?photo_id=${photoId}`);
        const data = await res.json();

        if (!data.comments || data.comments.length === 0) {
            container.innerHTML = '<p class="text-gray-500 text-sm">Aucun commentaire pour l\'instant.</p>';
            return;
        }

        container.innerHTML = '';
        data.comments.forEach(c => appendComment(c));
    } catch (err) {
        container.innerHTML = '<p class="text-red-400 text-sm">Erreur lors du chargement.</p>';
    }
}

/* ─────────────────────────────────────────────
   Ajoute un seul commentaire dans la liste
───────────────────────────────────────────── */
function appendComment(comment) {
    const container = document.getElementById('comments-list');
    if (!container) return;

    // Retire le message "Aucun commentaire" / "Chargement…"
    const empty = container.querySelector('p');
    if (empty) empty.remove();

    const div = document.createElement('div');
    div.style.cssText = 'display:flex;gap:.5rem;font-size:.875rem;line-height:1.4;align-items:baseline';
    div.innerHTML = `
        <span style="font-weight:600;color:#93c5fd;white-space:nowrap;flex-shrink:0">
            ${escapeHtml(comment.username)}
        </span>
        <span style="color:#e5e5e5;word-break:break-word">${escapeHtml(comment.content)}</span>`;
    container.appendChild(div);
}

/* ─────────────────────────────────────────────
   Supprime le popup courant
───────────────────────────────────────────── */
function deletePopUp() {
    const popUp = document.getElementById('popUp');
    if (popUp) popUp.remove();
}

/* ─────────────────────────────────────────────
   Utilitaire : échappe le HTML
───────────────────────────────────────────── */
function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}
