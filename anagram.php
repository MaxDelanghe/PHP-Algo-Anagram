<?php
/*
count()
•strlen()

•print_r()
•microtime()
•round()
•trim()
*/
class anagram
{
  public $string = '';
  public $word = '';
  public $founded = 0;
  public $nbr = 0;
  public $handle = null;
  public $end = "\n\n";




  public function __construct($tab) {
    if (isset($tab[2])) { // il y a un nbr
      if ($tab[2] < 0 || $tab[2] > strlen($tab[1])) {
        echo "Veuillez entrer un nombre correct\n";
        exit();
      }
      elseif ($tab[2] == 1) {
        echo "\n";
        exit();
      }
      else {
        $this->nbr = $tab[2];
      }
    }
    $this->word = $tab[1];
    $this->wordexist();
  }

  public function wordexist() {
    $handle = fopen("anagram-master-dictionnaire.txt", "r");
    $string = '';
    $word = $this->word;

    if ($handle != NULL)
    {
      while ($string != 'zythums') {
        $caractereActuel = fgetc($handle); // On lit le caractère
        if ($caractereActuel != "\n") {
          $string .= $caractereActuel;
        }
        else {
          if ($string == $word) {
            $this->founded = 1;
          }
          //echo "$string"."\n";
          $string = "";
        }
      }
      fclose($handle); // On ferme le fichier qui a été ouvert
      if ($this->founded == 1) {
        $this->handle = fopen("anagram-master-dictionnaire.txt", "r");
        if ($this->nbr > 0) {
          $this->travel_nbr();
        }
        else {
          $this->travel();
        }
      }
      else {
        echo "\n";
        exit();
      }
    }
  }

  public function IswordOkTwo($need) {
    $size = strlen($this->word) - $this->nbr;
    $p = 0;
    $newWord = '';

    for ($p= 0; $p < $size ; $p++) {
      $newWord .= $this->word[$p];
    }
    if (strlen($newWord) != strlen($need)) {
      return(false);
    }
    $word = $newWord;
    $a = 0;
    $b = 0;
    $nbr = 0;
    $count_in_word = 0;
    $count_in_need = 0;
    $tested = '';
    while (isset($need[$a])) {
      $tested = $need[$a];
      while (isset($word[$b])) {
        if ($word[$b] == $tested) {
          $count_in_word++;
        }
        $b++;
      }
      $b = 0;
      while (isset($need[$b])) {
        if ($need[$b] == $tested) {
          $count_in_need++;
        }
        $b++;
      }
      if ($count_in_need != $count_in_word) {
        return(false);
      }
      $b = 0;
      $count_in_word = 0;
      $count_in_need = 0;
      $tested = '';
      $a++;
    }
    return(true);
  }

  public function travel_nbr() {
    $string = '';
    $caractereActuel = '9999';
    $count = 0;
    $stop = 0;
    if ($this->handle != NULL)
    {
      while ($caractereActuel != '') {
        $count++;
      /*  $stop++;
        if ($stop > 30) {
          exit;
          // code...
        }*/
        $caractereActuel = fgetc($this->handle); // On lit le caractère
        if ($caractereActuel != "\n" && $count <= ($this->nbr +1)) {
          $string .= $caractereActuel;
        }
        else {
        //  echo "\n test = > $string\n";
          $count = 0;
          $try = $this->IswordOkTwo($string);
          if ($try == true) { // le mot est ok
            echo "$string\n";
          }
          $try = false;
          $string = '';
            while ($caractereActuel != "\n") {
              //echo "$caractereActuel-";
              $caractereActuel = fgetc($this->handle);
            }
          //$this->finish($caractereActuel);
          $caractereActuel = '9999';
        }
      }
      fclose($this->handle); // On ferme le fichier qui a été ouvert
      exit();
    }
  }

  public function travel() {
    $stop = 0;
    $string = '';
    $caractereActuel = '9999';
    if ($this->handle != NULL)
    {
      while ($caractereActuel != '') {
        $stop++;
      /*  if ($stop > 100) {
          exit;
          // code...
        }*/
        $caractereActuel = fgetc($this->handle); // On lit le caractère
        if ($caractereActuel != "\n") {
        //  echo "$caractereActuel-";
          $string .= $caractereActuel;
        }
        else {
        //  echo "\n test = > $string\n";
          $try = $this->IswordOk($string);
          if ($try == true) { // le mot est ok
            echo "$string\n";
          }
          $string = '';
          $caractereActuel = '9999';
          //$this->finish($caractereActuel);
        }
      }
      fclose($this->handle); // On ferme le fichier qui a été ouvert
      exit();
    }
  }

  public function finish($caractereActuel){
    if ($caractereActuel == "\n") {
      return;
    }
    while ($caractereActuel != "\n") {
      $caractereActuel = fgetc($this->handle);
    }
    return;
  }

  public function IswordOk($need) {
    if (strlen($this->word) != strlen($need)) {
      return(false);
    }
    if ($this->word == $need) {
      return(false);
    }
    $word = $this->word;
    $a = 0;
    $b = 0;
    $nbr = 0;
    $count_in_word = 0;
    $count_in_need = 0;
    $tested = '';
    while (isset($need[$a])) {
      $tested = $need[$a];
      while (isset($word[$b])) {
        if ($word[$b] == $tested) {
          $count_in_word++;
        }
        $b++;
      }
      $b = 0;
      while (isset($need[$b])) {
        if ($need[$b] == $tested) {
          $count_in_need++;
        }
        $b++;
      }
      if ($count_in_need != $count_in_word) {
        return(false);
      }
      $b = 0;
      $count_in_word = 0;
      $count_in_need = 0;
      $tested = '';
      $a++;
    }
    return(true);
  }
}

$Game = new anagram($argv);
