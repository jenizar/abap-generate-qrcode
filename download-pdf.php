<?php
//library phpqrcode
include "phpqrcode/qrlib.php";
include 'koneksi.php';
//library mpdf
define('_MPDF_PATH','mpdf/');
include(_MPDF_PATH . "mpdf.php");

//setting dan nama file pdf
$nama_dokumen='product-inventory-pdf';
$mpdf=new mPDF('utf-8', 'A4', 11, 'Georgia');
ob_start();
?>
<html>
<head>
</head>
<body>
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
            $namafile = $matnr.".png";

	              if($no % 2 == 0) { echo "<tr>";}
    ?>		
             <td style="padding: 30px;"><img src="temp/<?php echo $namafile; ?>" width="70px"><span style="color: black; font-size: 11px;"><?php echo "<br/>"; echo $matnr; ?></span></td>		
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
<?php
mysqli_close($db1);
$html = ob_get_contents();
ob_end_clean();

$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output("".$nama_dokumen.".pdf" ,'D');
?>