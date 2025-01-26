<?php 
/**
 * File			: pengguna_script.php
 * Description  : Script untuk halaman Master > Pengguna
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 25 Mar 2023
 * Last Update  : 27 Mar 2023
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
                    "first": "<i class='bx bx-chevrons-left'>",
                    "previous": "<i class='bx bx-chevron-left'>",
                    "next": "<i class='bx bx-chevron-right'>",
                    "last": "<i class='bx bx-chevrons-right'>"
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
                url: _HOST+'master/pengguna/get-datatable',
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
                {data:"photo", sortable: false, width: "10%", searchable: false, class: "text-sm",
                    render: function(data) {
                        return '<div class="d-flex justify-content-start align-items-center">'+
                                    '<div class="avatar-wrapper">'+
                                        '<div class="avatar me-2">'+
                                            '<img src="'+(data == '' || data == null ? _HOST+'public/assets/img/avatars/user_800.jpg' : _HOST+data)+'" alt="photo" class="rounded-circle">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                    }
                },
                {data:"nip", sortable: true, width: "25%", class: "text-sm"},
                {data:"nama_lengkap", sortable: true, width: "25%", class: "text-sm"},
                {data:"nm_unit", sortable: true, width: "20%", class: "text-sm"},
                {data:"actions", sortable: false, width: "20%", class: "text-sm"}
            ],
            order: [2, 'asc'],
            drawCallback: function(settings) { 
                // .btn-view, .btn-edit dan .btn-delete dideklarasi di [na/getDatatable()
                $(this).on('click', '#btn-view', function(e) {
                    let _id = $(this).data("id");
                    openModal(_HOST+'master/pengguna/get-form?sts=view&id='+_id, 'modal-lg', 'Detail Pengguna', event);
                });
                $(this).on('click', '#btn-edit', function(e) {
                    let _id = $(this).data("id");
                    openModal(_HOST+'master/pengguna/get-form?sts=edit&id='+_id, 'modal-lg', 'Edit Pengguna', event);
                });
                $(this).on('click', '#btn-delete', function(e) {
                    let _id = $(this).data("id");
                    let _desc = $(this).data("desc");
                    let _msg = 'Anda akan menghapus data Pengguna: ' + _desc + '.';
                    deleteData(_HOST+'master/pengguna/delete', _id, _msg, event);
                });
            },
            rowCallback: function(row, data, displayIndex) {

            },
            footerCallback: function (row, data, start, end, display) {

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

        $('#list-pengguna #btn-add').on('click', function(e) {
            openModal(_HOST+'master/pengguna/get-form?sts=add', 'modal-lg', 'Input Pengguna', e);
        });

        // agar bisa jalan di modal pake $(document).on(event, object, function(){})
        $(document).on('change', '#form-pengguna #opd-id', function(e) {
            let _level_id = $(this).val();

            $('#unit-id').val('');

            if (_level_id == '0') {
                $('#unit-id').addClass('no-click');
                $('#unit-id').removeAttr('required');
            } else {
                $('#unit-id').removeClass('no-click');
                $('#unit-id').attr('required', 'required');
            }
        });

        $(document).on('submit', '#form-pengguna', function(e) {
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
                    $('#form-pengguna #btn-save').attr('disabled', 'disabled');
                    $('#form-pengguna #btn-save').html('<span class="spinner-border spinner-border-sm me-1"></span> Proses...');
      			},
      			complete: function() {
                    $('#form-pengguna #btn-save').removeAttr('disabled');
                    $('#form-pengguna #btn-save').html('<span class="tf-icons bx bx-save me-1"></span> Simpan');
      			},
      			success: function(result) {
      				let _res = JSON.parse(result);
      				
      				if (_res.rc == '1') {
      					swalMsg('Sukses', _res.rd, 'success', function() {
                            $(document).find('#form-pengguna #btn-close').trigger('click');
      					});
      				} else {
      					let _error = '';
      					for (err in _res.errors) {
                            _error = _res.errors[err];
                            ToastifyMsg(_res.rd, _error , 'bg-danger', 'bx bx-error me-2', 'top-0 start-50 translate-middle-x');
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
