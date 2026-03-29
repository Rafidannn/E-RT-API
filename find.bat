powershell -c "Get-ChildItem -Path C:\xampp\htdocs -Filter get_notifikasi.php -Recurse -ErrorAction SilentlyContinue | Select-Object -ExpandProperty FullName" > C:\flutterrgabubg\API\found.txt
