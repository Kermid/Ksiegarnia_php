<?php

if (isset($_GET['user_id']) && isset($_GET['view']) && $_GET['view'] === 'Wypozyczanie') 
{
    
    $user_id = (int) $_GET['user_id'];
    $ksiazka_id = (int) $_GET['ksiazka_id'];
    $date = $_GET['data'] ?? null;

    if ($date) {
        $update_sql = "UPDATE Wypozyczenia
                       SET status = 'wypożyczona', data_wypozyczenia = CURRENT_DATE, data_zwrotu = '$date'
                       WHERE ksiazka_id = $ksiazka_id AND status = 'zwrócona'";
    } else {
        $update_sql = "UPDATE Wypozyczenia
                       SET status = 'wypożyczona', data_wypozyczenia = CURRENT_DATE, data_zwrotu = null
                       WHERE ksiazka_id = $ksiazka_id AND status = 'zwrócona'";
    }
    $user_id_sql = "SELECT user_id FROM uzytkownicy where user_id = $user_id";
    $update_result = pg_query($conn, $update_sql);
    $user_id_result = pg_query($conn,$user_id_sql);
    if ($update_result && pg_affected_rows($update_result) > 0 && $user_id_result && pg_affected_rows($user_id_result))
    {
        echo "<div class='success-message'>Książka została pomyślnie wypożyczona!</div>";
    } else 
    {
        echo "<div class='error-message'>Nie udało się wypożyczyć książki. Sprawdź, czy książka jest dostępna.</div>";
    }
}
?>