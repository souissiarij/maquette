<?php
// Traitement de la demande de subvention
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecter les données du formulaire
    $montant = $_POST['subventionMontant'];
    $utilisation = $_POST['utilisationSubvention'];
    $impact = $_POST['impactClub'];

    // Traitement du fichier justificatif (si téléchargé)
    if (isset($_FILES['justificatifUpload'])) {
        $file_name = $_FILES['justificatifUpload']['name'];
        $file_tmp = $_FILES['justificatifUpload']['tmp_name'];
        move_uploaded_file($file_tmp, "uploads/" . $file_name); // Enregistrer dans un dossier "uploads"
    }

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'subventions_db');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insérer la demande dans la base de données
    $sql = "INSERT INTO demandes (montant, utilisation, impact, justificatif)
            VALUES ('$montant', '$utilisation', '$impact', '$file_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Demande soumise avec succès.";
    } else {
        echo "Erreur: " . $conn->error;
    }

    $conn->close();
}
?>
