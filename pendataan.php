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
    <title>Pengenalan Pola</title>
</head>
<body>


<?php

if(
    (!isset($_POST['column'])||!isset($_POST['rows']))||
    ($_POST['column']==0 || $_POST['rows'] == 0)
){
    header("Location: index.php");
}
$baris = $_POST['rows'];
$kolom = $_POST['column'];
for ($i=0; $i < $kolom; $i++) { 
    for ($j=0; $j < $baris; $j++) { 
        $data[$j][$i] = 0;
    }
}


// data dummy $data[baris][kolom]
// $data[0][0] = 4;  $data[0][1] = 2;  $data[0][2] = 3;
// $data[1][0] = 2;  $data[1][1] = 1;  $data[1][2] = 3;
// $data[2][0] = 2;  $data[2][1] = 5;  $data[2][2] = 1;
// $data[3][0] = 2;  $data[3][1] = 1;  $data[3][2] = 3;
// $data[4][0] = 2;  $data[4][1] = 3;  $data[4][2] = 2;
// $data[5][0] = 3;  $data[5][1] = 3;  $data[5][2] = 2;
// $data[6][0] = 4;  $data[6][1] = 3;  $data[6][2] = 2;
// $data[7][0] = 2;  $data[7][1] = 1;  $data[7][2] = 3;
?>


<div class="container p-5">
    <h1 class="text-center" style="font-weight: bold;letter-spacing: 10px; text-indent: 10px;">CLUSTERING</h1>
    <p  class="text-center mb-5">pengelompokan nilai siswa menggunakan metode k-means</p>
    <form action="cluster.php" method="post">
        <div class="table-responsive-md">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <?php foreach($data[0] as $rows=>$value): ?>
                        <?="<th scope=\"col\"><input class=\"transparent-input form-control p-0\" style=\"font-weight: bold;\" type=\"text\" value=\"mapel ".($rows+1)."\"></th>"?>
                        <?php endforeach ?>
                        <th scope="col" class="text-center">centroid</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php foreach($data as $index_value => $value):?>
                        <?="<tr>"?>
                        <?="<td scope=\"row\"> <input name=\"student[]\" class=\"transparent-input form-control p-0\" style=\"font-weight: bold;\" type=\"text\" value=\"siswa ".($index_value+1)."\"> </td>"?>
                        <?php foreach($value as $child_index_value => $child_value):?>
                            <?="<td scope=\"col\"><input name=\"data[$index_value][]\" class=\"transparent-input form-control p-0\" type=\"number\" value=\"$child_value\"></td>"?>
                        <?php endforeach;?>
                        <?="<td class=\"text-center\" > <input name=\"centroid[]\" class=\"form-check-input\" type=\"checkbox\" value=\"$index_value\"></td>"?>
                        <?="</tr>"?>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    <button class="btn btn-success float-end" type="submit">process</button>
    </form>
</div>


<script>
    var myform = $('#myform')
    var iter = 0

$('#btnAddCol').click(function () {
     myform.find('tr').each(function(){
         var trow = $(this);
         if(trow.index() === 0){
            console.log('true');
            trow.append("<td><div class=\"form-group\"><input class=\"form-control transparent-input\" type='text' name='name' placeholder=\"value...\"  required></div></td>");
         }else{
            console.log('false');
            trow.append('<td><input type="checkbox" name="cb'+iter+'"/></td>');
         }
     });
     iter += 1;
});
</script>


</body>
</html>