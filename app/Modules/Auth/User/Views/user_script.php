<?php 
/**
 * File			: user_script.php
 * Description  : Script untuk halaman Auth > User
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 18 Mar 2023
 * Last Update  : 19 Mar 2023
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
                url: _HOST+'auth/user/get-datatable', 
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
                {data:"user_name", sortable: true, width: "10%", class: "text-sm"},
                {data:"nama_lengkap", sortable: true, width: "30%", class: "text-sm"},
                {data:"level", sortable: true, searchable: false, class: "text-sm"},
                {data:"is_active", sortable: true, searchable: false, class: "text-sm",
                    render: function(data) {
                        let _checked = '';
                        let _label = '';

                        if (data == 'T') {
                            _checked = 'checked';
                            _label = 'Aktif';
                        } else {
                            _label = 'Tidak Aktif';
                        }

                        return '<div class="form-check form-switch d-flex align-items-center">'+
                                    '<input class="form-check-input chk-status" type="checkbox" onclick="setActive(this, &apos;'+data+'&apos;, event);" '+_checked+'>'+
                                    '<label class="form-check-label">'+_label+'</label>'+
                                '</div>';
                    }
                },
                {data:"is_login", sortable: true, searchable: false, class: "text-sm",
                    render: function(data) {
                        let _checked = '';
                        let _label = '';

                        if (data == 'T') {
                            _checked = 'checked';
                            _label = 'Ya';
                        } else {
                            _label = 'Tidak';
                        }

                        return '<div class="form-check form-switch d-flex align-items-center">'+
                                    '<input class="form-check-input chk-login" type="checkbox" onclick="setLogin(this, &apos;'+data+'&apos;, event);" '+_checked+'>'+
                                    '<label class="form-check-label">'+_label+'</label>'+
                                '</div>';
                    }
                },
                {data:"actions", sortable: false, width: "20%", class: "text-sm"}	
            ],
            order: [0, 'asc'], 
            drawCallback: function(settings) { 
                // .btn-view, .btn-edit dan .btn-delete dideklarasi di [na/getDatatable()
                $(this).on('click', '#btn-view', function(e) {
                    let _id = $(this).data("id");
                    openModal(_HOST+'auth/user/get-form?sts=view&id='+_id, 'modal-lg', 'Detail User', event);
                });
                $(this).on('click', '#btn-edit', function(e) {
                    let _id = $(this).data("id");
                    openModal(_HOST+'auth/user/get-form?sts=edit&id='+_id, 'modal-lg', 'Edit User', event);
                });
                $(this).on('click', '#btn-delete', function(e) {
                    let _id = $(this).data("id");
                    let _desc = $(this).data("desc");
                    // khusus sa tidak boleh dihapus
                    if (_desc == 'sa') {swalMsg('Peringatan', 'User Name sa tidak boleh dihapus.', 'warning');return;}
                    let _msg = 'Anda akan menghapus data User Name: ' + _desc + '.';
                    deleteData(_HOST+'auth/user/delete', _id, _msg, event);
                });
                $(this).on('click', '#btn-reset', function(e) {
                    let _id = $(this).data("id");
                    let _desc = $(this).data("desc");
                    // khusus sa tidak boleh dihapus
                    let _msg = 'Anda akan mereset password User Name: ' + _desc + '.';
                    resetPassword(_HOST+'auth/user/reset-password', _id, _msg, event);
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

        $('#list-user #btn-add').on('click', function(e) {
            openModal(_HOST+'auth/user/get-form?sts=add', 'modal-lg', 'Input User', e);
        });

        // agar bisa jalan di modal pake $(document).on(event, object, function(){})
        $(document).on('click', '#form-user #chk-status', function(e) {
            //e.preventDefault();
            if (!$(this).is(':checked')) {
                $(this).parent().find('label').html('Tidak Aktif');
            } else {
                $(this).parent().find('label').html('Aktif');
            }
        });

        // agar bisa jalan di modal pake $(document).on(event, object, function(){})
        $(document).on('change', '#form-user #level-id', function(e) {
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

        $(document).on('submit', '#form-user', function(e) {
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
                    $('#form-user #btn-save').attr('disabled', 'disabled');
                    $('#form-user #btn-save').html('<span class="spinner-border spinner-border-sm me-1"></span> Proses...');
      			},
      			complete: function() {
                    $('#form-user #btn-save').removeAttr('disabled');
                    $('#form-user #btn-save').html('<span class="tf-icons bx bx-save me-1"></span> Simpan');
      			},
      			success: function(result) {
      				let _res = JSON.parse(result);
      				
      				if (_res.rc == '1') {
      					swalMsg('Sukses', _res.rd, 'success', function() {
                            $(document).find('#form-user #btn-close').trigger('click');
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

    function setActive(_obj, _data, e) {
        e.preventDefault();
        let _parentrow = $(_obj).closest('tr');
        let _rowdata = _datatable.row(_parentrow).data();
        let _id = _rowdata.id; 
        let _switch = (_rowdata.is_active == 'T' ? 'F' : 'T');
        
        swal.fire({
            title: 'Anda yakin?',
            text: 'Anda akan ' + (_rowdata.is_active == 'T' ? 'menonaktifkan' : 'mengaktifkan') + ' User Name: '+ _rowdata.user_name,
            icon: 'question',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-danger me-1',
            cancelButtonClass: 'btn btn-default',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                // csrf_token_name harus disertakan jika csrf diaktifkan di Config/Filters.php
                $.post(_HOST+'auth/user/set-active', {id:_id, is_active: _switch, csrf_token_name: _csrf_content}, function(result) {
                    let _res = JSON.parse(result);
                    // jika csrf diaktifkan di Config/Filters.php
                    updateCSRF(_res.csrf_content);
                    // jika ingin pake datatable reload, 
                    // csrf token harus disertakan pada respon ajax
                    // menggunakan location.reload(); ga perlu sertakan csrf token pada respon ajax
                    if (_res.rc == '1') {
                        swalMsg('Sukses', _res.rd, 'success', function() {
                            _datatable.ajax.reload();
                        });
                    } else {
                        swalMsg('Gagal', _res.rd, 'error', function() {
                            _datatable.ajax.reload();
                            
                        });
                    }		   
                });
            }
        });
    }

    function setLogin(_obj, _data, e) {
        e.preventDefault();
        let _parentrow = $(_obj).closest('tr');
        let _rowdata = _datatable.row(_parentrow).data();
        let _id = _rowdata.id; 
        let _switch = '';
        // hanya bisa logout paksa
        if (_rowdata.is_login == 'T') 
            _switch = 'F';
        else 
            return;
        
        swal.fire({
            title: 'Anda yakin?',
            text: 'Anda akan melogout paksa User Name: '+ _rowdata.user_name,
            icon: 'question',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-danger me-1',
            cancelButtonClass: 'btn btn-default',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                // csrf_token_name harus disertakan jika csrf diaktifkan di Config/Filters.php
                $.post(_HOST+'auth/user/set-login', {id:_id, is_login: _switch, csrf_token_name: _csrf_content}, function(result) {
                    let _res = JSON.parse(result);
                    // jika csrf diaktifkan di Config/Filters.php
                    updateCSRF(_res.csrf_content);
                    // jika ingin pake datatable reload, 
                    // csrf token harus disertakan pada respon ajax
                    // menggunakan location.reload(); ga perlu sertakan csrf token pada respon ajax
                    if (_res.rc == '1') {
                        swalMsg('Sukses', _res.rd, 'success', function() {
                            _datatable.ajax.reload();
                        });
                    } else {
                        swalMsg('Gagal', _res.rd, 'error', function() {
                            _datatable.ajax.reload();
                            
                        });
                    }		   
                });
            }
        });
    }

    function resetPassword(_url, _id, _msg, e) {
        e.preventDefault();
        swal.fire({
            title: 'Anda yakin?',
            text: _msg,
            icon: 'question',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-danger me-1',
            cancelButtonClass: 'btn btn-default',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                // csrf_token_name harus disertakan jika csrf diaktifkan di Config/Filters.php
                $.post(_url, {id:_id, csrf_token_name: _csrf_content}, function(result) {
                    let _res = JSON.parse(result);
                    // jika csrf diaktifkan di Config/Filters.php
                    updateCSRF(_res.csrf_content);
                    // jika ingin pake datatable reload, 
                    // csrf token harus disertakan pada respon ajax
                    // menggunakan location.reload(); ga perlu sertakan csrf token pada respon ajax
                    if (_res.rc == '1') {
                        swalMsg('Sukses', _res.rd, 'success', function() {
                            _datatable.ajax.reload();
                        });
                    } else {
                        swalMsg('Gagal', _res.rd, 'error', function() {
                            _datatable.ajax.reload();
                            
                        });
                    }		   
                });
            }
        });
    }
</script>
