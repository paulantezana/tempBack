<!-- Print Modal -->
<div class="modal fade" id="documentPrinterModal" tabindex="-1" role="dialog" aria-labelledby="documentPrinterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentPrinterModalLabel">Comprobante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <a href="" class="btn btn-primary" target="_blank" id="documentPrinterOpenBrowser">Abrir en navegador</a>
                    <div class="btn btn-secondary" onclick="DocumentPrinter.print()">Imprimir</div>
                </div>
                <div id="documentPrinterIframe"></div>
            </div>
        </div>
    </div>
</div>
