<?php 
include 'DBconnect.php';
include 'CVtreatment.php';
include 'Picturestreatment.php';
$conn=DBconnect();

function Create($conn)
{
      if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (!empty($_POST['Nom']) && !empty($_POST['Prenom']) &&
            !empty($_POST['Num']) && !empty($_POST['mail']) &&
            !empty($_POST['Logement']) && 
            isset($_FILES['CV']) && $_FILES['CV']['error'] == 0 &&
            isset($_FILES['Picture']) && $_FILES['Picture']['error'] == 0) 
        {
            // Vérification et nettoyage des données
            $Nom = verif($_POST['Nom']);
            $Prenom = verif($_POST['Prenom']);
            $Numero = verif($_POST['Num']);
            $mail = verif($_POST['mail']);
            $Logement = verif($_POST['Logement']);
            
            // Vérification et traitement des fichiers
            $CV = verif_CV_file($_FILES['CV']['name'], $_FILES['CV']['tmp_name'], $_FILES['CV']['size']);
            $Photo = verif_Pict($_FILES['Picture']['name'], $_FILES['Picture']['tmp_name'], $_FILES['Picture']['size']);

                      if ($CV && $Photo) 
                      {
                          echo " Toutes les données ont été traitées avec succès.";
                                try 
                                {
                                    // Préparer la requête d'insertion
                                    $stmt = $conn->prepare("INSERT INTO `formulaire` (`Nom`, `Prenom`, `Numero`, `mail`, `Logement`, `CV`, `Photo`,`Statut`) VALUES (:Nom, :Prenom, :Numero, :mail, :Logement, :CV, :Photo, :Statut)");

                                    // Lier les paramètres
                                    $stmt->bindParam(':Nom', $Nom);
                                    $stmt->bindParam(':Prenom', $Prenom);
                                    $stmt->bindParam(':Numero', $Numero);
                                    $stmt->bindParam(':mail', $mail);
                                    $stmt->bindParam(':Logement', $Logement);
                                    $stmt->bindParam(':CV', $CV);
                                    $stmt->bindParam(':Photo', $Photo);
                                    $stmt->bindParam(':Statut', 1);
                                        // Exécuter la requête
                                        if ($stmt->execute()) 
                                        {
                                            echo "Nouvel enregistrement créé avec succès.";
                                        } 
                                        else 
                                        {
                                            echo "Erreur: " . $stmt->errorInfo();
                                        }
                                 } 
                                catch (PDOException $e) 
                                {
                                    echo "Erreur: " . $e->getMessage();
                                }
    // Fermer la connexion
    $conn = null;
        } 
        else 
        {
            echo " Erreur lors du téléchargement des fichiers.";
            exit; // Stopper l'algo
            
            //ici si les fichiers sont invalides
        }
    } 
    else 
    {
        echo " Formulaire incomplet, veuillez remplir tous les champs.";
        header("Location: ../index.php"); // Redirection en cas d'erreur
        exit;
    }
    } 
} 
function Read($conn)
{
    $numeroIdentification=1;
    try {
        $stmt = $conn->prepare("SELECT * FROM formulaire WHERE Statut='1'");
        $stmt->execute();
        $donnees_utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($donnees_utilisateurs) 
        {
            echo "<table border='1' style='background-color:DodgerBlue;'>";
            echo "<tr>";
            //verifier dans l'en tete des données tableau
            foreach (array_keys($donnees_utilisateurs[0]) as $enteteTableau) 
            {
                echo "<th>" . htmlspecialchars($enteteTableau) . "</th>";
                
            }
            echo "<th>action</th>";
            echo "</tr>";
            //verifie dans chaque cellule du tableau
            foreach ($donnees_utilisateurs as $ligne) 
            {
                echo "<tr>";
                foreach ($ligne as $cellule) 
                {
                    echo "<td>" . htmlspecialchars($cellule) . "</td>";
                }
                echo 
                "<td>
                <button type='button' class='btn btn-info'>
                    <a href='modifier.php?id=" .$numeroIdentification  . "'>Modifier</a>
                </button>
                </td>
                <td>
                <button type='button' class='btn btn-danger' name='supprimer'>
                    <a href='supprimer.php?id=" .$numeroIdentification  . "'>Supprimer</a>
                </button>
                </td>";
                echo "</tr>";
                $numeroIdentification++;
            }
    
            echo "</table>";
          
        } 
        else 
        {
            echo "Aucun enregistrement trouvé.";
        }
    } 
    catch (PDOException $e) 
    {
        echo "Erreur : " . $e->getMessage();
    }
    
} 
    
