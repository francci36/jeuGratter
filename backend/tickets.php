<?php
require_once('../config.php');
ini_set('display_errors',true);
// on verifie si utilisateur connecté
if(!verifAdmin())
{
    //si l'utilisateur n'est pas connecté
    $message = 'veuillez vous connecter';
    header('location:login.php?msg='.urlencode($message));
    exit;
}
include('inc/header.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestion des Tickets</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
              <li class="breadcrumb-item active">Gestion des Tickets</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste  des Tickets 22</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-default" id="btn-ticket" >
                        Ajouter un ticket
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nom</th>
                      <th>catégorie</th>
                      <th>prix</th>
                      <th>nombre/restant</th>
                      <th>action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                   // on va chercher les categories dans la BDD
                      $liste_tickets = $db->query('SELECT ticket_id, ticket_name, table_ticket.categorie_id AS categorie_id, prix_ticket, nb_ticket FROM `table_ticket` INNER JOIN `table_categorie` ON table_ticket.categorie_id = table_categorie.categorie_id; ');
                      // on verifie qu'on a au moins une catégorie
                      if( $liste_tickets->rowCount() >= 1)
                        {
                          // on crée l'objet catégorie
                          $tickets = $liste_tickets->fetchAll(PDO::FETCH_OBJ);
                          foreach($tickets as $ticket)
                          {
                            echo '<tr>';
                            echo '<td>'.$ticket->ticket_id.'</td>';
                            echo '<td>'.$ticket->ticket_name.'</td>';
                            echo '<td>'.$ticket->categorie_id.'</td>';
                            echo '<td>'.$ticket->prix_ticket.'</td>';
                            echo '<td>'.$ticket->nb_ticket.'/XX</td>';
                            echo'<td/>';
                            echo '<button type="button" class="btn btn-danger delticket" data-id="'.$ticket->ticket_id.'">supprimer</button>';
                            '</td>';
                            echo'</tr>';
                            }
                          }
                          else
                          {
                            echo '<div class="btn btn-warning">Aucun ticket</div>';
                          }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- Formulaire d'ajout/édition -->
          <div class="col-12" id="div_ticket" <?php if(!empty($_SESSION['form_ticket'])) echo 'class="affiche"'; ?>>
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ajouter/éditer un ticket</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
                if(!empty($_SESSION['form_ticket']))
                {
                  // On va déséréaliser notre session
                  $ticket = unserialize(($_SESSION['form_ticket']));
                }
                else
                {
                  // Si la session est vide on initialise la varianle categorie vide
                  $ticket = '';
                }
              ?>
              <form name="ticket" method="post" action="" id="form_ticket" action="<?php if(!empty($ticket)) echo 'action.php?e=ajoutticket'; ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="categorie">Catégorie</label>
                    <select name="categorie" class="form-control">
                      <?php 
                        $categories = $db->query('SELECT * FROM `table_Categorie`');
                        if($categories->rowCount() >= 1)
                        {
                          $categorie = $categories->fetchALL(PDO::FETCH_OBJ);
                          // On parcourt les catégories
                          foreach($categorie as $cat)
                          {
                            echo '<option value="'.$cat->categorie_id.'">'.$cat->categorie_name.'</option>';
                          }
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="nom" class="form-control" id="nom" name="nom" placeholder="Nom" value="<?php if(!empty($ticket['nom'])) echo strip_tags($ticket['nom']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="prix">prix</label>
                    <input type="number" class="form-control" id="prix" name="prix" placeholder="prix" value="<?php if(!empty($ticket['prix'])) echo strip_tags($ticket['prix']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="number" class="form-control" id="nombre" name="nombre" placeholder="nombre" value="<?php if(!empty($ticket['nombre'])) echo intval($ticket['nombre']); ?>">
                  </div>
                  <!--debut div partie-->
                  <div id="partie" class="row" >
                        <div class="col-md-6 form-group">
                          <label for="nb_partie">Nombre de partie</label>
                          <input type="number" name="number[]" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                          <label for="valeur_partie">valeur</label>
                          <input type="number" name="valeur_partie[]" class="form-control">
                        </div>
                  </div>
                  <!--fin div partie-->
                  <div id="add_partie" class="row" >
                    
                  </div>
                  <!--fin de partie-->
                  <button type="button" class="btn btn-success" id="add_partie_btn">+</button>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!-- / Fin Formulaire d'ajout/édition -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include('inc/footer.php');
?>