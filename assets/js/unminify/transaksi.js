let isCetak = false,
produk = [],
isDp = false,
isReseller = false,
hargabarang = 0,
totalbayar = 0,

transaksi = $("#transaksi").DataTable({
    responsive: true,
    lengthChange: false,
    searching: false,
    scrollX: true
});

function reloadTable() {
    transaksi.ajax.reload()
    console.log(transaksi.rows().data())
}

function nota(jumlah) {
    let hasil = "",
        char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        total = char.length;
    for (var r = 0; r < jumlah; r++) hasil += char.charAt(Math.floor(Math.random() * total));
    return hasil
}

function getNama() {
    $.ajax({
        url: produkGetNamaUrl,
        type: "post",
        dataType: "json",
        data: {
            id: $("#barcode").val()
        },
        success: res => {
            $("#nama_produk").html(res.nama_produk);
            $("#sisa").html(`Sisa ${res.stok}`);
            checkEmpty()
        },
        error: err => {
            console.log(err)
        }
    })
}

function totalBayar(){
    let total = hargabarang
    let ongkir= parseInt($("#ongkir").val()) || 0;
    let diskon= $('[name="diskon"]').val();
    let bayar = total + ongkir - diskon;
    totalbayar = bayar

    $(".total_bayar").html(bayar)
    $("#total").html(bayar)
    
    let nominal = isDp ? parseInt($("#nominal").val()) : 0
    $("#piutang_kurang").val(totalbayar - nominal)
    if (nominal > 0)
        $("#total").html(nominal || totalbayar)
    else
        $("#total").html(totalbayar)
    
}

function setReseller(){
    let text = $("#pelanggan option:selected").text()
    if(text.includes("reseller"))
    isReseller = true
    else 
    isReseller = false
    console.log(isReseller)
}

function setDp(bool){
    isDp = bool
    if(isDp)
    $("#nominal").removeAttr("disabled")
    else
    $("#nominal").attr("disabled", "disabled");
    totalBayar()
}

function isDelivery(){
    if($("#jenis_kirim").val() != "")
    $("#ongkir").removeAttr("disabled")
    else
    $("#ongkir").attr("disabled", "disabled");
}

function setKurang(){
    console.log(isDp)
    
}

function checkStok() {
    $.ajax({
        url: produkGetStokUrl,
        type: "post",
        dataType: "json",
        data: {
            id: $("#barcode").val()
        },
        success: res => {
            $("#pelanggan").attr("disabled", "disabled")
            let barcode = $("#barcode").val(),
                nama_produk = res.nama_produk,
                jumlah = parseInt($("#jumlah").val()),
                stok = parseInt(res.stok),
                harga = parseInt(res.harga_jual),
                hargaTotal = parseInt(res.harga_jual) * parseInt($("#jumlah").val()),
                dataBarcode = res.barcode,
                total = parseInt($("#total").html());
            if(isReseller)
                harga = parseInt(res.harga_reseller);
            if (stok < jumlah) Swal.fire("Gagal", "Stok Tidak Cukup", "warning");
            else {
                let a = transaksi.rows().indexes().filter((a, t) => dataBarcode === transaksi.row(a).data()[0]);
                if (a.length > 0) {
                    let row = transaksi.row(a[0]),
                        data = row.data();
                    if (stok < data[3] + jumlah) {
                        Swal.fire('stok', "Stok Tidak Cukup", "warning")
                    } else {
                        produk.filter((x)=>{
                            if(x.id_produk == barcode)
                                x.jumlah += jumlah
                            return x
                        });
                        console.log(produk)
                        data[3] = data[3] + jumlah;
                        row.data(data).draw();
                        indexProduk = produk.findIndex(a => a.id_produk == barcode);
                        produk[indexProduk].stok = stok - data[3];
                        hargabarang +=  harga * jumlah
                        totalBayar()
                    }
                } else {
                    produk.push({
                        id_produk: barcode,
                        jumlah: jumlah
                    });
                    transaksi.row.add([
                        dataBarcode,
                        nama_produk,
                        harga,
                        jumlah,
                        harga * jumlah,
                        `<button name="${barcode}" class="btn btn-sm btn-danger" onclick="remove('${barcode}')">Hapus</btn>`]).draw();

                    hargabarang +=  harga * jumlah
                    totalBayar()
                    $("#jumlah").val("");
                    $("#tambah").attr("disabled", "disabled");
                    $("#bayar").removeAttr("disabled")
                } 
            }
        }
    })
    console.log(transaksi.rows().data())
}

function bayarCetak() {
    isCetak = true
}

function bayar() {
    isCetak = false
}

