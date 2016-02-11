
<!-- Block psmodule -->
<div id="psmodule_block_home" class="block">
    <h4>Test PS Module</h4>
    <div class="block_content">
        <p>
        {if isset($ps_module_name) && $ps_module_name}
            {$ps_module_name}
        {else}
            Hello from the other side!
        {/if}
        </p>   
        <div class="lnk">
            <a href="{$ps_module_link}" title="Click this link"  class="btn btn-default button button-small"><span>Click me!<i class="icon-chevron-right right"></i></span></a>
        </div>
    </div>
</div>
<!-- /Block psmodule -->
