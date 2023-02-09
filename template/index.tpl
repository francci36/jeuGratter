{config_load file="config.conf"}
{include file="header.tpl" title=header}
<section class="index">
{foreach from= $ticket item=t key=k}
    <div class="ticket">
        {$t.ticket_name}
    </div>
{/foreach}
</section>
{include file="footer.tpl" title=footer}