<?php 

include 'header.php'; 

//Belirli veriyi seçme işlemi
$askUser=$db->prepare("SELECT * FROM kullanicilar where kullanici_magaza=:magaza");
$askUser->execute(array(
  'magaza' => 1
));


?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Mağaza Başvuru <small>,

              <?php 

              if (@$_GET['durum']=="ok") {?>

              <b style="color:green;">İşlem Başarılı...</b>

              <?php } elseif (@$_GET['durum']=="no") {?>

              <b style="color:red;">İşlem Başarısız...</b>

              <?php }

              ?>


            </small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Kayıt Tarih</th>
                  <th>Firma Adı</th>
                  <th>Ad</th>
                  <th>Soyad</th>
                  <th>Mail Adresi</th>
                  <th>Telefon</th>
                  <th></th>

                </tr>
              </thead>

              <tbody>

                <?php 

                while($takekUser=$askUser->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>
                  <td><?php echo $takekUser['kullanici_zaman'] ?></td>
                  <td><?php echo $takekUser['kullanici_firma_unvan'] ?></td>
                  <td><?php echo $takekUser['kullanici_adSoyad'] ?></td>
                  <td><?php echo $takekUser['kullanici_mail'] ?></td>
                  <td><?php echo $takekUser['kullanici_gsm'] ?></td>

                  <td><center><a href="shop-confirm-process.php?kullanici_id=<?php echo $takekUser['kullanici_id']; ?>"><button class="btn btn-primary btn-xs">Mağaza İnceleme</button></a></center></td>
                 
                </tr>



                <?php  }

                ?>


              </tbody>
            </table>

            <!-- Div İçerik Bitişi -->


          </div>
        </div>
      </div>
    </div>




  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>