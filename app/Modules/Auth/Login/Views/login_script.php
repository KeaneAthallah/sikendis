<?php 
/**
 * File			: login_script.php
 * Description  : Script untuk halaman login
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 3 Mar 2023
 * Last Update  : 14 Mar 2023
**/
?>
<script>
    $(function() {
        $("#form-login").on('submit', function(e) {
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
                    $('#form-login #btn-login').attr('disabled', 'disabled');
                    $('#form-login #btn-login').html('<span class="spinner-border spinner-border-sm me-1"></span> Sedang login...');
      			},
      			complete: function() {
                    $('#form-login #btn-login').removeAttr('disabled');
                    $('#form-login #btn-login').html('<span class="tf-icons bx bx-log-in-circle me-1"></span> Log in');
      			},
      			success: function(result) {
      				let _res = JSON.parse(result);
      				
      				if (_res.rc == '1') {
      					//swalMsg('Sukses', _res.rd, 'success', function() {
                            window.location.href = _HOST;
                        //});
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
