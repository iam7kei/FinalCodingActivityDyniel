<?php

namespace app\controllers;

use app\core\Application;
use app\core\elements\Card;
use app\core\Request;
use app\core\Response;
use app\core\Session;
use app\models\catalog\products\CommentsModel;

class CommentController extends Controller
{
    public function comment(Request $request, Response $response)
    {
        $commentModel = new CommentsModel();
        $primaryKey = $commentModel->getPrimaryKey();
        $productId = $request->getLastSlug();

        if ($request->isPost()) {
            $commentModel->loadData($request->getBody());
            $generateData = $commentModel->generateCommentData($productId);
            $commentModel->loadGeneratedData($generateData);

            if ($commentModel->validate('addRules') && $commentModel->save()) {
                Application::$app->session->setFlashMessage(
                    'success',
                    'Successfully added comment.'
                );
                Application::$app->response->redirect('/products/' . $productId);
            }

            Application::$app->response->redirect('/products/' . $productId);
        }
    }

    public function renderComments(array $comments)
    {
        foreach ($comments as $comment => $commentData) {
            $commentData['info'] = $commentData['email'] . " - " . $commentData['comment_date'];
            echo Card::renderCard(self::getCommentKeys(), $commentData);
        }
    }

    public function getCommentKeys(): array
    {
        return [
            'subject',
            'info',
            'comment',
        ];
    }
}
