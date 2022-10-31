<?php
include('../auth.php');
require_once("../assets/dompdf/autoload.inc.php");
error_reporting(0);

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$start = $_GET['start'];
$end = $_GET['end'];
$query = mysqli_query($con, "SELECT * FROM pemasukan,pelanggan,barang
          WHERE pemasukan.id_pelanggan=pelanggan.id_pelanggan
          AND pemasukan.id_barang=barang.id_barang
          AND tanggal BETWEEN '$start' AND '$end' ORDER BY nota DESC");
$html = '<center><h3>LAPORAN PEMASUKAN</h3></center><hr><br/>';
$html .= '<h5><h3>Periode Tanggal : ' . date('d-m-Y', strtotime($start)) . ' s/d ' . date('d-m-Y', strtotime($end)) . '</h3></h5>';
$html .= '<table border="1" cellspacing="0" width="100%">
 <tr>
 <th align="center">No</th>
 <th>Nota</th>
 <th>Tanggal</th>
 <th>Pelanggan</th>
 <th>Barang</th>
 <th>Harga</th>
 <th align="center">Qty</th>
 <th>Subtotal</th>
 </tr>';
$no = 1;
while ($row = mysqli_fetch_array($query)) {
  $subtotal = $row['harga'] * $row['jumlah'];
  $total = $total + $subtotal;

  $html .= '<tr>
 <td align="center">' . $no++ . '</td>
 <td>' . $row['nota'] . '</td>
 <td>' . date('d-m-Y', strtotime($row['tanggal'])) . '</td>
 <td>' . $row['nama_pelanggan'] . '</td>
 <td>' . $row['nama_barang'] . '</td>
 <td>' . 'Rp. ' . number_format($row['harga'], 0, ',', '.') . '</td>
 <td align="center">x ' . $row['jumlah'] . '</td>
 <td>' . 'Rp. ' . number_format($subtotal, 0, ',', '.') . '</td>
 </tr>';
}
$html .= '<tr>
<td colspan="7" align="right"><b>Total  </b></td>
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
$dompdf->stream('laporan_pemasukan.pdf');
