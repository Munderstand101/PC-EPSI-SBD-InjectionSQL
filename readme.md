# Application de démonstration de l'injection SQL

Cette application est un exemple destiné à illustrer le concept d'injection SQL et à démontrer comment il peut être exploité pour compromettre la sécurité d'une application web. L'objectif est de sensibiliser aux risques associés à l'utilisation de requêtes SQL non sécurisées et de montrer comment ces attaques peuvent être prévenues en utilisant des techniques appropriées.

## Injection SQL

L'injection SQL est une technique d'attaque largement utilisée par les pirates informatiques pour exploiter les failles de sécurité dans les applications web qui interagissent avec des bases de données. L'attaque consiste à injecter du code SQL malveillant dans les entrées utilisateur, ce qui peut entraîner l'exécution de commandes non autorisées sur la base de données.

### Étapes de l'attaque

1. **Mise en place d'un formulaire de recherche**: L'application propose un formulaire de recherche où les utilisateurs peuvent saisir des termes de recherche.

2. **Injection de requêtes SQL malveillantes**: Les attaquants saisissent des termes de recherche spécialement conçus pour injecter des commandes SQL malveillantes dans les requêtes de l'application.

   Exemple 1 de requête SQL malveillante :
    ```sql
    '; DROP TABLE users; --
    ```

   Exemple 2 de requête SQL malveillante :
    ```sql
    ' OR '1'='1
    ```

3. **Extraction ou suppression de données**: Les commandes SQL malveillantes peuvent être conçues pour extraire ou supprimer des données sensibles de la base de données.

## Prévention des injections SQL

Pour prévenir les attaques par injection SQL, plusieurs mesures de sécurité doivent être mises en place :

1. **Utilisation de requêtes préparées**: Les requêtes préparées avec des déclarations préparées permettent de séparer les données des instructions SQL, réduisant ainsi le risque d'injection.

2. **Validation des entrées utilisateur**: Toutes les entrées utilisateur doivent être validées et filtrées pour éviter l'exécution de commandes SQL non autorisées.

3. **Échappement des caractères spéciaux**: Les caractères spéciaux doivent être échappés ou supprimés des entrées utilisateur avant d'être utilisés dans les requêtes SQL.

## Installation du projet

Pour installer et exécuter ce projet sur votre propre environnement, suivez ces étapes :

1. Assurez-vous d'avoir un serveur web local configuré avec PHP et MySQL.

2. Téléchargez les fichiers du projet dans un répertoire sur votre serveur.

3. Accédez au fichier install.php via votre navigateur pour configurer et lancer les tâches de création de la base de données.

4. Une fois les tâches d'installation terminées, lancez l'application en accédant à la page principale via votre navigateur.