function checkEmpty() {
    let barcode = $("#barcode").val(),
        pelanggan = $("#pelanggan").val(),
        jumlah = $("#jumlah").val();
    console.log(pelanggan)
    if (pelanggan != null && barcode !== "" && jumlah !== "" && parseInt(jumlah) >= 1) {
        $("#tambah").removeAttr("disabled")    
    } else {
        $("#tambah").attr("disabled", "disabled")
    }
}

function checkUang() {
    console.log($("input[name='piutang']:checked").val())
    let jumlah_uang = $('[name="jumlah_uang"').val(),
        diskon= $('[name="diskon"]').val(),
        total_bayar = parseInt($(".total_bayar").html());
        
    if (jumlah_uang !== "" && jumlah_uang >= total_bayar - diskon) {
        $("#add").removeAttr("disabled");
        $("#cetak").removeAttr("disabled")
    } else {
        $("#add").attr("disabled", "disabled");
        $("#cetak").attr("disabled", "disabled")
    }
}

function remove(nama) {
    let data = transaksi.row($("[name=" + nama + "]").closest("tr")).data(),
        stok = data[3],
        harga = data[2];
        hargabarang -= stok * harga

    totalBayar()
    transaksi.row($("[name=" + nama + "]").closest("tr")).remove().draw();
    produk = produk.filter(x=>{

        return x.id_produk != nama
    })
    console.log(produk)
    $("#tambah").attr("disabled", "disabled");
    if (akhir < 1) {
        $("#bayar").attr("disabled", "disabled")
    }
}

function add() {
    let data = transaksi.rows().data()
    let jenis = $("input[name='piutang']:checked").val() == null ? "lunas" : $("input[name='piutang']:checked").val()

    $.ajax({
        url: addUrl,
        type: "post",
        dataType: "json",
        data: {
            produk: JSON.stringify(produk),
            tanggal: $("#tanggal").val(),
            total_bayar: totalbayar,
            jumlah_uang: jenis == 'full' ? 0 : $('[name="jumlah_uang"]').val(),
            diskon: $('[name="diskon"]').val(),
            pelanggan: $("#pelanggan").val(),
            nota: $("#nota").html(),
            marketplace: $("#marketplace").val(),
            jenis_kirim: $("#jenis_kirim").val(),
            jenis_piutang: jenis,
            piutang_kurang : $("#piutang_kurang").val(),
            ongkir: $("#ongkir").val(),
            jenis_bayar: $("#jenis_bayar").val(),
            bank: $("#bank").val(),
        },
        success: res => {
            console.log($("#piutang").val())
            if (isCetak) {
                Swal.fire("Sukses", "Sukses Membayar", "success").
                    then(() => window.location.href = `${cetakUrl}${res}`)
            } else {
                Swal.fire("Sukses", "Sukses Membayar", "success").
                    then(() => window.location.reload())
            }
        },
        error: err => {
            console.log(err)
        }
    })
}

function isCash(){
    if($('#jenis_bayar').val() == "cash")
      $("#bank").attr("disabled", "disabled");
    else
      $("#bank").removeAttr("disabled");
  }

function kembalian() {
    let total = $(".total_bayar").html(),
        jumlah_uang = $('[name="jumlah_uang"').val(),
        diskon = $('[name="diskon"]').val();
    $(".kembalian").html(jumlah_uang - total);
    checkUang()
}
$("#barcode").select2({
    placeholder: "Barcode",
    ajax: {
        url: getBarcodeUrl,
        type: "post",
        dataType: "json",
        data: params => ({
            barcode: params.term
        }),
        processResults: res => ({
            results: res
        }),
        cache: true
    }
});
$("#pelanggan").select2({
    placeholder: "Pelanggan",
    ajax: {
        url: pelangganSearchUrl,
        type: "post",
        dataType: "json",
        data: params => ({
            pelanggan: params.term
        }),
        processResults: res => ({
            results: res
        }),
        cache: true
    }
});
$("#tanggal").datetimepicker({
    format: "dd-mm-yyyy h:ii:ss"
});
$(".modal").on("hidden.bs.modal", () => {
    $("#form")[0].reset();
    $("#form").validate().resetForm()
});
$(".modal").on("show.bs.modal", () => {
    let now = moment().format("D-MM-Y H:mm:ss"),
        total = $("#total").html(),
        jumlah_uang = $('[name="jumlah_uang"').val();
    $("#tanggal").val(now), $(".kembalian").html(Math.max(jumlah_uang - total, 0))
    $(".total_bayar").html($("#total").html())

});
$("#form").validate({
    errorElement: "span",
    errorPlacement: (err, el) => {
        err.addClass("invalid-feedback"), el.closest(".form-group").append(err)
    },
    submitHandler: () => {
        add()
    }
});
$("#nota").html(nota(15));
