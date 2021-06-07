<?php 
ob_start();
session_start();

include 'connectDB.php';
include '../production/fonksiyon.php';


if (@$_GET['shopconfirmed']=="red") {


	$kullaniciguncelle=$db->prepare("UPDATE kullanicilar SET

		
		kullanici_magaza=:kullanici_magaza
		
		WHERE kullanici_id={$_GET['kullanici_id']}");


	$update=$kullaniciguncelle->execute(array(

		
		'kullanici_magaza' => 0
		
	));

	if ($update) {
		
		Header("Location:../production/shops.php?durum=ok");


	} else {

		Header("Location:../production/shops.php?durum=no");
	}



}


if (isset($_POST['shop_confirming'])) {
	



	$kullaniciguncelle=$db->prepare("UPDATE kullanicilar SET

		kullanici_adSoyad=:kullanici_adSoyad,
		kullanici_gsm=:kullanici_gsm,
		kullanici_banka=:kullanici_banka,
		kullanici_iban=:kullanici_iban,
		kullanici_tc=:kullanici_tc,
		kullanici_firma_unvan=:kullanici_firma_unvan,
		kullanici_firma_vDaire=:kullanici_firma_vDaire,
		kullanici_firma_vNo=:kullanici_firma_vNo,
		kullanici_adres=:kullanici_adres,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce,
		kullanici_magaza=:kullanici_magaza
		WHERE kullanici_id={$_POST['user_edit_db']}");


	$update=$kullaniciguncelle->execute(array(

		'kullanici_adSoyad' => htmlspecialchars($_POST['shop_confirmed_nameSurname']),
		'kullanici_gsm' => htmlspecialchars($_POST['shop_confirmed_gsm']),
		'kullanici_banka' => htmlspecialchars($_POST['shop_confirmed_bank']),
		'kullanici_iban' => htmlspecialchars($_POST['shop_confirmed_iban']),
		
		'kullanici_tc' => htmlspecialchars($_POST['shop_confirmed_republic_id']),
		'kullanici_firma_unvan' => htmlspecialchars($_POST['shop_confirmed_class']),
		'kullanici_firma_vDaire' => htmlspecialchars($_POST['shop_confirmed_name']),
		'kullanici_firma_vNo' => htmlspecialchars($_POST['shop_confirmed_no']),
		'kullanici_adres' => htmlspecialchars($_POST['shop_confirmed_adress']),
		'kullanici_il' => htmlspecialchars($_POST['shop_confirmed_city']),
		'kullanici_ilce' => htmlspecialchars($_POST['shop_confirmed_town']),
		'kullanici_magaza' => 2
	));

	if ($update) {
		
		Header("Location:../production/shops.php?durum=ok");


	} else {

		Header("Location:../production/shops.php?durum=no");
	}



}



if (isset($_POST['update_photo'])) {

	
	if ($_FILES['user_shop_photo']['size']>1048576) {
		
		echo "Bu dosya boyutu çok büyük";

		Header("Location:../../update-profile-photo?situation=bigfile");

	}


	$izinli_uzantilar=array('jpg','png');

	//echo $_FILES['ayar_logo']["name"];

	$ext=strtolower(substr($_FILES['user_shop_photo']["name"],strpos($_FILES['user_shop_photo']["name"],'.')+1));


	

	if (in_array($ext, $izinli_uzantilar) === false) {
		echo "Bu uzantı kabul edilmiyor";
		Header("Location:../../update-profile-photo.php?situation=type_error");

		exit;
	}

	@$tmp_name = $_FILES['user_shop_photo']["tmp_name"];
	@$name = $_FILES['user_shop_photo']["name"];

	//İmage Resize İşlemleri
	include('simple-image.php');
	$image = new SimpleImage();
	$image->load($tmp_name);
	$image->resize(128,128);
	$image->save($tmp_name);

	$uploads_dir = '../../img/userphoto';

	$uploads_dir = '../../img/test';

	

	$uniq=uniqid();
	$refimgyol=substr($uploads_dir, 6)."/".$uniq.".".$ext;

	@move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");

	
	$duzenle=$db->prepare("UPDATE kullanicilar SET
		
		kullanici_magazaFoto=:kullanici_magazaFoto

		WHERE kullanici_id={$_SESSION['login_user_id']}");

	$update=$duzenle->execute(array(

		'kullanici_magazaFoto' => $refimgyol
	));



	if ($update) {

		$delete_photo_unlink=$_POST['past_path'];
		unlink("../../$delete_photo_unlink");

		Header("Location:../../update-profile-photo.php?situation=ok");

	} else {

		Header("Location:../../update-profile-photo.php?situation=error");
	}

}


if (isset($_POST['product_add'])) {

	
	if ($_FILES['product_photo_path']['size']>1048576) {
		
		echo "Bu dosya boyutu çok büyük";

		Header("Location:../../product-add.php?situation=bigfile");

	}


	$izinli_uzantilar=array('jpg','png');

	//echo $_FILES['ayar_logo']["name"];

	$ext=strtolower(substr($_FILES['product_photo_path']["name"],strpos($_FILES['product_photo_path']["name"],'.')+1));


	

	if (in_array($ext, $izinli_uzantilar) === false) {
		echo "Bu uzantı kabul edilmiyor";
		Header("Location:../../product-add.php?situation=type_error");

		exit;
	}

	@$tmp_name = $_FILES['product_photo_path']["tmp_name"];
	@$name = $_FILES['product_photo_path']["name"];

	//İmage Resize İşlemleri
	include('simple-image.php');
	$image = new SimpleImage();
	$image->load($tmp_name);
	$image->resize(829,422);
	$image->save($tmp_name);

	$uploads_dir = '../../img/productPhoto';

	

	$uniq=uniqid();
	$refimgpath=substr($uploads_dir, 6)."/".$uniq.".".$ext;

	@move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");

	
	

	$duzenle=$db->prepare("INSERT INTO urunler SET
		
		kategori_id=:kategori_id,
		kullanici_id=:kullanici_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_stok=:urun_stok,
		urun_fiyat=:urun_fiyat,
		urun_fotograf=:urun_fotograf

		");

	$update=$duzenle->execute(array(

		'kategori_id' => htmlspecialchars($_POST['category_id']),
		'kullanici_id' =>2,
		'urun_ad' => htmlspecialchars($_POST['product_name']),
		'urun_detay' => htmlspecialchars($_POST['product_detail']),
		'urun_stok' => htmlspecialchars($_POST['product_amount']),
		'urun_fiyat' => htmlspecialchars($_POST['product_price']),
		'urun_fotograf' => $refimgpath
	));



	if ($update) {


		Header("Location:../../product-add.php?situation=ok");

	} else {

		Header("Location:../../product-add.php?situation=hata");
	}

}




/////////////////////////////////////////////////

if (isset($_POST['product_update'])) {

	if ($_FILES['product_edit_photo_path']['size']>0) {


		if ($_FILES['product_edit_photo_path']['size']>1048576) {

			echo "Bu dosya boyutu çok büyük";

			Header("Location:../../product-edit.php?situation=bigfile");

		}


		$izinli_uzantilar=array('jpg','png');

	//echo $_FILES['ayar_logo']["name"];

		$ext=strtolower(substr($_FILES['product_edit_photo_path']["name"],strpos($_FILES['product_edit_photo_path']["name"],'.')+1));




		if (in_array($ext, $izinli_uzantilar) === false) {
			echo "Bu uzantı kabul edilmiyor";
			Header("Location:../../product-edit.php?situation=type_error");

			exit;
		}

		@$tmp_name = $_FILES['product_edit_photo_path']["tmp_name"];
		@$name = $_FILES['product_edit_photo_path']["name"];

	//İmage Resize İşlemleri
		include('simple-image.php');
		$image = new SimpleImage();
		$image->load($tmp_name);
		$image->resize(829,422);
		$image->save($tmp_name);

		$uploads_dir = '../../dimg/urunfoto';



		$uniq=uniqid();
		$refimgyol=substr($uploads_dir, 6)."/".$uniq.".".$ext;

		@move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");




		$duzenle=$db->prepare("UPDATE urunler SET

			kategori_id=:kategori_id,
			urun_ad=:urun_ad,
			urun_detay=:urun_detay,
			urun_stok=:urun_stok,
			urun_fiyat=:urun_fiyat,
			urun_fotograf=:urun_fotograf
			WHERE urun_id={$_POST['product_id_edit']}");


		$update=$duzenle->execute(array(

			'kategori_id' => htmlspecialchars($_POST['product_edit_category_id']),
			'urun_ad' => htmlspecialchars($_POST['product_edit_name']),
			'urun_detay' => htmlspecialchars($_POST['product_edit_detail']),
			'urun_stok' => htmlspecialchars($_POST['product_edit_amount']),
			'urun_fiyat' => htmlspecialchars($_POST['product_edit_price']),
			'urun_fotograf' => $refimgyol
		));


		$product_id=$_POST['product_id_edit'];

		if ($update) {

			$delete_photo_unlink=$_POST['product_edit_photo_past'];
			unlink("../../$delete_photo_unlink");




			Header("Location:../../product-edit.php?situation=ok&product_id=$product_id");

		} else {

			Header("Location:../../product-edit.php?situation=hata&product_id=$product_id");
		}


	} else {


//Fotoğraf Yoksa İşlemler


		$edit=$db->prepare("UPDATE urunler SET

			kategori_id=:kategori_id,
			urun_ad=:urun_ad,
			urun_detay=:urun_detay,
			urun_stok=:urun_stok,
			urun_fiyat=:urun_fiyat
			
			WHERE urun_id={$_POST['product_id']}");


		$update=$edit->execute(array(

			'kategori_id' => htmlspecialchars($_POST['product_edit_category_id']),
			'urun_ad' => htmlspecialchars($_POST['product_edit_name']),
			'urun_detay' => htmlspecialchars($_POST['product_edit_detail']),
			'urun_stok' => htmlspecialchars($_POST['product_edit_amount']),
			'urun_fiyat' => htmlspecialchars($_POST['product_edit_price'])

		));


		$product_id=$_POST['product_id'];

		if ($update) {

			
			Header("Location:../../product-edit.php?situation=ok&product_id=$product_id");

		} else {

			Header("Location:../../product-edit.php?situation=error&product_id=$product_id");
		}

	}

}



if (@$_GET['deleteProduct']=="ok") {

	
	
	$sil=$db->prepare("DELETE from urunler where urun_id=:urun_id");
	$kontrol=$sil->execute(array(
		'urun_id' => $_GET['product_id']
	));

	if ($kontrol) {

		$delete_photo_unlink=$_GET['product_photo'];
		unlink("../../$delete_photo_unlink");

		Header("Location:../../products.php?durum=ok");

	} else {

		Header("Location:../../products.php?durum=error");
	}

}


if (isset($_POST['product_edit'])) {

	$category_id=$_POST['category_id'];
	$category_seourl=seo($_POST['category_name']);

	
	$kaydet=$db->prepare("UPDATE kategoriler SET
		kategori_ad=:ad,
		kategori_durum=:kategori_durum,	
		kategori_seourl=:seourl,
		kategori_oneCikar=:kategori_oneCikar,
		kategori_sira=:sira
		WHERE kategori_id={$_POST['category_id']}");
	$update=$kaydet->execute(array(
		'ad' => htmlspecialchars($_POST['category_name']),
		'kategori_durum' => htmlspecialchars($_POST['category_situation']),
		'seourl' => $category_seourl,
		'kategori_oneCikar' => htmlspecialchars($_POST['category_forward']),
		'sira' => $_POST['category_count']		
	));

	if ($update) {

		Header("Location:../production/category-edit.php?situation=ok&category_id=$category_id");

	} else {

		Header("Location:../production/category-edit.php?situation=no&category_id=$category_id");
	}

}


 ?>