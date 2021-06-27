<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Penjualan</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <?php $this->load->view('partials/head'); ?>
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
            <h1 class="m-0 text-dark">Laporan Pengeluaran</h1>
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
            <button class="btn btn-success" data-toggle="modal" data-target="#modal">Add</button>
          </div>
          <div class="card-body">
             <button type="button" class="btn btn-default float-right" id="daterange-btn">
               <i class="far fa-calendar-alt"></i> Date range picker
               <i class="fas fa-caret-down"></i>
            </button>
            <table class="table w-100 table-bordered table-hover" id="laporan_penjualan">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Nominal</th> 
                  <th>Jenis Pembayaran</th>
                  <th>Keterangan</th> 
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>

<div class="modal fade" id="modal">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title">Add Data</h5>
    <button class="close" data-dismiss="modal">
      <span>&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form id="form">
      <div class="form-group">
        <label>Tanggal</label>
        <input id="tanggal" type="text" class="form-control" value="<?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s');?>" name="tanggal" disabled>
      </div>
      
      <div class="form-group">
        <label>Nominal</label>
        <input type="number" class="form-control" placeholder="Jumlah" name="nominal" required>
      </div>

      <div class="form-group">
        <label>Jenis Pembayaran</label>
        <input type="text" class="form-control" placeholder="Jenis Pembayaran" name="jenis_bayar" required>
      </div>

      <div class="form-group">
        <label>Keterangan</label>
        <input type="text" name="keterangan" id=""  class="form-control">
        <!-- <input type="text" class="form-control" placeholder="Jenis Pembayaran" name="jenis_pembayaran" required> -->
      </div>
      <!-- <div class="form-group">
        <label>Keterangan</label>
        <select class="form-control" placeholder="Keterangan" name="keterangan" required>
          <option value="rusak">Rusak</option>
          <option value="hilang">Hilang</option>
          <option value="kadaluarsa">Kadaluarsa</option>
        </select>
      </div> -->
      <button class="btn btn-success" type="submit" onclick="addData()">Add</button>
      <button class="btn btn-danger" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>
</div>
</div>

<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script>
  var readUrl = '<?php echo site_url('laporan/getpengeluaran') ?>';
  var addUrl = '<?php echo site_url('laporan/addpengeluaran') ?>';
  var deleteUrl = '<?php echo site_url('laporan/deletepengeluaran/') ?>';
</script>
<script >
  let laporan_penjualan = $("#laporan_penjualan").DataTable({
      responsive: true,
      scrollX: true,
      ajax: readUrl,
      columnDefs: [{
          searcable: false,
          orderable: false,
          targets: 0
      }],
      order: [
          [1, "asc"]
      ],
      columns: [
        {data: "no"}, 
        {data: "tanggal"}, 
        {data: "nominal"}, 
        {data: "jenis_bayar"}, 
        {data: "keterangan"}, 
        {data: "action"}
      ]
  });

  $("#tanggal").datetimepicker({
    format: "dd-mm-yyyy h:ii:ss"
  });

  $(".modal").on("show.bs.modal", () => {
    let a = moment().format("D-MM-Y H:mm:ss");
    $("#tanggal").val(a)
  });
  $(".modal").on("hidden.bs.modal", () => {
    $("#form")[0].reset();
    $("#form").validate().resetForm()
  });
  $("#form").validate({
    errorElement: "span",
    errorPlacement: (err, el) => {
        err.addClass("invalid-feedback"), el.closest(".form-group").append(err)
    },
    submitHandler: () => {
        addData()
      }
    });
    
  function reloadTable() {
    laporan_penjualan.ajax.reload()
  }
  
  function addData() {
    // console.log($("#form").serialize());
    $.ajax({
        url: addUrl,
        type: "post",
        dataType: "json",
        data: $("#form").serialize(),
        success: () => {
            $(".modal").modal("hide");
            Swal.fire("Sukses", "Sukses Menambahkan Data", "success");
            reloadTable()
        },
        error: err => {
            console.log(err)
        }
    })
  }

  function del(id) {
      $.ajax({
          url: deleteUrl+id,
          type: "get",
          success: res => {
            Swal.fire("Sukses", "Sukses Delete", "success")
            reloadTable()
          },
          error: err => {
              console.log(err)
          }
      })
    }

  laporan_penjualan.on("order.dt search.dt", () => {
    laporan_penjualan.column(0, {
        search: "applied",
        order: "applied"
    }).nodes().each((el, val) => {
        console.log(val);
        el.innerHTML = val + 1
    })
  });

</script>
<script>

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
</body>
</html>