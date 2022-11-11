<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class PalindromeModel extends Model
{
    public string $palindrome = '';
    public array $palindromeArr;
    public array $palindromeArrRev;
    public array $status = [];

    public function rules(): array
    {
        return [
            'palindrome' => [self::RULE_REQUIRED, self::RULE_PALINDROME]
        ];
    }
    public function palindromeRules(): array
    {
        return [
            'palindrome' => [self::RULE_REQUIRED, self::RULE_PALINDROME]
        ];
    }

    public function statusMessages(): array
    {
        return [
            true => ['success', 'This is a palindrome!'],
            false => []
        ];
    }

    public function isPalindrome()
    {
        $palindromeLen = strlen($this->palindrome) / 2;
        $this->palindromeArr = str_split($this->palindrome);
        $this->palindromeArrRev = array_reverse($this->palindromeArr);

        for ($i = 0; $i < $palindromeLen; $i++) {
            if ($this->palindromeArr[$i] !== $this->palindromeArrRev[$i]) {
                return  false;
            }
        }
        return true;
    }
}
