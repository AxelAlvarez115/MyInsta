<?php
    function updateCommentContent($id, $content, $pdo) {
        $stmt = $pdo->prepare("UPDATE comments SET content = :content WHERE id = :id");
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
?>