<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Database connection
$conn = mysqli_connect("sql100.infinityfree.com", "if0_41253855", "Mutha9529", "if0_41253855_startersql");
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

// 2. PATH SETUP (FIXED FOR OPEN_BASEDIR)
// __DIR__ use karne se script apne hi folder ke andar 'uploads' ko dhoondhega
$upload_folder = "gurukul/gurukul/uploads/";

// Folder check aur creation
if (!is_dir($upload_folder)) {
    mkdir($upload_folder, 0755, true);
}

// 3. FILE UPLOAD FUNCTION
function uploadFile($field) {
    global $upload_folder;

    if (isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
        $name = $_FILES[$field]['name'];
        $tmp  = $_FILES[$field]['tmp_name'];

        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $allowed = array("jpg", "jpeg", "png");

        if (in_array($ext, $allowed)) {
            $newname = time() . "_" . rand(1000, 9999) . "." . $ext;
            
            // Yahan error aa raha tha, ab fixed hai
            if (move_uploaded_file($tmp, $upload_folder ."/". $newname)) {
                return $newname; 
            }
        }
    }
    return "";
}

// 4. UPLOAD ALL FILES
$student_photo      = uploadFile("student_photo");
$student_signature  = uploadFile("student_signature");
$parent_signature   = uploadFile("parent_signature");
$mother_signature   = uploadFile("mother_signature");
$father_signature   = uploadFile("father_signature");
$preparer_signature = uploadFile("preparer_signature");
$file_birth_cert    = uploadFile("file_birth_certi"); 
$file_caste_cert    = uploadFile("file_caste_certi");
$file_lc            = uploadFile("file_lc");
$file_marksheet     = uploadFile("file_marksheet");



// 5. CLEAN INPUTS (SQL Injection se bachne ke liye)
function clean($conn, $key) {
    return isset($_POST[$key]) ? mysqli_real_escape_string($conn, trim($_POST[$key])) : '';
}

$student_full_name = clean($conn, 'student_full_name');
$father_full_name  = clean($conn, 'father_full_name');
$mother_name       = clean($conn, 'mother_name');
$academic_class    = clean($conn, 'academic_class');
$academic_year     = clean($conn, 'academic_year');
$mobile1           = clean($conn, 'mobile1');
$mobile2           = clean($conn, 'mobile2');
$aadhar_number     = clean($conn, 'aadhar_number');
$current_address   = clean($conn, 'current_address');
$permanent_address = clean($conn, 'permanent_address');
$birth_place       = clean($conn, 'birth_place');
$religion_cast     = clean($conn, 'religion_cast');
$mother_tongue     = clean($conn, 'mother_tongue');
$prev_school_name  = clean($conn, 'prev_school_name');
$weight            = clean($conn, 'weight');
$height            = clean($conn, 'height');
$student_diseases  = clean($conn, 'student_diseases');

// 6. INSERT QUERY
$sql = "INSERT INTO admissions (
            student_full_name, father_full_name, mother_name, academic_class, academic_year,
            mobile1, mobile2, aadhar_number, current_address, permanent_address,
            student_photo, student_signature, parent_signature, mother_signature,
            father_signature, preparer_signature, birth_place, 
            prev_school_name, weight, height, student_diseases,
            file_birth_cert, file_caste_cert, file_lc, file_marksheet
        ) VALUES (
            '$student_full_name', '$father_full_name', '$mother_name', '$academic_class', '$academic_year',
            '$mobile1', '$mobile2', '$aadhar_number', '$current_address', '$permanent_address',
            '$student_photo', '$student_signature', '$parent_signature', '$mother_signature',
            '$father_signature', '$preparer_signature', '$birth_place',
            '$prev_school_name', '$weight', '$height', '$student_diseases',
            '$file_birth_cert', '$file_caste_cert', '$file_lc', '$file_marksheet'
        )";

// 7. EXECUTION & RESPONSE
echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
if (mysqli_query($conn, $sql)) {
    echo "<h2 style='color:green'>Data Saved Successfully ✅</h2>";
    
} else {
    echo "<h2 style='color:red'>Database Error ❌</h2>";
    echo "<p>" . mysqli_error($conn) . "</p>";
}
echo "<br><br>";
echo "<a href='form.html' style='padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:5px;'>Submit Another Response</a>";
echo "<button style='padding:10px 20px; margin:5px; cursor:pointer;' onclick='window.history.back()'>Edit Response</button>";
echo "</div>";

mysqli_close($conn);
?>
