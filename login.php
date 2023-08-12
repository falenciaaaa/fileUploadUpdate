<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
</head>
<body>
    <h1>Upload a File and Enter Your Email</h1>
    <form action="fileupload.php" method="post" enctype="multipart/form-data">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="file">Upload a JPEG or PNG file:</label>
        <input type="file" id="file" name="file" accept=".jpeg,.png" required>
        <br>
        <input type="submit" value="Submit">
    </form>

    <h2>Uploaded Files</h2>
    <table>
        <tr>
            <th>Email</th>
            <th>File Path</th>
        </tr>
        <?php foreach ($uploads as $upload) : ?>
            <tr>
                <td><?php echo $upload['email']; ?></td>
                <td><a href="<?php echo $upload['file_path']; ?>" target="_blank"><?php echo $upload['file_path']; ?></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>