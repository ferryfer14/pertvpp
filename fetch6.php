<?php
session_start();
//fetch.php
include "mysqli.php";
if ($_SESSION['level'] == "superuser") {
    $columns = array('id_system', 'kode_transaksi', 'marketplace', 'nama_pembeli', 'alamat_pembeli', 'status_transaksi', 'nominal', 'biaya_admin', 'diskon', 'kupon', 'ket_kupon', 'pendapatan', 'laba', 'kurir', 'biaya_kurir', 'resi', 'tanggal_transaksi');
} elseif ($_SESSION['level'] == "admin") {
    $columns = array('id_system', 'kode_transaksi', 'marketplace', 'nama_pembeli', 'alamat_pembeli', 'status_transaksi', 'nominal', 'kurir', 'biaya_kurir', 'resi', 'tanggal_transaksi');
}
$manual = '';
if (isset($_SESSION['manual'])) {
    if ($_SESSION['manual'] != '') {
        $manual = $_SESSION['manual'];
    }
}
$start1 = date('Y-m-d');
$end1 = date('Y-m-d');
if (isset($_SESSION['start'])) {
    $start1 = $_SESSION['start'];
}
if (isset($_SESSION['end'])) {
    $end1 = $_SESSION['end'];
}
$mulai = $start1 . ' 00:00:01';
$end = $end1 . ' 23:59:59';
if (isset($_SESSION['tab'])) {
    $tab = $_SESSION['tab'];
}
if (isset($_SESSION['market'])) {
    $market = $_SESSION['market'];
    $sta = 'Selesai';
    if ($sta != '') {
        if ($sta == 'all') {
            if ($market != "") {
                if ($_POST["length"] != -1) {
                    $start = $_POST['start'];
                    $leng = $_POST['length'];
                    if (isset($_POST["search"]["value"])) {
                        $cari = $_POST["search"]["value"];
                        $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                        $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                    }
                    if ($cari == "") {
                        if (isset($_POST["order"])) {
                            $dir = $_POST['order']['0']['dir'];
                            $kolom = $columns[$_POST['order']['0']['column']];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng");
                        } else {
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                        }
                    }
                } else {
                    if (isset($_POST["search"]["value"])) {
                        $cari = $_POST["search"]["value"];
                        $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                        $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                    }
                    if ($cari == "") {
                        if (isset($_POST["order"])) {
                            $dir = $_POST['order']['0']['dir'];
                            $kolom = $columns[$_POST['order']['0']['column']];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir");
                        } else {
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                        }
                    }
                }
                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
            } else {
                if ($_POST["length"] != -1) {
                    $start = $_POST['start'];
                    $leng = $_POST['length'];
                    if (isset($_POST["search"]["value"])) {
                        $cari = $_POST["search"]["value"];
                        $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                        $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                    }
                    if ($cari == "") {
                        if (isset($_POST["order"])) {
                            $dir = $_POST['order']['0']['dir'];
                            $kolom = $columns[$_POST['order']['0']['column']];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng");
                        } else {
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                        }
                    }
                } else {
                    if (isset($_POST["search"]["value"])) {
                        $cari = $_POST["search"]["value"];
                        $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                        $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                    }
                    if ($cari == "") {
                        if (isset($_POST["order"])) {
                            $dir = $_POST['order']['0']['dir'];
                            $kolom = $columns[$_POST['order']['0']['column']];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir");
                        } else {
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                        }
                    }
                }
                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi IN ('Terkirim','Diproses') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
            }
        } else {
            if ($market != "") {
                if ($market == "Offline") {
                    $market="";
                    if ($_POST["length"] != -1) {
                        $start = $_POST['start'];
                        $leng = $_POST['length'];
                        if (isset($_POST["search"]["value"])) {
                            $cari = $_POST["search"]["value"];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                        }
                        if ($cari == "") {
                            if (isset($_POST["order"])) {
                                $dir = $_POST['order']['0']['dir'];
                                $kolom = $columns[$_POST['order']['0']['column']];
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng");
                            } else {
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                            }
                        }
                    } else {
                        if (isset($_POST["search"]["value"])) {
                            $cari = $_POST["search"]["value"];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                        }
                        if ($cari == "") {
                            if (isset($_POST["order"])) {
                                $dir = $_POST['order']['0']['dir'];
                                $kolom = $columns[$_POST['order']['0']['column']];
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir");
                            } else {
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                            }
                        }
                    }
                    $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                } else {
                    if ($_POST["length"] != -1) {
                        $start = $_POST['start'];
                        $leng = $_POST['length'];
                        if (isset($_POST["search"]["value"])) {
                            $cari = $_POST["search"]["value"];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                        }
                        if ($cari == "") {
                            if (isset($_POST["order"])) {
                                $dir = $_POST['order']['0']['dir'];
                                $kolom = $columns[$_POST['order']['0']['column']];
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng");
                            } else {
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                            }
                        }
                    } else {
                        if (isset($_POST["search"]["value"])) {
                            $cari = $_POST["search"]["value"];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                        }
                        if ($cari == "") {
                            if (isset($_POST["order"])) {
                                $dir = $_POST['order']['0']['dir'];
                                $kolom = $columns[$_POST['order']['0']['column']];
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir");
                            } else {
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                            }
                        }
                    }
                    $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and marketplace='$market' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                }
            } else {
                if ($manual != '') {
                    if ($_POST["length"] != -1) {
                        $start = $_POST['start'];
                        $leng = $_POST['length'];
                        if (isset($_POST["search"]["value"])) {
                            $cari = $_POST["search"]["value"];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','')  and input='Offline' and marketplace != '' AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                        }
                        if ($cari == "") {
                            if (isset($_POST["order"])) {
                                $dir = $_POST['order']['0']['dir'];
                                $kolom = $columns[$_POST['order']['0']['column']];
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng");
                            } else {
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                            }
                        }
                    } else {
                        if (isset($_POST["search"]["value"])) {
                            $cari = $_POST["search"]["value"];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                        }
                        if ($cari == "") {
                            if (isset($_POST["order"])) {
                                $dir = $_POST['order']['0']['dir'];
                                $kolom = $columns[$_POST['order']['0']['column']];
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir");
                            } else {
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                            }
                        }
                    }
                    $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and input='Offline' and marketplace != '' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                } else {
                    if ($_POST["length"] != -1) {
                        $start = $_POST['start'];
                        $leng = $_POST['length'];
                        if (isset($_POST["search"]["value"])) {
                            $cari = $_POST["search"]["value"];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                        }
                        if ($cari == "") {
                            if (isset($_POST["order"])) {
                                $dir = $_POST['order']['0']['dir'];
                                $kolom = $columns[$_POST['order']['0']['column']];
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir LIMIT $start,$leng");
                            } else {
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi LIMIT $start,$leng");
                            }
                        }
                    } else {
                        if (isset($_POST["search"]["value"])) {
                            $cari = $_POST["search"]["value"];
                            $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                            $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') AND kode_transaksi LIKE '%$cari%' OR id_system LIKE '%$cari%' and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                        }
                        if ($cari == "") {
                            if (isset($_POST["order"])) {
                                $dir = $_POST['order']['0']['dir'];
                                $kolom = $columns[$_POST['order']['0']['column']];
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by $kolom $dir");
                            } else {
                                $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                                $result = mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi");
                            }
                        }
                    }
                    $number_filter_row = mysqli_num_rows(mysqli_query($con, "SELECT * from transaksi WHERE account='$tab' and status_transaksi in ('Selesai','') and tanggal_transaksi between '$mulai' and '$end' ORDER by tanggal_transaksi"));
                }
            }
        }
    }
}

$data = array();
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $del = 0;
    $hasil = mysqli_query($con, "select * from login where email='$email'");
    while ($buff = mysqli_fetch_array($hasil)) {
        $del = $buff['del_transaksi'];
    }
}
while ($row = mysqli_fetch_array($result)) {
    $nominal = null;
    $pendapatan = null;
    $kupon = null;
    $kupon1 = null;
    if (isset($row["nominal"])) $nominal = number_format((float)$row['nominal'], 0, ",", ".");
    if ($row["kupon"] != null) {
        $kupon1 = $row["kupon"];
        $kupon = number_format((float)$row["kupon"], 0, ",", ".");
    }
    if (isset($row["pendapatan"])) {
        if ($kupon1 != null) {
            $pendapatan0 = $row['pendapatan'] - $kupon1;
            $pendapatan = number_format((float)$pendapatan0, 0, ",", ".");
        } else {
            $pendapatan = number_format((float)$row['pendapatan'], 0, ",", ".");
        }
    }
    if ($row['input'] == "Online") {
        $kode = $row["kode_transaksi"];
        $a = 1;
        $select5 = "SELECT * from data_transaksi where kode_transaksi='$kode'";
        $hasil5 = mysqli_query($con, $select5);
        while ($buff5 = mysqli_fetch_array($hasil5)) {
            $sku = $buff5['sku'];
            $select2 = "SELECT * from data_transaksi where kode_transaksi='$kode' and sku='$sku'";
            $hasil2 = mysqli_query($con, $select2);
            while ($buff2 = mysqli_fetch_array($hasil2)) {
                $sku = $buff2['sku'];
                $ada = 1;
                $ada1 = null;
                $table = null;
                $select = "SELECT * from inventory";
                $hasil = mysqli_query($con, $select);
                while ($buff = mysqli_fetch_array($hasil)) {
                    $table = $buff['nama_table'];
                    $select1 = "SELECT * from $table where sku='$sku'";
                    $hasil1 = mysqli_query($con, $select1);
                    while ($buff1 = mysqli_fetch_array($hasil1)) {
                        $ada1 = $buff1['sku'];
                    }
                }
                if ($ada1 == null) {
                    $a = $ada1;
                }
                $ada = $a;
            }
        }
        $sub_array = array();
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="id_system">' . $row["id_system"] . '</div>';
        if ($ada == null) {
            $sub_array[] = '<div style="background:red" class="update" data-id="' . $row["id"] . '" data-column="kode_transaksi">' . $row["kode_transaksi"] . '</div>';
        } else {
            $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="kode_transaksi">' . $row["kode_transaksi"] . '</div>';
        }
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="marketplace">' . $row["marketplace"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="nama_pembeli">' . $row["nama_pembeli"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="alamat_pembeli"><textarea disabled id="' . $row["id"] . '" style="border:none; resize:none; background:transparent" cols="20" rows="4">' . $row["alamat_pembeli"] . '</textarea></div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="status_transaksi">' . $row["status_transaksi"] . '</div>';
        $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="nominal">' . $nominal . '</div>';
        if ($_SESSION['level'] == "superuser") {
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="biaya_admin">' . $row["biaya_admin"] . '</div>';
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="diskon">' . $row["diskon"] . '</div>';
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="kupon">' . $kupon . '</div>';
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="ket_kupon">' . $row["ket_kupon"] . '</div>';
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="pendapatan">' . $pendapatan . '</div>';
            $select5 = "SELECT SUM(laba) as laba from data_transaksi where kode_transaksi='$kode'";
            $hasil5 = mysqli_query($con, $select5);
            while ($buff5 = mysqli_fetch_array($hasil5)) {
                $ab = $buff5['laba'];
                if ($row['biaya_admin'] == null) {
                    $laba = $ab - ($row['nominal'] - $row['pendapatan']);
                } else {
                    $laba = $ab - $row['biaya_admin'] - ($row['nominal'] - $row['pendapatan'] - $row['biaya_admin']);
                }
            }
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="laba">' . $laba . '</div>';
        }
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="kurir">' . $row["kurir"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="kurir">' . $row["biaya_kurir"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="resi">' . $row["resi"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="tanggal_transaksi">' . $row["tanggal_transaksi"] . '</div>';
        if ($del != 0) {
            $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["id"] . '">Delete</button> <button type="button" name="lihat" class="btn btn-warning btn-xs lihat" id="' . $row["id"] . '">Lihat</button>';
        } else {
            $sub_array[] = '<button type="button" name="lihat" class="btn btn-warning btn-xs lihat" id="' . $row["id"] . '">Lihat</button>';
        }
        $data[] = $sub_array;
    } else {
        $ada = null;
        $kode = $row["kode_transaksi"];
        $a = 1;
        $select5 = "SELECT * from data_transaksi where kode_transaksi='$kode'";
        $hasil5 = mysqli_query($con, $select5);
        while ($buff5 = mysqli_fetch_array($hasil5)) {
            $sku = $buff5['sku'];
            $select2 = "SELECT * from data_transaksi where kode_transaksi='$kode' and sku='$sku'";
            $hasil2 = mysqli_query($con, $select2);
            while ($buff2 = mysqli_fetch_array($hasil2)) {
                $sku = $buff2['sku'];
                $ada = 1;
                $ada1 = null;
                $table = null;
                $select = "SELECT * from inventory";
                $hasil = mysqli_query($con, $select);
                while ($buff = mysqli_fetch_array($hasil)) {
                    $table = $buff['nama_table'];
                    $select1 = "SELECT * from $table where sku='$sku'";
                    $hasil1 = mysqli_query($con, $select1);
                    while ($buff1 = mysqli_fetch_array($hasil1)) {
                        $ada1 = $buff1['sku'];
                    }
                }
                if ($ada1 == null) {
                    $a = $ada1;
                }
                $ada = $a;
            }
        }
        $nominal = null;
        $pendapatan = null;
        if (isset($row["nominal"])) $nominal = number_format((float)$row['nominal'], 0, ",", ".");
        if (isset($row["pendapatan"])) $pendapatan = number_format((float)$row['pendapatan'], 0, ",", ".");
        $sub_array = array();
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="id_system">' . $row["id_system"] . '</div>';
        if ($ada == null) {
            $sub_array[] = '<div style="background:red" class="update" data-id="' . $row["id"] . '" data-column="kode_transaksi">' . $row["kode_transaksi"] . '</div>';
        } else {
            $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="kode_transaksi">' . $row["kode_transaksi"] . '</div>';
        }
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="marketplace">' . $row["marketplace"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="nama_pembeli">' . $row["nama_pembeli"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="alamat_pembeli"><textarea disabled id="' . $row["id"] . '" style="border:none; resize:none; background:transparent" cols="20" rows="4">' . $row["alamat_pembeli"] . '</textarea></div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="status_transaksi">' . $row["status_transaksi"] . '</div>';
        $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="nominal">' . $nominal . '</div>';
        if ($_SESSION['level'] == "superuser") {
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="biaya_admin">' . $row["biaya_admin"] . '</div>';
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="diskon">' . $row["diskon"] . '</div>';
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="kupon">' . $kupon . '</div>';
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="ket_kupon">' . $row["ket_kupon"] . '</div>';
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="pendapatan">' . $pendapatan . '</div>';
            $select5 = "SELECT SUM(laba) as laba from data_transaksi where kode_transaksi='$kode'";
            $hasil5 = mysqli_query($con, $select5);
            while ($buff5 = mysqli_fetch_array($hasil5)) {
                $ab = $buff5['laba'];
                if ($row['biaya_admin'] == null) {
                    if ($row['diskon'] != null) {
                        $laba = $ab - ($row['diskon']);
                    } else {
                        $laba = $ab;
                    }
                } else {
                    $laba = $ab - $row['biaya_admin'] - ($row['nominal'] - $row['pendapatan'] - $row['biaya_admin']);
                }
            }
            $sub_array[] = '<div onkeypress="return Angkasaja(event)" class="update" data-id="' . $row["id"] . '" data-column="laba">' . $laba . '</div>';
        }
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="kurir">' . $row["kurir"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="kurir">' . $row["biaya_kurir"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="resi">' . $row["resi"] . '</div>';
        $sub_array[] = '<div class="update" data-id="' . $row["id"] . '" data-column="tanggal_transaksi">' . $row["tanggal_transaksi"] . '</div>';
        if ($del != 0) {
            $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row["id"] . '">Delete</button> <button type="button" name="lihat" class="btn btn-warning btn-xs lihat" id="' . $row["id"] . '">Lihat</button>';
        } else {
            $sub_array[] = '<button type="button" name="lihat" class="btn btn-warning btn-xs lihat" id="' . $row["id"] . '">Lihat</button>';
        }
        $data[] = $sub_array;
    }
}

function get_all_data($con)
{

    if (isset($_SESSION['tab'])) {
        $tab = $_SESSION['tab'];
    }
    $query = "SELECT * FROM transaksi WHERE account='$tab' and status_transaksi IN ( 'Terkirim','Diproses')  ORDER by tanggal_transaksi";
    $result = mysqli_query($con, $query);
    return mysqli_num_rows($result);
}

$output = array(
    "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  get_all_data($con),
    "recordsFiltered" => $number_filter_row,
    "data"    => $data
);

echo json_encode($output);
