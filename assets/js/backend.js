/* code pour backend_user */
$('#btn_user').click(function(){
    $('#form_utilisateur').attr('action','action.php?e=ajoutUser');
    // afficher la div contenant le formulaire
    $('#div_user').show(1000);
});
// Pour l'édition de l'utilisateur
$('.editUser').click(function(){
    let user_id = $(this).attr('data-id');
    $.ajax({
        url: 'action.php?e=printuser&userid='+user_id,
        type: 'GET',
       // date: 'userid:'+user_id,
        success:function(response){
            // on parse(rendre lisible) les donnes JSON
            let utilisateur = jQuery.parseJSON(response);
            // on rajoute les valeurs au formulaire
            $('#email').val(utilisateur.client_email);
            $('#nom').val(utilisateur.client_name);
            $('#prenom').val(utilisateur.client_prenom);
            $('#credit').val(utilisateur.client_credit);
            // on met à jour l'action
            $('#form_utilisateur').attr('action','action.php?e=editUser&id='+utilisateur.client_id);
            // afficher la div contenant le formulaire
            $('#div_user').show(1000);
        }
    });
});
$('.delUser').click(function(){
    let user_id = $(this).attr('data-id');
    if(confirm('etes vous sûr de vouloir effectuer cette action?'))
    {
        document.location.href="action.php?e=deluser&id="+user_id;
    }
});
// fin utilisateur
// début catégorie

$('#btn-categorie').click(function(){
    $('#form_categorie').attr('action','action.php?e=ajoutcategorie');
    // afficher la div contenant le formulaire
    $('#div_categorie').show(1000);
});
$('.editcategorie').click(function(){

    let cat_id = $(this).attr('data-id');
    $.ajax({

        url: 'action.php?e=printcategorie&id='+cat_id,
        type: 'get',
        success: function(response){
            let categorie = jQuery.parseJSON(response);
            $('#nom').val(categorie.categorie_name);
            $('#form_categorie').attr('action','action.php?e=editcategorie&id='+categorie.categorie_id);
            $('#div_categorie').show(1000);
        }
    });
});
$('.delcategorie').click(function(){

    let cat_id = $(this).attr('data-id');
    if(confirm('êtes bous sûr de vouloir supprimer la catégorie?'))
    {
        document.location.href = 'action.php?e=delcategorie&id='+cat_id;
    }
});
// fin de catégorie ticket
//début de catégorie ticket
$('#nombre').on('blur',function(){
    let valeur = $(this).val();
    if(valeur > 0)
    {
        let contenu = $('#partie');
        // on affiche la div partie
        contenu.show(1000);
    }
    else
    {
        // on cache la div partie
        contenu.hide();
    }
});
$('#add_partie_btn').click(function(){
    let valeur = $('#nombre').val();
    if(valeur > 0)
    {
        let contenu = $('#partie');
        $('#add_partie').append(contenu.html()); //append ajoute du contenu
    }
    else
    {
        alert('veuillez ajouter des tickets');
    }
});
$('#btn-ticket').click(function(){
    $('#form_ticket').attr('action','action.php?e=ajoutticket');
    $('#div_ticket').show(1000);
});
$('.delticket').click(function(){
    let ticket_id = $(this).attr('data-id');
    if(confirm('êtes vous sûr de vouloir supprimer le ticket?'))
    {
        document.location.href="action.php?edelticket&id="+ticket_id;
    }
});