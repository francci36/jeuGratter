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