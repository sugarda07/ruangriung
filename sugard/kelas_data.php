<?php

include('../koneksi.php');
include('../function.php');

session_start();

$query = "
SELECT * FROM kelas
INNER JOIN sekolah ON sekolah.sekolah_id=kelas.sekolah_id
INNER JOIN jurusan ON jurusan.jurusan_id=kelas.jurusan_id
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table id="tabel_kelas" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="">No</td>
			<th width="">Kelas</td>
			<th width="">Jurusan</td>
			<th width="">sekolah</td>
			<th width="">Siswa</td>
			<th width="">Aksi</td>
		</tr>
	</thead> 
';

foreach($result as $row)
{
	$output .= '
	<tr>
		<td>'.$row['kelas_id'].'</td>
		<td>'.$row['kelas_nama'].'</td>
		<td>'.$row['jurusan_nama'].'</td>
		<td>'.$row['sekolah_nama'].'</td>
		<td><a type="button" class="btn btn-info btn-xs lihat_daftar_siswa" name="lihat_daftar_siswa" id="'.$row['kelas_id'].'" data-kelas="'.$row['kelas_nama'].'"><i class="fa fa-users"></i>  '.get_jumlah_siswa_kelas($connect, $row['kelas_id']).'   Siswa</a></td>
		<td>Aksi</td>
	</tr>
	';
}

$output .= '</table>
<script>
  $(function () {
    $("#tabel_kelas").DataTable();
  });
</script>';

echo $output;

?>