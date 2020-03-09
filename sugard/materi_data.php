<?php

include('../koneksi.php');
include('../function.php');
session_start();

$query = "
SELECT * FROM materi
INNER JOIN kelas ON kelas.kelas_id = materi.materi_kelas_id
INNER JOIN sekolah ON sekolah.sekolah_id = kelas.sekolah_id
ORDER BY materi.materi_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table id="materi_datatabel" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="5%">Materi Id</td>
			<th width="30%">Nama Materi</td>
			<th width="25%">Data Materi</td>
			<th width="25%">Kelas Materi</td>
			<th width="15%">Tanggal</td>
			<th width="15%">Aksi</td>
		</tr>
	</thead> 
';

foreach($result as $row)
{
	$output .= '
	<tr>
		<td>'.$row['materi_id'].'</td>
		<td>'.$row['materi_nama'].'</td>
		<td>'.$row['materi_data'].'</td>
		<td>'.$row['kelas_nama'].' '.$row['sekolah_nama'].'</td>
		<td>'.tgl_indo($row['materi_tgl']).'</td>
		<td>Aksi</td>
	</tr>
	';	
}

$output .= '</table>
<script>
  $(function () {
    $("#materi_datatabel").DataTable();
  });
</script>';

echo $output;


?>