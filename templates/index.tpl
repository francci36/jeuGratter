{config_load file="config.conf"}
{include file="header.tpl" title=header}
<section class="index">
{foreach from= $tickets item=t key=k}
    <div class="ticket">
        <h3>{$t.ticket_name}</h3>
        <p><b>prix:</b>{$t.ticket_prix}</p>
        <a href="ticket.php?id={$t.ticket_id}">Jouer</a>
    </div>
{/foreach}
</section>
{include file="footer.tpl" title=footer}