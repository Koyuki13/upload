<?php

$uploadDir = './uploads/';
$messages = [];
if (isset($_FILES['avatars']) AND !empty($_FILES['avatars']['name'])) {
    $tailleMax = 1000000;
    $extensionsValides = array('jpg', 'png', 'gif');
    $nbUploadedFiles = count($_FILES['avatars']['name']);
    for ($i=0; $i<=$nbUploadedFiles; $i++) {
        if ($_FILES['avatars']['size'][$i] <= $tailleMax) {
            $extension = pathinfo($_FILES['avatars']['name'][$i], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            if (in_array($extension, $extensionsValides)) {
                $uploadFile = $uploadDir . basename($_FILES['avatars']['name'][$i]);
                $resultat = move_uploaded_file($_FILES['avatars']['tmp_name'][$i], $uploadFile);
                if (!$resultat) {
                    $messages[] = 'Votre fichier' . $_FILES['avatars']['name'][$i] . 'est merdique';
                }
            } else {
                $messages[] = 'Votre fichier' . $_FILES['avatars']['name'][$i] . 'est invalide';
            }
        } else {
            $messages[] = 'Votre fichier' . $_FILES['avatars']['name'][$i] . 'ne doit pas dépasser 1Mo';
        }
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Upload de fichiers</title>
</head>

<body>
<h1>Formulaire d'upload de fichiers</h1>
<form action="" method="post" enctype="multipart/form-data">
    <label for="imageUpload">Upload an profile image</label>
    <input type="file" name="avatars[]" multiple="multiple" />
    <button>Send</button>
</form>
<?php
$images = new FilesystemIterator($uploadDir);
foreach ($images as $image):
?>

<figure>
    <img src="<?= $image ?>" alt="/<?= $image->getFilename()?>"/>
    <figcaption>
        <?= $image->getFilename()?>
    </figcaption>
</figure>
<?php endforeach;

foreach ($messages as $message) {
    echo $message . "<br>";
}
?>
</body>
</html>