<?php
include 'variable.php';
class Randomizer {
    private $vowels = ['a', 'i', 'u', 'e', 'o'];
    private $consonants = ['b','c','d','f','g','h','j','k','l','m','n','p','r','s','t'];
    private $domains;
    public function __construct($count) {
        $this->count = $count;
    }

    private function randVowel() {
        return $this->vowels[array_rand($this->vowels, 1)];
    }

    public function randConsonant() {
        return $this->consonants[array_rand($this->consonants, 1)];
    }

    public function generateName() {
        return $this->randConsonant() . "" . $this->randVowel() . "" . $this->randConsonant() . "" . $this->randVowel() . "" . $this->randVowel() . " " . $this->randConsonant() . "" . $this->randVowel() . "" . $this->randConsonant() . "" . $this->randVowel() . "" . $this->randConsonant() . "" . $this->randVowel();
    }

    public function randUsername() {
        return $this->randConsonant() . "" . $this->randVowel() . "" . $this->randConsonant() . "" . $this->randVowel() . "" . $this->randVowel() . "" . $this->randConsonant() . "" . $this->randVowel() . "" . $this->randConsonant();
    }

    public function randString($length) {
         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($characters);
         $randomString = '';
         for ($i = 0; $i < $length; $i++) {
             $randomString .= $characters[rand(0, $charactersLength - 1)];
         }
         return $randomString;
    }

    public function randEmail() {
        $email = $this->randUsername() . "@" . $GLOBALS['domains'][array_rand($GLOBALS['domains'], 1)];
        return $email;
    }

    public function randPhoneNumber() {
        $number = 08;
        for ($i = 0; $i < 10; $i++) {
            $number = $number . rand(0,9);
        }
        return $number;
    }
}
 ?>
