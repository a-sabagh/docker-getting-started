<?php

require __DIR__ . '/vendor/autoload.php';

use SimpleUploader\Uploader;

$uploadedFiles = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDirectory = __DIR__ . '/uploads';

    $uploader = new Uploader($uploadDirectory);

    $uploadedFiles = $uploader->upload($_FILES['files']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple File Uploader</title>
    <style>
        body { max-width: 40rem; margin: 3rem auto; font-family: sans-serif; }
    </style>
</head>

<body style="background-color: darksalmon;">
    <h1>Upload files</h1>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="files[]" multiple>
        <button type="submit">Upload</button>
    </form>

    <?php if ($uploadedFiles): ?>
        <h2>Uploaded</h2>
        <ul>
            <?php foreach ($uploadedFiles as $file): ?>
                <li><a href="uploads<?php echo $file['path']; ?>"><?php echo $file['basename']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
