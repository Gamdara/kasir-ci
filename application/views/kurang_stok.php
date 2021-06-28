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
            <h1 class="m-0 text-dark">Tambah Stok Keluar</h1>
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
          <div class="form-group">
              <label>Tanggal</label>
              <input id="tanggal" type="text" class="form-control col-sm-6" 
              value="<?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s');?> " name="tanggal" disabled>
          </div>
            <div class="form-group">
              <label>Nama Barang</label>
              <div class="form-inline">
              <select class="form-control select2" style="width: 100%;" name="barang" id="barang" onchange="setHarga()">
              <option value="">No Selected</option>
              <?php foreach($barang as $k) : ?>
                <option value="<?php echo $k->id;?>" > <?php echo $k->nama_produk; ?></option>
              <?php endforeach; ?>
              </select>
              </div>
            </div>
            <div class="form-group">
              <label>Stok</label>
              <input id="stok" type="number" class="form-control col-sm-6" 
              value="" name="stok" disabled>
              
          </div>
            <div class="form-group">
              <label>Jumlah</label>
              <input type="number" class="form-control col-sm-6" placeholder="Jumlah" name="jumlah" id="jumlah" value="0" onkeyup="validate()">
              <label id="error"></label>
            </div>
            <div class="form-group">
              <label>Keterangan</label>
              <input type="text" class="form-control col-sm-6" placeholder="Keterangan" name="keterangan" id="keterangan" onkeyup="validate()">
            </div>
            
            <div class="form-group">
              <button id="tambah" class="btn btn-success" onclick="tambah();" disabled>Tambah</button>
            </div>
          </div>
        </div>
        </div>
        <div class="card-body">
        <b class="mr-2">Tanggal : </b> <span id="nota"></span>
          <table class="table w-100 table-bordered table-hover" id="keluar">
            <thead>
              <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <!--<th>Total</th>-->
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="card-body">
              <button id="simpan" class="btn btn-success" data-toggle="modal" data-target="#modal" disabled onclick="add()">Simpan</button>
            </div>
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
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>
<script>
  let count = 0,
  produk = [],
  keluar = $("#keluar").DataTable({
        responsive: true,
        lengthChange: false,
        searching: false,
        scrollX: true,
    });
    
  function reloadTable() {
    transaksi.ajax.reload()
  }

  function validate(){
    $("#error").html("")

    const barang = document.getElementById('barang').value;
    const jumlah = document.getElementById('jumlah').value;
    const ket = document.getElementById('keterangan').value;
    // const stok = document.getElementById('stok').value;
    
    // if(stok < jumlah)
    //   $("#error").html("Jumlah melebihi stok")
    if(barang != "" && ket != "" && jumlah > 0)
      $("#tambah").removeAttr("disabled")
    else
      $("#tambah").attr("disabled", "disabled")
  }
  function setHarga(){
    validate()
    $.ajax({
        url : '<?php echo site_url('produk/get_produk') ?>',
        type: "post",
        dataType: "json",
        data: {
            id: $("#barang").val()
        },
        success: res => {
            $("#stok").val(res.stok);
        },
        error: err => {
            console.log(err)
        }
      })
  }

  function remove(nama){
    keluar.row($("[name=" + nama + "]").closest("tr")).remove().draw();
    $("#tambah").attr("disabled", "disabled");
    if (keluar.rows().count() < 1) {
        $("#simpan").attr("disabled", "disabled")
    }
    
  }

  function tambah(){
    const tanggal =  $("#tanggal").val();
    const barang = document.getElementById('barang');
    const barangText = barang.options[barang.selectedIndex].text;
    const jumlah = document.getElementById('jumlah').value;
    const keterangan = document.getElementById('keterangan').value;

    let ref = produk.find(el => el.barcode == barang.value);
    
    // if(ref != undefined){
      // ref.jumlah = jumlah;
      // const ref = stok.rows( function ( idx, data, node ) {
      //   return data.supplier == sup.value && data.barcode == barang.value
      // } )
      // .data();
      // stok.rows().every(el=>{
      //   console.log(this.data())
      // })
      // keluar.rows().each( function ( index ) {
          // var row = stok.row( index );
      
          // var data = row.data();
          // data[4] = jumlah;
          // ... do something with data(), or row.node(), etc
    //       console.log(data);
    //       return;
    //   } );
    //   keluar.draw();
    // }

    produk.push({
      tanggal: tanggal,
      barcode: parseInt(barang.value),
      jumlah: parseInt(jumlah),
      keterangan: keterangan,
    })

    keluar.row.add([
      barangText,
      jumlah,
      keterangan,
      `<button name="${count}" class="btn btn-sm btn-danger" onclick="remove('${count}')">Hapus</btn>`
    ]).draw()
    count++;
    $("#simpan").removeAttr("disabled")
    $("#total").html(total);
  }

  function add(){
    $.ajax({
        url: '<?php echo site_url('stok_keluar/add') ?>',
        type: "post",
        dataType: "json",
        data: {
            produk: JSON.stringify(produk),
        },
        success: res => {
          console.log(res);
          Swal.fire("Sukses", "Stok telah berkurang", "success").
              then(() => window.location.href = `<?php echo site_url('stok_keluar') ?>`)
        },
        error: err => {
            console.log(err)
        }
    })
  }

    // function tambah()
    // {
        
    // // untuk ambil nilai pada input
    //   var sup = document.getElementById('supplier');
    //   const supText = sup.options[sup.selectedIndex].text;
    //   var barang = document.getElementById('barang');
    //   const barangText = barang.options[barang.selectedIndex].text;
    //   var jumlah = document.getElementById('jumlah').value;
      
      
    //   // 0 = baris awal pada tabel
    //   var table = document.getElementsByTagName('table')[0];
      
    //   // tambah baris kosong pada tabel
    //   // 0 = dihitung dari atas 
    //   // table.rows.length = menambahkan pada akhir baris
    //   // table.rows.length/2 = menambahkan data pada baris tengah tabel , urutan baris ke 2 
    //   var newRow = table.insertRow(table.rows.length);

    //   // tambah cell pada baris baru
    //   var cell1 = newRow.insertCell(0);
    //   var cell2 = newRow.insertCell(1);
    //   var cell3 = newRow.insertCell(2);
    //   var cell4 = newRow.insertCell(3);

    //   // tambah nilai ke dalam cell
    //   cell1.innerHTML = supText;
    //   cell2.innerHTML = barangText;
    //   cell3.innerHTML = jumlah;
    //   cell4.innerHTML = '<button id="tambah" class="btn btn-danger  ">Delete</button>';
    //   $("#simpan").removeAttr("disabled")
    // }
</script>
</body>
</html>
