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
            <h1>Gestion des Utilisateurs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
              <li class="breadcrumb-item active">Gestion des Utilisateurs</li>
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
                <h3 class="card-title">Liste  des utilisateurs</h3>
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
                      <th>Nom</th>
                      <th>prénom</th>
                      <th>email</th>
                      <th>credit</th>
                      <th>action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                   // on va chercher les categories dans la BDD
                      $liste_utilisateurs = $db->query('SELECT * FROM `table_client`');
                      // on verifie qu'on a au moins une catégorie
                      if( $liste_utilisateurs->rowCount() >= 1)
                        {
                          // on crée l'objet catégorie
                          $utilisateurs = $liste_utilisateurs->fetchALL(PDO::FETCH_OBJ);
                          foreach($utilisateurs as $user)
                          {
                            echo '<tr>';
                            echo '<td>'.$user->client_id.'</td>';
                            echo '<td>'.$user->client_name.'</td>';
                            echo '<td>'.$user->client_prenom.'</td>';
                            echo '<td>'.$user->client_email.'</td>';
                            echo '<td>'.$user->client_credit.'</td>';
                            echo'<td/></td>';
                            echo'</tr>';
                
                            }
                          }
                          else
                          {
                            echo '<div class="btn btn-warning">Aucun utilisateur</div>';
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