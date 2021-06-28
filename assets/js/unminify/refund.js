let refund = $("#refund").DataTable( {
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
        {data: "tgl_refund"}, 
        {data: "total_refund"},
        {data: "action"}
    ]
});

refund.on("order.dt search.dt", ()=> {
    refund.column(0, {
        search: "applied", order: "applied"
    }).nodes().each((el, err)=> {
        el.innerHTML=err+1
    })
});
