<?php
$file = isset($_GET['file']) ? basename($_GET['file']) : '';

// IMPORTANT: Path must be relative to where show.php is located on the server
$path = "gurukul/gurukul/uploads/" . $file; 

if (!empty($file) && file_exists($path)) {

    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    // Set correct headers for permanent display
    if ($ext == "jpg" || $ext == "jpeg") {
        header("Content-Type: image/jpeg");
    } 
    elseif ($ext == "png") {
        header("Content-Type: image/png");
    } 
    else {
        exit("Unsupported file type");
    }

    // Clean any previous output to prevent image corruption
    ob_clean();
    flush();

    readfile($path);
    exit;
} else {
    // If you see this message, the file is not in the 'uploads' folder on the server
    echo "File not found on server at: " . $path;
}
?>
