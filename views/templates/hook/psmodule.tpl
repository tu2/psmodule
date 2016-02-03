<!-- Block mymodule -->
<div id="mymodule_block_home" class="block">
  <h4>Test PS Module</h4>
  <div class="block_content">
    <p>
       {if isset($ps_module_name) && $ps_module_name}
           {$ps_module_name}
       {else}
           Hello from the other side!
       {/if}      
    </p>   
    <ul>
      <li><a href="{$ps_module_link}" title="Click this link">Click me!</a></li>
    </ul>
  </div>
</div>
<!-- /Block mymodule -->
