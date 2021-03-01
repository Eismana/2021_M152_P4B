<?php
//Connection à la base de données
function Connection()
{
    static $dbh = null;
    $dbName = "cfpt-facebook";
    $dbUser = "abel.esmnc"; //changer l'utilisateur si besoin
    $dbPass = "CWmcfzwejE87SgWf"; //changer le mot de passe si besoin
    if ($dbh === null) {
        try {
            $dbh = new PDO(
                "mysql:host=localhost;dbname=$dbName;charset=utf8",
                $dbUser,
                $dbPass,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_PERSISTENT => true
                )
            );
        } catch (Exception $e) {
            die("Connexion impossible à la base " . $e->getMessage());
        }
    }
    return $dbh;
}

function InsertPost($commentaire, $creationDate)
{
    $sql = "INSERT INTO `post`(`commentaire`,`creationDate`,`modificationDate`,`modificationDate`)
    VALUES (:commentaire, :creationDate, modificationDate)";

    $query = Connection()->prepare($sql);

    $query->execute([
        ':commentaire' => $commentaire,
        ':creationDate' => $creationDate,
        ':modificationDate' => $creationDate,

    ]);
    $lastest_id = Connection()->lastInsertID();
    return $lastest_id;
}
function InsertMedia($typeMedia, $nomMedia, $creationDate, $lastId)
{
    $connexion = Connection();
    $sql = "INSERT INTO `media`(`typeMedia`,`nomMedia`,`creationDate`,`idPost`)
    VALUES (:typeMedia, :nomMedia, :creationDate, : $lastId)";
    $query = $connexion->prepare($sql);
    $query->execute([
        'typeMedia' => $typeMedia,
        ':nomMedia' => $nomMedia,
        ':creationDate' => $creationDate,
    ]);
}
