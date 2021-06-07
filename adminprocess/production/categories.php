<?php 

include 'header.php'; 

//Belirli veriyi seçme işlemi
$askCategory=$db->prepare("SELECT * FROM kategoriler order by kategori_sira ASC");
$askCategory->execute();



?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">

             <h2>Kategori Listeleme <small>,

              <?php 

              if (@$_GET['situation']=="ok") {?>

              <b style="color:green;">İşlem Başarılı...</b>

              <?php } elseif (@$_GET['situation']=="no") {?>

              <b style="color:red;">İşlem Başarısız...</b>

              <?php }

              ?>
           
        

            </small></h2>


             <div align="right">
              <a href="category-add.php"><button class="btn btn-success btn-xs"> Yeni Ekle</button></a>
            </div>

            
            <div class="clearfix"></div>
          </div>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                 <th>S.No</th>
                  <th>Kategori Ad</th>
                  <th>Kategori Sira</th>
                  <th>Kategori Durum</th>
                  <th></th>
                  <th></th>

                </tr>
              </thead>

              <tbody>

                <?php 

                $say=0;

                while($takeCategory=$askCategory->fetch(PDO::FETCH_ASSOC)) {  $say++?>


                <tr>

        		  <td width="20"><?php echo $say?></td>
                 <td><?php echo $takeCategory['kategori_ad'] ?></td>
                 <td><?php echo $takeCategory['kategori_sira'] ?></td>

                  <td><center> <?php 



                  if ($takeCategory['kategori_durum']==1) {?>

                   <button class="btn btn-success btn-xs">Aktif</button>

                   <?php  }else  { ?>

               	  <button class="btn btn-danger btn-xs">Pasif</button>

               		<?php } ?></center></td>

               		<td><center><a href="category-edit.php?category_id=<?php echo $takeCategory['kategori_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></center></td>



               		 <td><center><a href="../connecting/process.php?category_id=<?php echo $takeCategory['kategori_id']; ?>&deleteCategory=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
                 
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
