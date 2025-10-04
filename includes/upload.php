<?php
if (isset($_FILES['imagem_capa']) && $_FILES['imagem_capa']['error'] === UPLOAD_ERR_OK) {
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    $file_tmp_path = $_FILES['imagem_capa']['tmp_name'];
    $file_name = basename($_FILES['imagem_capa']['name']);
    $target_file_path = $upload_dir . uniqid() . '_' . $file_name;
    if (move_uploaded_file($file_tmp_path, $target_file_path)) {
        $imagem_capa = $upload_dir . basename($target_file_path);
    }
}
?>