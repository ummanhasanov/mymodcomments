{* @author Umman Hasanov
*<umman3018@gmail.com>
*}

<h3 class="page-product-heading" id="mymodcomments-content-tab"{if isset($new_comment_posted)} data-scroll="true"{/if}>{l s='Product Comments' mod='mymodcomments'}</h3>
<div class="rte">
    {foreach from=$comments item=comment}
        <p>
            <strong>
                Comment #{$comment.id_mymod_comment}:</strong>
            {$comment.comment}<br>
            <strong>Grade:</strong>{$comment.grade}/5<br>
        </p> <br>
    {/foreach}
</div>
<div class="rte">
    <form action="" method="POST" id="comment-form">
        {if $enable_grades eq 1}
            <div class="form-group">
                <label for="grade">Grade:</label>
                <input id="grade" name="grade" value="0" type="number" class="rating"
                       min="0" max="5" step="1" data-size="sm" >
            </div>
        {/if}
        {if $enable_comments eq 1}
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea name="comment" id="comment" class="form-control" ></textarea>
            </div>
        {/if}
        <div class="submit">
            <button type="submit" name="mymod_pc_submit_comment" class="button btn btn-default button-medium"><span>Send<i class="icon-chevron-right right"></i></span></button>
        </div>
    </form>  
</div>
