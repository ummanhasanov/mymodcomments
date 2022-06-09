
<h1>{l s='Comments' mod='mymodcomments'} "{$product->name}"</h1>
<div class="rte">
    {foreach from=$comments item=comment}
        <div class="mymodcomments-comment"> 
            <img
                src="http://www.gravatar.com/avatar/{$comment.email|trim|strtolower|md5}?
                s=45" class="pull-left img-thumbnail mymodcomments-avatar" />
            <div> {$comment.firstname} {$comment.lastname|substr:0:1}. <small>
                    {$comment.date_add|substr:0:10}</small>
            </div>
            <strong>{l s='Grade' mod='mymodcomments'} :</strong>{$comment.grade}/5<br>
            <strong>
                {l s='Comment' mod='mymodcomments'}  #{$comment.id_mymod_comment}:</strong>
            {$comment.comment}<br>

        </div>
        <hr />
    {/foreach}
</div>
<div>{$comment.firstname} {$comment.lastname|substr:0:1}. <small>
        {$comment.date_add|substr:0:10}</small>
</div>