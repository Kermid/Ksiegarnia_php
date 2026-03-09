<?php

    if (isset($_GET['ksiazka_id']) && isset($_GET['user_id']) && isset($_GET['view']) && $_GET['view'] === 'Oddawanie') 
    {
        $ksiazka_id = (int)$_GET['ksiazka_id'];
        $user_id = (int)$_GET['user_id'];
        
        $update_sql = "UPDATE Wypozyczenia
                       SET status = 'zwrócona', data_zwrotu = CURRENT_DATE
                       WHERE ksiazka_id = $ksiazka_id AND user_id = $user_id AND status IN ('wypożyczona', 'przetrzymana')";
        
        $update_result = pg_query($conn, $update_sql);
        
        if ($update_result && pg_affected_rows($update_result) > 0) 
        {
            echo "<div class='success-message'>Książka została pomyślnie zwrócona!</div>";
        } else 
        {
            echo "<div class='error-message'>Nie udało się zwrócić książki. Sprawdź czy książka jest rzeczywiście wypożyczona przez tego użytkownika.</div>";
        }
    }

?>