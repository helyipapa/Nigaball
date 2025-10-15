Készítette: [Morzsa Milán Dominik,Boros Péter]

## Model - Transaction.php

A Transaction model egy egyszerű PHP class ami egy pénzügyi tranzakciót reprezentál. A model a következő tulajdonságokat tartalmazza:

### Tulajdonságok:
1. **id** - A tranzakció azonosítója
2. **type** - A tranzakció típusa
3. **amount** - A tranzakció összege
4. **description** - A tranzakció leírása
5. **created_at** - A tranzakció létrehozásának időpontja

### Konstruktor:
```php
public function __construct($id, $type, $amount, $description, $created_at = null)
```

A konstruktor paraméterek alapján építi fel a tranzakció objektumot

## Controller/Service - FinanceManager.php

A FinanceManager osztály tartalmazza az alkalmazás fő logikáját és a CRUD-ot:

### Konstruktor:
```php
public function __construct($pdo)
{
    $this->pdo = $pdo;
}
```

A konstruktor felépíti a PDO adatbázis kapcsolatot

### Főbb funkciók:

#### Create (Létrehozás):
- **addTransaction()** - Új tranzakció hozzáadása az adatbázishoz
- SQL injection elleni védelem prepared statement-ekkel

#### Read (Olvas):
- **listTransactions()** - Az összes tranzakció kilistázása
- **calculateBalance()** - Egyenleg számítása

#### Delete (Törlés):
- **deleteTransaction()** - Tranzakció törlése ID alapján

## Adatbázis struktúra

### transactions tábla:
```sql
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('income','expense') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
```

## Használat

### Parancsori argumentumok:

1. **Tranzakciók kilistázása:**
   ```bash
   php index.php list
   ```

2. **Új bevétel hozzáadása:**
   ```bash
   php index.php add income 50000 "Fizetés"
   ```

3. **Új kiadás hozzáadása:**
   ```bash
   php index.php add expense 12000 "Bevásárlás"
   ```

4. **Egyenleg lekérdezése:**
   ```bash
   php index.php balance
   ```

5. **Tranzakció törlése:**
   ```bash
   php index.php delete 3
   ```

## Telepítés és konfiguráció

### Előfeltételek:
- XAMPP vagy hasonló webszerver környezet
- PHP 7.0 vagy újabb verzió
- MySQL adatbázis

### Telepítési lépések:
1. Másold a fájlokat a htdocs-ba
2. Indítsd el a XAMPP-ot
3. Hozz létre egy `finance_db` nevű adatbázist
4. Futtasd a scriptet

### Adatbázis konfiguráció:
Az `index.php` fájlban található az adatbázis beállításai:
```php
$dbHost = 'localhost';
$dbName = 'finance_db';
$dbUser = 'root';
$dbPass = '';
```

## Funkciók

- Tranzakciók létrehozása
- Tranzakciók kilistázása
- Egyenleg számítása
- Tranzakciók törlése
- SQL injection védelem
- Automatikus adatbázis tábla létrehozás