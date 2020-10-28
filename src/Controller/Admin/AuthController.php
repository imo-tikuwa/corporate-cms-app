<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Event\EventInterface;

/**
 * Auth Controller
 *
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 */
class AuthController extends AppController
{
    /**
     *
     * {@inheritDoc}
     * @see \Cake\Controller\Controller::beforeFilter()
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        // ログインアクションを認証を必要としないように設定することで、
        // 無限リダイレクトループの問題を防ぐことができます
        $this->Authentication->addUnauthenticatedActions(['login']);

        // ログイン画面はレイアウトを使用しない
        $this->viewBuilder()->disableAutoLayout();
    }

    /**
     * ログイン
     * @return \Cake\Http\Response|null
     */
    public function login()
    {
        $this->getRequest()->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // POSTやGETに関係なく、ユーザーがログインしていればリダイレクトします
        if ($result->isValid()) {
            $redirect = $this->getRequest()->getQuery('redirect', [
                'controller' => 'Top',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }
        // ユーザーの送信と認証に失敗した場合にエラーを表示します
        if ($this->getRequest()->is('post') && !$result->isValid()) {
            $this->Flash->error('ログインIDかパスワードが正しくありません。');
        }
    }

    /**
     * ログアウト
     * @return \Cake\Http\Response|NULL
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        // POSTやGETに関係なく、ユーザーがログインしていればリダイレクトします
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['action' => 'login']);
        }
    }
}
