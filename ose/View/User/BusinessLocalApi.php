<div class="container">
    <?php require_once __DIR__ . '/Partials/AlertMessage.php'?>
    <div class="card mt-4">
        <div class="card-body">
            <span>Locales</span>
            <hr>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Local asignado</th>
                            <th>RUTA</th>
                            <th>Token</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parameter['businessLocalApi'] as $key => $row): ?>
                            <tr>
                                <td><?=$row['short_name']?></td>
                                <?php if($row['api_token']): ?>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?= $row['api_url'] ?>" id="apiTokenUrl<?= $key ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button"  id="apiTokenUrl<?= $key ?>btn" onclick="BusinessLocalApi.copy('apiTokenUrl<?= $key ?>')">Copiar</button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?= $row['api_token'] ?>" id="apiTokenData<?= $key ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="apiTokenData<?= $key ?>btn" onclick="BusinessLocalApi.copy('apiTokenData<?= $key ?>')">Copiar</button>
                                        </div>
                                    </div>
                                </td>
                                <?php else: ?>
                                    <td colspan="2">
                                        <form action="" method="post">
                                            <input type="hidden" name="businessLocalId" value="<?= $row['business_local_id'] ?>">
                                            <button type="submit" class="btn btn-primary btn-block" name="commit">Generar Token</button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo FOLDER_NAME . '/Asset/Js/User/BusinessLocalApi.js' ?>"></script>