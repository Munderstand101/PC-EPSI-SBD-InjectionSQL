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

        // Construction de la requête SQL (vulnérable à l'injection SQL)
        $sql = "SELECT * FROM search_data WHERE column_name LIKE '%$search_term%'";

        // Exécution de la requête
        if ($conn->multi_query($sql)) {
            // Lecture des résultats de la première requête
            do {
                if ($result = $conn->store_result()) {
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
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
        } else {
            echo "<div class='alert alert-danger mt-4' role='alert'>Erreur lors de l'exécution de la requête SQL : " . $conn->error . "</div>";
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
