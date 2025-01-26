<?php 
/**
 * File			: monitoring_kendaraan_script.php
 * Description  : Script untuk halaman Monitoring > Monitoring Kendaraan [Rutin/Operasional]
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 15 Apr 2023
 * Last Update  : 17 May 2023
**/
?>
<script>
    let _start = 0;
    let _limit = 10;
    _sts = '<?= $sts ?? '' ?>';
    let _segment = '<?= getSegment()[1] ?>';
    let _title = _segment.replace('-', ' ');
    // di js tidak ada ucwords kaya di php
    _title = _title.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });

    $(function() {
        _datatable = $('#dt-<?= $mod ?>').DataTable({
            destroy: true,
            processing: true, 
            jQueryUI: false,
            autoWidth: false,
            searching: true,
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
            //scrollX" : true,
            //scrollY" : "300",
            scrollCollapse : true,
            responsive: false,
            initComplete: function() {
                //code
            },
            ajax: {
                url: _HOST+'monitoring/'+_segment+'/get-datatable',
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
                {data:"th_beli", sortable: true, visible: false, class: "text-sm"},
                {data:"no_rangka", sortable: true, width: "30%", class: "text-sm"},
                {data:"merk", sortable: true, visible: false, class: "text-sm"},
                {data:"photo",
                    render: function(data) {
                        return '<img src="'+(data == '' || data == null ? _HOST+'public/assets/img/no-image.png' : _HOST+data)+'" width="100px" class="img-datatable img-fluid img-thumbnail zoom">';
                    }
                },
                {data:"status", sortable: true, width: "35%", class: "text-sm text-wrap"}
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
    });
</script>
