<link rel="stylesheet" type="text/css" href="style/popup1.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<style>
  <?php
  if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
  }
  $result1 = mysqli_query($con, "SELECT * FROM pegawai where email='$email'");
  while ($buff = mysqli_fetch_array($result1)) {
    $bg = $buff['bg'];
  }
  ?>body {
    margin: 0;
    padding: 0;
    background-image: url('image/<?php echo $bg; ?>');
    height: 100%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    background-color: #f1f1f1;
    background-attachment: fixed;
  }

  .box {
    width: 1270px;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 25px;
    box-sizing: border-box;
  }
</style>
<?php
if (isset($_GET['tab'])) {
  $tab = $_GET['tab'];
  $_SESSION['tab'] = $tab;
}
if (isset($_SESSION["tab"])) {
  $tab = $_SESSION['tab'];
}
$market = null;
if (isset($_SESSION["market"])) {
  $market = $_SESSION['market'];
}
if (isset($_POST["market"])) {
  if ($_POST['market'] == "Manual") {
    $_SESSION['manual'] = 'Manual';
    $_SESSION['market'] = '';
    $market = '';
  } else {
    $_SESSION['manual'] = '';
    $_SESSION['market'] = $_POST['market'];
    $market = $_POST['market'];
  }
}
if ($market == null) {
  $_SESSION['market'] = '';
}
$sta = 'all';
if (isset($_SESSION["sta"])) {
  $sta = $_SESSION['sta'];
}
if (isset($_POST["sta"])) {
  $_SESSION['sta'] = $_POST['sta'];
  $sta = $_SESSION['sta'];
}
if ($sta == 'all') {
  $_SESSION['sta'] = $sta;
}
$start = '';
$end = '';
if (isset($_SESSION["start"])) {
  if (isset($_SESSION["end"])) {
    $start = $_SESSION['start'];
    $end = $_SESSION['end'];
  } else {
    $end = date('Y-m-d');
  }
}
if (isset($_POST["start"])) {
  if (isset($_POST["end"])) {
    $_SESSION['start'] = $_POST['start'];
    $start = $_SESSION['start'];
    $_SESSION['end'] = $_POST['end'];
    $end = $_SESSION['end'];
  } else {
    $_SESSION['end'] = date('Y-m-d');
    $end = $_SESSION['end'];
  }
}
if ($_SESSION['level'] != "superuser" && $_SESSION['level'] != "admin") {
  echo "<script>alert('Anda harus login terlebih dahulu');window.location.href='index.php';</script>";
}
$stock = null;
$sku = null;
include('mysqli.php');
$hasil1 = mysqli_query($con, 'select * from min_stock');
while ($buff1 = mysqli_fetch_array($hasil1)) {
  $min = $buff1['min_stock'];
}

