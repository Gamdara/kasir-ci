let laporan_piutang = $("#laporan_piutang").DataTable( {
    responsive:true,
    scrollX:true,
    ajax:readUrl,
    columnDefs:[{
        searcable: false,
        orderable: false,
        targets: 0
    }],
    order:[
        [1, "asc"]],
        columns:[ 
        {data: null}, 
        {data: "nota"},
        {data: "total_bayar"}, 
        {data: "piutang_kurang"},
        {data: "action"}
    ]
});

let laporan_transaksi = $("#laporan_transaksi").DataTable( {
    responsive:true,
    scrollX:true,
    ajax:readUrl,
    columnDefs:[{
        searcable: false,
        orderable: false,
        targets: 0
    }],
    order:[
        [1, "asc"]],
        columns:[ 
        {data: null}, 
        {data: "tanggal"},
        {data: "nota"},
        {data: "total_bayar"}, 
        {data: "jumlah_uang"},
        {data: "diskon"}, 
        {data: "pelanggan"},
        {data: "action"}
    ]
});

let laporan_penjualan = $("#laporan_penjualan").DataTable( {
    responsive:true,
    scrollX:true,
    ajax:readUrl,
    columnDefs:[{
        searcable: false,
        orderable: false,
        targets: 0
    }],
    order:[
        [1, "asc"]],
        columns:[ 
        {data: null}, 
        {data: "tanggal"},
        {data: "total_beli"}, 
        {data: "total_jual"},
        {data: "jumlah_transaksi"}, 
        {data: "laba"}
    ]
});

let laporan_bulanan = $("#laporan_bulanan").DataTable( {
    responsive:true,
    scrollX:true,
    ajax:readUrl,
    columnDefs:[{
        searcable: false,
        orderable: false,
        targets: 0
    }],
    order:[
        [1, "asc"]],
        columns:[ 
        {data: "bulan"},
        {data: "total_beli"}, 
        {data: "total_jual"},
        {data: "jumlah_transaksi"}, 
        {data: "total_pengeluaran"}, 
        {data: "laba"}
    ]
});


function reloadTable() {
    laporan_penjualan.ajax.reload()
    laporan_transaksi.ajax.reload()
    laporan_piutang.ajax.reload()
}

function remove(id) {
    Swal.fire( {
        title: "Hapus",
        text: "Hapus data ini?",
        type: "warning",
        showCancelButton: true
    }).then((result)=> {
        if(result.isCanceled) return
        $.ajax( {
            url:deleteUrl,
            type:"post",
            dataType:"json",
            data: {
                id: id
            },
            success:()=> {
                Swal.fire("Sukses", "Sukses Menghapus Data", "success");
                reloadTable()
            },
            error:err=> {
                console.log(err)
            }
        })
    })
}

laporan_penjualan.on("order.dt search.dt", ()=> {
    laporan_penjualan.column(0, {
        search: "applied", order: "applied"
    }).nodes().each((el, err)=> {
        el.innerHTML=err+1
    })
});

laporan_piutang.on("order.dt search.dt", ()=> {
    laporan_piutang.column(0, {
        search: "applied", order: "applied"
    }).nodes().each((el, err)=> {
        el.innerHTML=err+1
    })
});

laporan_transaksi.on("order.dt search.dt", ()=> {
    laporan_transaksi.column(0, {
        search: "applied", order: "applied"
    }).nodes().each((el, err)=> {
        el.innerHTML=err+1
    })
});

$(".modal").on("hidden.bs.modal", ()=> {
    $("#form")[0].reset();
    $("#form").validate().resetForm()
});