<?php 

include 'header.php'; 


$askProduct=$db->prepare("SELECT * FROM urunler where urun_id=:id");
$askProduct->execute(array(
  'id' => $_GET['product_id']
  ));
$takenID = $_GET['product_id'];
$takeProduct=$askProduct->fetch(PDO::FETCH_ASSOC);

?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Ürün Düzenleme <small>

              <?php 

              if (@$_GET['situation']=="ok") {?>

              <b style="color:green;">İşlem Başarılı...</b>

              <?php } elseif (@$_GET['situation']=="no") {?>

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
            <form action="../connecting/process.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


             <div class="form-group">
                  <label class="col-sm-3 control-label">Mevcut Resim</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <img  src="../../<?php echo $takeProduct['urun_fotograf'] ?>">
                  </div>
              </div>



                   <div class="form-group">
                      <label class="col-sm-3 control-label">Ürün Kategori Ad</label>

                      <?php
                    

                      $innerCategory=$db->prepare("SELECT urun_id,kategori_ad FROM urunler INNER JOIN kategoriler on urunler.kategori_id=kategoriler.kategori_id WHERE urun_id=:id");
                      $innerCategory->execute(array(
                        'id' => $takenID
                        ));
                      $takeInner=$innerCategory->fetch(PDO::FETCH_ASSOC);

                        ?>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" id="address2" readonly="" name="product_edit_Ctgname" type="text" value="<?php echo $takeInner['kategori_ad'] ?>">
                      </div>
                  </div>



                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Kategori Değiştir<span class="required"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                   <select id="heard" class="form-control" name="product_edit_category" >

                    <?php $askCategory=$db->prepare("SELECT * FROM kategoriler order by kategori_sira ASC ");

                                      $askCategory->execute();

                                      while ($takeCategory=$askCategory->fetch(PDO::FETCH_ASSOC)) {

                                        $kategori_id=$takeCategory['kategori_id'];
                                          
                                        
                                   ?>

                        <option value="<?php echo $takeCategory['kategori_id'] ?>"><?php echo $takeCategory['kategori_ad']; ?></option>
                    

                        <?php } ?>


                         </select>
                       </div>
                     </div>




                   <div class="form-group">
                      <label class="col-sm-3 control-label">Ürün Ad</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" id="address2" name="product_edit_name" type="text" value="<?php echo $takeProduct['urun_ad'] ?>">
                      </div>
                  </div>


                   <div class="form-group">
                      <label class="col-sm-3 control-label">Açıklama</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">

                          <textarea  class="ckeditor" id="editor1" name="product_edit_detail" placeholder="Ürün Açıklaması..."><?php echo $takeProduct['urun_detay']; ?></textarea>
                      </div>
                  </div>

                  <script type="text/javascript">

                         CKEDITOR.replace( 'editor1',

                         {

                            filebrowserBrowseUrl : 'ckfinder/ckfinder.html',

                            filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',

                            filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',

                            filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

                            filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

                            filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',

                            forcePasteAsPlainText: true

                        } 

                        );

                    </script>

                   <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Keyword <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" name="product_edit_keyword" value="<?php echo $takeProduct['urun_keyword'] ?>" placeholder="Ürün keyword giriniz" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Stok <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" name="product_edit_amount" value="<?php echo $takeProduct['urun_stok'] ?>" placeholder="Ürün stok giriniz" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>



                  <div class="form-group">
                      <label class="col-sm-3 control-label">Ürün Fiyat</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" value="<?php echo $takeProduct['urun_fiyat'] ?>" id="address2" name="product_edit_price" type="text" value="">
                      </div>
                  </div>




                   <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Durum<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <select id="heard" class="form-control" name="product_edit_situation" required>



                   <!-- Kısa İf Kulllanımı 

                    <?php echo $uruncek['urun_durum'] == '1' ? 'selected=""' : ''; ?>

                  -->




                  <option value="1" <?php echo $takeProduct['urun_durum'] == '1' ? 'selected=""' : ''; ?>>Aktif</option>



                  <option value="0" <?php if ($takeProduct['urun_durum']==0) { echo 'selected=""'; } ?>>Pasif</option>
                  <!-- <?php 

                   if ($uruncek['urun_durum']==0) {?>


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



            <input type="hidden" value="<?php echo $takeProduct['urun_id'] ?>" name="product_id">
            <input type="hidden" value="<?php echo $takeProduct['urun_fotograf'] ?>" name="product_edit_photo_past">

                                     


             <input type="hidden" name="kullanici_id" value="<?php echo $takeUser['kullanici_id'] ?>"> 


             <div class="ln_solid"></div>
             <div class="form-group">
              <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="product_edit" class="btn btn-success">Ürünü Güncelle</button>
                
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
