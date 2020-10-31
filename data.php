<?php include 'db.php'; ?>
<?php session_start(); ?>
<?php 

if(!isset($_SESSION['username'])){
    header("Location: index.php");
};
?>

<?php 
    if(isset($_POST['kegiatan'])){
        $kegiatan = $_POST['nama_kegiatan'];
        $query = mysqli_query($conn,"INSERT INTO kegiatan(nama_kegiatan) VALUES('$kegiatan')");
    }
    if(isset($_POST['jabatan'])){
        $jabatan = $_POST['nama_jabatan'];
        $query = mysqli_query($conn,"INSERT INTO jabatan(nama_jabatan) VALUES('$jabatan')");
    }
    if(isset($_POST['nilai'])){
        $kegiatan = $_POST['id_kegiatan'];
        $jabatan = $_POST['id_jabatan'];
        $point = $_POST['point'];
        $query = mysqli_query($conn,"INSERT INTO nilai(id_kegiatan,id_jabatan,point) VALUES('$kegiatan','$jabatan','$point')");
    }

    if(isset($_POST['agen'])){

        $iduser = $_SESSION['id_user'];
        $tgl = $_POST['tgl_kegiatan'];
        $kegiatan = $_POST['id_kegiatan'];
        

        $idjabatan = $_SESSION['id_jabatan'];

        $query_nilai = mysqli_query($conn,"SELECT * FROM nilai");

        while($result_nilai = mysqli_fetch_array($query_nilai)){

            if($result_nilai['id_kegiatan'] == $kegiatan ){
            
                if($result_nilai['id_jabatan'] == $idjabatan){
                    $point =  $result_nilai['point'];
                }
            }
        }
                  
        $query = mysqli_query($conn,"INSERT INTO agen(tgl_kegiatan,id_user,id_kegiatan,nilai) VALUES('$tgl','$iduser','$kegiatan','$point')");
        if(!$query){
            die("Query Failed ") . mysqli_error($conn);
        }
        
        
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>

<div class="row">


    <div class="col-md-4">
        <h1>Biodata</h1>
        <ul class="list-group">
            <?php 
                $id = $_SESSION['id_user'];
                // echo $id;
                $query_user = mysqli_query($conn,"SELECT * FROM user INNER JOIN jabatan ON jabatan.id_jabatan  = user.id_jabatan WHERE id_user = '$id' ");
                $data_user = mysqli_fetch_array($query_user);

                
                
            ?>
            <li class="list-group-item">Nilai 
                <?php 
                $idjabatan = $_SESSION['id_jabatan'];

                $query_nilai = mysqli_query($conn,"SELECT * FROM nilai");

                while($result_nilai = mysqli_fetch_array($query_nilai)){

                    if($result_nilai['id_kegiatan'] == 2 ){
                    
                        if($result_nilai['id_jabatan'] == $idjabatan){
                            echo $result_nilai['point'];
                        }
                    }
                }


                ?>

            </li>
            <li class="list-group-item">ID Jabatan : <?php echo $data_user['id_jabatan'] ?></li>
            <li class="list-group-item">ID User : <?php echo $data_user['id_user'] ?></li>
            <li class="list-group-item">Username : <?php echo $data_user['username']?></li>
            <li class="list-group-item">ID Jabatan : <?php echo $data_user['nama_jabatan'] ?></li>
        </ul>

        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>






    <div class="col-md-8">
    <h1>Database master</h1>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Kegiatan</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Jabatan</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Nilai</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#data" role="tab" aria-controls="contact" aria-selected="false">Data Agen</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">

  
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#kegiatan">
    + Kegiatan
    </button>

    <!-- Modal -->
    <div class="modal fade" id="kegiatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kegiatan">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <input type="text" name="nama_kegiatan" class="form-control">
                        <button type="submit" name="kegiatan" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            <?php  

                $query = mysqli_query($conn,"SELECT * FROM kegiatan");
                while($row = mysqli_fetch_array($query))
                {
                    $data_kegiatan = $row['nama_kegiatan'];
            ?>
            <tr>
                <td><?php echo $data_kegiatan ?></td>
            </tr>
            
            <?php        
                }
            ?>
        </tbody>

    </table>


  </div>
  
  
  
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
  
        <!-- Button trigger modal -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#jabatan">
    + Jabatan
    </button>

    <!-- Modal -->
    <div class="modal fade" id="jabatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kegiatan">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <input type="text" name="nama_jabatan" class="form-control">
                        <button type="submit" name="jabatan" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            <?php  

                $query = mysqli_query($conn,"SELECT * FROM jabatan");
                while($row = mysqli_fetch_array($query))
                {
                    $data_jabatan = $row['nama_jabatan'];
            ?>
            <tr>
                <td><?php echo $data_jabatan ?></td>
            </tr>
            
            <?php        
                }
            ?>
        </tbody>

    </table>


  </div>
  
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#nilai">
    + Nilai
    </button>

    <!-- Modal -->
    <div class="modal fade" id="nilai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kegiatan">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <label for="">Pilih Kegiatan</label>
                        <select name="id_kegiatan" class="form-control">
                            <?php 
                            $query = mysqli_query($conn,"SELECT * FROM kegiatan");
                            while($row = mysqli_fetch_array($query))
                            {
                                $id_kegiatan = $row['id_kegiatan'];
                                $data_kegiatan = $row['nama_kegiatan'];
                            ?>
                            <option value="<?php echo $id_kegiatan ?>"><?php echo $data_kegiatan ?></option>
                            <?php } ?>
                        </select>
                        <label for="">Pilih Jabatan</label>
                        <select name="id_jabatan" class="form-control">
                            <?php 
                            $query = mysqli_query($conn,"SELECT * FROM jabatan");
                            while($row = mysqli_fetch_array($query))
                            {
                                $id_jabatan = $row['id_jabatan'];
                                $data_jabatan = $row['nama_jabatan'];
                            ?>
                            <option value="<?php echo $id_jabatan ?>"><?php echo $data_jabatan ?></option>
                            <?php } ?>
                        </select>
                        <label for="">Input Nilai</label>
                        <input type="text" name="point" class="form-control">

                        <button type="submit" name="nilai" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                
                <th>Nama Kegiatan</th>
                <th>Nama Jabatan</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php  

                $query = mysqli_query($conn,"SELECT * FROM nilai INNER JOIN kegiatan on kegiatan.id_kegiatan = nilai.id_kegiatan INNER JOIN jabatan on jabatan.id_jabatan = nilai.id_jabatan");
                while($row = mysqli_fetch_array($query))
                {
                    
                    $data_kegiatan = $row['nama_kegiatan'];
                    $data_jabatan = $row['nama_jabatan'];
                    $data_point = $row['point'];
            ?>
            <tr>
               
                <td><?php echo $data_kegiatan ?></td>
                <td><?php echo $data_jabatan ?></td>
                <td><?php echo $data_point ?></td>
            </tr>
            
            <?php        
                }
            ?>
        </tbody>

    </table>
  </div>


</div>
    </div>
</div>


<div class="container">
<div class="row">
    <div class="col-md-6">
    <h2>Cari Data</h2>
        <hr>
        <form method="post">

            <label for="">Mulai Tanggal Kegiatan</label>
            <input type="date" name="tgl_awal" class="form-control" >
            <label for="">Akhir Tanggal Kegiatan</label>
            <input type="date" name="tgl_akhir" class="form-control" >

            <label for="">Pilih User</label>
            
            <select name="id_user" class="form-control">
                <?php 
                $query = mysqli_query($conn,"SELECT * FROM user");
                while($row = mysqli_fetch_array($query))
                {
                    $id_user = $row['id_user'];
                    $username = $row['username'];
                ?>
                <option value="<?php echo $id_user ?>"><?php echo $username ?></option>
                <?php } ?>
            </select>
            
            
            <button type="submit" name="cari" class="btn btn-danger">Cari Data</button>
        </form>




        <h1 class="text-center">Data Agen</h1>
        <hr>
        <h2>Tambah Data</h2>
        <hr>
        <form method="post">

            <label for="">Tanggal Kegiatan</label>
            <input type="date" name="tgl_kegiatan" class="form-control" >

            <label for="">Pilih Kegiatan</label>
            <select name="id_kegiatan" class="form-control">
                <?php 
                $query = mysqli_query($conn,"SELECT * FROM kegiatan");
                while($row = mysqli_fetch_array($query))
                {
                    $id_kegiatan = $row['id_kegiatan'];
                    $data_kegiatan = $row['nama_kegiatan'];
                ?>
                <option value="<?php echo $id_kegiatan ?>"><?php echo $data_kegiatan ?></option>
                <?php } ?>
            </select>
            
            
            <button type="submit" name="agen" class="btn btn-primary">Simpan Data</button>
        </form>
        
        <hr>



        
      
        </div>
        <div class="col-md-6">
        <h1 class="text-center">List Data Kegiatan</h1>
        <hr>
        <?php if(isset($_POST['cari'])) { 
            
            
        ?>

            
            <h2>Tampilan Setelah Cari Data</h2>
            <?php echo $_POST['tgl_awal']?>
            <?php echo $_POST['tgl_akhir']?>
        <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal Kegiatan</th>
                        <th>Nama</th>
                        <th>Nama Kegiatan</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
    
                        $tgl_awal = $_POST['tgl_awal'];
                        $tgl_akhir = $_POST['tgl_akhir'];
                        $id_user = $_POST['id_user'];
                    
                                
                        $query = mysqli_query($conn,"SELECT * FROM agen 
                        INNER JOIN kegiatan on kegiatan.id_kegiatan = agen.id_kegiatan 
                        INNER JOIN user on user.id_user = agen.id_user 
                        WHERE agen.id_user = '$id_user' AND agen.tgl_kegiatan BETWEEN '$tgl_awal' AND '$tgl_akhir' ");
                        while($row = mysqli_fetch_array($query))
                        {
                           
                            $data_tgl = $row['tgl_kegiatan'];
                            $data_kegiatan = $row['nama_kegiatan'];
                            $data_nilai = $row['nilai'];
                            $nama = $row['username'];
                            
                    ?>
                    <tr>
                        <td><?php echo $data_tgl ?></td>
                        <td><?php echo $nama ?></td>
                        <td><?php echo $data_kegiatan ?></td>
                        <td><?php echo $data_nilai ?></td>
                    </tr>
                    
                    <?php        
                        }
                    ?>
                </tbody>
    
            </table>
            <?php }else{ ?>
                <h2>Tampilan Data Awal</h2>
        <hr>
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal Kegiatan</th>
                        <th>Nama</th>
                        <th>Nama Kegiatan</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php  
    
                        $query = mysqli_query($conn,"SELECT * FROM agen INNER JOIN kegiatan on kegiatan.id_kegiatan = agen.id_kegiatan INNER JOIN user on user.id_user = agen.id_user ");
                        while($row = mysqli_fetch_array($query))
                        {
                            $data_tgl = $row['tgl_kegiatan'];
                            $data_kegiatan = $row['nama_kegiatan'];
                            $data_nilai = $row['nilai'];
                            $nama = $row['username'];
                            
                    ?>
                    <tr>
                        <td><?php echo $data_tgl ?></td>
                        <td><?php echo $nama ?></td>
                        <td><?php echo $data_kegiatan ?></td>
                       
                    </tr>
                    
                    <?php        
                        }
                    ?>
                </tbody>
    
            </table>
            <?php } ?>
        </div>
        

    
</div>
</div>

    


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
</body>
</html>
        