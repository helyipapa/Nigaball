<?php
// FinanceManager Controller

spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Models\Transaction;
use App\Services\FinanceManager;

$dbHost = 'localhost';
$dbName = 'finance_db';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo " Sikeres adatbázis kapcsolat!\n";
} catch (PDOException $ex) {
    die(" Adatbázis hiba: " . $ex->getMessage());
}

$sql = "
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('income','expense') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";
$pdo->exec($sql);

$manager = new FinanceManager($pdo);
$action = $argv[1] ?? 'list';

switch ($action) {
    case 'list':
        $manager->listTransactions();
        break;

    case 'add':
        $type = $argv[2] ?? 'income';
        $amount = (float)($argv[3] ?? 0);
        $desc = $argv[4] ?? 'Ismeretlen tranzakció';
        $transaction = new Transaction(null, $type, $amount, $desc);
        $manager->addTransaction($transaction);
        break;

    case 'balance':
        $manager->calculateBalance();
        break;

    case 'delete':
        $id = (int)($argv[2] ?? 0);
        $manager->deleteTransaction($id);
        break;

    default:
        echo "Használat: php index.php [add|list|balance|delete]\n";
        echo "Példa:\n";
        echo " php index.php add income 50000 'Fizetés'\n";
        echo " php index.php add expense 12000 'Bevásárlás'\n";
        echo " php index.php list\n";
        echo " php index.php balance\n";
        echo " php index.php delete 3\n";
        break;
}
?>
