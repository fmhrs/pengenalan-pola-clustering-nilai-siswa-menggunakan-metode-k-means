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

// pada if else dibawah ini yang bekerja hanyala else
// program if adalah sisah pendevelopan sebelumnya yang setiap - 
// iterasinya di lakukan looping manual dengan cara meng click button
if(isset($_POST['iterasi'])){ // iterasi > 1
    $iterasi = $_POST['iterasi'];
    $data = unserialize($_POST['data']);
    $centroid = unserialize($_POST['new_centroid']);
    $student =  unserialize($_POST['student']);
} else { // iterasi == 1
    $iterasi = 1; // develop sebelumnya = 0 karena setiap pengaksesn file akan di +1
    $data = $_POST['data'];
    $student = $_POST['student'];
    $random_centroid = $_POST['centroid']; // sudah berupa index
    foreach($random_centroid as $row_m_centroid => $m_centroid){
        $centroid[$row_m_centroid] = $data[$m_centroid];
    }    
}


// $iterasi++; 
$control_input = 3; // 3 dari tag<input> centroid pada form dimulai dari 3
$jumlah_centroid = count($centroid);
$cluster = clustering($data, $centroid);
$new_centroid = newCentroid($data, $cluster, $centroid);

// Proses pengclusteran dan penentuan cetntroid baru akan di ulang sampai tidak -
// ada perubahan titik pada centroid baru dengan centroid sebelumnya
while($new_centroid!=$centroid){
    $iterasi++;
    $centroid = $new_centroid;
    $cluster = clustering($data, $centroid);
    $new_centroid = newCentroid($data, $cluster, $centroid);
}

// jika iterasi terakhir sembunyikan button process to next iteration
// $final_iterasi = "";
// if($new_centroid == $centroid){
//     $final_iterasi = "hidden";
// }


?>

<form action="cluster-sort.php" method="post">
    <input type='hidden' name='data' value="<?php echo htmlentities(serialize($data)); ?>" />
    <input type='hidden' name='new_centroid' value="<?php echo htmlentities(serialize($new_centroid)); ?>" />
    <input type='hidden' name='student' value="<?php echo htmlentities(serialize($student)); ?>" />
    <input type='hidden' name='cluster' value="<?php echo htmlentities(serialize($cluster)); ?>" />

    <div class="container p-5">
        <div class="ps-2">
            <h1 style="font-weight: bold;letter-spacing: 10px;">CLUSTERING</h1>
            <p class="mb-5">pengelompokan nilai siswa menggunakan metode k-means</p>
        </div>
    
    
        <div class="row">
            <div class="col col-md-3 px-4">
                <h5><strong>DETAIL DATA</strong></h5>
                <div class="mb-3">
                    <label for="controlInput1" class="form-label">Jumlah Cluster</label>
                    <input id="controlInput1" type="text" class="form-control form-control-sm" value="<?=$jumlah_centroid?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="controlInput2" class="form-label">Jumlah Siswa</label>
                    <input id="controlInput2" type="text" class="form-control form-control-sm" value="<?=count($data)?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="controlInput3" class="form-label">Jumlah Mata Pelajaran</label>
                    <input id="controlInput3" type="text" class="form-control form-control-sm" value="<?=count($data[0])?>" readonly>
                </div>

                <?php foreach($centroid as $row_m_centroid => $m_centroid):?>
                    <?="<div class=\"mb-3\">"?>
                    <?="<label for=\"controlInput$control_input\" class=\"form-label\">Centroid ".($row_m_centroid+1)."</label>"?>
                    <?="<input id=\"controlInput$control_input\" type=\"text\" class=\"form-control form-control-sm\" value=\"".implode(", ", $m_centroid)."\" readonly>"?>
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
                        <?php foreach($cluster as $row_m_cluster=>$m_cluster):?>
                            <?="<tr>"?>
                            <?="<th scope=\"row\">".($student[$row_m_cluster])."</th>"?>
                            <?php for($i = 0; $i< count($centroid); $i++):?>
                                <?php $isNearest = $cluster[$row_m_cluster]==$i ? "Yes" : "";?>
                                <?="<td scope=\"col\" class=\"text-center\">$isNearest</td>"?>
                            <?php endfor;?>
                            <?="</tr>"?>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <button class="btn btn-primary float-end"1 type="submit">urutkan data</button>
            </div>
        </div>
    </div>
</form>
<?php 

// echo"CENTROID<br>";
// print_r($centroid);
// echo "<br><br>";

// echo "<br><br>";
// echo"CLUSTER<br>";
// print_r($cluster);

