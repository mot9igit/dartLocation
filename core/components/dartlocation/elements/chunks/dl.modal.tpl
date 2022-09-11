<div class="modal" id="modal_city" tabindex="-1" aria-labelledby="city_title" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="city_title">Выберите ваш город</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="city_choice">
                    <input type="text" name="city" class="form-control city_complete" placeholder="Начните вводить название города">
                </div>
                {$_modx->runSnippet("!dl.get_cities", [
                    "tpl" => "dl.cities"
                ])}
            </div>
        </div>
    </div>
</div>