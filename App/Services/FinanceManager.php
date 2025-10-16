<?php
namespace App\Services;

use App\Models\Transaction;
use PDO;

class FinanceManager {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function addTransaction(Transaction $transaction): void {
        $stmt = $this->pdo->prepare("INSERT INTO transactions (type, amount, description) VALUES (?,?,?)");
        $stmt->execute([$transaction->type, $transaction->amount, $transaction->description]);
        echo " Tranzakció hozzáadva!\n";
    }

    public function listTransactions(): void {
        $stmt = $this->pdo->query("SELECT * FROM transactions");
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$transactions) {
            echo "Nincsenek tranzakciók.\n";
            return;
        }

        echo "\n--- Tranzakciók listája ---\n";
        foreach ($transactions as $row) {
            $t = new Transaction($row['id'], $row['type'], $row['amount'], $row['description']);
            echo $t->display() . "\n";
        }
        echo "----------------------------\n";
    }

    public function calculateBalance(): void {
        $stmt = $this->pdo->query("SELECT type, amount FROM transactions");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $balance = 0;
        foreach ($rows as $row) {
            $balance += ($row['type'] === 'income') ? $row['amount'] : -$row['amount'];
        }
        echo "\nJelenlegi egyenleg: {$balance} Ft\n";
    }

    public function deleteTransaction(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM transactions WHERE id = ?");
        $success = $stmt->execute([$id]);
        echo $success ? "Tranzakció törölve!\n" : " Sikertelen törlés!\n";
    }
}
?>
