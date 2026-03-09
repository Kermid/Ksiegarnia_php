<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_ksiegarnia.css">
    <title>Ksiegarnia</title>
</head>
<body>
    <h1>Księgarnia</h1>
    <div class="view-buttons">
        <form action="strona_ksiegarni.php" method="get">
            <button type="submit" name="view" value="Dostepne">Dostępne</button>
            <button type="submit" name="view" value="Wypozyczone">Wypożyczone</button>
            <button type="submit" name="view" value="Wszystkie">Wszystkie</button>
            <button type="submit" name="view" value="Oddawanie">Oddaj książke</button>
        </form>
    </div>

<?php

    include("connect.php");
    include("wypozyczanie.php");
    include("oddawanie.php");
    include("rezerwacja.php");

    $view = $_GET['view'] ?? "Dostepne";
    switch ($view) 
    {
        case 'Dostepne':
                ?>
                <h1>Wszystkie dostępne książki</h1>
                <?php
                $sql = "SELECT 
                Ksiazki.ksiazka_id,
                Ksiazki.tytul,
                Ksiazki.autor_imie,
                Ksiazki.autor_nazwisko,
                Ksiazki.isbn,
                Ksiazki.rok_wydania,
                Wypozyczenia.status
                FROM Wypozyczenia
                JOIN Ksiazki ON Wypozyczenia.ksiazka_id = Ksiazki.ksiazka_id
                WHERE Wypozyczenia.status = 'zwrócona';";
                $result = pg_query($conn, $sql);

                if (pg_num_rows($result) > 0) {
                    while ($row = pg_fetch_assoc($result)) 
                    {
                        ?>
                        <div class="ksiazka">
                            <div class="info">
                                <p><strong>Tytuł:</strong> <?= htmlspecialchars($row['tytul']) ?></p>
                                <p><strong>Autor:</strong> <?= htmlspecialchars($row['autor_imie'])." ".htmlspecialchars($row['autor_nazwisko']) ?></p>
                                <p><strong>ISBN:</strong> <?= htmlspecialchars($row['isbn']) ?></p>
                                <p><strong>Rok wydania:</strong> <?= htmlspecialchars($row['rok_wydania']) ?></p>
                                <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>
                            </div>
                            <div class="akcje">
                                <?php
                                    if(htmlspecialchars($row['status']) === 'zwrócona')
                                    {
                                ?>
                                        <form action="strona_ksiegarni.php" method="get">
                                        <input type="hidden" name="view" value="Wypozyczanie">
                                        <button type="submit" name="ksiazka_id" value="<?= htmlspecialchars($row['ksiazka_id']) ?>">Wypożycz</button>
                                        </form>
                                        <form action="strona_ksiegarni.php" method="get">
                                        <input type="hidden" name="view" value="rezerwacja">
                                        <button type="submit" name="ksiazka_id" value="<?= htmlspecialchars($row['ksiazka_id']) ?>">Rezerwuj</button>
                                        </form>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                } 
                else 
                {
                    echo "<p>Brak książek na magazynie.</p>";
                }
            break;
        case 'Wypozyczone':
                ?>
                <h1>Wszystkie wypożyczone książki</h1>
                <?php
                $sql = "SELECT 
                Ksiazki.ksiazka_id,
                Ksiazki.tytul,
                Ksiazki.autor_imie,
                Ksiazki.autor_nazwisko,
                Ksiazki.isbn,
                Ksiazki.rok_wydania,
                Wypozyczenia.status
                FROM Wypozyczenia
                JOIN Ksiazki ON Wypozyczenia.ksiazka_id = Ksiazki.ksiazka_id
                WHERE Wypozyczenia.status IN ('wypożyczona', 'przetrzymana')";
                $result = pg_query($conn, $sql);

                if (pg_num_rows($result) > 0) {
                    while ($row = pg_fetch_assoc($result)) 
                    {
                        ?>
                        <div class="ksiazka">
                            <div class="info">
                                <p><strong>Tytuł:</strong> <?= htmlspecialchars($row['tytul']) ?></p>
                                <p><strong>Autor:</strong> <?= htmlspecialchars($row['autor_imie'])." ".htmlspecialchars($row['autor_nazwisko']) ?></p>
                                <p><strong>ISBN:</strong> <?= htmlspecialchars($row['isbn']) ?></p>
                                <p><strong>Rok wydania:</strong> <?= htmlspecialchars($row['rok_wydania']) ?></p>
                                <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>
                            </div>
                        </div>
                        <?php
                    }
                } 
                else 
                {
                    echo "<p>Brak wypożyczonych książek.</p>";
                }
            break;
        case 'Oddawanie':
                ?>
                <h1>Oddaj książkę</h1>
                <form action="strona_ksiegarni.php" method="get" class="oddawanie-form">
                    <input type="hidden" name="view" value="Oddawanie">
                    <label>Podaj ID użytkownika:</label>
                    <input type="number" name="user_id" required>
                    <button type="submit">Pokaż książki</button>
                </form>
                <?php

                $user_id = $_GET['user_id'] ?? null;

                if (isset($user_id)) 
                {
                    $sql = "SELECT 
                        Ksiazki.ksiazka_id,
                        Ksiazki.tytul,
                        Ksiazki.autor_imie,
                        Ksiazki.autor_nazwisko,
                        Ksiazki.isbn,
                        Ksiazki.rok_wydania,
                        Wypozyczenia.status
                    FROM Wypozyczenia
                    JOIN Ksiazki ON Wypozyczenia.ksiazka_id = Ksiazki.ksiazka_id
                    WHERE (Wypozyczenia.status = 'wypożyczona' OR Wypozyczenia.status = 'przetrzymana')
                    AND Wypozyczenia.user_id = $user_id";

                    $result = pg_query($conn, $sql);

                    if (pg_num_rows($result) > 0) 
                    {
                        while ($row = pg_fetch_assoc($result)) 
                        {
                            ?>
                            <div class="ksiazka">
                                <div class="info">
                                    <p><strong>Tytuł:</strong> <?= htmlspecialchars($row['tytul']) ?></p>
                                    <p><strong>Autor:</strong> <?= htmlspecialchars($row['autor_imie'])." ".htmlspecialchars($row['autor_nazwisko']) ?></p>
                                    <p><strong>ISBN:</strong> <?= htmlspecialchars($row['isbn']) ?></p>
                                    <p><strong>Rok wydania:</strong> <?= htmlspecialchars($row['rok_wydania']) ?></p>
                                    <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>
                                </div>
                                <div class="akcje">
                                    <form action="strona_ksiegarni.php" method="get">
                                        <input type="hidden" name="view" value="Oddawanie">
                                        <input type="hidden" name="ksiazka_id" value="<?= htmlspecialchars($row['ksiazka_id']) ?>">
                                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
                                        <button type="submit">Oddaj</button>
                                    </form>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>Brak wypożyczonych książek dla tego użytkownika.</p>";
                    }
                }
            break;
        case 'rezerwacja':
                ?>
            <h1>Rezerwacja książki</h1>
            <form action="strona_ksiegarni.php" method="get" class="oddawanie-form">
                <input type="hidden" name="ksiazka_id" value="<?= htmlspecialchars($_GET['ksiazka_id']) ?>"><br>
                <input type="hidden" name="view" value="rezerwacja"><br>
                <label>Podaj swój ID użytkownika:</label><br>
                <input type="number" name="user_id" required><br>
                <label>Podaj date oddania książki:</label><br>
                <input type="date" name="data_rezerwacji"><br>
                <button type="submit">Zarezerwuj</button>
            </form>
            <?php
            break;
        case 'Wszystkie':
             ?>
                <h1>Wszystkie książki</h1>
                <?php
                $sql = "SELECT 
                Ksiazki.ksiazka_id,
                Ksiazki.tytul,
                Ksiazki.autor_imie,
                Ksiazki.autor_nazwisko,
                Ksiazki.isbn,
                Ksiazki.rok_wydania,
                Wypozyczenia.status
                FROM Wypozyczenia
                JOIN Ksiazki ON Wypozyczenia.ksiazka_id = Ksiazki.ksiazka_id;";
                $result = pg_query($conn, $sql);

                if (pg_num_rows($result) > 0) 
                {
                    while ($row = pg_fetch_assoc($result)) 
                    {
                        ?>
                        <div class="ksiazka">
                            <div class="info">
                                <p><strong>Tytuł:</strong> <?= htmlspecialchars($row['tytul']) ?></p>
                                <p><strong>Autor:</strong> <?= htmlspecialchars($row['autor_imie'])." ".htmlspecialchars($row['autor_nazwisko']) ?></p>
                                <p><strong>ISBN:</strong> <?= htmlspecialchars($row['isbn']) ?></p>
                                <p><strong>Rok wydania:</strong> <?= htmlspecialchars($row['rok_wydania']) ?></p>
                                <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>
                            </div>
                            <div class="akcje">
                                <?php
                                    if(htmlspecialchars($row['status']) === 'zwrócona')
                                    {
                                ?>
                                        <form action="strona_ksiegarni.php" method="get">
                                        <input type="hidden" name="view" value="Wypozyczanie">
                                        <button type="submit" name="ksiazka_id" value="<?= htmlspecialchars($row['ksiazka_id']) ?>">Wypożycz</button>
                                        </form>
                                        <form action="strona_ksiegarni.php" method="get">
                                        <input type="hidden" name="view" value="rezerwacja">
                                        <button type="submit" name="ksiazka_id" value="<?= htmlspecialchars($row['ksiazka_id']) ?>">Rezerwuj</button>
                                        </form>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                } 
                else 
                {
                    echo "<p>Brak książek na magazynie.</p>";
                }
            break;
        case 'Wypozyczanie':
              ?>
                <h1>Wypożycz książkę</h1>
                <form action="strona_ksiegarni.php" method="get" class="oddawanie-form">
                    <input type="hidden" name="view" value="Wypozyczanie"><br>
                    <input type="hidden" name="ksiazka_id" value="<?= htmlspecialchars($_GET['ksiazka_id'] ?? '') ?>"><br>
                    <label>Podaj swój ID:</label><br>
                    <input type="number" name="user_id"><br>
                    <label>Podaj date oddania książki:</label><br>
                    <input type="date" name="data"><br>
                    <button type="submit">Wypożycz</button>
                </form>
                <?php
            break;
    }
    ?>
        <div class="view-buttons">
        <form action="panel_adm.php" method="get">
            <button type="submit">Panel Administratora</button>
        </form>
    </div>
    
    <?php
    pg_close($conn);
?>
</body>
</html>