function ReadById($conn,$id)
{
    try 
    {
        $stmt = $conn->prepare("SELECT  `id`, `Nom`, `Prenom`, `Numero`, `mail`, `Logement`, `CV`, `Photo` FROM `formulaire` WHERE `id`=:id AND Statut ='1'");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $donnees_utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $donnees_utilisateurs; 
    }
    catch (PDOException $e) 
    {
        echo "Erreur : " . $e->getMessage();
    }

}
    // verifier les valeurs de champs 
  // ensuite les comparer voir si il y des changements 
  // generer la requete selon ceci en dynamique
  function FormUpdate($conn,$id)
  {
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            if (isset($_POST['id'])) 
            {
                $id = $_POST['id'];
                if
                ( 
                isset($_POST['NewName'])&&
                isset($_POST['SecondName'])&&
                isset($_POST['Number'])&&
                isset($_POST['ModifiedMail'])&&
                isset($_POST['NewHome'])&&
                isset($_FILES['NewCV'])&& $_FILES['NewCV']['error'] == 0 &&
                isset($_FILES['NewPicture']) && $_FILES['NewPicture']['error'] == 0
                )
                {
                $NouveauNom = verif($_POST['NewName']);
                $NouveauPrenom = verif($_POST['SecondName']);
                $NouveauNumero = verif($_POST['Number']);
                $Nouveaumail = verif($_POST['ModifiedMail']);
                $NouveauLogement = verif($_POST['NewHome']);
                $NouveauCV = verif_CV_file($_FILES['NewCV']['name'],$_FILES['NewCV']['tmp_name'],$_FILES['NewCV']['size']);
                $NouveauPhoto = verif_Pict($_FILES['NewPicture']['name'],$_FILES['NewPicture']['tmp_name'],$_FILES['NewPicture']['size']);
                
                        try 
                        {
                            // 1. Récupération des données existantes
                        $stmt = $conn->prepare("SELECT * FROM formulaire WHERE id = ? AND Statut ='1'");
                        $stmt->execute([$id]);
                        $donnees_utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

                        if (!$donnees_utilisateur) 
                            {
                            echo "Aucune donnée trouvée pour cet ID.";
                            exit;
                            }

                            // 2. Comparaison avec les nouvelles données
                        $champsModifiables = 
                        [
                            'Nom' => $NouveauNom,
                            'Prenom' => $NouveauPrenom,
                            'Numero' => $NouveauNumero,
                            'mail' => $Nouveaumail,
                            'Logement' => $NouveauLogement,
                            'CV' => $NouveauCV,
                            'Photo' => $NouveauPhoto
                        ];
                        foreach ($champsModifiables as $key => $value) 
                        {
                            if($donnees_utilisateur[$key] != $value)
                            {
                                $ChampAmettreAJour[$key]=$value;
                            }
                        }
    //eto aho no migenerer ilay requete dynamique(je genere la requete dynamique ici)
                        if(!empty($ChampAmettreAJour))
                        {
                            //alaina @ ilay array_map ilay champ mise à jour//prendre avec array map les champs mise à jours
                            //return avy eo format $clechamp=? miaraka @ valeur anle clé anat array keys)
                            //retourne le format  $clechamp=? ou clechmaps equivaut à cle dans array_keys du tab ChampAmettreAJour
                            $PartieMiseAJour=array_map(function($CleChamp){return"$CleChamp=?";},array_keys($ChampAmettreAJour));
                            //apoaka ilay tableau misy ireo nom champ mise à jour eto // imploder le tableau contenant le nom des champs mise a jour
                            $MiseAJourUnique=implode(',', $PartieMiseAJour);
                            // $CleValeurChamp=array_keys($ChampAmettreAJour);
                            $stmt=$conn->prepare("UPDATE `formulaire` SET $MiseAJourUnique WHERE `id`= ?");
                            // var_dump($ChampAmettreAJour);
                            //ajout à la fin du tableau la value de id
                            $valeursAmettreAJour=array_values($ChampAmettreAJour);
                            $valeursAmettreAJour[]=intval($id);
                            // var_dump($valeursAmettreAJour);
                            $stmt->execute($valeursAmettreAJour);
                            header("Location:../index.php");
                            exit;
                        }
                        else
                        {
                            echo "desolé ne peut mettre à jours vos données";
                        }
                        } 
                        catch (Exception $e) 
                        {
                            echo "Erreur : " . $e->getMessage();
                        }
            }
        
                
            else 
            {
                echo 'rien à traiter';
                header("Location:../index.php");
                exit;
            }
        }
    }

}  
  
function Delete($conn)
{
   
    // supprimer un profil par suppression logique et non suppression pur et dur
    // ekena ilay requete client 
    // Asiana statut 1 na 0 anaty base 
    // dia avy eo ok ilay boutton supprimer
    var_dump($_POST);
    $id=intval($_POST['id']);

    if(isset($_POST['submit']) && $_POST['submit'] === 'Supprimer' && is_numeric($id))
    {
        $stmt= $conn->prepare("UPDATE `formulaire` SET `Statut`='0' WHERE `id`=:id ");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        header("Location:../index.php");
        
    }

}
function verif($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) 
{
    
    if ($conn !== null) {
        switch ($_POST['submit']) 
        {
            //nom anle variable avy any @ info anle form io 
            case 'Creer':
                Create($conn);
                break;
            case 'Update':
                FormUpdate($conn,$id);
                break;
            case 'Supprimer':
                Delete($conn);
                break;
            default:
                echo "Action inconnue.";
        }
    } else {
        echo "Connexion à la base de données échouée.";
    }
}      
?>
