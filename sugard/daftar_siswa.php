<?php

include('../koneksi.php');
include('../function.php');

session_start();

$query = "
SELECT * FROM user
INNER JOIN kelas ON kelas.kelas_id=user.kelas
INNER JOIN sekolah ON sekolah.sekolah_id=kelas.sekolah_id
INNER JOIN jurusan ON jurusan.jurusan_id=kelas.jurusan_id
WHERE user.kelas = '".$_POST["id"]."'
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table id="tabel_daftar_siswa" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="">UserId</td>
			<th width="">Nama</td>
			<th width="">Lahir</td>
			<th width="">email</td>
			<th width="">Aksi</td>
		</tr>
	</thead> 
';

foreach($result as $row)
{
	$output .= '
	<tr>
		<td>'.$row['user_id'].'</td>
		<td>'.$row['nama_depan'].' '.$row['nama_belakang'].'</td>
		<td>'.$row['tmp_lahir'].', '.tgl_indo($row['tgl_lahir']).'</td>
		<td>'.$row['email'].'</td>
		<td>Aksi</td>
	</tr>
	';
}

$output .= '</table>
<script>
  $(function () {
    $("#tabel_daftar_siswa").DataTable();
  });
</script>';

echo $output;

?>