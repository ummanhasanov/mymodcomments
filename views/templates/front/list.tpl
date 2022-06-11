
<h1>{l s='Comments' mod='mymodcomments'} "{$product->name}"</h1>
<div class="rte">
    {foreach from=$comments item=comment}
        <div class="mymodcomments-comment"> 
            <img src="http://www.gravatar.com/avatar/371e84c43b7aadf4c6de6f67d9211b45{$comment.email|trim|strtolower|md5}?s=45" class="pull-left img-thumbnail mymodcomments-avatar"/>
            <div> {$comment.firstname} {$comment.lastname|substr:0:1}.<small>{$comment.date_add|substr:0:10}</small></div>
            <strong>{l s='Grade' mod='mymodcomments'} :</strong>{$comment.grade}/5<br><strong>{l s='Comment' mod='mymodcomments'}  #{$comment.id_mymod_comment}:</strong>{$comment.comment}<br>
        </div>
        <hr />
    {/foreach}
</div>

<ul class="pagination">
    {for $count=1 to $nb_pages}
        {assign var=params value=[
        'module_action' => 'list',
        'product_rewrite' => $product->link_rewrite,
        'id_product' => $smarty.get.id_product,
        'page' => $count
        ]}
        {if $page ne $count}
            <li>
                <a href="{$link->getModuleLink('mymodcomments', 'comments', $params)}">
                    <span>{$count}</span>
                </a>
            </li>
        {else}
            <li class="active current">
                <span><span>{$count}</span></span>
            </li>
        {/if}
    {/for}
</ul>
