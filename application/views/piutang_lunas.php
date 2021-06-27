<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transaksi</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/select2/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') ?>">
  <?php $this->load->view('partials/head'); ?>
  <style>
    @media(max-width: 576px){
      .nota{
        justify-content: center !important;
        text-align: center !important;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php $this->load->view('includes/nav'); ?>

  <?php $this->load->view('includes/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark">Bayar DP Lunas</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
        <div class="row">
          <div class="col-sm-6">
          <?php foreach($transaksi as $u){ ?>
            <form id="form">
                <div class="form-group">
                  <label>No Nota</label>
                  <input placeholder="Diskon" type="text" class="form-control" value="<?= $u->nota ?>" name="nota" disabled>
                </div>
                <div class="form-group">
                  <label>Total Bayar</label>
                  <input placeholder="Diskon" type="number" class="form-control" value="<?= $u->total_bayar ?>" name="diskon" disabled>
                </div>
                <div class="form-group">
                  <label>Jenis Bayar</label>
                  <select name="pelannggan" id="jenis_bayar" class="form-control select2" onchange="isCash()">
                    <option value="bank">Bank / Transfer</option>
                    <option  value="cash">Cash</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Bank</label>
                  <select name="bank" id="bank" class="form-control select2">
                    <option value="BCA">BCA</option>
                    <option value="BRI">BRI</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Jumlah Uang</label>
                  <input placeholder="Jumlah Uang" type="number" class="form-control" name="jumlah_uang" onkeyup="kembalian()" required>
                </div>
                <div class="form-group">
                  <b>Piutang Kurang:</b> <span id="piutang_kurang"><?= $u->piutang_kurang ?></span>
                </div>
                <div class="form-group">
                  <b>Kembalian:</b> <span class="kembalian"></span>
                </div>
                <button id="add" class="btn btn-success" type="submit" onclick="bayar()" disabled>Bayar</button>
                <button id="cetak" class="btn btn-success" type="submit" onclick="bayarCetak()" disabled>Bayar Dan Cetak</button>
              </form>
            <?php } ?>
          </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/select2/js/select2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/moment/moment.min.js') ?>"></script>

<script>
  let isCetak = false
  const update = '<?= base_url('/laporan/bayar/'.$transaksi[0]->id) ?>';
  let cetakUrl = '<?php echo base_url('transaksi/cetak/') ?>';
  let detailUrl = '<?php echo base_url('detail') ?>';
  
  function add() {
    $.ajax({
        url: update,
        type: "post",
        dataType: "json",
        data: {
            jumlah_uang: $('[name="jumlah_uang"]').val(),
            jenis_bayar: $("#jenis_bayar").val(),
            bank: $("#bank").val(),
        },
        success: res => {
            if (isCetak) {
                Swal.fire("Sukses", "Sukses Membayar", "success").
                    then(() => window.location.href = `${cetakUrl}${res}`)
            } else {
                Swal.fire("Sukses", "Sukses Membayar", "success").
                    then(() => window.location.href = `${detailUrl}`)
            }
        },
        error: err => {
            console.log(err)
        }
    })
  }

  function bayarCetak() {
    isCetak = true
  }

  function bayar() {
    isCetak = false
  }

  $("#form").validate({
    errorElement: "span",
    errorPlacement: (err, el) => {
        err.addClass("invalid-feedback"), el.closest(".form-group").append(err)
    },
    submitHandler: () => {
        add()
    }
  });

  function isCash(){
    if($('#jenis_bayar').val() == "cash")
      $("#bank").attr("disabled", "disabled");
    else
      $("#bank").removeAttr("disabled");
  }

  function kembalian() {
    let kurang = $('#piutang_kurang').html();
    let jumlah_uang = $('[name="jumlah_uang"').val();

    $(".kembalian").html( jumlah_uang - kurang);
    if($(".kembalian").html() >= 0){
      $("#add").removeAttr("disabled");
        $("#cetak").removeAttr("disabled")
    }
    else{
      $("#add").attr("disabled", "disabled");
        $("#cetak").attr("disabled", "disabled")
    }

  }
</script>
</body>
</html>
