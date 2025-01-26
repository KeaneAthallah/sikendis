<?php 
/**
 * File			: level_script.php
 * Description  : Script untuk halaman Auth > Level 
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 24 Nov 2022
 * Last Update  : 26 Nov 2022
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
                    "first": "<i class='fas fa-angle-double-left'>",
                    "previous": "<i class='fas fa-angle-left'>",
                    "next": "<i class='fas fa-angle-right'>",
                    "last": "<i class='fas fa-angle-double-right'>"
                },
            },  
            //scrollX" : true,
            //scrollY" : "300",
            scrollCollapse : true,
            responsive: true,
            initComplete: function() {
                //code
            },
            ajax: {
                url: _HOST+'auth/level/get-datatable', 
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
                {data:"id", sortable: true, width: "10%", class: "text-sm"},
                {data:"description", sortable: true, width: "80%", class: "text-sm"},
                {data:"actions", sortable: false, width: "20%", class: "text-sm"}	
            ],
            order: [0, 'asc'], 
            drawCallback: function(settings) { 
                $(this).on('click', '#btn-edit', function (e) {
                    let _id = $(this).data("id");
                    openModal(_HOST+'auth/level/get-form?sts=edit&id='+_id, '', 'Edit Level', event);
                });
                $(this).on('click', '#btn-delete', function (e) {
                    let _id = $(this).data("id");
                    let _desc = $(this).data("desc");
                    let _msg = 'Anda akan menghapus data level: ' + _desc + '.';
                    deleteData(_HOST+'auth/level/delete', _id, _msg, event);
                });
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

        $('#level-list #btn-add').on('click', function(e) {
            openModal(_HOST+'auth/level/get-form?sts=add', '', 'Input Level', e);
        });

        $(document).on('submit', '#level-form', function(e) {
      		e.preventDefault(); 
            let _url = $(this).attr("action");
      		let _data = new FormData(this); 
                  
      		$.ajax({
      			type: 'post',
      			url: _url,
      			data: _data,
      			cache:false,
      			contentType: false,
      			processData: false,
      			beforeSend: function() {
                    $('#level-form #btn-save').attr('disabled', 'disabled');
                    $('#level-form #btn-save').html('<span class="btn-inner--icon"><i class="fa fa-spin fa-spinner"></i></span><span class="btn-inner--text">Proses...</span>');
      			},
      			complete: function() {
                    $('#level-form #btn-save').removeAttr('disabled');
                    $('#level-form #btn-save').html('<span class="btn-inner--icon"><i class="fa fa-save"></i></span><span class="btn-inner--text">Simpan</span>');
      			},
      			success: function(result) {
      				let _res = JSON.parse(result);
      				
      				if (_res.rc == '1') {
      					swalMsg('Sukses', _res.rd, 'success', function() {
                            $(document).find('#level-form #btn-close').trigger('click');
      					});
      				} else {
      					let _error = '';
      					for (err in _res.errors) {
                            _error = _res.errors[err];
                            ToastifyMsg(_res.rd, _error , 'danger', 'fa fa-exclamation-triangle');
                        }
      				}
      				// jika csrf diaktifkan di Config/Filters.php
      				updateCSRF(_res.csrf_content);
      			},
      			error: function(jqXHR, textStatus, errorThrown) {
      				swalMsg('Error', 'status code: ' + jqXHR.status + ' errorThrown: ' + errorThrown + ' responseText: ' + jqXHR.responseText, 'error');
      			}
      		});
      	});
    });
</script>