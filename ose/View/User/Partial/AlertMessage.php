<?php if ((isset($parameter['message']) ? $parameter['message'] : '' ) != ''): ?>
    <div class="alert alert-<?php echo $parameter['messageType'] ?? 'info' ?>" role="alert">
        <?= $parameter['message'] ?>
    </div>
<?php endif; ?>