// fungsi untuk menghitung dan menentukan jarak terdekat setiap data terhadap
// setiap centroid yang ditentukan
function clustering($data, $centroid){   

    // echo "<br><br>";
    // echo"Centroid<br>";
    // print_r(json_encode($centroid));
    // echo "<br><br>";


    // Menghutung jarak setiap data mapel siswa dengan centroid yang telah ditentukan -
    // lalu jarak tersebut di simpan kedalan variable $jarak_centroid.
    foreach($data as $row_m_data => $m_data){ 
        foreach($centroid as $row_m_centroid => $m_centroid){
            // mendefinisikan jarak awal seelum perhitungan setiap data = 0
            // agar tidak terjadi salah perhitungan pada looping berikutnya.
            $jarak_centroid[$row_m_data][$row_m_centroid] = 0.0;
            $jarak = 0.0;
            // echo "sqrt(";
            foreach($m_centroid as $row_single_centroid => $single_centroid){
                $single_data = $m_data[$row_single_centroid];
                $jarak += pow(($single_data - $single_centroid), 2);
                // echo"(($single_data - $single_centroid)^ 2) [$jarak] + ";
            }
            // echo ")";
            $hasil = round(sqrt($jarak),2);
            $jarak_centroid[$row_m_data][$row_m_centroid] = $hasil;
            // echo "= " . $hasil. "<br>";
        }
        // echo"<br><br>";
    }

    // Setelah melakukan perhitungan jarak, maka ditentukan lah jarak terdekat dari - 
    // setiap data dengan setiap centroid.
    // jarak rata rata data dari setiap nilai siswa yang paling dekat dengan centroid -
    // yang ada akan di simpan ke dalam var new_centroid lalu di kembalikan kedalam
    // variable yang memanggil fungsi clustering().
    foreach($jarak_centroid as $m_jarak){ // Menghitung jarak terdekat
        $nearest_cluster[] = array_search(min($m_jarak), $m_jarak);
    }

    // echo "<br><br>";
    // echo"new centroid<br>";
    // print_r(json_encode($new_centroid));
    // echo "<br><br>";

    return $nearest_cluster;
}


// fungsi untuk menentukan titik centroid terbaru.
function newCentroid($data, $cluster, $centroid){
    
    
    

    // setiap data yang memiliki cluster yang sama akan di masukkan ke dalam $multi_cluster -
    // sesuai index nya masing masing, index disini menggantikan nilai cluster yang di tuju -
    // oleh setiap data.
    $multi_cluster=array();
    foreach($cluster as $row_m_cluster=>$m_cluster){
        $multi_cluster[$m_cluster][] = $row_m_cluster;
    }
    // CONTOH
    // siswa 1 dan 4 termasuk cluster 2
    // siswa 2, 3 dan 5 termasuk cluster 1
    // maka akan di simpan 
    // [1][] = 1, [1][] = 4
    // [0][] = 2, [0][] = 3, [0][] = 5
    
    // pada pemrosesan sebelumnya dapat terlihat bahwa data yang di simpan akan berurutkan -
    // cluster berapa yag di miliki oleh data pertama, maka dari itu data tersebut harus -
    // di urutkan terlebih dahulu menggunakan fungsi ksort(),
    // ksort() = mengurutkan secara ascending berdasarkan nilai key yang dimiliki.
    ksort($multi_cluster);
    
    
    // echo "<br><br>";
    // echo"Multi Cluster<br>";
    // print_r(json_encode($multi_cluster));
    // echo "<br><br>";
    
    
    // proses code dibawah berfungsi untuk menghitung centroid baru sesuai dengan -
    // metode k-means, lalu nilai dari centroid baru disimpan kedalam var $centroid_baru
    // di kembalikan kedalam variable yang memanggil fungsi new_centroid()
    $centroid_baru = array();
    foreach($multi_cluster as $row_m_multi_cluster=>$m_multi_cluster){
        foreach($centroid[0] as $row_m_centroid=>$_m_centroid){ // hanya agar looping sebanyak jumlah mapel :D
            $temp_centroid = 0;
            // echo "<br>start||";
            foreach($m_multi_cluster as $n_multi_cluster){
                $temp_centroid += $data[$n_multi_cluster][$row_m_centroid];
                // $original = $data[$n_multi_cluster][$row_m_centroid];
                // echo "[$n_multi_cluster][$row_m_centroid]=$original +   ";
            }
            $temp_centroid = round($temp_centroid/count($m_multi_cluster), 2);
            $centroid_baru[$row_m_multi_cluster][] = $temp_centroid;
            // echo " / ". count($m_multi_cluster) . "= ". $temp_centroid ;
        }
    }
    
    // echo "<br>";
    return $centroid_baru;
}
?>
    
</body>
</html>