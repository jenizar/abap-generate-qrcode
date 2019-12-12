<?php
//library phpqrcode
include "phpqrcode/qrlib.php";
include 'koneksi.php';

//direktory tempat menyimpan hasil generate qrcode jika folder belum dibuat maka secara otomatis akan membuat terlebih dahulu
$tempdir = "temp/"; 
if (!file_exists($tempdir))
    mkdir($tempdir);

?>
<html>
<head>
</head>
<body>
    <div align="" style="margin-top: 50px;">

    <a href="download-pdf.php"><p>Download PDF</p></a>

    <table cellspacing="0" cellpadding="0">
        <thead>
            <th></th>
            <th></th>
            <th></th>
        </thead>
        <tbody>
        <?php
            $no = 0;
            $query = "SELECT * FROM qrcode";
            $arsip1 = $db1->prepare($query);
            $arsip1->execute();
            $res1 = $arsip1->get_result();
            while ($row = $res1->fetch_assoc()) {
                $matnr = $row['matnr'];
                $maktx = $row['maktx'];
                //Isi dari QRCode Saat discan
                $isi_matnr1 = $matnr;
                //Nama file yang akan disimpan pada folder temp 
                $namafile1 = $matnr.".png";
                //Kualitas dari QRCode 
                $quality1 = 'H'; 
                //Ukuran besar QRCode
                $ukuran1 = 10; 
                $padding1 = 0; 
                QRCode::png($isi_matnr1,$tempdir.$namafile1,$quality1,$ukuran1,$padding1);
              if($no % 2 == 0) { echo "<tr>";} ?>
                <td style="padding: 30px;"><img src="temp/<?php echo $namafile1; ?>" width="70px"><span style="color: black; font-size: 11px;"><?php echo "<br/>"; echo $matnr; ?></span></td>			
				<?php 
				//https://stackoverflow.com/questions/29434576/creating-four-columns-using-php-loop-in-table
			  if($no % 2 != 0){ echo "</tr>"; } 			  	  
			  $no++; 			  
         } 
		?>
        </tbody>
    </table>

</body>
</html>
<?php mysqli_close($db1); ?>