<?php
// Database connection
$conn = mysqli_connect("sql100.infinityfree.com", "if0_41253855", "Mutha9529", "if0_41253855_startersql");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM admissions ORDER BY id DESC");

// CSS for a robust, permanent view
echo "<style>
    body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 20px; }
    .card { background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
    th { background: #0056b3; color: white; }
    img { border: 1px solid #ccc; border-radius: 4px; background: #eee; }
    .label { display: block; font-size: 11px; font-weight: bold; margin-bottom: 5px; color: #333; }
</style>";

while($row = mysqli_fetch_assoc($result)){
?>

<div class="card">
    <h2>Student: <?php echo htmlspecialchars($row['student_full_name']); ?></h2>
    <table>
        <tr>
            <th>Primary Photo</th>
            <th>Required Documents (JPG)</th>
            <th>All Signatures</th>
        </tr>
        <tr>
            <td>
                <span class="label">PROFILE PHOTO</span>
                <img src="show.php?file=<?php echo urlencode($row['student_photo']); ?>" width="130" alt="Image Missing">
            </td>

            <td>
                <div style="margin-bottom: 15px;">
                    <span class="label">BIRTH CERTIFICATE</span>
                    <img src="show.php?file=<?php echo urlencode($row['file_birth_cert']); ?>" width="110" alt="Not Found">
                </div>
                <div style="margin-bottom: 15px;">
                    <span class="label">CASTE CERTIFICATE</span>
                    <img src="show.php?file=<?php echo urlencode($row['file_caste_cert']); ?>" width="110" alt="Not Found">
                </div>
                <div style="margin-bottom: 15px;">
                    <span class="label">MARKSHEET</span>
                    <img src="show.php?file=<?php echo urlencode($row['file_marksheet']); ?>" width="110" alt="Not Found">
                </div>
                <div>
                    <span class="label">LC DATA</span>
                    <img src="show.php?file=<?php echo urlencode($row['file_lc']); ?>" width="110" alt="Not Found">
                </div>
            </td>

            <td>
                <span class="label">Student:</span> <img src="show.php?file=<?php echo urlencode($row['student_signature']); ?>" width="90"><br><br>
                <span class="label">Parent:</span> <img src="show.php?file=<?php echo urlencode($row['parent_signature']); ?>" width="90"><br><br>
                <span class="label">Mother:</span> <img src="show.php?file=<?php echo urlencode($row['mother_signature']); ?>" width="90"><br><br>
                <span class="label">preparer:</span> <img src="show.php?file=<?php echo urlencode($row['preparer_signature']); ?>" width="90">
            </td>
        </tr>
    </table>
</div>

<?php } ?>
