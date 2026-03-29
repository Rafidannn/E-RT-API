<?php
$source = "c:/flutterrgabubg/API/notifikasi";
$dest = "c:/xampp/htdocs/api/notifikasi";
@mkdir($dest, 0777, true);
$files = glob($source . "/*.*");
foreach($files as $file) {
    copy($file, str_replace($source, $dest, $file));
}
echo "Copied notifikasi\n";

$source2 = "c:/flutterrgabubg/API/verifikasi";
$dest2 = "c:/xampp/htdocs/api/verifikasi";
@mkdir($dest2, 0777, true);
$files = glob($source2 . "/*.*");
foreach($files as $file) {
    copy($file, str_replace($source2, $dest2, $file));
}
echo "Copied verifikasi\n";
?>
