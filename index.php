<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <title>Pengenalan Pola</title>
</head>
<body>



<div class="container p-5">
    <h1 class="text-center" style="font-weight: bold;letter-spacing: 10px; text-indent: 10px;">CLUSTERING</h1>
    <p  class="text-center mb-5">pengelompokan nilai siswa menggunakan metode k-means</p>
    <form action="pendataan.php" method="post">
        <div class="mx-auto" style="max-width: 500px;">
            <div class="form-group">
                <label for="column">Jumlah Mata Pelajaran</label>
                <input name="column" type="number" class="form-control" id="column" placeholder="masukan angka">
            </div>
            <div class="form-group mt-2">
                <label for="rows">Jumlah Siswa</label>
                <input name="rows" type="numbeer" class="form-control" id="rows" placeholder="masukan angka">
            </div>
            <button class="btn btn-success float-end mt-5" type="submit">process</button>
        </div>
    </form>
</div>



</body>
</html>