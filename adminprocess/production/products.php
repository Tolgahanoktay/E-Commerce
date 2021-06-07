<?php 

include 'header.php'; 

//Belirli veriyi seçme işlemi
$askProduct=$db->prepare("SELECT * FROM urunler order by urun_id ASC");
$askProduct->execute();


?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Onay Bekleyen Ürünler <small>,

              <?php 

              if (@$_GET['situation']=="ok") {?>

              <b style="color:green;">İşlem Başarılı...</b>

              <?php } elseif (@$_GET['situation']=="no") {?>

              <b style="color:red;">İşlem Başarısız...</b>

              <?php }

              ?>

        

            </small></h2>


             <div align="right">
              <a href="product-add.php"><button class="btn btn-success btn-xs"> Yeni Ekle</button></a>
            </div>

            
            <div class="clearfix"></div>
          </div>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                 <th>S.No</th>
                  <th>Ürün Ad</th>
                  <th>Ürün Fiyat</th>
                  <th>Öne Çıkar</th>
                  <th>Durum</th>
                  <th></th>
                  <th></th>

                </tr>
              </thead>

              <tbody>

                <?php 

                $say=1;

                while($takeProduct=$askProduct->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>

        		  <td width="20"><?php echo $say++ ?></td>
                  <td><?php echo $takeProduct['urun_ad'] ?></td>
                  <td><?php echo $takeProduct['urun_fiyat'] ?></td>

                  <td><center> <?php 



                  if ($takeProduct['urun_oneCikar']==0) { ?>

                   <a href="../connecting/process.php?product_id=<?php echo $takeProduct['urun_id'] ?>&product_forw=1&product_forward=ok"><button class="btn btn-success btn-xs">Öne Çıkar</button></a>

                   <?php  }else if ($takeProduct['urun_oneCikar']==1) { ?>

               	   <a href="../connecting/process.php?product_id=<?php echo $takeProduct['urun_id'] ?>&product_forw=0&product_forward=ok"><button class="btn btn-warning btn-xs">Kaldır</button></a>

               		<?php } ?></center></td>

               		<td><center><?php 


               		 if ($takeProduct['urun_durum']==1) {?>

                  		<button class="btn btn-success btn-xs">Aktif</button>

                  	<?php }else{ ?>

                  		<button class="btn btn-danger btn-xs">Pasif</button>

                  		<?php } ?></center></td>


                  	<td><center><a href="product-edit.php?product_id=<?php echo $takeProduct['urun_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>


               		 <td><center><a onclick="return confirm('Bu ürünü silmek istediğinize eminmisiniz?')" href="../connecting/process.php?product_id=<?php echo $takeProduct['urun_id']; ?>&urunsil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
                 
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
