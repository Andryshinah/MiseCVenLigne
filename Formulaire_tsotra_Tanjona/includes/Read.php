<?php include '../includes/header.php'; ?>
<?php require_once '../BDD/FormTreatment.php'; ?>
<body class="bg-dark">
    <nav class="navbar navbar-expand-lg bg-light" data-bs-theme="light">
        <div class="w-100">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor03">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="../index.php">Main menu <span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Verify my identity</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <?php 
    $conn=DBconnect();
    //renvoyeo aty @ view ny resultat interogation bdd anlah fa aza manao traitement anaty controller
    if ($conn !== null) { Read($conn); }
     ?>
<?php include '../includes/footer.php'; ?>

