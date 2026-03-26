<?php
$data = ['id_keluarga' => '1', 'status_jentik' => 'tidak', 'sumber_air' => 'Ember Ajaib', 'catatan' => 'Tes Local', 'tanggal' => '2026-03-20', 'petugas' => '1'];
$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data)
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents('http://127.0.0.1/api/jumantik/create.php', false, $context);
echo "RESPONSE FROM API: " . $result;
?>
