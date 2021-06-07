<?php 

include 'header.php'; 


$askUser=$db->prepare("SELECT * FROM kullanicilar where kullanici_id=:id");
$askUser->execute(array(
  'id' => $_GET['kullanici_id']
  ));

$takeUser=$askUser->fetch(PDO::FETCH_ASSOC);

?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Kullanıcı Düzenleme <small>,

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
            <br />

            <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
            <form action="../connecting/process.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <div class="form-group">
              <label class="col-sm-3 control-label">Mail</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" id="first-name" readonly="" name="user_edit_mail" type="text" value="<?php echo $takeUser['kullanici_mail'] ?>">

                  <input type="hidden" name="user_id_db" value="<?php echo $takeUser['kullanici_adSoyad'] ?>">
                  </div>
              </div>

          

            <?php 

            $zaman=explode(" ",$takeUser['kullanici_zaman']);

             ?>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kayıt Tarihi <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="" id="first-name" name="kullanici_tc" disabled="" value="<?php echo $zaman[0]; ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kayıt Saati <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="time" id="first-name" name="kullanici_tc" disabled="" value="<?php echo $zaman[1]; ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-3 control-label">TC*</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control" id="first-name" name="user_edit_republic_id" type="text" value="<?php echo $takeUser['kullanici_tc'] ?>">

                    <input type="hidden" name="user_edit_db" value="<?php echo $takeUser['kullanici_id'] ?>">
                </div>
            </div>


             <div class="form-group">
              <label class="col-sm-3 control-label">Ad Soyad</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" id="first-name" name="user_edit_name" type="text" value="<?php echo $takeUser['kullanici_adSoyad'] ?>">

                  <input type="hidden" name="user_id_db" value="<?php echo $takeUser['kullanici_adSoyad'] ?>">
              </div>
          </div>

          <div class="form-group">
                <label class="col-sm-3 control-label">İl</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control" id="first-name" name="user_edit_city" type="text" value="<?php echo $takeUser['kullanici_il'] ?>">
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label">İlçe</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control" id="first-name" name="user_edit_town" type="text" value="<?php echo $takeUser['kullanici_ilce'] ?>">
                </div>
            </div>


             <div class="form-group">
              <label class="col-sm-3 control-label">GSM</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control" id="first-name" name="user_edit_gsm" type="text" value="<?php echo $takeUser['kullanici_gsm'] ?>">
              </div>
          </div>


            <div class="form-group">
                <label class="col-sm-3 control-label">Adres</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control" id="first-name" name="user_edit_adress" type="text" value="<?php echo $takeUser['kullanici_adres'] ?>">
                </div>
            </div>

             


              

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı Durum<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <select id="heard" class="form-control" name="user_edit_situation" required>



                   <!-- Kısa İf Kulllanımı 

                    <?php echo $kullanicicek['kullanici_durum'] == '1' ? 'selected=""' : ''; ?>

                  -->




                  <option value="1" <?php echo $takeUser['kullanici_durum'] == '1' ? 'selected=""' : ''; ?>>Aktif</option>



                  <option value="0" <?php if ($takeUser['kullanici_durum']==0) { echo 'selected=""'; } ?>>Pasif</option>
                  <!-- <?php 

                   if ($kullanicicek['kullanici_durum']==0) {?>


                   <option value="0">Pasif</option>
                   <option value="1">Aktif</option>


                   <?php } else {?>

                   <option value="1">Aktif</option>
                   <option value="0">Pasif</option>

                   <?php  }

                   ?> -->


                 </select>
               </div>
             </div>


             <input type="hidden" name="kullanici_id" value="<?php echo $takeUser['kullanici_id'] ?>"> 


             <div class="ln_solid"></div>
             <div class="form-group">
              <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="edit_user" class="btn btn-success">Güncelle</button>
              </div>
            </div>

          </form>



        </div>
      </div>
    </div>
  </div>



  <hr>
  <hr>
  <hr>



</div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
