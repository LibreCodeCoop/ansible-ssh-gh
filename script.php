<?php


// Required run this command with sudo
$users = array('enieber', 'vitormattos');
$FILE_TO_USE = '/root/.ssh/authorized_keys';

if (file_exists($FILE_TO_USE)) {
  $file = fopen($FILE_TO_USE, 'a');
  addUserKey($file, $users);
} else {
  $file = fopen($FILE_TO_USE, 'w');
  addUserKey($file, $users);
}

function addUserKey($file, $users) {
  foreach ($users as &$user) {
    $retorno = getKeyFromUser($user);
    echo "# add keys of $user\n";
    fwrite($file, $retorno);
  }

  fclose($file);
}

function getKeyFromUser($user) {
  $cr = curl_init();
 
  curl_setopt($cr, CURLOPT_URL, "https://github.com/$user.keys");
 
  curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
 
  $retorno = curl_exec($cr);
 
  curl_close($cr);
  return $retorno;
}
