<?php 
/**
 * File			: user_history_script.php
 * Description  : Script untuk halaman User History
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 25 Dec 2022
 * Last Update  : 7 Jan 2023
**/
?>
<script>
    // Jquery Datatable
    let _start = 0;
    let _limit = 10;
    let _program = '<?= getSegment()[1] ?? '' ?>';
    let _level_id = '<?= $_GET['level_id'] ?? '' ?>';
    let _user_id = '<?= $_GET['user_id'] ?? '' ?>';
    _sts = '<?= $sts ?? '' ?>';
        
    $(function() {
        _datatable = $('#dt-<?= $mod ?>').DataTable({
            destroy: true,
            processing: true, 
            jQueryUI: false,
            autoWidth: false,
            searching: true,
            paging: false,
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
                    "first": "<i class='fas fa-angle-double-left'>",
                    "previous": "<i class='fas fa-angle-left'>",
                    "next": "<i class='fas fa-angle-right'>",
                    "last": "<i class='fas fa-angle-double-right'>"
                },
            },  
            scrollX : true,
            scrollY : "300",
            //scrollCollapse : true,
            responsive: false, //true
            initComplete: function() {
                //code
            },
            ajax: {
                url: _HOST+'auth/user-history/get-datatable?level_id='+_level_id+'&user_id='+_user_id, 
                type: 'POST',
                data: function (d) {
                    //csrf_token_name ada di Config/App.php
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
                {data:"date_time", sortable: false, searchable: true, width: "20%", class: "text-sm"},
                {data:"activity", sortable: false, searchable: true, class: "text-sm",
                    render: function (data, type, full, meta) {
                        return '<div class="text-wrap">' + data + "</div>";
                    }
                },
                {data:"no_sp", sortable: false, searchable: true, class: "text-sm",
                    render: function (data, type, full, meta) {
                        return '<div class="text-wrap">' + data + "</div>";
                    }
                },
                {data:"mitra_desc", sortable: false, searchable: true, class: "text-sm",
                    render: function (data, type, full, meta) {
                        return '<div class="text-wrap">' + data + "</div>";
                    }
                },
                {data:"area_desc", sortable: false, searchable: true, class: "text-sm",
                    render: function (data, type, full, meta) {
                        return '<div class="text-wrap">' + data + "</div>";
                    }
                },
                {data:"jobdesc", sortable: false, searchable: true, class: "text-sm",
                    render: function (data, type, full, meta) {
                        return '<div class="text-wrap">' + data + "</div>";
                    }
                },	
                {data:"revisi", sortable: false, searchable: true, class: "text-sm",
                    render: function (data, type, full, meta) {
                        return '<div class="text-wrap">' + data + "</div>";
                    }
                },
                {data:"actions", sortable: false, searchable: false, class: "text-sm", visible: false}	
            ],
            order: [0, 'desc'], 
            drawCallback: function(settings) { 
                
            },
            rowCallback: function(row, data, displayIndex) {
                
            },
            footerCallback: function (row, data, start, end, display) {

            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    className: 'btn-danger',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    title: 'User History<br>Level: '+$('#level-id option:selected').text()+'<br>User Name: '+$('#user-id option:selected').text(),
                    customize: function ( doc ) {
                        $(doc.document.body).find('h1').css('font-size', '15pt');
                        $(doc.document.body).find('h1').css('text-align', 'center'); 
                    }
                }
            ]
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