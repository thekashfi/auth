<?php if($msg = flash()): ?>
    <div class="alert alert-info alert-dismissible fade show" id="delete_alert" role="alert">
        <?= $message ?? $msg ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<div class="alert alert-info alert-dismissible fade" style="display: none" id="delete_alert" role="alert">
    <span id="flash">ssss</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<script>

    window.flash = ($msg) => {
        $('#flash').parent().show()
        $('#flash').parent().css('opacity','100');
        $('#flash').text($msg)
    }
</script>