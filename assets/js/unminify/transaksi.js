let isCetak = false,
produk = [],
isReseller = false,
transaksi = $("#transaksi").DataTable({
    responsive: true,
    lengthChange: false,
    searching: false,
    scrollX: true
});

function reloadTable() {
    transaksi.ajax.reload()
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
    let total = parseInt($("#total").html());
    let piutang_kurang = parseInt($("#piutang_kurang").val()) || 0;
    let ongkir= parseInt($("#ongkir").val()) || 0;
    let bayar = total - piutang_kurang + ongkir;
    console.log(bayar)
    $(".total_bayar").html(bayar)
}

function setReseller(){
    let text = $("#pelanggan option:selected").text()
    if(text.includes("reseller"))
    isReseller = true
    else 
    isReseller = false
    console.log(isReseller)
}

function isDp(str){
    if(str == 'dp')
    $("#nominal").removeAttr("disabled")
    else
    $("#nominal").attr("disabled", "disabled");
}

function isDelivery(){
    if($("#jenis_kirim").val() != "")
    $("#ongkir").removeAttr("disabled")
    else
    $("#ongkir").attr("disabled", "disabled");
}

function setKurang(){
    let nominal = parseInt($("#nominal").val()),
    total = parseInt($("#total").html());
    $("#piutang_kurang").val(total - nominal)
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
                        data[3] = data[3] + jumlah;
                        row.data(data).draw();
                        indexProduk = produk.findIndex(a => a.id_produk == barcode);
                        produk[indexProduk].stok = stok - data[3];
                        $("#total").html(total + harga * jumlah)
                    }
                } else {
                    produk.push({
                        id_produk: barcode,
                        jumlah: jumlah
                    });
                    console.log(produk)
                    transaksi.row.add([
                        dataBarcode,
                        nama_produk,
                        harga,
                        jumlah,
                        hargaTotal,
                        `<button name="${barcode}" class="btn btn-sm btn-danger" onclick="remove('${barcode}')">Hapus</btn>`]).draw();

                    $("#total").html(total + harga * jumlah);
                    $("#jumlah").val("");
                    $("#tambah").attr("disabled", "disabled");
                    $("#bayar").removeAttr("disabled")
                } 
            }
        }
    })
}

function bayarCetak() {
    isCetak = true
}

function bayar() {
    isCetak = false
}

function checkEmpty() {
    let barcode = $("#barcode").val(),
        jumlah = $("#jumlah").val();
    if (barcode !== "" && jumlah !== "" && parseInt(jumlah) >= 1) {
        $("#tambah").removeAttr("disabled")    
    } else {
        $("#tambah").attr("disabled", "disabled")
    }
}

function checkUang() {
    let jumlah_uang = $('[name="jumlah_uang"').val(),
        total_bayar = parseInt($(".total_bayar").html());
    if (jumlah_uang !== "" && jumlah_uang >= total_bayar) {
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
        harga = data[2],
        total = parseInt($("#total").html());
        akhir = total - stok * harga
    $("#total").html(akhir);
    transaksi.row($("[name=" + nama + "]").closest("tr")).remove().draw();
    $("#tambah").attr("disabled", "disabled");
    if (akhir < 1) {
        $("#bayar").attr("disabled", "disabled")
    }
}

function add() {
    let data = transaksi.rows().data()
    $.ajax({
        url: addUrl,
        type: "post",
        dataType: "json",
        data: {
            produk: JSON.stringify(produk),
            tanggal: $("#tanggal").val(),
            total_bayar: $("#total").html(),
            jumlah_uang: $('[name="jumlah_uang"]').val(),
            diskon: $('[name="diskon"]').val(),
            pelanggan: $("#pelanggan").val(),
            nota: $("#nota").html(),
            marketplace: $("#marketplace").val(),
            jenis_kirim: $("#jenis_kirim").val(),
            jenis_piutang: $("#piutang").val(),
            piutang_kurang : $("#piutang_kurang").val(),
            ongkir: $("#ongkir").val(),
            jenis_bayar: $("#jenis_bayar").val(),
            bank: $("#bank").val(),
        },
        success: res => {
            console.log($("#pelanggan").val())
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
    $(".kembalian").html(jumlah_uang - (total - diskon));
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
    totalBayar();
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
