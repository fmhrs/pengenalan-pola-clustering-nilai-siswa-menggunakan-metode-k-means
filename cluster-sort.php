<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <title>Centroid</title>
</head>
<body>

<?php

if(!isset($_POST['data'])){
    header('Location: index.php');
}

// Declaration 
// Mengmbil data dari cluster.php
// $iterasi = $_POST['iterasi'];
$data = unserialize($_POST['data']);
$centroid = unserialize($_POST['new_centroid']);
$student = unserialize($_POST['student']);
$cluster = unserialize($_POST['cluster']);
$control_input = 3; // 3 dari tag<input> centroid pada form dimulai dari 3
$jumlah_centroid = count($centroid);

// Mengurutkan data berdasarkan cluster======================================
// ukuran dataa cluster = jumlah siswa
// nilai cluster berisikan angka 0-jumlah cluster yang menunjukan -
// siswa tersebut termask ke dalam cluster ke ...
$cluster_gabungan = array(); // Menggabungkan nama siswa dengan nilai cluster
foreach($cluster as $row_m_cluster=>$m_cluster){
    // echo "$m_cluster <br>";
    $cluster_gabungan[$student[$row_m_cluster]]=$m_cluster;
    // sementara jika tidak digunakan tidak berpengaruh apa apa
    // for($i = 0; $i< count($centroid); $i++){ 
    //     $isNearest = $cluster[$row_m_cluster]==$i ? "Yes" : "";
    // }
}
// nilai cluster gabungan urut berdasarkan nama siswa
// asort berguna untuk mengurutkan berdasarkan value
asort($cluster_gabungan);


// echo "<br>";
// echo "<br> cluster gabungan <br>";
// print_r($cluster_gabungan);

// Mengurutkan nilai cluster sesuai dari nilai centroid yang tertinggi =====
$order_centroid = array(); // Menghitung nilai rata rata dari setiap centroid
foreach($centroid as $key_m_centroid=>$m_centroid){
    $temp = 0;
    foreach($m_centroid as $value){
        $temp += $value;
    }
    $temp = $temp/count($m_centroid); 
    $order_centroid[$key_m_centroid] = strval($temp);
}

arsort($order_centroid); // mengurutkan nilai value berdasarkan yang tertinggi
$order_centroid = array_flip($order_centroid); // menukar (key -> value) dan (value -> key)
$order_centroid = array_values($order_centroid); // menghapus key dari seluruh data array
// echo "<br>";
// echo "<br> order_centroid <br>";
// print_r($order_centroid);




// cluster_gabungan merupakan variabel berisika data gabungan antara nama siswa -
// dengan letak cluster siswa yang belum di urutkan berdasarkan setiap cluster -
// dan cluster tertinggi.
// sedangkan cluster_gabungan2 telah di urutkan berdasarkan setiap cluster -
// masing - masing data dan juga cluster tertinggi
$cluster_gabungan2 = array();
foreach($order_centroid as $key_m_order_centroid => $m_order_centroid){
    foreach($cluster_gabungan as $key_m_cluster_gabungan => $m_cluster_gabungan){
        if($m_cluster_gabungan == $m_order_centroid){
            // echo $key_m_cluster_gabungan . $m_order_centroid. " <br>";
            $cluster_gabungan2[$key_m_cluster_gabungan] = $key_m_order_centroid;
        }
    }
}

// var_dump($cluster_gabungan);
// echo"<br>";
// var_dump($cluster_gabungan2);
?>

<form action="cluster.php" method="post">

    <div class="container p-5">  
        <div class="ps-2">
            <h1 style="font-weight: bold;letter-spacing: 10px;  ">CLUSTERING</h1>
            <p class="mb-5">pengelompokan nilai siswa menggunakan metode k-means</p>
        </div>  
        <div class="row ">
            <div class="col col-md-3 px-4">
                <h5><strong>DETAIL DATA</strong></h5>

                <div class="mb-3">
                    <label for="controlInput1" class="form-label">Jumlah Cluster</label>
                    <input id="controlInput1" type="text" class="form-control form-control-sm" value="<?=$jumlah_centroid?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="controlInput2" class="form-label">Jumlah Baris</label>
                    <input id="controlInput2" type="text" class="form-control form-control-sm" value="<?=count($data)?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="controlInput3" class="form-label">Jumlah Kolom</label>
                    <input id="controlInput3" type="text" class="form-control form-control-sm" value="<?=count($data[0])?>" readonly>
                </div>

                <?php foreach($centroid as $row_m_centroid => $m_centroid):?>
                    <?="<div class=\"mb-3\">"?>
                    <?="<label for=\"controlInput$control_input\" class=\"form-label\">Centroid ".($row_m_centroid+1)."</label>"?>
                    <?="<input id=\"controlInput$control_input\" type=\"text\" class=\"form-control form-control-sm\" value=\"".implode(", ", $centroid[$order_centroid[$row_m_centroid]])."\" readonly>"?>
                    <?="</div>"?>
                <?php endforeach?>
            </div>


            <div class="col col-12 col-md-9 px-4">
                <h5><strong>CENTROID TERDEKAT</strong></H5>

                <table class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <?php for($i = 0; $i< count($centroid); $i++):?>
                                <?="<th scope=\"col\" class=\"text-center\">Cluster " .($i+1). "</th>"?>
                            <?php endfor;?>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($cluster_gabungan2 as $row_m_cluster=>$m_cluster):?>
                            <?="<tr>"?>
                            <?="<th scope=\"row\">".($row_m_cluster)."</th>"?>
                            <?php for($i = 0; $i< count($centroid); $i++):?>
                                <?php $isNearest = $m_cluster==$i ? "Yes" : "";?>
                                <?="<td scope=\"col\" class=\"text-center\">$isNearest</td>"?>
                            <?php endfor;?>
                            <?="</tr>"?>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</form>
    
</body>
</html>