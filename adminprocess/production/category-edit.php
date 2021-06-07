<?php 

include 'header.php'; 


$askCategory=$db->prepare("SELECT * FROM kategoriler where kategori_id=:id");
$askCategory->execute(array(
  'id' => $_GET['category_id']
  ));

$takeCategory=$askCategory->fetch(PDO::FETCH_ASSOC);

?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">

            <h2>Kategori Düzenleme <small>

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
            <form action="../connecting/admin-process.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Ad <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="category_name" value="<?php echo $takeCategory['kategori_ad'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>



                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Sıra <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" name="category_count" value="<?php echo $takeCategory['kategori_sira'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>



                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Öne Çıkar<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <select id="heard" class="form-control" name="category_forward" >



                      <option value="1" <?php echo $takeCategory['kategori_oneCikar'] == '1' ? 'selected=""' : ''; ?>>Evet</option>



                      <option value="0" <?php if ($takeCategory['kategori_oneCikar']== '0') { echo 'selected=""'; } ?>>Hayır</option>
                     

                     </select>
                   </div>
                 </div>




               <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Durum<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                   <select id="heard" class="form-control" name="category_situation" required>



                      <option value="1" <?php echo $takeCategory['kategori_durum'] == '1' ? 'selected=""' : ''; ?>>Aktif</option>



                      <option value="0" <?php if ($takeCategory['kategori_durum']==0) { echo 'selected=""'; } ?>>Pasif</option>
                     


                     </select>
                   </div>
                 </div>


                   <input type="hidden" name="category_id" value="<?php echo $takeCategory['kategori_id'] ?>"> 


                 <div class="ln_solid"></div>
                  <div class="form-group">
                    <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="submit" name="product_edit" class="btn btn-success">Kategori Güncelle</button>
                    
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
