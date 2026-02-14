<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>message-display</title>
</head>

<body>

    <h1>message-display</h1>
    <p>This script is used to list and process files in a specific directory.</p>

    <?php
    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    echo "<p>Current URI: $uri</p>";
    ?>

    <ul>
        <?php

        $dir = "/var/www/workerbase.org/public_html/$uri";

        $files = scandir($dir);
        $files = array_diff($files, array('.', '..'));
        if (empty($files)) {
            echo "No files found in the directory.";
        } else {
            foreach ($files as $file) {
                $filePath = $dir . '/' . $file;
                if (is_file($filePath)) {
                    //echo "Processing file: $file\n";
                    echo "<li><a href='$file'>$file</a></li>\n";
                    // Here you can add code to process each file as needed
                } else if (is_dir($filePath)) {
                    echo "<li><a href='$file'>$file</a> (Directory)</li>\n";
                } else {
                    echo "$file is not a valid file.\n";
                }
            }
        }
        ?>
    </ul>

    <?php
    $md_files = array_filter($files, function ($file) {
        return pathinfo($file, PATHINFO_EXTENSION) === 'md';
    });
    if (!empty($md_files)) {
        echo "<h3>Markdown Files</h3><ul>";
        echo "<script src='https://arkenidar.com/app/lib/html-markdown/markdown.js'></script>";
        foreach ($md_files as $md_file) {
            echo "<li><a href='$md_file'>$md_file</a><br>\n";
            echo "<div class='markdown-url' data-url='$md_file'></div>\n";
            echo "</li>\n";
        }
        echo "</ul>";
    } else {
        echo "<p>No Markdown files found in the directory.</p>";
    }
    ?>

</body>

</html>