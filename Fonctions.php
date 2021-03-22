<!--
   Fonctions.php
   Nom du projet: facebook-cfpt
   Auteur : Eisman Camara Abel
   Crée le : 28.01.2021
   Mis a jour le : 22.03.2021
-->
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

function InsertPost($commentaire)
{
    $dbh = Connection();
    $dbh->beginTransaction();
    try {
        $sql = "INSERT INTO `post` (`commentaire`) VALUES (:commentaire)";

        $query = $dbh->prepare($sql);

        $query->execute(array(
            ':commentaire' => $commentaire,

        ));
        $lastest_id = $dbh->lastInsertID();
        $dbh->commit();
        return $lastest_id;
    } catch (Exception $e) {
        $dbh->rollBack();
        echo "Failed: " . $e->getMessage();
    }
}
function InsertMedia($typeMedia, $nomMedia, $lastId)
{
    $dbh = Connection();
    $dbh->beginTransaction();
    try {
        $sql = "INSERT INTO `media`(`typeMedia`,`nomMedia`,`idPost`)
        VALUES (:typeMedia, :nomMedia, :lastId)";
        $query = $dbh->prepare($sql);
        $query->execute([
            'typeMedia' => $typeMedia,
            'nomMedia' => $nomMedia,
            'lastId' => $lastId,
        ]);
    } catch (Exception $e) {
        $dbh->rollBack();
        echo "Failed: " . $e->getMessage();
    }
}

function InsertPostMedia($commentaire, $typeMedia, $nomMedia)
{
    $dbh = Connection();
    $dbh->beginTransaction();
    try {
        $sql = "INSERT INTO `post` (`commentaire`) VALUES (:commentaire)";
        $query = $dbh->prepare($sql);
        $query->execute(array(
            ':commentaire' => $commentaire,
        ));
        $lastest_id = $dbh->lastInsertID();

        $sql = "INSERT INTO `media`(`typeMedia`,`nomMedia`,`idPost`)
        VALUES (:typeMedia, :nomMedia, :lastId)";
        $query = $dbh->prepare($sql);
        $query->execute([
            'typeMedia' => $typeMedia,
            'nomMedia' => $nomMedia,
            'lastId' => $lastest_id,
        ]);
        $dbh->commit();
    } catch (Exception $e) {
        $dbh->rollBack();
        echo "Failed: " . $e->getMessage();
    }
}



function SelectPost()
{
    $dbh = Connection();
    $sql = $dbh->prepare('SELECT * FROM post ORDER BY creationDate DESC');
    $sql->execute();
    $resultat = $sql->fetchAll();

    return $resultat;
}
function SelectMedia($idPost)
{
    $dbh = Connection();
    $sql = $dbh->prepare('SELECT * FROM media WHERE idPost = :idPost');
    $sql->execute(array(
        'idPost' => $idPost,
    ));
    $resultat = $sql->fetchAll();

    return $resultat;
}
function ShowPost()
{
    $posts = SelectPost();

    foreach ($posts as $post => $value) {

        $medias = SelectMedia($value['idPost']);
        echo '<div class="col-sm-5">
                 
    <div class="panel panel-default" style="max-width:200px;">
      <div class="panel-thumbnail"><img src="../img/' . $medias[0]['nomMedia'] . '" class="img-responsive" width="200x"></div>
      <div class="panel-body ">
        <b>' .$medias[0]['nomMedia']. '</b>
        <p>
          <img src="assets/img/uFp_tsTJboUY7kue5XAsGAs28.png" height="28px" width="28px">
        </p>
        <button type="button" class="btn btn-default" aria-label="Left Align">
  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
</button>
<button type="button" class="btn btn-default" aria-label="Left Align" style="margin-left:41px;">
<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
</button>

      </div>
    </div>
</div>
';
     
    }
}
