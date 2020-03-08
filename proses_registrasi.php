<?php

include('koneksi.php');

sleep(5);

if(isset($_POST['nama_depan']))
{
	$query = "
	 SELECT * FROM user 
	 WHERE email = '".trim($_POST["email"])."'
	 ";

	 $statement = $connect->prepare($query);

	 $statement->execute();

	 $total_row = $statement->rowCount();

	 if($total_row > 0)
	 {
	 	echo 'email sudah terdaftar...';
	 }
	 else
	 {
		$data = array(
			':nama_depan'  	=> $_POST['nama_depan'],
			':nama_belakang'  => $_POST['nama_belakang'],
			':email'  	 	=> $_POST['email'],
			':password'   	=> password_hash($_POST['password'], PASSWORD_DEFAULT)
		);

		$query = "
		INSERT INTO user 
		(nama_depan, nama_belakang, email, password) 
		VALUES (:nama_depan, :nama_belakang, :email, :password)
		";
		$statement = $connect->prepare($query);
		if($statement->execute($data))
		{
			echo 'Registration Berhasil...';
		}
	 }
 
	 
}

?>