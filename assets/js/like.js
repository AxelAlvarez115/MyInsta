async function like (photoId) {
    const response = await fetch('/MyInsta/utils/likes/like.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ photoId : photoId })
    });
    // const data = await response.json();
    // if (data.liked !== undefined) {
    //     const likeCountElement = document.getElementById(`like-count-${photoId}`);
    //     if (likeCountElement) {
    //         likeCountElement.textContent = data.liked ? parseInt(likeCountElement.textContent) + 1 : parseInt(likeCountElement.textContent) - 1;
    //     }
    // }
    // else {
    //     alert('An error occurred while liking the photo.');
    // }
}