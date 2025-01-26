<?php 
/**
 * File			: pengguna_rutin_list.php
 * Description  : Script untuk halaman Data > Penggunaan > Peminjaman Operasional
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 4 Apr 2023
 * Last Update  : 11 Apr 2023
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
                url: _HOST+'data/penggunaan/peminjaman-operasional/get-datatable',
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
                {data:"instansi", sortable: true, width: "30%", class: "text-sm"},
                {data:"no_disposisi", sortable: true, width: "30%", class: "text-sm"},
                {data:"actions", sortable: false, width: "20%", class: "text-sm"}
            ],
            order: [0, 'asc'], 
            drawCallback: function(settings) { 
                // .btn-view, .btn-edit dan .btn-delete dideklarasi di [model/getDatatable()
                $(this).on('click', '#btn-view', function(e) {
                    let _id = $(this).data("id");
                    openModal(_HOST+'data/penggunaan/peminjaman-operasional/get-form?sts=view&id='+_id, 'modal-lg', 'View Peminjaman Operasional', event);
                });
                $(this).on('click', '#btn-edit', function (e) {
                    let _id = $(this).data("id");
                    openModal(_HOST+'data/penggunaan/peminjaman-operasional/get-form?sts=edit&id='+_id, 'modal-lg', 'Edit Peminjaman Operasional', event);
                });
                $(this).on('click', '#btn-delete', function (e) {
                    let _id = $(this).data("id");
                    let _desc = $(this).data("desc");
                    let _msg = 'Anda akan menghapus data Peminjaman Operasional: ' + _desc + '.';
                    deleteData(_HOST+'data/penggunaan/peminjaman-operasional/delete', _id, _msg, event);
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

        $('#list-peminjaman-operasional #btn-add').on('click', function(e) {
            openModal(_HOST+'data/penggunaan/peminjaman-operasional/get-form?sts=add', 'modal-lg', 'Input Peminjaman Operasional', e);
        });

        $(document).on('submit', '#form-peminjaman-operasional', function(e) {
      		e.preventDefault();
            // choices js tidak bisa focus kaya select
            $('#form-peminjaman-operasional #kendaraan-id, #form-peminjaman-operasional #pengguna-id').parent().removeClass('choices__inner-focus');

            if ($('#form-peminjaman-operasional #kendaraan-id').val() == '') {
                $('#form-peminjaman-operasional #kendaraan-id').parent().addClass('choices__inner-focus');
                return;
            }

            if ($('#form-peminjaman-operasional #tgl-mulai').val() > $('#form-peminjaman-operasional #tgl-selesai').val()) {
                ToastifyMsg('Data gagal disimpan.', 'Tgl. Mulai tidak boleh lebih besar dari Tgl. Selesai.' , 'bg-danger', 'bx bx-error me-2', 'top-0 start-50 translate-middle-x');
                return;
            }

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
                    $('#form-peminjaman-operasional #btn-save').attr('disabled', 'disabled');
                    $('#form-peminjaman-operasional #btn-save').html('<span class="spinner-border spinner-border-sm me-1"></span> Proses...');
      			},
      			complete: function() {
                    $('#form-peminjaman-operasional #btn-save').removeAttr('disabled');
                    $('#form-peminjaman-operasional #btn-save').html('<span class="tf-icons bx bx-save me-1"></span> Simpan');
      			},
      			success: function(result) {
      				let _res = JSON.parse(result);
      				
      				if (_res.rc == '1') {
      					swalMsg('Sukses', _res.rd, 'success', function() {
                            $(document).find('#form-peminjaman-operasional #btn-close').trigger('click');
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
