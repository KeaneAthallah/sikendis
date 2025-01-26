<?php 
/**
 * File			: change_password_script.php
 * Description  : Script untuk halaman ubah password 
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 8 Mar 2023
 * Last Update  : 8 Mar 2023
**/
?>
<script>
    $(function() {
        $("#form-change-password").on('submit', function(e) {
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
                    $('#form-change-password #btn-change').attr('disabled', 'disabled');
                    $('#form-change-password #btn-change').html('<span class="spinner-border spinner-border-sm me-1"></span> Mohon tunggu...');
      			},
      			complete: function() {
                    $('#form-change-password #btn-change').removeAttr('disabled');
                    $('#form-change-password #btn-change').html('<span class="tf-icons bx bx-key me-1"></span> Ubah Password');
      			},
      			success: function(result) {
      				let _res = JSON.parse(result);
      				
      				if (_res.rc == '1') {
      					swalMsg('Sukses', _res.rd, 'success', function() {
                            window.location.href = _HOST+'auth/do-logout';
                        });
      				} else {
      					let _error = '';
      					for (err in _res.errors) {
                            _error = _res.errors[err];
							ToastifyMsg(_res.rd, _error , 'bg-danger', 'bx bx-bell me-2', 'top-0 start-50 translate-middle-x');
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
