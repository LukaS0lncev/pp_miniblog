<div id="owl-carousel-1" class="owl-carousel">

{foreach from=$articles key=k item=article}
    <div class="carousel-item">
        
            <div class="module-item-heading-grid" data-toggle="modal" data-target="#module-modal-read-more-webcallback">
                <h3 class="text-ellipsis module-name-grid" data-toggle="tooltip" data-placement="top" title="" data-original-title="Call Back">
                    <a href="{$link->getModuleLink('pp_miniblog', 'post', ['id_post' => $article.id_article])}">{$article.title|truncate:30:"...":true}</a>
                </h3>
                <div class="text-ellipsis xsmall module-version-author-grid">
                    {l s='Category: '} <td>{$article.category}</td>
                </div>
            </div>
            <br>
            <div class="module-quick-description-grid small no-padding">
                {$article.article|truncate:40:"...":true}

                <br>
                <div style="display: flex;">
                    {l s='Tags: '} 	&nbsp;

                    {foreach from=$article.tags key=k item=tag}
                        <span class="badge badge-primary">{$tag}</span>	&nbsp;
                    {/foreach}

                </div>
            </div>
        
    </div>
{/foreach}


</div>