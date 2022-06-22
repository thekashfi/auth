<?php if($msg = flash()): ?>
    <div class="alert alert-info alert-dismissible fade show" id="delete_alert" role="alert">
        <?= $message ?? $msg ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>