<?php 
/**
 * File			: kendaraan_list.php
 * Description  : Script untuk halaman Master > Kendaraan > Kendaraan [Rutin/Operasional]
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 20 Mar 2023
 * Last Update  : 17 May 2023
**/
?>
<script>
    let _start = 0;
    let _limit = 10;
    _sts = '<?= $sts ?? '' ?>';
    let _segment = '<?= getSegment()[2] ?>';
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
            responsive: true,
            initComplete: function() {
                //code
            },
            ajax: {
                url: _HOST+'master/kendaraan/'+_segment+'/get-datatable',
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
                {data:"th_beli", sortable: true, width: "10%", class: "text-sm"},
                {data:"no_rangka", sortable: true, width: "30%", class: "text-sm"},
                {data:"merk", sortable: false, visible: false, class: "text-sm"},
                {data:"photo",
                    render: function(data) {
                        return '<img src="'+(data == '' || data == null ? _HOST+'public/assets/img/no-image.png' : _HOST+data)+'" width="100px" class="img-datatable img-fluid img-thumbnail zoom">';
                    }
                },
                {data:"actions", sortable: false, width: "20%", class: "text-sm"}
            ],
            order: [0, 'asc'], 
            drawCallback: function(settings) { 
                // .btn-view, .btn-edit dan .btn-delete dideklarasi di [model/getDatatable()
                $(this).on('click', '#btn-view', function(e) {
                    let _id = $(this).data("id");
                    openModal(_HOST+'master/kendaraan/'+_segment+'/get-form?sts=view&id='+_id, 'modal-lg', 'View '+_title, event);
                });
                $(this).on('click', '#btn-edit', function (e) {
                    let _id = $(this).data("id");
                    openModal(_HOST+'master/kendaraan/'+_segment+'/get-form?sts=edit&id='+_id, 'modal-lg', 'Edit '+_title, event);
                });
                $(this).on('click', '#btn-delete', function (e) {
                    let _id = $(this).data("id");
                    let _desc = $(this).data("desc");
                    let _msg = 'Anda akan menghapus data Kendaraan: ' + _desc + '.';
                    deleteData(_HOST+'master/kendaraan/'+_segment+'/delete', _id, _msg, event);
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

        $('#list-kendaraan #btn-add').on('click', function(e) {
            openModal(_HOST+'master/kendaraan/'+_segment+'/get-form?sts=add', 'modal-lg', 'Input '+_title, e);
        });

        $(document).on('focus', '#form-kendaraan #harga', function() {
            $(this).val(stringToNumber($(this).val(), 0));
        });

        $(document).on('focusout', '#form-kendaraan #harga', function() {
            $(this).val(numberFormat($(this).val(), 0, ',', '.'));
        });

        $(document).on('submit', '#form-kendaraan', function(e) {
      		e.preventDefault(); 
            $('#form-kendaraan #harga').val(stringToNumber($('#form-kendaraan #harga').val(), 0));

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
                    $('#form-kendaraan #btn-save').attr('disabled', 'disabled');
                    $('#form-kendaraan #btn-save').html('<span class="spinner-border spinner-border-sm me-1"></span> Proses...');
      			},
      			complete: function() {
                    $('#form-kendaraan #btn-save').removeAttr('disabled');
                    $('#form-kendaraan #btn-save').html('<span class="tf-icons bx bx-save me-1"></span> Simpan');
      			},
      			success: function(result) {
      				let _res = JSON.parse(result);
      				
      				if (_res.rc == '1') {
      					swalMsg('Sukses', _res.rd, 'success', function() {
                            $(document).find('#form-kendaraan #btn-close').trigger('click');
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
