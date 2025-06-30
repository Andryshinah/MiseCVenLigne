
<?php include '../includes/header.php';?>
<?php require_once '../BDD/FormTreatment.php';?>
<?php require_once '../BDD/DBconnect.php'; ?>
<?php 
$id=$_GET['id'];
$conn=DBconnect();
if ($conn !== null) 
{ 
    $DataUser=ReadById($conn,$id); 
    if ($DataUser) 
    {
        foreach ($DataUser as $ligne) 
        {
?>
<body class="bg-dark">
<nav class="navbar navbar-expand-lg bg-light" data-bs-theme="light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav me-auto">
             <li class="nav-item">
                    <a class="nav-link active" href="FormMethod.php">Main menu <span class="visually-hidden">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Changer les infos perso</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4" style="width: 100%; max-width: 400px;">
        <form method="POST" action="../BDD/FormTreatment.php" enctype="multipart/form-data">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="200" fill="#868e96">
            <rect width="100%" height="100%" fill="#868e96"></rect>
            <image href="../BDD/Images/<?= basename($ligne['Photo']); ?>" width="100%" height="100%" />
        </svg>
        <div class="form-group">
                <label class="col-form-label mt-4" for="inputDefault">Id</label>
                <input type="hidden" name="id" class="form-control" value='<?= $ligne['id']; ?>'>
            </div>
            <div class="form-group">
                <label class="col-form-label mt-4" for="inputDefault">Nom</label>
                <input type="text" name="NewName" class="form-control" value='<?= $ligne['Nom']; ?>'>
            </div>
            <div class="form-group">
                <label class="col-form-label mt-4" for="inputDefault">Prenom</label>
                <input type="text" name="SecondName" class="form-control" value='<?= $ligne['Prenom']; ?>'>
            </div>
            <div class="form-group">
                <label class="col-form-label mt-4" for="inputDefault">Numero de telephone</label>
                <input type="text" name="Number" class="form-control" value='<?= $ligne['Numero']; ?>'>
            </div>
            <div>
                <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
                <input type="email" class="form-control" name="ModifiedMail" aria-describedby="emailHelp" placeholder="Enter email" value='<?= $ligne['mail']; ?>'>
            </div>
            <div class="form-group">
                <label class="col-form-label mt-4" for="inputDefault">Logement</label>
                <input type="text" name="NewHome" class="form-control" value='<?= $ligne['Logement']; ?>'>
            </div>
            <div>
                <label for="cvFile" class="form-label mt-4">CV actuel</label>
                <input type="text" name="CVactuel" class="form-control" value='<?= basename($ligne['CV']); ?>'>
            </div>

            <button type="submit" class="btn btn-danger w-100" name="submit" value="Supprimer" style="margin: 21px 10px 10px 10px;">Supprimer mon profil</button>
        </form>
    </div>
</div>

</body>

<?php 
}
    }
        }
include '../includes/footer.php'; ?>