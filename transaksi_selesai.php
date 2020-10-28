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
?>
<div style="width:90%;" class="container box">
  <div class="table-responsive">
    <br />
    <button style="display:inline;" type="button" name="kembali" id="kembali" class="btn btn-info">Kembali</button>
    <div style="margin-top: 10px;"></div>
    <div align="left">
      <button style="display:inline;" type="button" name="add" id="add" class="btn btn-info">Add</button>
      <select style="width:150px; display:inline;" class="form-control" id="sel1">
        <option value="tokopedia">Tokopedia</option>
      </select></br>
      <form style="display:none; margin-top:5px;" id="bukalapak" method="post" enctype="multipart/form-data" action="proses.php">
        <div class="form-group">
          <label for="exampleInputFile">File Upload</label>
          <input type="file" style="width:300px" name="berkas_excel" class="form-control" id="exampleInputFile">
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
      </form>
    </div>
    <div align="right">
      <?php
      if ($start != '') {
        if ($end != '') {
      ?>
          <form style=" margin-top:5px;" method="post" enctype="multipart/form-data" action="?module=transaksi_selesai">
            <button style="display:inline;" type="submit" name="cari" id="cari" class="btn btn-info">Search</button>
            <input type="date" style=" width:150px; display:inline;" name="start" class="form-control" id="start" value="<?php echo $start; ?>">
            <input type="date" style=" width:150px; display:inline;" name="end" class="form-control" id="end" value="<?php echo $end; ?>">
          </form>
        <?php
        } else {
        ?>
          <form style=" margin-top:5px;" method="post" enctype="multipart/form-data" action="?module=transaksi_selesai">
            <button style="display:inline;" type="submit" name="cari" id="cari" class="btn btn-info">Search</button>
            <input type="date" style=" width:150px; display:inline;" name="start" class="form-control" id="start" value="<?php echo $start; ?>">
            <input type="date" style=" width:150px; display:inline;" name="end" class="form-control" id="end" value="<?php echo date('Y-m-d'); ?>">
          </form>
        <?php
        }
      } else {
        ?>
        <form style=" margin-top:5px;" method="post" enctype="multipart/form-data" action="?module=transaksi_selesai">
          <button style="display:inline;" type="submit" name="cari" id="cari" class="btn btn-info">Search</button>
          <input type="date" style=" width:150px; display:inline;" name="start" class="form-control" id="start" value="<?php echo date('Y-m-d'); ?>">
          <input type="date" style=" width:150px; display:inline;" name="end" class="form-control" id="end" value="<?php echo date('Y-m-d'); ?>">
        </form>
      <?php
      }
      ?>
      <?php
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
      ?>
    </div>

    <form style=" margin-top:5px;" method="post" enctype="multipart/form-data" action="?module=transaksi_selesai">
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
    </form>
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
    $('#add').click(function() {
      var value = document.getElementById("sel1").value;
      if (value == "tokopedia") {
        document.getElementById('bukalapak').style.display = "block";
        document.getElementById("bukalapak").action = "kupon_toped.php";
      }
    });
    fetch_data();

    function fetch_data() {
      var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          url: "fetch6.php",
          type: "POST"
        }
      });
    }

    $('#kembali').click(function() {
      window.location.href = ("?module=transaksi&tab=<?php echo $tab; ?>");
    });

    $(document).on('click', '.delete', function() {
      var id = $(this).attr("id");
      if (confirm("Are you sure you want to remove this?")) {
        $.ajax({
          url: "delete16.php",
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