      {* @author Umman Hasanov
*<umman3018@gmail.com>
*}

<h3 class="page-product-heading" id="mymodcomments-content-tab"{if isset($new_comment_posted)} data-scroll="true"{/if}>{l s='Product Comments' mod='mymodcomments'}</h3>
<div class="rte">
    {foreach from=$comments item=comment}
        <div class="mymodcomments-comment"> 
            <img src="http://www.gravatar.com/avatar/371e84c43b7aadf4c6de6f67d9211b45{$comment.email|trim|strtolower|md5}? s=45" class="pull-left img-thumbnail mymodcomments-avatar" />
            <div> {$comment.firstname} {$comment.lastname|substr:0:1}. <small>{$comment.date_add|substr:0:10}</small></div>
            <strong>{l s='Grade' mod='mymodcomments'} :</strong>{$comment.grade}/5<br><strong>{l s='Comment' mod='mymodcomments'}  #{$comment.id_mymod_comment}:</strong>{$comment.comment}<br>
        </div>
        <hr/>
    {/foreach}
</div>

<div class="rte">
    {assign var=params value=[
        'module_action' => 'list',
        'product_rewrite' => $product->link_rewrite,
        'id_product'=> $smarty.get.id_product,
        'page' => 1
    ]}
    <a href="{$link->getModuleLink('mymodcomments', 'comments', $params)}" target="_blank">{l s='See all comments' mod='mymodcomments'}  </a>
</div>


{if $enable_grades eq 1 OR $enable_comments eq 1}
    <div class="rte">

        {if isset($new_comment_posted) && $new_comment_posted eq 'error'}
            <div class="alert alert-danger">
                <p>{l s='Some fields of the form seems wrong, please check them before
                submitting your comment.' mod='mymodcomments'}
                </p>
            </div>
        {/if}
        <form action="" method="POST" id="comment-form">
            <div class="form-group">
                <label for="firstname">
                    {l s='Firstname' mod='mymodcomments'}:
                </label>
                <div class="row"><div class="col-xs-4">
                        <input type="text" name="firstname" id="firstname" class="form-control"
                               />
                    </div></div>
            </div>
            <div class="form-group">
                <label for="lastname">
                    {l s='Lastname' mod='mymodcomments'}:
                </label>
                <div class="row"><div class="col-xs-4">
                        <input type="text" name="lastname" id="lastname" class="form-control"/>
                    </div></div>
            </div>
            <div class="form-group">
                <label for="email">
                    {l s='Email' mod='mymodcomments'}:
                </label>
                <div class="row"><div class="col-xs-4">
                        <input type="email" name="email" id="email" class="form-control" />
                    </div></div>
            </div>

            {if $enable_grades eq 1}
                <div class="form-group">
                    <label for="grade">{l s='Grade' mod='mymodcomments'} :</label>
                    <input id="grade" name="grade" value="0" type="number" class="rating"
                           min="0" max="5" step="1" data-size="sm" >
                </div>
            {/if}
            {if $enable_comments eq 1}
                <div class="form-group">
                    <label for="comment">{l s='Comment' mod='mymodcomments'} :</label>
                    <textarea name="comment" id="comment" class="form-control" ></textarea>
                </div>
            {/if}


            <div class="submit">
                <button type="submit" name="mymod_pc_submit_comment" class="button btn btn-default button-medium"><span>{l s='Send' mod='mymodcomments'}<i class="icon-chevron-right right"></i></span></button>
            </div>
        </form>  
    </div>
{/if}
