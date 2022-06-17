<fieldset>
    <div class="panel">
        <div class="panel-heading">
            <legend><i class="icon-info"></i>
                {l s='Comment on product' mod='mymodcomments'}</legend>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='ID:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->id}</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='Firstname:' mod='mymodcomments'}
            </label>
            <div class="col-lg-9">{$mymodcomment->firstname}</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='Lastname:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->lastname}</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='E-mail:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->email}</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='Product:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->id_product}</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='Grade:' mod='mymodcomments'}</label>
            <div class="col-lg-9">{$mymodcomment->grade}/5</div>
        </div>
        <div class="form-group clearfix">
            <label class="col-lg-3">{l s='Comment:' mod='mymodcomments'}</label>
            <div class="col-lg-9">
                {$mymodcomment->comment|nl2br}</div>
        </div>
    </div>
</fieldset>
