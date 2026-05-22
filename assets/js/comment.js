async function getComments (photoId) {
    const response = await fetch('/MyInsta/utils/comments/get_comments.php?photo_id=' + photoId, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    const data = await response.json();
    return data.comments;
}