<?php

return [
    'host' => $_ENV['PGHOST'] ?? 'localhost',
    'port' => $_ENV['PGPORT'] ?? '5432',
    'database' => $_ENV['PGDATABASE'] ?? 'tewiiq',
    'username' => $_ENV['PGUSER'] ?? 'postgres',
    'password' => $_ENV['PGPASSWORD'] ?? '',
    'dsn' => $_ENV['DATABASE_URL'] ?? null,
];