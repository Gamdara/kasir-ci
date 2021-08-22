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
            <h1 class="m-0 text-dark">Tambah Stok Masuk</h1>
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
              <label>Supplier</label>
              <select class="form-control" name="supplier" id="supplier" onchange="validate()">
              <option value="">No Selected</option>
              <?php foreach($supplier as $k) : ?>
                  <option value="<?php echo $k->id;?>" > <?php echo $k->nama; ?></option>
              <?php endforeach; ?>
              </select>
          </div>
            <div class="form-group">
              <label>Nama Barang</label>
              <div class="form-inline">
              <!-- <?php var_dump($barang) ?> -->
              <select class="form-control select2" style="width: 100%;" name="barang" id="barang" onchange="setHarga()">
              <option value="">No Selected</option>
              <?php foreach($barang as $k) : ?>
                            <option value="<?php echo $k->id;?>" > <?php echo $k->nama_produk; ?></option>
              <?php endforeach; ?>
              </select>
              </div>
            </div>
            <div class="form-group">
              <label>Harga Beli</label>
              <input id="harga_beli" type="text" class="form-control col-sm-6" 
              value="" name="harga_beli" disabled>
          </div>
            <div class="form-group">
              <label>Jumlah</label>
              <input type="number" class="form-control col-sm-6" placeholder="Jumlah" name="jumlah" id="jumlah" value="0" onkeyup="validate()">
            </div>
            <div class="form-group">
              <button id="tambah" class="btn btn-success" onclick="tambah();" disabled>Tambah</button>
            </div>
          </div>
          <div class="col-sm-6 d-flex justify-content-end text-right nota">
            <div>
              <div class="mb-0">
                <b class="mr-2">Nota</b> <span id="nota"><?php echo 'STM-'.date('dmyHis', time());?></span>
              </div>
              <span id="total" style="font-size: 80px; line-height: 1" class="text-danger">0</span>
            </div>
          </div>
        </div>
        </div>
        <div class="card-body">
        <b class="mr-2">Tanggal : </b> <span id="nota"></span>
          <table class="table w-100 table-bordered table-hover" id="stok">
            <thead>
              <tr>
                <th>Supplier</th>
                <th>Nama Barang</th>
                <th>Subtotal</th>
                <th>Stok Ditambahkan</th>
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
  let total = 0;
  $("#total").html(total);
  produk = [],
  stok = $("#stok").DataTable({
        responsive: true,
        lengthChange: false,
        searching: false,
        scrollX: true,
    });
    
  function reloadTable() {
    transaksi.ajax.reload()
  }
  function getNama() {
    $.ajax({
        type: "post",
        dataType: "json",
        data: {
            id: $("#id_produk").val()
        },
        success: res => {
            $("#nama_produk").html(res.nama_produk);
            $("#harga_beli").html(res.harga_beli);
        },
        error: err => {
            console.log(err)
        }
      })
  }
  function validate(){
    const sup = document.getElementById('supplier').value;
    const barang = document.getElementById('barang').value;
    const jumlah = document.getElementById('jumlah').value;

    if(sup != "" && barang != "" && jumlah > 0)
      $("#tambah").removeAttr("disabled")
    else
      $("#tambah").attr("disabled", "disabled")
  }
  function setHarga(){
    console.log($("#barang").val())
    validate()
    $.ajax({
        url : '<?php echo site_url('produk/get_produk') ?>',
        type: "post",
        dataType: "json",
        data: {
            id: $("#barang").val()
        },
        success: res => {
            $("#harga_beli").val(res.harga_beli);
        },
        error: err => {
            console.log(err)
        }
      })
  }

  function remove(nama){
    stok.row($("[name=" + nama + "]").closest("tr")).remove().draw();
    total = 0
    console.log("sebelum",total,produk)
    produk = produk.filter(x=> x.barcode != nama)
    produk.map(p => {
      console.log(total)
      total += p.bayar
    })
    console.log("sesudah",total,produk)
    $("#total").html(total || 0);
    $("#tambah").attr("disabled", "disabled");
    if (stok.rows().count() < 1) {
        $("#simpan").attr("disabled", "disabled")
    }
    
  }

  function tambah(){
    const tanggal =  $("#tanggal").val();
    const sup = document.getElementById('supplier');
    const supText = sup.options[sup.selectedIndex].text;
    const barang = document.getElementById('barang');
    const barangText = barang.options[barang.selectedIndex].text;
    const jumlah = document.getElementById('jumlah').value;
    const keterangan = "pembahan";
    const harga = $("#harga_beli").val();
    const bayar = jumlah * harga

    let a = stok.rows().indexes().filter((a, t) => supText == stok.row(a).data()[0] && barangText == stok.row(a).data()[1]);
    if (a.length > 0) {
      let row = stok.row(a[0]),
      data = row.data();
      console.log(produk)
      
      data[3] = parseInt(data[3])+parseInt(jumlah);
      data[2] = parseInt(harga) * parseInt(data[3]);
      produk.map((x)=>{
          if(x.barcode == barang.value && x.supplier == sup.value){
            x.bayar = parseInt(data[2])
            x.jumlah = parseInt(data[3])
          }
          return x
      });
        
        row.data(data).draw();
        
        total += harga * jumlah;

        $("#simpan").removeAttr("disabled")
        $("#total").html(total);
    } 
    else{
    produk.push({
      tanggal: tanggal,
      barcode: parseInt(barang.value),
      jumlah: parseInt(jumlah),
      keterangan: "penambahan",
      supplier: parseInt(sup.value),
      bayar : bayar
    })
    // console.log("barcode",sup.value)
    stok.row.add([
      supText,
      barangText,
      bayar,
      jumlah,
      `<button name="${barang.value}" class="btn btn-sm btn-danger" onclick="remove('${barang.value}')">Hapus</btn>`
    ]).draw()
    
    total += harga * jumlah;
    $("#simpan").removeAttr("disabled")
    $("#total").html(total);
  }
  }

  function add(){
    $.ajax({
        url: '<?php echo site_url('stok_masuk/add') ?>',
        type: "post",
        dataType: "json",
        data: {
            produk: JSON.stringify(produk),
        },
        success: res => {
          console.log(res);
          Swal.fire("Sukses", "Sukses Membayar", "success").
              then(() => window.location.href = `<?php echo site_url('stok_masuk/') ?>`)
        },
        error: err => {
          // console.log(this.data);
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
