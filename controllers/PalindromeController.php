<?php

namespace app\controllers;

use app\core\Request;
use app\models\PalindromeModel;

class PalindromeController extends Controller
{
    protected $params = [];
    public bool $isPalindrome = false;

    public function palindrome(Request $request)
    {
        $this->setLayout('admin_main');
        $palindromeModel = new PalindromeModel();

        if ($request->isPost()) {
            $palindromeModel->loadData($request->getBody());

            if ($palindromeModel->validate() && $palindromeModel->isPalindrome()) {
                $this->isPalindrome = true;
            }
            $status = $palindromeModel->statusMessages();
            $palindromeModel->status = $status[$this->isPalindrome];
            return $this->render(
                'palindrome',
                [
                'model' => $palindromeModel,
                'isPalindrome' => $this->isPalindrome
                ]
            );
        }

        return $this->render(
            'palindrome',
            [
            'model' => $palindromeModel,
            'isPalindrome' => $this->isPalindrome
            ]
        );
    }
}
