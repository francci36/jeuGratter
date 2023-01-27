<?php
require_once('../config.php');
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
                <h3 class="card-title">Liste  des Tickets</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
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
                      $liste_tickets = $db->query('SELECT * FROM `table_ticket` INNER JOIN `table_categorie` ON categorie_id = ticket_categorie_id');
                      // on verifie qu'on a au moins une catégorie
                      if( $liste_tickets->rowCount() >= 1)
                        {
                          // on crée l'objet catégorie
                          $tickets = $liste_tickets->fetchALL(PDO::FETCH_OBJ);
                          foreach($tickets as $ticket)
                          {
                            echo '<tr>';
                            echo '<td>'.$ticket->ticket_id.'</td>';
                            echo '<td>'.$ticket->ticket_name.'</td>';
                            echo '<td>'.$ticket->categorie_name.'</td>';
                            echo '<td>'.$ticket->ticket_prix.'</td>';
                            echo '<td>'.$ticket->nombre_ticket.'/XX</td>';
                            echo'<td/></td>';
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
        </div>
        <!-- /.row -->

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php
include('inc/footer.php');
?>