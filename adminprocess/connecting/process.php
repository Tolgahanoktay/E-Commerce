<?php
ob_start();
session_start();

include 'connectDB.php';
include '../production/fonksiyon.php';



if (isset($_POST['adminLogin'])) {



	$user_mail=$_POST['user_mail'];
	$user_password=md5($_POST['password']);

	$kullanicisor=$db->prepare("SELECT * FROM kullanicilar where kullanici_mail=:mail and kullanici_password=:password and kullanici_yetki=:yetki");
	$kullanicisor->execute(array(
		'mail' => $user_mail,
		'password' => $user_password,
		'yetki' => 5
	));

	echo $say=$kullanicisor->rowCount();

	if ($say==1) {

		$_SESSION['kullanici_mail']=$user_mail;
		header("Location:../production/index.php");
		exit;



	} else {

		header("Location:../production/login.php?durum=no");
		exit;
	}
	

}


if (isset($_POST['edit_user'])) {

	$user_id=$_POST['user_edit_db'];


	$kullaniciguncelle=$db->prepare("UPDATE kullanicilar SET

		kullanici_adSoyad=:kullanici_adSoyad,
		kullanici_gsm=:kullanici_gsm,
		kullanici_tc=:kullanici_tc,
		kullanici_adres=:kullanici_adres,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce,
		kullanici_durum=:kullanici_durum
		WHERE kullanici_id={$_POST['user_edit_db']}");


	$update=$kullaniciguncelle->execute(array(

		'kullanici_adSoyad' => htmlspecialchars($_POST['user_edit_name']),
		'kullanici_gsm' => htmlspecialchars($_POST['user_edit_gsm']),
		'kullanici_tc' => htmlspecialchars($_POST['user_edit_republic_id']),
		'kullanici_adres' => htmlspecialchars($_POST['user_edit_adress']),
		'kullanici_il' => htmlspecialchars($_POST['user_edit_city']),
		'kullanici_ilce' => htmlspecialchars($_POST['user_edit_town']),
		'kullanici_durum' => htmlspecialchars($_POST['user_edit_situation'])
		
	));

	if ($update) {
		
		Header("Location:../production/edit-user.php?durum=ok&kullanici_id=$user_id");


	} else {

		Header("Location:../production/edit-user.php?durum=no&kullanici_id=$user_id");
	}

}

if (@$_GET['product_forward']=="ok") {

	

	
	$duzenle=$db->prepare("UPDATE urunler SET
		
		urun_oneCikar=:urun_oneCikar
		
		WHERE urun_id={$_GET['product_id']}");
	
	$update=$duzenle->execute(array(


		'urun_oneCikar' => $_GET['product_forw']
	));



	if ($update) {

		

		Header("Location:../production/products.php?situation=ok");

	} else {

		Header("Location:../production/products.php?situation=no");
	}

}



if (isset($_POST['product_add'])) {

	$product_seourl=seo($_POST['product_add_name']);

	
	if ($_FILES['product_add_photo_path']['size']>1048576) {
		
		echo "Bu dosya boyutu çok büyük";

		Header("Location:../production/product-add.php?situation=bigfile");

	}


	$izinli_uzantilar=array('jpg','png');

	//echo $_FILES['ayar_logo']["name"];

	$ext=strtolower(substr($_FILES['product_add_photo_path']["name"],strpos($_FILES['product_add_photo_path']["name"],'.')+1));


	

	if (in_array($ext, $izinli_uzantilar) === false) {
		echo "Bu uzantı kabul edilmiyor";
		Header("Location:../production/product-add.php?situation=type_error");

		exit;
	}

	@$tmp_name = $_FILES['product_add_photo_path']["tmp_name"];
	@$name = $_FILES['product_add_photo_path']["name"];

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

	
	

	$edit=$db->prepare("INSERT INTO urunler SET
		
		kategori_id=:kategori_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_keyword=:urun_keyword,
		urun_stok=:urun_stok,
		urun_fiyat=:urun_fiyat,
		urun_durum=:urun_durum,
		urun_seoURL=:seoURL,
		urun_fotograf=:urun_fotograf

		");

	$update=$edit->execute(array(

		'kategori_id' => htmlspecialchars($_POST['product_edit_category']),
		'urun_ad' => htmlspecialchars($_POST['product_add_name']),
		'urun_detay' => htmlspecialchars($_POST['product_add_detail']),
		'urun_keyword' => htmlspecialchars($_POST['product_add_keyword']),
		'urun_stok' => htmlspecialchars($_POST['product_add_amount']),
		'urun_fiyat' => htmlspecialchars($_POST['product_add_price']),
		'urun_durum' => 0,
		'seoURL' => htmlspecialchars($_POST['product_add_name']),
		'urun_fotograf' => $refimgpath
	));



	if ($update) {


		Header("Location:../production/product-add.php?situation=ok");

	} else {

		Header("Location:../production/product-add.php?situation=hata");
	}

}



if (isset($_POST['product_edit'])) {

	$product_id=$_POST['product_id'];
	$product_seourl=seo($_POST['product_edit_name']);

	$kaydet=$db->prepare("UPDATE urunler SET
		kategori_id=:kategori_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_fiyat=:urun_fiyat,
		urun_keyword=:urun_keyword,
		urun_durum=:urun_durum,
		urun_stok=:urun_stok,	
		urun_seoURL=:seourl		
		WHERE urun_id={$_POST['product_id']}");
	$update=$kaydet->execute(array(
		'kategori_id' => $_POST['product_edit_category'],
		'urun_ad' => $_POST['product_edit_name'],
		'urun_detay' => $_POST['product_edit_detail'],
		'urun_fiyat' => $_POST['product_edit_price'],
		'urun_keyword' => $_POST['product_edit_keyword'],
		'urun_durum' => $_POST['product_edit_situation'],
		'urun_stok' => $_POST['product_edit_amount'],
		'seourl' => $urun_seourl

	));

	if ($update) {

		Header("Location:../production/product-edit.php?situation=ok&product_id=$product_id");

	} else {

		Header("Location:../production/product-edit.php?situation=no&product_id=$product_id");
	}

}



if ($_GET['deleteCategory']=="ok") {
	
	$delete=$db->prepare("DELETE from kategoriler where kategori_id=:kategori_id");
	$control=$delete->execute(array(
		'kategori_id' => $_GET['category_id']
	));

	if ($control) {

		Header("Location:../production/process.php?situation=ok");

	} else {

		Header("Location:../production/process.php?situation=no");
	}

}


if (isset($_POST['category_add'])) {

	$category_seourl=seo($_POST['category_name']);

	$kaydet=$db->prepare("INSERT INTO kategoriler SET
		kategori_ad=:ad,
		kategori_durum=:kategori_durum,	
		kategori_seoURL=:seourl,
		kategori_sira=:sira
		");
	$insert=$kaydet->execute(array(
		'ad' => $_POST['category_name'],
		'kategori_durum' => $_POST['category_situation'],
		'seourl' => $category_seourl,
		'sira' => $_POST['category_count']		
	));

	if ($insert) {

		Header("Location:../production/categories.php?situation=ok");

	} else {

		Header("Location:../production/categories.php?situation=no");
	}

}

?>