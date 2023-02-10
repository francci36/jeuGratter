<html>
    <head>
        <title>{#titrepage#}</title>
        <meta charset="utf8">
        <meta name="description">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="{#urlaccueil#}">{#titre_accueil#}</a></li>
                    {if $connected}
                        <li><a href="{#url_categorie#}">{#titre_categorie#}</a></li>
                        <li><a href="{#url_profil#}">{#titre_profil#}</a></li>
                        <li><a href="{#url_deco#}">{#titre_deco#}</a></li>
                    {else}
                        <li><a href="{#url_login#}">{#titre_login#}</a></li>
                    {/if}
                </ul>
            </nav>
            <p>Credit: {$credit}</p>
        </header>
    </body>
