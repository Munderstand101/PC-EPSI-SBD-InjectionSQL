<!DOCTYPE html>
<html>
<head>
    <title>Installation de l'application</title>
    <!-- Intégration de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2 class="mt-5 mb-4">Installation de l'application</h2>

    <!-- Onglets -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="config-tab" data-toggle="tab" href="#config" role="tab" aria-controls="config" aria-selected="true">Configuration</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tasks-tab" data-toggle="tab" href="#tasks" role="tab" aria-controls="tasks" aria-selected="false">Tâches</a>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content" id="myTabContent">
        <!-- Onglet Configuration -->
        <div class="tab-pane fade show active" id="config" role="tabpanel" aria-labelledby="config-tab">
            <?php
            // Si le formulaire de configuration a été soumis
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['config_submit'])) {
                // Récupération des données du formulaire
                $servername = $_POST['servername'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $dbname = $_POST['dbname'];

                // Création du fichier config.php avec les informations de connexion
                $config_content = "<?php\n";
                $config_content .= "// Configuration des accès à la base de données\n";
                $config_content .= "\$servername = \"$servername\";\n";
                $config_content .= "\$username = \"$username\";\n";
                $config_content .= "\$password = \"$password\";\n";
                $config_content .= "\$dbname = \"$dbname\";\n";
                $config_content .= "?>";

                // Écriture du contenu dans le fichier config.php
                $config_file = fopen("config.php", "w");
                if ($config_file) {
                    fwrite($config_file, $config_content);
                    fclose($config_file);
                    echo "<div class='alert alert-success' role='alert'>Le fichier config.php a été créé avec succès.</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Erreur lors de la création du fichier config.php.</div>";
                }
            }

            // Lecture des informations de connexion depuis le fichier config.php s'il existe
            if (file_exists("config.php")) {
                include "config.php";
            } else {
                // Si le fichier config.php n'existe pas, initialiser les variables à des valeurs par défaut
                $servername = "";
                $username = "";
                $password = "";
                $dbname = "";
            }
            ?>

            <!-- Formulaire de configuration de la base de données -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Configuration de la base de données
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <input type="hidden" name="config_submit">
                                <div class="form-group">
                                    <label for="servername">Nom du serveur:</label>
                                    <input type="text" class="form-control" id="servername" name="servername" value="<?php echo $servername; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Nom d'utilisateur:</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Mot de passe:</label>
                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="dbname">Nom de la base de données:</label>
                                    <input type="text" class="form-control" id="dbname" name="dbname" value="<?php echo $dbname; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Tâches -->
        <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
            <?php
            // Si le formulaire des tâches concernant la base de données a été soumis
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tasks_submit'])) {
                // Lecture des informations de connexion depuis le fichier config.php
                require_once 'config.php';

                // Connexion à la base de données
                $conn = new mysqli($servername, $username, $password);

                // Vérification de la connexion
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Création de la base de données
                $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success' role='alert'>Base de données créée avec succès</div>";

                    // Sélection de la base de données
                    $conn->select_db($dbname);

                    // Création de la table pour stocker les données de recherche
                    $sql = "CREATE TABLE IF NOT EXISTS search_data (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        column_name VARCHAR(255) NOT NULL
                    )";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>Table créée avec succès</div>";

                        // Insertion de données de test dans la table
                        $sql = "INSERT INTO search_data (column_name) VALUES ('Test Data 1'), ('Test Data 2'), ('Test Data 3')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<div class='alert alert-success' role='alert'>Données de test insérées avec succès</div>";
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>Erreur lors de l'insertion des données de test: " . $conn->error . "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Erreur lors de la création de la table: " . $conn->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Erreur lors de la création de la base de données: " . $conn->error . "</div>";
                }

                // Fermeture de la connexion
                $conn->close();
            }
            ?>

            <!-- Formulaire des tâches concernant la base de données -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Tâches concernant la base de données
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <input type="hidden" name="tasks_submit">
                                <button type="submit" class="btn btn-primary">Exécuter les tâches</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Intégration des scripts Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
