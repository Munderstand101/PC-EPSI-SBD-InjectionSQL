<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de Recherche</title>
    <!-- Intégration de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="mt-5 mb-4">Recherche</h2>

    <form method="post" action="">
        <div class="form-group">
            <label for="search_term">Terme de recherche:</label>
            <input type="text" class="form-control" id="search_term" name="search_term">
        </div>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <?php
    // Vérification si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Inclusion du fichier de configuration
        require_once 'config.php';

        // Création de la connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Récupération du terme de recherche depuis le formulaire
        $search_term = $_POST['search_term'];

        // Requête préparée pour éviter les attaques par injection SQL
        $sql = "SELECT * FROM search_data WHERE column_name LIKE ?";

        // Préparation de la requête
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Liaison des paramètres et exécution de la requête
            $search_param = "%$search_term%";
            $stmt->bind_param("s", $search_param);
            $stmt->execute();

            // Récupération des résultats
            $result = $stmt->get_result();

            // Vérification s'il y a des résultats
            if ($result->num_rows > 0) {
                echo "<h3 class='mt-4'>Résultats de la recherche:</h3>";
                echo "<ul class='list-group'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item'>" . $row["column_name"] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<div class='alert alert-info mt-4' role='alert'>Aucun résultat trouvé.</div>";
            }

            // Fermeture du résultat et de la déclaration préparée
            $result->close();
            $stmt->close();
        } else {
            // En cas d'erreur lors de la préparation de la requête
            echo "<div class='alert alert-danger mt-4' role='alert'>Erreur lors de la préparation de la requête.</div>";
        }

        // Fermeture de la connexion
        $conn->close();
    }
    ?>

</div>

<!-- Intégration des scripts Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
