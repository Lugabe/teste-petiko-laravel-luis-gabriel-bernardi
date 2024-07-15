<?php

$logFile = 'storage/logs/laravel.log';
$searchString = 'Novo usuário cadastrado';

if (!file_exists($logFile)) {
    die("Arquivo de log não encontrado: $logFile\n");
}

// Ler o arquivo de log em linhas
$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$latestLog = '';

// Percorrer as linhas em ordem reversa para encontrar a mais recente
foreach (array_reverse($lines) as $line) {
    if (strpos($line, $searchString) !== false) {
        $latestLog = $line;
        break;
    }
}

if ($latestLog) {
    echo "Último log de criação de usuário:\n$latestLog\n";
} else {
    echo "Nenhum log de criação de usuário encontrado.\n";
}
