let url;
let produk = $("#produk").DataTable({
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
        { data: null }, 
        { data: "kategori" },
        { data: "nama_produk" },
        { data: "harga_beli" },
        { data: "harga_jual" },
        { data: "harga_reseller" },
        { data: "action" }
    ]
});

console.log(produk.rows().data())

let daftar_stok = $("#daftar_stok").DataTable({
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
        { data: null }, 
        { data: "barcode" },
        { data: "nama_produk" },
        { data: "harga_jual" },
        { data: "stok" },
        { data: "subtotal" }
    ]
});

function reloadTable() {
    produk.ajax.reload()
}

function addData() {
    $.ajax({
        url: addUrl,
        type: "post",
        dataType: "json",
        data: $("#form").serialize(),
        success: res => {
            $(".modal").modal("hide");
            Swal.fire("Sukses", "Sukses Menambahkan Data", "success");
            reloadTable();
        },
        error: res => {
            console.log(res);
        }
    })
}

function remove(id) {
    Swal.fire({
        title: "Hapus",
        text: "Hapus data ini?",
        type: "warning",
        showCancelButton: true
    }).then(() => {
        $.ajax({
            url: deleteUrl,
            type: "post",
            dataType: "json",
            data: {
                id: id
            },
            success: () => {
                Swal.fire("Sukses", "Sukses Menghapus Data", "success");
                reloadTable();
            },
            error: () => {
                console.log(a);
            }
        })
    })
}

function editData() {
    $.ajax({
        url: editUrl,
        type: "post",
        dataType: "json",
        data: $("#form").serialize(),
        success: () => {
            $(".modal").modal("hide");
            Swal.fire("Sukses", "Sukses Mengedit Data", "success");
            reloadTable();
        },
        error: err => {
            console.log(err)
        }
    })
}

function add() {
    url = "add";
    $(".modal-title").html("Add Data");
    $('.modal button[type="submit"]').html("Add");
}

function edit(id) {
    $.ajax({
        url: getProdukUrl,
        type: "post",
        dataType: "json",
        data: {
            id: id
        },
        success: res => {
            $('[name="id"]').val(res.id);
            $('[name="barcode"]').val(res.barcode);
            $('[name="nama_produk"]').val(res.nama_produk);
            $('[name="satuan"]').append(`<option value='${res.satuan_id}'>${res.satuan}</option>`);
            $('[name="kategori"]').append(`<option value='${res.kategori_id}'>${res.kategori}</option>`);
            $('[name="harga"]').val(res.harga);
            $('[name="stok"]').val(res.stok);
            $(".modal").modal("show");
            $(".modal-title").html("Edit Data");
            $('.modal button[type="submit"]').html("Edit");
            url = "edit";
        },
        error: err => {
            console.log(err)
        }
    });
}
produk.on("order.dt search.dt", () => {
    produk.column(0, {
        search: "applied",
        order: "applied"
    }).nodes().each((el, val) => {
        el.innerHTML = val + 1
    });
});

daftar_stok.on("order.dt search.dt", () => {
    daftar_stok.column(0, {
        search: "applied",
        order: "applied"
    }).nodes().each((el, val) => {
        // console.log(el, val)
        el.innerHTML = val + 1
    });
});

let a = 0;
daftar_stok.on("order.dt search.dt", () => {
    daftar_stok.column(5).nodes().each((el, val) => {
        a += parseInt(el.innerHTML);
        console.log(el, val)
    });
});
console.log(a)

$("#form").validate({
    errorElement: "span",
    errorPlacement: (err, el) => {
        err.addClass("invalid-feedback");
        el.closest(".form-group").append(err)
    },
    submitHandler: () => {
        "edit" == url ? editData() : addData()
    }
});
$("#kategori").select2({
    placeholder: "Kategori",
    ajax: {
        url: kategoriSearchUrl,
        type: "post",
        dataType: "json",
        data: params => ({
            kategori: params.term
        }),
        processResults: data => ({
            results: data
        }),
        cache: true
    }
});
$("#satuan").select2({
    placeholder: "Satuan",
    ajax: {
        url: satuanSearchUrl,
        type: "post",
        dataType: "json",
        data: paras => ({
            satuan: paras.term
        }),
        processResults: data => ({
            results: data
        }),
        cache: true
    }
});
$(".modal").on("hidden.bs.modal", () => {
    $("#form")[0].reset();
    $("#form").validate().resetForm();
});