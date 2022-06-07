
<h1>{l s='Comments' mod='mymodcomments'}</h1>
<div class="rte">
    {assign var=params value=[
'module_action' => 'list',
'id_product'=> $smarty.get.id_product
]}
    <a href="{$link->getModuleLink('mymodcomments', 'comments', $params)}">
        {l s='See all comments' mod='mymodcomments'}
    </a>
</div>
