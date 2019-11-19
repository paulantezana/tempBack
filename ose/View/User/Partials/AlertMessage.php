<?php if ((isset($parameter['message']) ? $parameter['message'] : '' ) != ''): ?>
    <div class="alert alert-<?php echo $parameter['messageType'] ?? 'info' ?> mt-5" role="alert">
        <?= $parameter['message'] ?>
    </div>
<?php endif; ?>