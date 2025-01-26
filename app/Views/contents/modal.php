<?php
/**
 * File			: modal.php
 * Description  : view kerangka dasar untuk modal
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 2 Mar 2023
 * Last Update  : 2 Mar 2023
**/

# menggunakan jquery $('#my-modal').modal('show'), modalnya belum bisa muncul
# alternatif memakai trigger button
?>
<!-- Button trigger modal -->
<button type="button" id="btn-modal-trigger" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#my-modal" style="display: none;">Launch Modal</button>
<!-- Modal -->
<div class="modal fade" id="my-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="javascript: if (_datatable !== null) _datatable.ajax.reload();"></button>
            </div>
            <div class="modal-body">
                <!-- content -->
            </div>
            <!--
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
            -->
        </div>
    </div>
</div>
