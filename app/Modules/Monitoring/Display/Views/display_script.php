<?php 
/**
 * File			: display_list.php
 * Description  : Script untuk halaman Monitoring > Display
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 4 Mei 2023
 * Last Update  : 15 Mei 2023
**/
?>
<script>
    let _start = 0;
    let _limit = 10;
    _sts = '<?= $sts ?? '' ?>';

    $(function() {
        _datatable = $('#dt-<?= $mod ?>').DataTable({
            destroy: true,
            processing: true, 
            jQueryUI: false,
            autoWidth: false,
            searching: false,
            paging: true,
            pagingType: 'full_numbers',
            serverSide: true, 
            displayStart: _start,
            pageLength: _limit,
            lengthMenu: [5,10,25,50,100],
            language: {
                /* sudah ada bawaan template
                processing: '<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">'+
                                '<span class="visually-hidden">Loading...</span>'+
                            '</div>'
                */
                paginate: {
                    "first": "<i class='bx bx-chevrons-left'>",
                    "previous": "<i class='bx bx-chevron-left'>",
                    "next": "<i class='bx bx-chevron-right'>",
                    "last": "<i class='bx bx-chevrons-right'>"
                },
            },  
            //scrollX : true,
            //scrollY : "300",
            scrollCollapse : true,
            responsive: false,
            initComplete: function() {
                //code
            },
            ajax: {
                url: _HOST+'monitoring/display/get-datatable',
                type: 'POST',
                data: function (d) {
                    // csrf_token_name ada di Config/App.php
                    d.csrf_token_name = _csrf_content 
                }
            },
            columnDefs: [
                {
                    targets: [ -1 ], 
                    orderable: false,
                    searchable: false
                },
            ], 
            columns: [
                {data:"no_polisi", sortable: true, width: "20%", class: "text-sm"},
                {data:"status", sortable: true, width: "10%", class: "text-sm"},
                {data:"instansi", sortable: true, width: "30%", class: "text-sm"},
                {data:"no_telp", sortable: true, width: "20%", class: "text-sm"},
                {data:"tgl_mulai", sortable: true, width: "10%", class: "text-sm"},
                {data:"tgl_selesai", sortable: true, width: "10%", class: "text-sm"}
            ],
            order: [0, 'asc'], 
            drawCallback: function(settings) { 

            },
            rowCallback: function(row, data, displayIndex) {

            },
            footerCallback: function ( row, data, start, end, display ) {

            }
        });

        // Refresh Data
        //_datatable.ajax.reload();

        // Cek Data 
        // untuk menghilangkan pesan error datatable, biar dilihat di consol sj
        $.fn.dataTable.ext.errMode = 'throw';
        
        _datatable.on('xhr', function() {
            var _json = _datatable.ajax.json();
            // untuk menampilkan/alert data di datatable
            //alert(_json.data.length +' row(s) were loaded' );
            //alert(JSON.stringify(_json));
            //alert(_json.csrf_content);
            // update csrf token 
            updateCSRF(_json.csrf_content);
        });

        // slide per 6 detik
        setInterval(function() {
            var info = _datatable.page.info();
            //var pageNum = (info.page < info.pages) ? info.page + 1 : 1;
            var pageNum = (info.page < (info.pages-1)) ? info.page + 1 : 0;
            _datatable.page(pageNum).draw(false);
        }, 3000);
    });
</script>
