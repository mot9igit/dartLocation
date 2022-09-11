{if $cities}
    <div class="cities">
        {foreach $cities as $city}
            <a href="#" class="city_checked" data-data='{$city.data}'>
                <span>{$city.city}</span>
            </a>
        {/foreach}
    </div>
{/if}