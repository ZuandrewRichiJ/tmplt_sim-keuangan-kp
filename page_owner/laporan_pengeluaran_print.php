<?php
include('../auth.php');
require_once("../assets/dompdf/autoload.inc.php");
error_reporting(0);

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$start = $_GET['start'];
$end = $_GET['end'];
$query = mysqli_query($con, "SELECT * FROM pengeluaran WHERE 
        tanggal BETWEEN '$start' AND '$end' ORDER BY tanggal DESC");
$html = '<center><h3>LAPORAN PENGELUARAN</h3></center><hr><br/>';
$html .= '<h5><h3>Periode Tanggal : ' . date('d-m-Y', strtotime($start)) . ' s/d ' . date('d-m-Y', strtotime($end)) . '</h3></h5>';
$html .= '<table border="1" cellspacing="0" width="100%">
 <tr>
 <th align="center">No</th>
 <th>Nota</th>
 <th>Tanggal</th>
 <th>Keterangan</th>
 <th>Total Pengeluaran</th>
 </tr>';
$no = 1;
while ($row = mysqli_fetch_array($query)) {

    $total = $total + $row['nominal'];

    $html .= '<tr>
 <td align="center">' . $no++ . '</td>
 <td>' . $row['nota_keluar'] . '</td>
 <td>' . date('d-m-Y', strtotime($row['tanggal'])) . '</td>
 <td>' . $row['keterangan'] . '</td>
 <td>' . 'Rp. ' . number_format($row['nominal'], 0, ',', '.') . '</td>
 </tr>';
}
$html .= '<tr>
<td colspan="4" align="right"><b>Total  </b></td>
<td><b>Rp. ' . number_format($total, 0, ',', '.') . '</b></td>
</tr>
</table>';

$html .= "</html>";
$dompdf->loadHtml($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('laporan_pengeluaran.pdf');
