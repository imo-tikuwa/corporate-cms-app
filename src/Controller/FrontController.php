<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
use App\Form\FrontContactForm;
use Cake\Event\EventInterface;

/**
 * Front Controller
 *
 * @property \App\Model\Table\ChargesTable $Charges
 * @property \App\Model\Table\StaffsTable $Staffs
 * @property \App\Model\Table\AccessMapsTable $AccessMaps
 * @property \App\Model\Table\LinksTable $Links
 * @property \App\Model\Table\ContactsTable $Contacts
 *
 * @method \App\Model\Entity\Front[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FrontController extends AppController
{
    /**
     *
     * {@inheritDoc}
     * @see \Cake\Controller\Controller::beforeFilter()
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('front');
    }

    /**
     * トップページ index action
     * @return void
     */
    public function index()
    {
    }

    /**
     * メニュー・料金 menu action
     * @return void
     */
    public function menu()
    {
        $this->loadModel('Charges');
        $charges = $this->Charges->find()->contain(['ChargeDetails'])->order(['id' => 'ASC'])->toArray();
        $this->set(compact('charges'));
    }

    /**
     * ギャラリー works action
     * @return void
     */
    public function works()
    {
    }

    /**
     * スタッフのご紹介 staff action
     * @return void
     */
    public function staff()
    {
        $this->loadModel('Staffs');
        $staffs = $this->Staffs->find()->order(['staff_position' => 'ASC'])->toArray();
        $this->set(compact('staffs'));
    }

    /**
     * 店舗のご案内 shop action
     * @return void
     */
    public function shop()
    {
    }

    /**
     * アクセスマップ access action
     * @return void
     */
    public function access()
    {
        $this->loadModel('AccessMaps');
        $access_map = $this->AccessMaps->get(1);
        $this->set(compact('access_map'));
    }

    /**
     * リンク集 link action
     * @return void
     */
    public function link()
    {
        $this->loadModel('Links');
        $links = $this->Links->find()->order(['category' => 'ASC'])->toArray();

        $shop_links = Hash::extract($links, '{n}[category=01]');
        $other_links = Hash::extract($links, '{n}[category=02]');
        $this->set(compact('shop_links', 'other_links'));
    }

    /**
     * サイトマップ sitemap action
     * @return void
     */
    public function sitemap()
    {
        $this->viewBuilder()->disableAutoLayout();
    }

    /**
     * 採用情報 recruit action
     * @return void
     */
    public function recruit()
    {
    }

    /**
     * お問い合わせ contact action
     * @return \Cake\Http\Response|void
     */
    public function contact()
    {
        $token_name = 'FRONT_CONTACT_TOKEN';
        $this->loadModel('Contacts');
        $form = new FrontContactForm();
        if ($this->request->is('post')) {
            // 確認画面から戻る
            if ('return' == $this->request->getData('mode')) {
                $this->set(compact('form'));
                return;
            }

            // バリデーションチェック
            $form_values = $this->request->getData();
            if (!$form->validate($form_values)) {
                $this->set(compact('form'));
                return;
            }

            if ('input' == $this->request->getData('mode')) {
                // 確認画面表示処理
                $token = create_random_str(32);
                $this->request->getSession()->write($token_name, $token);
                $this->set(compact('form', 'form_values', 'token'));
                $this->render('contact_confirm');
                return;
            } elseif ('confirm' == $this->request->getData('mode')) {
                // 完了画面表示処理

                // トークンチェック
                $session_token = $this->request->getSession()->consume($token_name);
                $request_token = $this->request->getData('token');
                if (is_null($session_token) || empty($session_token) || $session_token !== $request_token) {
                    $this->Flash->error('トークンエラーが発生しました。');
                    return $this->redirect(['controller' => 'Front', 'action' => 'contact']);
                }

                // 保存
                $request = $this->request->getData();
                $contact = $this->Contacts->patchEntity($this->Contacts->newEmptyEntity(), [
                    'name' => $request['content1'],
                    'email' => $request['content2'],
                    'type' => $request['content3'],
                    'tel' => @$request['content4'],
                    'content' => $request['content5'],
                    'hp_url' => @$request['content6'],
                ]);
                $result = $this->Contacts->save($contact);
                $this->render('contact_complete');
                return;
            }
        }
        $this->set(compact('form'));
    }
}
