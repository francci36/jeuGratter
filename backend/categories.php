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
            <h1>Gestion des catégories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
              <li class="breadcrumb-item active">Gestion des catégories</li>
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
                <h3 class="card-title">Liste  des catégories</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-default" id="btn-categorie">
                        Ajouter une catégorie
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
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                   // on va chercher les categories dans la BDD
                      $liste_categories = $db->query('SELECT * FROM `table_categorie`');
                      // on verifie qu'on a au moins une catégorie
                      if( $liste_categories->rowCount() >= 1)
                        {
                          // on crée l'objet catégorie
                          $categories = $liste_categories->fetchALL(PDO::FETCH_OBJ);
                          foreach($categories as $cat)
                          {
                            echo '<tr>';
                            echo '<td>'.$cat->categorie_id.'</td>';
                            echo '<td>'.$cat->categorie_name.'</td>';
                            echo'<td/>';
                            echo '<button type="button" class="btn btn-primary editcategorie" data-id="'.$cat->categorie_id.'">modifier</button>';
                            echo '<button type="button" class="btn btn-warning delcategorie" data-id="'.$cat->categorie_id.'">supprimer</button>';
                            echo '</td>';
                            echo'</tr>';
                            }
                          }
                          else
                          {
                            echo '<div class="btn btn-warning">Aucune categorie</div>';
                          }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
                 <!--Formulaire d'ajout d'édition-->
                 <div class="col-12" id="div_categorie" <?php if(!empty($_SESSION['form_categorie'])) echo 'class= "affiche"';?>>
             <!-- general form elements -->
             <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ajouter/éditeur une categorie</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php

              if(!empty($_SESSION['form_categorie']))
              {
                // on va desearialiser notre sesssion
                $categorie = unserialize($_SESSION['form_categorie']);
              }
              else{
                // si la session est vide on initialise la variable utilisateur vide
                $categorie = '';
              }

              ?>
              <form name="categorie" method="post" action="<?php if(!empty($categorie)) echo 'action.php?e=ajoutcategorie'; ?>" id="form_categorie">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nom">nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="nom" value="<?php echo strip_tags(!empty($categorie['nom']));?>">
                  </div>
                  

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
              </form>
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