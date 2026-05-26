async function handleLike(photoId) {
    const btn       = document.querySelector(`[data-like="${photoId}"]`);
    const countEl   = document.getElementById(`like-count-${photoId}`);

    try {
        const response = await fetch('/MyInsta/utils/likes/like.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ photoId })
        });

        if (!response.ok) {
            console.error('Erreur like HTTP', response.status);
            return;
        }

        const data = await response.json();

        if (data.error) {
            console.error('Erreur like:', data.error);
            return;
        }

        // Mise à jour du compteur
        if (countEl) countEl.textContent = data.count;

        // Feedback visuel : cœur rouge si liké, blanc sinon
        const icon = document.getElementById(`like-icon-${photoId}`);
        if (icon) {
            icon.style.filter = data.liked
                ? 'invert(27%) sepia(99%) saturate(2000%) hue-rotate(330deg)'
                : 'invert(1)';
            icon.classList.add('like-bounce');
            icon.addEventListener('animationend', () => icon.classList.remove('like-bounce'), { once: true });
        }
    } catch (err) {
        console.error('Erreur réseau like:', err);
    }
}
