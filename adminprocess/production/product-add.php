<?php 

include 'header.php'; 


?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Yeni Ürün Ekle <small>,

              <?php 

                   if (@$_GET['situation']=="no") {?>

                   <div class="alert alert-danger">
                      <strong>İşlem Başarısız!</strong> 
                  </div>                             
                                      
                  
                  <?php } else if (@$_GET['situation']=="ok") { ?>


                  <div class="alert alert-success">
                      <strong>Ürün Başarıyla Eklendi!</strong>
                  </div>

                  
                  <?php }else if (@$_GET['situation']=="bigfile") {  ?>

                  <div class="alert alert-danger">
                      <strong>Ürün Resim Boyutu Büyük!</strong>
                  </div>

                <?php }else if (@$_GET['situation']=="type_error") { ?>

                <div class="alert alert-danger">
                      <strong>Ürün Resim Formatı Desteklenmiyor!</strong>Desteklenen Formatlar: JPG,PNG
                  </div>

                <?php } ?>


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
            <form action="../connecting/process.php" method="POST" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">

            <div class="form-group">
                <label class="col-sm-3 control-label">Ürünün Resmini Seçiniz</label>
                <div class="col-sm-9">
                    <input class="form-control" required="" id="first-name" name="product_add_photo_path"  type="file">
                </div>
            </div>


              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Kategori Değiştir<span class="required"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                   <select id="heard" class="form-control" name="product_edit_category" required>

                    <?php $askCategory=$db->prepare("SELECT * FROM kategoriler order by kategori_sira ASC ");

                                      $askCategory->execute();

                                      while ($takeCategory=$askCategory->fetch(PDO::FETCH_ASSOC)) {
                                          
                                        
                                   ?>

                        <option value="<?php echo $takeCategory['kategori_id'] ?>"><?php echo $takeCategory['kategori_ad']; ?></option>
                    

                        <?php } ?>


                         </select>
                       </div>
                     </div>

                   <div class="form-group">
                      <label class="col-sm-3 control-label">Ürün Ad</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" id="address2" name="product_add_name" type="text">
                      </div>
                  </div>


                   <div class="form-group">
                      <label class="col-sm-3 control-label">Açıklama</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">

                          <textarea  class="ckeditor" id="editor1" name="product_add_detail" placeholder="Ürün Açıklaması..."></textarea>
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
                      <input type="text" id="first-name" name="product_add_keyword" placeholder="Ürün keyword giriniz" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Stok <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" name="product_add_amount" placeholder="Ürün stok giriniz" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>



                  <div class="form-group">
                      <label class="col-sm-3 control-label">Ürün Fiyat</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" id="address2" name="product_add_price" type="text" >
                      </div>
                  </div>


               <div class="ln_solid"></div>
               <div class="form-group">
                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="product_add" class="btn btn-success">Ürünü Ekle</button>
                
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
