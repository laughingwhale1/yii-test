<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'mysql:host=mysql;dbname=yii2-test-db';
$db['username'] = 'root';
$db['password'] = 'root';

return $db;
