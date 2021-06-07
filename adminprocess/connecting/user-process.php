<?php 
ob_start();
session_start();
date_default_timezone_set('Europe/Istanbul');
include 'connectDB.php';
include '../production/fonksiyon.php';




if (isset($_POST['user_save'])) {

	$user_mail=htmlspecialchars(trim($_POST['user_reg_email'])); 

	$user_passwordone=htmlspecialchars(trim($_POST['user_reg_password_one'])); 
	$user_passwordtwo=htmlspecialchars(trim($_POST['user_reg_password_two'])); 



	if ($user_passwordone==$user_passwordtwo) {



		if (strlen($user_passwordone)>=6) {

			// Başlangıç

			$askUser=$db->prepare("select * from kullanicilar where kullanici_mail=:mail");
			$askUser->execute(array(
				'mail' => $user_mail
			));

			//dönen satır sayısını belirtir
			$say=$askUser->rowCount();



			if ($say==0) {

				//md5 fonksiyonu şifreyi md5 şifreli hale getirir.
				$password=md5($user_passwordone);

				$user_author=1;

				//Kullanıcı kayıt işlemi yapılıyor...
				$userSave=$db->prepare("INSERT INTO kullanicilar SET
					kullanici_adSoyad=:kullanici_adSoyad,
					kullanici_mail=:kullanici_mail,
					kullanici_password=:kullanici_password,
					kullanici_yetki=:kullanici_yetki
					");
				$insert=$userSave->execute(array(
					'kullanici_adSoyad' => htmlspecialchars($_POST['user_reg_nameSurname']),
					'kullanici_mail' => $user_mail,
					'kullanici_password' => $password,
					'kullanici_yetki' => $user_author
				));

				if ($insert) {


					header("Location:../../registration?durum=kayitok");



				} else {


					header("Location:../../registration?durum=basarisiz");
				}

			} else {

				header("Location:../../registration?durum=mukerrerkayit");



			}




		// Bitiş



		} else {


			header("Location:../../registration.php?durum=eksiksifre");


		}



	} else {



		header("Location:../../registration.php?durum=farklisifre");
	}
	


}




if (isset($_POST['customer_login'])) {



	require_once '../../securimage/securimage.php';

	$securimage = new Securimage();

	if ($securimage->check($_POST['captcha_code']) == false) {

		header("Location:../../login?situation=captchaError");
		exit;

	}
	
	echo $user_mail=htmlspecialchars($_POST['user_login_email']); 
	echo $user_password=md5(htmlspecialchars($_POST['user_login_password'])); 



	$askUser=$db->prepare("select * from kullanicilar where kullanici_mail=:mail and kullanici_yetki=:yetki and kullanici_password=:password and kullanici_durum=:durum");
	$askUser->execute(array(
		'mail' => $user_mail,
		'yetki' => 1,
		'password' => $user_password,
		'durum' => 1
	));


	$say=$askUser->rowCount();



	if ($say==1) {

		$user_ip=$_SERVER['REMOTE_ADDR'];

		$updateTime=$db->prepare("UPDATE kullanicilar SET


			kullanici_son_zaman=:kullanici_son_zaman,
			kullanici_ip=:kullanici_ip

			WHERE kullanici_mail='user_login_email'");


		$update=$updateTime->execute(array(


			'kullanici_son_zaman' => date("Y-m-d H:i:s"),
			'kullanici_ip' => $user_ip

		));


		$_SESSION['user_lastTime']=strtotime(date("Y-m-d H:i:s"));
		$_SESSION['login_user_mail']=$user_mail;



		header("Location:../../index.php?situation=loginsuccess");
		exit;
		




	} else {


		header("Location:../../login?situation=error");
		exit;

	}


}




if (isset($_POST['update_customer'])) {

	$user_id=$_POST['user_account_id'];

	$updateTo_database=$db->prepare("UPDATE kullanicilar SET
		kullanici_mail=:kullanici_mail,
		kullanici_adsoyad=:kullanici_adsoyad,
		kullanici_gsm=:kullanici_gsm
		WHERE kullanici_id={$_POST['kullanici_id']}");

	$update=$updateTo_database->execute(array(
		'kullanici_mail' => htmlspecialchars($_POST['account_mail']),
		'kullanici_adsoyad' => htmlspecialchars($_POST['account_nameSurname']),
		'kullanici_gsm' => htmlspecialchars($_POST['account_gsm'])
	));


	if ($update) {

		Header("Location:../../myAccount?updateSituation=ok");

	} else {

		Header("Location:../../myAccount?updateSituation=no");
	}

}


if (isset($_POST['update_customer_adress'])) {
	



	$kullaniciguncelle=$db->prepare("UPDATE kullanicilar SET

		kullanici_tip=:kullanici_tip,
		kullanici_tc=:kullanici_tc,
		kullanici_firma_unvan=:kullanici_firma_unvan,
		kullanici_firma_vDaire=:kullanici_firma_vDaire,
		kullanici_firma_vNo=:kullanici_firma_vNo,
		kullanici_adres=:kullanici_adres,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce
		WHERE kullanici_id={$_SESSION['login_user_id']}");


	$update=$kullaniciguncelle->execute(array(

		'kullanici_tip' => htmlspecialchars($_POST['user_type']),
		'kullanici_tc' => htmlspecialchars($_POST['user_republic_id']),
		'kullanici_firma_unvan' => htmlspecialchars($_POST['user_fix_class']),
		'kullanici_firma_vDaire' => htmlspecialchars($_POST['user_fix_name']),
		'kullanici_firma_vNo' => htmlspecialchars($_POST['user_fix_no']),
		'kullanici_adres' => htmlspecialchars($_POST['user_adres_detail']),
		'kullanici_il' => htmlspecialchars($_POST['user_city']),
		'kullanici_ilce' => htmlspecialchars($_POST['user_town'])

	));

	if ($update) {
		
		Header("Location:../../update-adress-info?durum=ok");

	} else {

		Header("Location:../../update-adress-info?durum=no");
	}



}



/*if (isset($_POST['update_customer_adress'])) {


	$updateTo_database=$db->prepare("UPDATE kullanicilar SET
		kullanici_tc=:kullanici_tc,
		kullanici_adres=:kullanici_adres,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce,
		kullanici_firma_unvan=:kullanici_firma_unvan,
		kullanici_firma_vDaire=:kullanici_firma_vDaire,,
		kullanici_firma_vNo=:kullanici_firma_vNo,
		kullanici_tip=:kullanici_tip
		WHERE kullanici_id={$_SESSION['login_user_id']}");

	$update=$updateTo_database->execute(array(

		'kullanici_tc' => htmlspecialchars($_POST['user_republic_id']),
		'kullanici_adres' => htmlspecialchars($_POST['user_adres_detail']),
		'kullanici_il' => htmlspecialchars($_POST['user_city']),
		'kullanici_ilce' => htmlspecialchars($_POST['user_town']),
		'kullanici_firma_unvan' => htmlspecialchars($_POST['user_fix_class']),
		'kullanici_firma_vDaire' => htmlspecialchars($_POST['user_fix_name']),
		'kullanici_firma_vNo' => htmlspecialchars($_POST['user_fix_no']),
		'kullanici_tip' => htmlspecialchars($_POST['user_type'])

	));



	if ($update) {

		Header("Location:../../update-adress-info.php?adress_Situation=ok");

	} else {

		Header("Location:../../update-adress-info.php?adress_Situation=no");
	}

}*/



if (isset($_POST['update_password'])) {
	

	$user_past_password=htmlspecialchars($_POST['account_past_password']);
	$user_new_password=htmlspecialchars($_POST['account_new_password']);
	$user_password_again=htmlspecialchars($_POST['account_new_password_again']);

	$user_password=md5($user_past_password);

	$askUser=$db->prepare("SELECT * from kullanicilar where kullanici_password=:password");
	$askUser->execute(array(
		'password' => $user_password
	));

	$say=$askUser->rowCount();

	if ($say==0) {
		
		Header("Location:../../update-password?situation=pastError");
		exit;


	}



	if ($user_new_password==$user_password_again) {


		if (strlen($user_new_password)>=6) {


			$password=md5($user_new_password);


			$update_password=$db->prepare("UPDATE kullanicilar SET

				kullanici_password=:kullanici_password

				WHERE kullanici_id={$_SESSION['login_user_id']}");


			$update=$update_password->execute(array(

				'kullanici_password' => $password
				

			));

			if ($update) {

				Header("Location:../../update-password?situation=ok");

			} else {

				Header("Location:../../update-password?situation=error");
			}




			


		} else {

			Header("Location:../../update-password?situation=missing");
			exit;

		}

		




	} else {


		Header("Location:../../update-password?situation=disagreement");
		exit;


	}


}



if (isset($_POST['send_shop_application'])) {
	



	$kullaniciguncelle=$db->prepare("UPDATE kullanicilar SET

		kullanici_adSoyad=:kullanici_adSoyad,
		kullanici_gsm=:kullanici_gsm,
		kullanici_banka=:kullanici_banka,
		kullanici_iban=:kullanici_iban,
		kullanici_tip=:kullanici_tip,
		kullanici_tc=:kullanici_tc,
		kullanici_firma_unvan=:kullanici_unvan,
		kullanici_firma_vDaire=:kullanici_vDaire,
		kullanici_firma_vNo=:kullanici_vNo,
		kullanici_adres=:kullanici_adres,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce,
		kullanici_magaza=:kullanici_magaza
		WHERE kullanici_id={$_SESSION['login_user_id']}");


	$update=$kullaniciguncelle->execute(array(

		'kullanici_adSoyad' => htmlspecialchars($_POST['shop_owner']),
		'kullanici_gsm' => htmlspecialchars($_POST['shop_gsm']),
		'kullanici_banka' => htmlspecialchars($_POST['shop_bank']),
		'kullanici_iban' => htmlspecialchars($_POST['shop_iban']),
		'kullanici_tip' => htmlspecialchars($_POST['user_type']),
		'kullanici_tc' => htmlspecialchars($_POST['user_owner_republic_id']),
		'kullanici_unvan' => htmlspecialchars($_POST['shop_fix_class']),
		'kullanici_vDaire' => htmlspecialchars($_POST['shop_fix_name']),
		'kullanici_vNo' => htmlspecialchars($_POST['shop_fix_no']),
		'kullanici_adres' => htmlspecialchars($_POST['shop_adres_detail']),
		'kullanici_il' => htmlspecialchars($_POST['shop_city']),
		'kullanici_ilce' => htmlspecialchars($_POST['shop_town']),
		'kullanici_magaza' => 1
	));

	if ($update) {
		
		Header("Location:../../shop-application.php");

	} else {

		Header("Location:../..shop-application?stiation=error");
	}



}

if (isset($_POST['saveOrder'])) {
	


	$kaydet=$db->prepare("INSERT INTO siparisler SET

		kullanici_id=:id,
		satici_id=:satici_id
		");

	$insert=$kaydet->execute(array(

		'id' => htmlspecialchars($_SESSION['login_user_id']),
		'satici_id' => htmlspecialchars($_POST['seller_id'])

	));

	if ($insert) {
		
		
		$siparis_id=$db->lastInsertId();


		$sipariskaydet=$db->prepare("INSERT INTO siparis_detay SET

			siparis_id=:siparis_id,
			kullanici_id=:id,
			satici_id=:satici_id,
			urun_id=:urun_id,
			urun_fiyat=:urun_fiyat
			");



		$insertkaydet=$sipariskaydet->execute(array(

			'siparis_id' => $siparis_id,
			'id' => htmlspecialchars($_SESSION['login_user_id']),
			'satici_id' => htmlspecialchars($_POST['seller_id']),
			'urun_id' => htmlspecialchars($_POST['productID']),
			'urun_fiyat' => htmlspecialchars($_POST['productPrice'])

		));



		if ($insertkaydet) {
			

			Header("Location:../../orders.php");


		}





	} else {

		Header("Location:../../404.php");

	}


}


if ($_GET['productDeliver']=="ok") {

	$siparis_id=$_GET['order_id'];

	$siparis_detayguncelle=$db->prepare("UPDATE siparis_detay SET
		
		detay_onay=:detay_onay
		
		WHERE detay_onay={$_GET['detail_id']}");


	$update=$siparis_detayguncelle->execute(array(

		
		'detay_onay' => 1
		
	));

	if ($update) {
		
		Header("Location:../../new-order.php?order_id=$siparis_id");

	} else {

		//Header("Location:../production/magazalar.php?durum=no");
	}



}


if ($_GET['productConfirm']=="ok") {

	$siparis_id=$_GET['order_id'];


	$siparis_detayguncelle=$db->prepare("UPDATE siparis_detay SET
		
		detay_onay=:detay_onay
		
		WHERE detay_id={$_GET['detail_id']}");


	$update=$siparis_detayguncelle->execute(array(

		
		'detay_onay' => 2
		
	));

	if ($update) {
		
		Header("Location:../../order-detail.php?order_id=$siparis_id");

	} else {

		//Header("Location:../production/magazalar.php?durum=no");
	}



}



if (isset($_POST['pointAndcomment'])) {
	


	$kaydet=$db->prepare("INSERT INTO yorumlar SET

		yorum_puan=:yorum_puan,
		urun_id=:urun_id,
		yorum_detay=:yorum_detay,
		kullanici_id=:kullanici_id
		");

	$insert=$kaydet->execute(array(

		'yorum_puan' => htmlspecialchars($_POST['comment_point']),
		'urun_id' => htmlspecialchars($_POST['product_id']),
		'yorum_detay' => htmlspecialchars($_POST['comment_detail']),
		'kullanici_id' => $_SESSION['login_user_id']

	));

	$order_id=$_POST['order_id'];


	if ($insert) {

		$siparis_detayguncelle=$db->prepare("UPDATE siparis_detay SET

			detay_yorum=:detay_yorum

			WHERE siparis_id={$_POST['order_id']}");


		$update=$siparis_detayguncelle->execute(array(


			'detay_yorum' => 1

		));


		Header("Location:../../order-detail?order_id=$order_id");

	} else {

		Header("Location:../../order-detail?order_id=$order_id");

	}

}




if (isset($_POST['sendAmessage'])) {

	$came_user=$_POST['came_user'];
	


	$kaydet=$db->prepare("INSERT INTO mesajlar SET

		mesaj_detay=:mesaj_detay,
		kime_geldi_id=:kime_geldi_id,
		kim_gonderdi_id=:kim_gonderdi_id
		");

	$insert=$kaydet->execute(array(

		'mesaj_detay' => $_POST['message_detail'],
		'kime_geldi_id' => htmlspecialchars($_POST['came_user']),
		'kim_gonderdi_id' => htmlspecialchars( $_SESSION['login_user_id'])

	));

	if ($insert) {
		
		
		Header("Location:../../message-send?situation=ok&came_user=$came_user");

	} else {

		Header("Location:../../message-send?situation=no&came_user=$came_user");


	}


}



if (isset($_POST['answerMessage'])) {

	$user_sender=$_POST['user_sender'];
	


	$kaydet=$db->prepare("INSERT INTO mesajlar SET

		mesaj_detay=:mesaj_detay,
		kime_geldi_id=:kime_geldi_id,
		kim_gonderdi_id=:kim_gonderdi_id
		");

	$insert=$kaydet->execute(array(

		'mesaj_detay' => $_POST['message_detail'],
		'kime_geldi_id' => htmlspecialchars($_POST['user_sender']),
		'kim_gonderdi_id' => htmlspecialchars( $_SESSION['login_user_id'])

	));

	if ($insert) {
		
		
		Header("Location:../../message-came?situation=ok");

	} else {

		Header("Location:../../message-came?situation=error");


	}


}




if ($_GET['deleteCameMessage']=="ok") {

	
	
	$sil=$db->prepare("DELETE from mesajlar where mesaj_id=:mesaj_id");
	$kontrol=$sil->execute(array(
		'mesaj_id' => $_GET['message_id']
	));

	if ($kontrol) {

		Header("Location:../../message-came.php?situation=ok");

	} else {

		Header("Location:../../message-came.php?situation=error");
	}

}




?>