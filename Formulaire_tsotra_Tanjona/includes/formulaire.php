
<body class="bg-dark">
    <nav class="navbar navbar-expand-lg bg-light" data-bs-theme="light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor03">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Main menu <span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Verify my identity</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4" style="width: 100%; max-width: 400px;">
            <form method="POST" action="../BDD/FormTreatment.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-form-label mt-4" for="inputDefault">Nom</label>
                    <input type="text" name="Nom" class="form-control">
                </div>
                <div class="form-group">
                    <label class="col-form-label mt-4" for="inputDefault">Prenom</label>
                    <input type="text" name="Prenom" class="form-control">
                </div>
                <div class="form-group">
                    <label class="col-form-label mt-4" for="inputDefault">Numero de telephone</label>
                    <input type="text" name="Num" class="form-control">
                </div>
                <div>
                    <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
                    <input type="email" class="form-control" name="mail" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label class="col-form-label mt-4" for="inputDefault">Logement</label>
                    <input type="text" name="Logement" class="form-control">
                </div>
                <div>
                    <label for="cvFile" class="form-label mt-4">CV</label>
                    <input class="form-control" name="CV" type="file" id="cvFile" accept=".pdf,.doc,.docx">
                </div>
                <div>
                    <label for="photoFile" class="form-label mt-4">Photo</label>
                    <input class="form-control" name="Picture" type="file" id="photoFile" accept=".jpg,.jpeg,.png">
                </div>

                <button type="submit" class="btn btn-primary w-100" name="submit" value="Creer" style="margin: 21px 10px 10px 10px;">Uploader mes données</button>
            </form>
        </div>
    </div>
    <div class="col-md-6 d-flex flex-column justify-content-around align-items-center" style="margin: -457px 11px 11px -104px;">
        <a href="./includes/Read.php" class="btn btn-info w-50 mb-3">Voir mes informations</a>
       
    </div>
</body>
