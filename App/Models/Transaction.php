<?php
namespace App\Models;

class Transaction {
    public ?int $id;
    public string $type;
    public float $amount;
    public string $description;

    public function __construct(?int $id, string $type, float $amount, string $description) {
        $this->id = $id;
        $this->type = $type;
        $this->amount = $amount;
        $this->description = $description;
    }

    public function display(): string {
        $sign = $this->type === 'income' ? '+' : '-';
        return "ID: {$this->id} | {$this->description} | {$sign}{$this->amount} Ft";
    }
}
?>
