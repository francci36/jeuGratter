<?php
exit;
require_once('../config.php');
$sql = " CREATE TABLE IF NOT EXISTS `table_admin`
( 
`admin_id` INT(10) NOT NULL AUTO_INCREMENT,
`admin_email` VARCHAR(150) COLLATE utf8_general_ci NOT NULL,
`admin_password` VARCHAR(200) COLLATE utf8_general_ci NOT NULL,
`admin_date` DATETIME NOT NULL,
`admin_update` DATETIME NOT NULL,
PRIMARY KEY(`admin_id`)
)";
// on execute la requette
$db->exec($sql);
echo 'Database table_admin créee <br/>';
$admin = $db->prepare('INSERT INTO `table_admin` SET
admin_email = :email,
admin_password = :password,
admin_date = NOW(),
admin_update = NOW()

');
$admin->bindValue(':email','francci36@gmail.com',PDO::PARAM_STR);
$admin->bindValue(':password',sha1(md5('cci1800')),PDO::PARAM_STR);
$admin->execute();
echo'ulisiateur crée avec succès <br/>';
?>
