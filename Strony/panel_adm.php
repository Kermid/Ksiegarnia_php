<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/style_adm.css">
    <title>Księgarnia</title>
</head>
<body>
    
    <?php
    include("connect.php");
     $view = $_GET['view'] ?? 'ksiazki';
    switch ($view) 
    {
        case 'ksiazki':
                 $sql = "SELECT Ksiazki.ksiazka_id, Ksiazki.tytul, Ksiazki.autor_imie,Ksiazki.autor_nazwisko, Ksiazki.isbn, Ksiazki.rok_wydania, Gatunki.nazwa 
                FROM Ksiazki
                LEFT JOIN Gatunki ON Ksiazki.gatunek_id = Gatunki.gatunek_id";
                $result = pg_query($conn, $sql);

                echo "<h2 style='text-align:center;'>Lista książek</h2>";

                if (pg_num_rows($result)> 0) {
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Tytuł</th><th>Imię autora</th><th>Nazwisko autora</th><th>ISBN</th><th>Rok wydania</th><th>Gatunek</th></tr>";
                    while ($row = pg_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["ksiazka_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["tytul"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["autor_imie"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["autor_nazwisko"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["isbn"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["rok_wydania"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nazwa"]) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else 
                {
                    echo "<p style='text-align:center;'>Brak książek w bazie.</p>";
                }
            break;
        case 'uzytkownicy':
                 echo "<h2 style='text-align:center;'>Lista użytkowników</h2>";
                $sql = "SELECT user_id,imie,nazwisko,email,nr_telefonu
                        FROM uzytkownicy";
                $result = pg_query($conn, $sql);

                if (pg_num_rows($result) > 0) 
                {
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>E-mail</th><th>Nr-telefonu</th></tr>";
                    while ($row = pg_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["imie"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nazwisko"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nr_telefonu"]) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else 
                {
                    echo "<p style='text-align:center;'>Brak użytkowników bazie.</p>";
                }
            break;
        case 'wypozyczenia':
                echo "<h2 style='text-align:center;'>Lista wypożyczeń</h2>";
                $sql = "SELECT wypozyczenie_id,ksiazka_id,data_wypozyczenia,data_zwrotu,status
                        FROM wypozyczenia";
                $result = pg_query($conn, $sql);

                if (pg_num_rows($result) > 0) 
                {
                    echo "<table>";
                    echo "<tr><th>ID rezerwacji</th><th>ID książki</th><th>Data wypożyczenia</th><th>Data zwrotu</th><th>Status</th></tr>";
                    while ($row = pg_fetch_assoc($result)) 
                    {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["wypozyczenie_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["ksiazka_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["data_wypozyczenia"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["data_zwrotu"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else 
                {
                    echo "<p style='text-align:center;'>Brak rezerwacji bazie.</p>";
                }
            break;
        case 'rezerwacje':
                echo "<h2 style='text-align:center;'>Lista rezerwacji</h2>";
                $sql = "SELECT rezerwacja_id,user_id,ksiazka_id,data_rezerwacji,status
                        FROM rezerwacje";
                $result = pg_query($conn, $sql);

                if (pg_num_rows($result) > 0) 
                {
                    echo "<table>";
                    echo "<tr><th>ID rezerwacjI</th><th>ID użytkownika</th><th>ID książki</th><th>Data rezerwacji</th><th>Status</th></tr>";
                    while ($row = pg_fetch_assoc($result)) 
                    {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["rezerwacja_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["ksiazka_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["data_rezerwacji"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else 
                {
                    echo "<p style='text-align:center;'>Brak wypożyczeń bazie.</p>";
                }
            break;
        case 'pracownicy':
                echo "<h2 style='text-align:center;'>Lista Pracowników</h2>";
                $sql = "SELECT pracownik_id,imie,nazwisko,email
                        FROM pracownicy";
                $result = pg_query($conn, $sql);

                if (pg_num_rows($result) > 0) 
                {
                    echo "<table>";
                    echo "<tr><th>ID pracownika</th><th>Imie</th><th>Nazwisko</th><th>E-mail</th></tr>";
                    while ($row = pg_fetch_assoc($result)) 
                    {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["pracownik_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["imie"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nazwisko"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else 
                {
                    echo "<p style='text-align:center;'>Brak pracowników bazie.</p>";
                }
            break;
    }
    pg_close($conn);
    ?>
    <!--przyciski do przelaczania sie pomiedzy tabelami -->
     <div class="nav-buttons">
        <form action="panel_adm.php" method="get">
            <button name="view" value="ksiazki">Książki</button>
            <button name="view" value="uzytkownicy">Użytkownicy</button>
            <button name="view" value="rezerwacje">Rezerwacje</button>
            <button name="view" value="wypozyczenia">Wypożyczenia</button>
            <button name="view" value="pracownicy">Pracownicy</button>
        </form>
        <form action="strona_ksiegarni.php">
            <button type="submit">Widok ksiegarni</button>
        </form>
    </div>
</body>
</html>