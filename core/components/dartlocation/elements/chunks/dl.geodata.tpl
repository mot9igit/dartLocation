<div class="geo_data">
    <div class="dl-item city_check">
        <a href="#" data-toggle="modal" data-target="#modal_city">
            <span class="dl_geo_city">{$_modx->getPlaceholder("dl.city")? : 'Город не выбран'}</span>
        </a>
        <div class="city_popup">
            <span>Вы находитесь в <b class="dl_geo_city">{$_modx->getPlaceholder("dl.city")}</b>?</span>
            <div class="buttons">
                <a href="#" class="dl-btn dl-btn-outline-secondary dl_city_more_info">Нет, другой</a>
                <a href="#" class="dl-btn dl-btn-primary dl_city_close">Да, верно</a>
            </div>
        </div>
    </div>
</div>