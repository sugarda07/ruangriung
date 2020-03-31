<?php 
// menghubungkan dengan koneksi
include('../master/koneksi.php');
$exam = new Koneksi;
// menghubungkan dengan library excel reader
include ('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');

$target = basename($_FILES['filesoal']['name']) ;
move_uploaded_file($_FILES['filesoal']['tmp_name'], $target);
 
// beri permisi agar file xls dapat di baca
chmod($_FILES['filesoal']['name'],0777);
 
// mengambil isi file xls
$data = new Spreadsheet_Excel_Reader($_FILES['filesoal']['name'],false);
// menghitung jumlah baris data yang ada
$jumlah_baris = $data->rowcount($sheet_index=0);
 
// jumlah default data yang berhasil di import
$berhasil = 0;
for ($i=2; $i<=$jumlah_baris; $i++){
 
	// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
	$exam->data = array(
		':soal_ujian_id'		=>	$_POST['soal_ujian_id'],
		':soal_teks'			=>	$data->val($i, 6),
		':soal_kunci'			=>	$data->val($i, 7)
	);

	// input data ke database (table data_pegawai)
	$exam->query = "
	INSERT INTO soal
	(soal_ujian_id, soal_teks, soal_kunci) 
	VALUES (:soal_ujian_id, :soal_teks, :soal_kunci)
	";

	$soal_id = $exam->execute_question_with_last_id($exam->data);

	for($count = 1; $count <= 5; $count++)
	{
		$exam->data = array(
			':pilihan_soal_id'	=>	$soal_id,
			':pilihan_no'		=>	$count,
			':pilihan_teks'		=>	$data->val($i, $count)
		);

		$exam->query = "
		INSERT INTO pilihan_soal 
		(pilihan_soal_id, pilihan_no, pilihan_teks) 
		VALUES (:pilihan_soal_id, :pilihan_no, :pilihan_teks)
		";

		$exam->execute_query($exam->data);
	}

	$berhasil++;

}
 
// hapus kembali file .xls yang di upload tadi
unlink($_FILES['filesoal']['name']);
 
// alihkan halaman ke index.php

?>