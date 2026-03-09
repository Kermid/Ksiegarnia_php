<?php
if (isset($_GET['user_id']) && isset($_GET['view']) && $_GET['view'] === 'rezerwacja') 
{
    $user_id = (int) $_GET['user_id'];
    $ksiazka_id = (int) $_GET['ksiazka_id'];
    $date = $_GET['data_rezerwacji'];

    $check_sql = "SELECT * FROM Rezerwacje 
                  WHERE ksiazka_id = $ksiazka_id AND status = 'aktywna'";
     $check_result = pg_query($conn, $check_sql);

     if(pg_num_rows($check_result) > 0) 
     {
        echo "<div class='error-message'>Ta książka jest już zarezerwowana.</div>";
     }
     else
     {
        $sql = "INSERT INTO Rezerwacje (user_id, ksiazka_id, data_rezerwacji, status)
                VALUES ($user_id, $ksiazka_id, '$date', 'aktywna')";

        $result = pg_query($conn, $sql);

        if ($result) 
        {
            echo "<div class='success-message'>Rezerwacja została zapisana!</div>";
        } else 
        {
            echo "<div class='error-message'>Nie udało się zarezerwować książki.</div>";
        }
     }
        
} 

    ?>