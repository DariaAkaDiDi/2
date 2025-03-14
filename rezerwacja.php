<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobranie danych z formularza
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST["phone"]);
    $date = htmlspecialchars($_POST["date"]);
    $service = htmlspecialchars($_POST["service"]);
    $message = htmlspecialchars($_POST["message"]);

    // Walidacja e-maila
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Niepoprawny adres e-mail!");
    }

    // Tworzenie treści rezerwacji
    $reservation = "Imię i nazwisko: $name\n"
                 . "E-mail: $email\n"
                 . "Telefon: $phone\n"
                 . "Data wizyty: $date\n"
                 . "Usługa: $service\n"
                 . "Uwagi: $message\n"
                 . "--------------------------\n";

    // Zapis rezerwacji do pliku
    file_put_contents("rezerwacje.txt", $reservation, FILE_APPEND);

    // Opcjonalnie: Wysłanie e-maila z rezerwacją
    $to = "kontakt@twojastrona.pl"; // Podaj prawdziwy adres
    $subject = "Nowa rezerwacja w salonie fryzjerskim";
    $headers = "From: $email\r\nReply-To: $email\r\n";
    
    mail($to, $subject, $reservation, $headers);

    // Potwierdzenie dla użytkownika
    echo "Dziękujemy, $name! Twoja rezerwacja na $date została zapisana.";
} else {
    echo "Błąd: niepoprawna metoda przesyłania danych.";
}
?>
