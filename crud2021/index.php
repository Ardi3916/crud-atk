<?php
	//koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "dblatihan";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//Jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if($_GET[hal] == "edit")
		{
			//data akan di edit
			$edit = mysqli_query($koneksi, " UPDATE tmhs set
												barang = '$_POST[barang]',
												satuan = '$_POST[satuan]',
												perpack = '$_POST[perpack]',
												isi = '$_POST[isi]'
											 WHERE id_mhs = '$_GET[id]'
							  			   ");
			if($edit) //Jika edit sukses
			{
				echo "<script>
						alert('Edit data suksess!');
						document.location='index.php';
					  </script>";
			}
			else
			{
				echo "<script>
						alert('Edit data GAGAL!');
						document.location='index.php';
					  </script>";
			}
		}
		else
		{
			//data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nama barang, harga satuan, harga perpack, isi perpack)
										  VALUES ('$_POST[tbarang]',
										  		 '$_POST[tsatuan]',
										  		 '$_POST[tperpack]',
										  		 '$_POST[tisi]')
							  			 ");
			if($simpan) //Jika simpan sukses
			{
				echo "<script>
						alert('Simpan data suksess!');
						document.location='index.php';
					  </script>";
			}
			else
			{
				echo "<script>
						alert('Simpan data GAGAL!');
						document.location='index.php';
					  </script>";
			}
		}



	}

	//Pengujian jika tombol edit / hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if($_GET['hal'] == "edit")
		{
			//Tampilkan data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
				$vbarang = $data['nama barang'];
				$vsatuan = $data['harga satuan'];
				$vperpack = $data['harga perpack'];
				$visi = $data['isi perpack'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' "); 
			if($hapus){
				echo "<script>
						alert('Hapus data suksess!');
						document.location='index.php';
 					  </script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Harga Barang ATK</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

	<h1 class="text-center">Harga Barang Alat Tulis Kantor</h1>
	<h2 class="text-center">Ardi Saputra</h2>

	<!--Awal Card Form-->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white ">
	    Form Input Harga Barang ATK
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>Nama Barang</label>
	    		<input type="text" name="tbarang" value='<?=@$vbarang?>' class="form-control" placeholder="Input Nama Barang disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Harga Satuan</label>
	    		<input type="text" name="tsatuan" value='<?=@$vsatuan?>' class="form-control" placeholder="Input Harga Satuan disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Harga Perpack</label>
	    		<input type="text" name="tperpack" value='<?=@$vbarang?>' class="form-control" placeholder="Input Harga Perpack disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Isi Perpack</label>
	    		<select class="form-control" name="tisi">
	    			<option value='<?=@$visi?>'><?=@$visi?></option>
	    			<option value="12 Biji">12 Biji</option>
	    			<option value="10 Biji">10 Biji</option>
	    			<option value="5 Rim">5 Rim</option>
	    		</select>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
			<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!--AkhirCard Form-->

	<!--Awal Card Tabel-->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white ">
	    Daftar Produk ATK
	  </div>
	  <div class="card-body">
	   
	  	<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>No.</th>
	  			<th>Nama Barang</th>
	  			<th>Harga Satuan</th>
	  			<th>Harga Perpack</th>
	  			<th>Isi Perpack</th>
	  			<th>Aksi</th>
	  		</tr>
	  		<?php
	  			$no = 1;
	  			$tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
	  			while($data = mysqli_fetch_array($tampil)) :

	  		?>
	  		<tr>
	  			<td><?=$no++;?></td>
	  			<td><?=$data['nama barang']?></td>
	  			<td><?=$data['harga satuan']?></td>
	  			<td><?=$data['harga perpack']?></td>
	  			<td><?=$data['isi perpack']?></td>
	  			<td>
	  				<a href="index.php?hal=edit&id=<?=$data['id_barang']?>" class="btn btn-warning">Edit</a>
	  				<a href="index.php?hal=hapus&id=<?=$data['id_barang']?>" 
	  					onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
	  			</td>
	  		</tr>
	  	<?php endwhile; //penutup perulangan while ?>
	  	</table>

	  </div>
	</div>
	<!--AkhirCard Tabel-->

</div>
<script type="text/javascript" src="js/bootstrap.min.css"></script>
</body>
</html>