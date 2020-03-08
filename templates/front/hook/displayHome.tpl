<div id="owl-carousel-1" class="owl-carousel">

{foreach from=$articles key=k item=article}
    <div class="carousel-mini-blog-item carousel-item">
        <div class="module-item-wrapper-grid" style="min-height: 200px;">
            <div class="module-item-heading-grid" data-toggle="modal" data-target="#module-modal-read-more-webcallback">
                <h3 class="text-ellipsis module-name-grid" data-toggle="tooltip" data-placement="top" title="" data-original-title="Call Back">
                    {$article.title}
                </h3>
                <div class="text-ellipsis xsmall module-version-author-grid">
                    {l s='Category: '} <td>{$article.category}</td>
                </div>
            </div>
            <div class="module-quick-description-grid small no-padding">
                {$article.article}

                <br>
                <div style="display: flex;   align-items: center; justify-content: center;">
                    {l s='Tags: '} 	&nbsp;

                    {foreach from=$article.tags key=k item=tag}
                        <span class="badge badge-primary">{$tag}</span>	&nbsp;
                    {/foreach}

                </div>
            </div>
        </div>
    </div>
{/foreach}


</div>