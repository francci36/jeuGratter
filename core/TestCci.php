<?php
use PHPUnit\Framework\TestCase;
//classe avec héritage d test case pour effectuer des testes unitaires


class TestCci extends TestCase
{
    public $nom;
    public $prenom;
    public $email;

    public function __construct($nom,$prenom,$email)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
    }
   
    public function testStagiaire()
    {
// Test pour une note inférieur à 10
        $note = 5;
        $result = $this->stagiaire($note);
        $this->assertEquals("Vous n'avez pas la moyenne",$result);
        // Test pour les notes suprérieur à 10
        $note = 10;
        $result = $this->stagiaire($note);
        $this->assertEquals('Vous avez la moyenne',$result);

        if($note < 10)
        {
            return "Vous n'avez la moyenne";
        }
        else
        {
            return "Vous avez la moyenne";
        }
        // on fait nos testes
        // assertTrue : verifie que la condition passé en paramètre est vrai
        //$this->assertTrue(true);
        // assertFalse : vérifie que la condition passée en paramètre est fausse
       // $this->assertFalse('test');
        //assertEquals : Vérifie que les deux paramètre sont bien égaux
        //$this->assertEquals(10,10);
        // assertNotEquals : vérifie que les 2  paramètres ne sont pas égaux
        //$this->assertNotEquals(10,10);
        // assertSame : vérifie que les 2 objets passsés en paramètres sont les mêmes objets
        //$this->assertSame($objet1,$objet2);
        // assertNotSame : vérifie que les deux objets passés en paramètres ne sont pas identiques
        //$this->assertNotSame($objet1,$objet2);
        // on va verifier si la valeur passer en paramètre est null assertNull
        //$this->assertNull($note);
        // assertNotNull
        //./tools$this->assertNotNull($note);

    }
    private function stagiaire($note)
    {
        if($note < 10)
        {
            return "Vous n'avez pas la moyenne";
        }
        else
        {
            return "Vous avez la moyenne";
        }
    }
    public function testValeur()
    {
        // Teste si la valeur vaut true
        $valeur = true;
        $resultat = $this->valeur($valeur);
        $this->assertNull($resultat);
        $this->assertNotNull($resultat);
    }
    private function valeur($val)
    {
        if($val)
        {
            return 'ok';
        }
        else
        {
            return null;
        }
    }
    public static function compare($objet1,$objet2)
    {
        // pour verifier si les deux parametre sont egaux
        //TestCci::assertNotEquals($objet1->nom,$objet2->nom,"nom pas identique");
        TestCci::assertSame($objet1,$objet2,"objet pas identique");
        TestCci::assertNotSame($objet1,$objet2,"Ce n'est pas les mêmes !");
        
    }
}
$nom1 = 'Larregain';
$prenom1 = 'Joseph';
$email1 = 'joseph.larregain@gmail.com';
$nom2 = 'Larregain';
$prenom2 = 'Gérald';
$email2 = "gerald.leger@taillegrain.fr";
$user1 = new TestCci($nom1,$prenom1,$email1);
$user2= new TestCci($nom2,$prenom2,$email2);
TestCci::compare($user1,$user2);