$table = null;
$result1 = mysqli_query($con, "SELECT * FROM inventory");
while ($buff = mysqli_fetch_array($result1)) {
  $table = $buff['nama_table'];
}
if ($table == null) {
  $stock = null;
} else {
  $stock = null;
  $hasil = mysqli_query($con, "select * from $table where stock < '$min'");
  while ($buff = mysqli_fetch_array($hasil)) {
    $stock = $buff['stock'];
  }
}
$hasil = mysqli_query($con, 'select * from data_faktur where status_faktur="pending"');
while ($buff = mysqli_fetch_array($hasil)) {
  $sku = $buff['no_faktur'];
}
$hasi = null;
$hasil = mysqli_query($con, 'select * from data_faktur where status_pembayaran="belum terbayar"');
while ($buff = mysqli_fetch_array($hasil)) {
  $no = $buff['no_faktur'];
  $tanggal = $buff['tanggal_pembayaran'];
  $tanggal1 = date('Y-m-d', strtotime('-7 day', strtotime($tanggal)));
  $tanggal2 = date('Y-m-d');
  if ($tanggal2 == $tanggal1) {
    $hasi = 1;
  }
}
?>
<div style="width:90%;" class="container box">
  <div class="table-responsive">
    <?php
    if ($stock != null) {
      if ($_SESSION['level'] == 'admin') {
    ?>
        </br>
      <?php
      }
      ?>
      </br>
      <div class="popup" onclick="myFunction()">
        <span class="popuptext" id="myPopup" onclick="location.href = '?module=barang_kurang';">Beberapa product memiliki Stock
          < <?php echo $min; ?></span> </div> <br />
        <?php
      }
      if ($hasi != null) {
        ?>
          </br>
          <div class="popup" onclick="myFunction2()">
            <span class="popuptext" id="myPopup2" onclick="location.href = '?module=faktur_pembelian';">Beberapa faktur Belum Terbayar</span>
          </div>
          </br>
        <?php
      }
        ?>
        <?php
        if ($_SESSION['level'] == 'superuser') {
          if ($sku != null) {
        ?>
            </br>
            <div class="popup" onclick="myFunction1()">
              <span class="popuptext" id="myPopup1" onclick="location.href = '?module=pending';">Beberapa Faktur Belum disetujui</span>
            </div>
        <?php
          }
        }
        ?>
        <br />
        <button style="display:inline;" type="button" name="retur" value="fetch2.php" id="retur" class="btn btn-info">Retur</button>
        <button style="display:inline;" type="button" name="add" id="selesai" class="btn btn-info">Transaksi Selesai</button>
        <div align="right">
          <button style="display:inline;" type="button" name="add" id="add" class="btn btn-info">Add</button>
          <select style="width:150px; display:inline;" class="form-control" id="sel1">
            <option value="bukalapak">Bukalapak</option>
            <option value="tokopedia">Tokopedia</option>
            <option value="shopee">Shopee</option>
            <option value="blibli">Blibli</option>
            <option value="lazada">Lazada</option>
            <option value="jdid">JD.ID</option>
            <option value="manual">Offline</option>
            <option value="offline">Manual</option>
          </select></br>
          <form style="display:none; margin-top:5px;" id="bukalapak" method="post" enctype="multipart/form-data" action="proses.php">
            <div class="form-group">
              <label for="exampleInputFile">File Upload</label>
              <input type="file" style="width:300px" name="berkas_excel" class="form-control" id="exampleInputFile">
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
          </form>
        </div>
        <form style=" margin-top:5px;" method="post" enctype="multipart/form-data" action="?module=transaksi">
          <button style="display:inline; margin-top:0px;" type="submit" name="cari" id="cari" class="btn btn-info">Search</button>
          <Select name="market" style="width:150px; display:inline;" class="form-control">
            <?php
            if ($market == 'Bukalapak') {
            ?>
              <option selected value="Bukalapak">Bukalapak</option>
              <option value="Tokopedia">Tokopedia</option>
              <option value="JD.ID">JD.ID</option>
              <option value="Blibli">Blibli</option>
              <option value="Lazada">Lazada</option>
              <option value="Shopee">Shopee</option>
              <option value="Offline">Offline</option>
              <option value="Manual">Manual</option>
              <option value="">All</option>
            <?php
            } elseif ($market == 'Tokopedia') {
            ?>
              <option value="Bukalapak">Bukalapak</option>
              <option selected value="Tokopedia">Tokopedia</option>
              <option value="JD.ID">JD.ID</option>
              <option value="Blibli">Blibli</option>
              <option value="Lazada">Lazada</option>
              <option value="Shopee">Shopee</option>
              <option value="Offline">Offline</option>
              <option value="Manual">Manual</option>
              <option value="">All</option>
            <?php
            } elseif ($market == 'Shopee') {
            ?>
              <option value="Bukalapak">Bukalapak</option>
              <option value="Tokopedia">Tokopedia</option>
              <option value="JD.ID">JD.ID</option>
              <option value="Blibli">Blibli</option>
              <option value="Lazada">Lazada</option>
              <option selected value="Shopee">Shopee</option>
              <option value="Offline">Offline</option>
              <option value="Manual">Manual</option>
              <option value="">All</option>
            <?php
            } elseif ($market == 'JD.ID') {
            ?>
              <option value="Bukalapak">Bukalapak</option>
              <option value="Tokopedia">Tokopedia</option>
              <option selected value="JD.ID">JD.ID</option>
              <option value="Blibli">Blibli</option>
              <option value="Lazada">Lazada</option>
              <option value="Shopee">Shopee</option>
              <option value="Offline">Offline</option>
              <option value="Manual">Manual</option>
              <option value="">All</option>
            <?php
            } elseif ($market == 'Blibli') {
            ?>
              <option value="Bukalapak">Bukalapak</option>
              <option value="Tokopedia">Tokopedia</option>
              <option value="JD.ID">JD.ID</option>
              <option selected value="Blibli">Blibli</option>
              <option value="Lazada">Lazada</option>
              <option value="Shopee">Shopee</option>
              <option value="Offline">Offline</option>
              <option value="Manual">Manual</option>
              <option value="">All</option>
            <?php
            } elseif ($market == 'Lazada') {
            ?>
              <option value="Bukalapak">Bukalapak</option>
              <option value="Tokopedia">Tokopedia</option>
              <option value="JD.ID">JD.ID</option>
              <option value="Blibli">Blibli</option>
              <option selected value="Lazada">Lazada</option>
              <option value="Shopee">Shopee</option>
              <option value="Offline">Offline</option>
              <option value="Manual">Manual</option>
              <option value="">All</option>
            <?php
            } elseif ($market == 'Offline') {
            ?>
              <option value="Bukalapak">Bukalapak</option>
              <option value="Tokopedia">Tokopedia</option>
              <option value="JD.ID">JD.ID</option>
              <option value="Blibli">Blibli</option>
              <option value="Lazada">Lazada</option>
              <option value="Shopee">Shopee</option>
              <option selected value="Offline">Offline</option>
              <option value="Manual">Manual</option>
              <option value="">All</option>
              <?php
            } else {
              if (isset($_SESSION['manual'])) {
              ?>
                <option value="Bukalapak">Bukalapak</option>
                <option value="Tokopedia">Tokopedia</option>
                <option value="JD.ID">JD.ID</option>
                <option value="Blibli">Blibli</option>
                <option value="Lazada">Lazada</option>
                <option value="Shopee">Shopee</option>
                <option value="Offline">Offline</option>
                <option selected value="Manual">Manual</option>
                <option value="">All</option>
              <?php
              } else {
              ?>
                <option value="Bukalapak">Bukalapak</option>
                <option value="Tokopedia">Tokopedia</option>
                <option value="JD.ID">JD.ID</option>
                <option value="Blibli">Blibli</option>
                <option value="Lazada">Lazada</option>
                <option value="Shopee">Shopee</option>
                <option value="Offline">Offline</option>
                <option value="Manual">Manual</option>
                <option selected value="">All</option>
            <?php
              }
            }
            ?>
          </select>
          <a style="display:inline; float:right; margin-left:2px" href="?module=pengirim#pos" class="btn btn-info">Data Pengiriman</a>

        </form>
        <form id='status' style=" margin-top:5px;" method="post" enctype="multipart/form-data" action="?module=transaksi">
          <button style="display:inline; margin-top:0px;" type="submit" name="cari" id="cari" class="btn btn-info">Search</button>
          <Select name="sta" style="width:150px; display:inline;" class="form-control">
            <?php
            if ($sta == 'Terkirim') {
            ?>
              <option Selected value="Terkirim">Terkirim</option>
              <option value="Diproses">Diproses</option>
              <option value="all">All</option>
            <?php
            } elseif ($sta == 'Diproses') {
            ?>
              <option value="Terkirim">Terkirim</option>
              <option Selected value="Diproses">Diproses</option>
              <option value="all">All</option>
            <?php
            } else {
            ?>
              <option value="Terkirim">Terkirim</option>
              <option value="Diproses">Diproses</option>
              <option selected value="all">All</option>
            <?php
            }
            ?>
          </select>
        </form>
        <div align="right">
          <?php
          if ($start != '') {
            if ($end != '') {
          ?>
              <form style=" margin-top:5px;" method="post" enctype="multipart/form-data" action="?module=transaksi">
                <button style="display:inline;" type="submit" name="cari" id="cari" class="btn btn-info">Search</button>
                <input type="date" style=" width:150px; display:inline;" name="start" class="form-control" id="start" value="<?php echo $start; ?>">
                <input type="date" style=" width:150px; display:inline;" name="end" class="form-control" id="end" value="<?php echo $end; ?>">
              </form>
            <?php
            } else {
            ?>
              <form style=" margin-top:5px;" method="post" enctype="multipart/form-data" action="?module=transaksi">
                <button style="display:inline;" type="submit" name="cari" id="cari" class="btn btn-info">Search</button>
                <input type="date" style=" width:150px; display:inline;" name="start" class="form-control" id="start" value="<?php echo $start; ?>">
                <input type="date" style=" width:150px; display:inline;" name="end" class="form-control" id="end" value="<?php echo date('Y-m-d'); ?>">
              </form>
            <?php
            }
          } else {
            ?>
            <form style=" margin-top:5px;" method="post" enctype="multipart/form-data" action="?module=transaksi">
              <button style="display:inline;" type="submit" name="cari" id="cari" class="btn btn-info">Search</button>
              <input type="date" style=" width:150px; display:inline;" name="start" class="form-control" id="start" value="<?php echo date('Y-m-d'); ?>">
              <input type="date" style=" width:150px; display:inline;" name="end" class="form-control" id="end" value="<?php echo date('Y-m-d'); ?>">
            </form>
          <?php
          }
          ?>
        </div>
        <br />
        <div id="alert_message"></div>
        <table id="user_data" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID System</th>
              <th>Kode Transaksi</th>
              <th>Ecommerce</th>
              <th>Pembeli</th>
              <th width="10%">Alamat Pembeli</th>
              <th>Status</th>
              <th>Total Transaksi</th>
              <?php
              if ($_SESSION['level'] == "superuser") {
              ?>
                <th>Biaya Admin</th>
                <th>Diskon</th>
                <th>Kupon</th>
                <th>Ket Kupon</th>
                <th>Penjualan</th>
                <th>Laba</th>
              <?php }
              ?>
              <th>Kurir</th>
              <th>Biaya Kurir</th>
              <th>Kode Resi</th>
              <th>Waktu Transaksi</th>
              <th width="10%"></th>
            </tr>
          </thead>
        </table>
      </div>
  </div>

  <script type="text/javascript" language="javascript">
    $(document).ready(function() {

      fetch_data();
      <?php
      if ($stock != null) { ?>
        myFunction();
      <?php }
      if ($hasi != null) {
      ?>
        myFunction2();
        <?php
      }
      if ($_SESSION['level'] == "superuser") {
        if ($sku != null) { ?>
          myFunction1();
      <?php
        }
      }
      ?>

      function myFunction() {
        var popup = document.getElementById("myPopup");
        popup.classList.toggle("show");
      }

      function myFunction1() {
        var popup = document.getElementById("myPopup1");
        popup.classList.toggle("show");
      }

      function myFunction2() {
        var popup = document.getElementById("myPopup2");
        popup.classList.toggle("show");
      }

      function fetch_data() {
        var data = document.getElementById("retur").value;
        var dataTable = $('#user_data').DataTable({
          "processing": true,
          "serverSide": true,
          "order": [],
          "ajax": {
            url: "fetch2.php",
            type: "POST"
          }
        });
      }

      function update_data(id, column_name, value) {
        $.ajax({
          url: "update2.php",
          method: "POST",
          data: {
            id: id,
            column_name: column_name,
            value: value
          },
          success: function(data) {
            $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
            $('#user_data').DataTable().destroy();
            fetch_data();
          }
        });
        setInterval(function() {
          $('#alert_message').html('');
        }, 5000);
      }

      $(document).on('blur', '.update', function() {
        var id = $(this).data("id");
        var column_name = $(this).data("column");
        if (column_name == "status_transaksi") {
          var value = document.getElementById(id + "c").value;
        } else if (column_name == "marketplace") {
          var value = document.getElementById(id + "a").value;
        } else {
          var value = $(this).text();
        }
        update_data(id, column_name, value);
      });
      $('#retur').click(function() {
        window.location.href = ("?module=retur_transaksi&tab=<?php echo $tab; ?>");
      });
      $('#selesai').click(function() {
        window.location.href = ("?module=transaksi_selesai&tab=<?php echo $tab; ?>");
      });
      $('#data').click(function() {
        var value = document.getElementById("sel2").value;
        if (value == "offline") {
          window.location.href = ("?module=tambah_transaksi");
        } else if (value == "bukalapak") {
          document.getElementById('biaya').style.display = "block";
          document.getElementById('pasar').value = "Bukalapak";
          document.getElementById("biaya").action = "biaya.php";
        } else if (value == "tokopedia") {
          document.getElementById('biaya').style.display = "block";
          document.getElementById('pasar').value = "Tokopedia";
          document.getElementById("biaya").action = "biaya.php";
        } else if (value == "shopee") {
          document.getElementById('biaya').style.display = "block";
          document.getElementById('pasar').value = "Shopee";
          document.getElementById("biaya").action = "biaya.php";
        } else if (value == "blibli") {
          document.getElementById('biaya').style.display = "block";
          document.getElementById('pasar').value = "Blibli";
          document.getElementById("biaya").action = "biaya.php";
        } else if (value == "lazada") {
          document.getElementById('biaya').style.display = "block";
          document.getElementById('pasar').value = "Lazada";
          document.getElementById("biaya").action = "biaya.php";
        } else if (value == "jdid") {
          document.getElementById('biaya').style.display = "block";
          document.getElementById('pasar').value = "JD.ID";
          document.getElementById("biaya").action = "biaya.php";
        }
      });

      $('#add').click(function() {
        var value = document.getElementById("sel1").value;
        if (value == "offline") {
          window.location.href = ("?module=tambah_transaksi");
        } else if (value == "bukalapak") {
          document.getElementById('bukalapak').style.display = "block";
          document.getElementById("bukalapak").action = "proses.php";
        } else if (value == "tokopedia") {
          document.getElementById('bukalapak').style.display = "block";
          document.getElementById("bukalapak").action = "proses1.php";
        } else if (value == "shopee") {
          document.getElementById('bukalapak').style.display = "block";
          document.getElementById("bukalapak").action = "proses2.php";
        } else if (value == "blibli") {
          document.getElementById('bukalapak').style.display = "block";
          document.getElementById("bukalapak").action = "proses3.php";
        } else if (value == "lazada") {
          document.getElementById('bukalapak').style.display = "block";
          document.getElementById("bukalapak").action = "proses4.php";
        } else if (value == "jdid") {
          document.getElementById('bukalapak').style.display = "block";
          document.getElementById("bukalapak").action = "proses5.php";
        } else if (value == "manual") {
          window.location.href = ("?module=offline");
        }
      });
      $(document).on('click', '.delete', function() {
        var id = $(this).attr("id");
        if (confirm("Are you sure you want to remove this?")) {
          $.ajax({
            url: "delete3.php",
            method: "POST",
            data: {
              id: id
            },
            success: function(data) {
              $('#alert_message').html('<div class="alert alert-success">' + data + '</div>');
              $('#user_data').DataTable().destroy();
              fetch_data();
            }
          });
          setInterval(function() {
            $('#alert_message').html('');
          }, 5000);
        }
      });
      $(document).on('click', '.lihat', function() {
        var id = $(this).attr("id");
        window.location.href = ("?module=detail_transaksi&id=" + id + "");
      });
    });
  </script>