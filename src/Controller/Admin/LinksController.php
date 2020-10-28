<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\Utility\Hash;

/**
 * Links Controller
 *
 * @property \App\Model\Table\LinksTable $Links
 *
 * @method \App\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LinksController extends AppController
{

    /**
     * Paging setting.
     */
    public $paginate = [
        'limit' => 20,
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $request = $this->getRequest()->getQueryParams();
        $this->set('params', $request);
        $query = $this->_getQuery($request);
        $links = $this->paginate($query);

        $this->set(compact('links'));
    }

    /**
     * ページネートに渡すクエリオブジェクトを生成する
     * @param array $request リクエスト情報
     * @return \Cake\ORM\Query $query
     */
    private function _getQuery($request)
    {
        $query = $this->Links->find();
        // ID
        if (isset($request['id']) && !is_null($request['id']) && $request['id'] !== '') {
            $query->where([$this->Links->aliasField('id') => $request['id']]);
        }
        // リンクカテゴリ
        if (isset($request['category']) && !is_null($request['category']) && $request['category'] !== '') {
            $query->where([$this->Links->aliasField('category') => $request['category']]);
        }
        // リンクタイトル
        if (isset($request['title']) && !is_null($request['title']) && $request['title'] !== '') {
            $query->where([$this->Links->aliasField('title LIKE') => "%{$request['title']}%"]);
        }
        // リンクURL
        if (isset($request['url']) && !is_null($request['url']) && $request['url'] !== '') {
            $query->where([$this->Links->aliasField('url LIKE') => "%{$request['url']}%"]);
        }
        // リンク説明
        if (isset($request['description']) && !is_null($request['description']) && $request['description'] !== '') {
            $query->where([$this->Links->aliasField('description LIKE') => "%{$request['description']}%"]);
        }
        // フリーワード
        if (isset($request['search_snippet']) && !is_null($request['search_snippet']) && $request['search_snippet'] !== '') {
            $search_snippet_conditions = [];
            foreach (explode(' ', str_replace('　', ' ', $request['search_snippet'])) as $search_snippet) {
                $search_snippet_conditions[] = [$this->Links->aliasField('search_snippet LIKE') => "%{$search_snippet}%"];
            }
            if (isset($request['search_snippet_format']) && $request['search_snippet_format'] == 'AND') {
                $query->where($search_snippet_conditions);
            } else {
                $query->where(function ($exp) use ($search_snippet_conditions) {
                    return $exp->or($search_snippet_conditions);
                });
            }
        }

        return $query;
    }

    /**
     * View method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $link = $this->Links->get($id);

        $this->set('link', $link);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null
     */
    public function add()
    {
        return $this->_form();
    }

    /**
     * Edit method
     *
     * @param string|null $id リンク集ID
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        return $this->_form($id);
    }

    /**
     * Add and Edit Common method
     *
     * @param string|null $id リンク集ID
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function _form($id = null)
    {
        if ($this->getRequest()->getParam('action') == 'edit') {
            $link = $this->Links->get($id);
        } else {
            $link = $this->Links->newEmptyEntity();
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $link = $this->Links->patchEntity($link, $this->getRequest()->getData());
            if (!$link->hasErrors()) {
                $conn = $this->Links->getConnection();
                $conn->begin();
                if ($this->Links->save($link, ['atomic' => false])) {
                    $conn->commit();
                    $this->Flash->success('リンク集の登録が完了しました。');

                    return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Links')]);
                }
                $conn->rollback();
            }
        }
        $this->set(compact('link'));
        $this->render('edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id リンク集ID
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $entity = $this->Links->get($id);
        if ($this->Links->delete($entity)) {
            $this->Flash->success('リンク集の削除が完了しました。');
        } else {
            $this->Flash->error('エラーが発生しました。');
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Links')]);
    }

    /**
     * csv export method
     * @return void
     */
    public function csvExport()
    {
        $request = $this->getRequest()->getQueryParams();
        $links = $this->_getQuery($request)->toArray();
        $_serialize = 'links';
        $_header = $this->Links->getCsvHeaders();
        $_extract = [
            // ID
            'id',
            // リンクカテゴリ
            function ($row) {
                if (!empty($row['category'])) {
                    return _code('Codes.Links.category.' . $row['category']);
                }

                return "";
            },
            // リンクタイトル
            'title',
            // リンクURL
            'url',
            // リンク説明
            'description',
            // 作成日時
            function ($row) {
                if ($row['created'] instanceof FrozenTime) {
                    return @$row['created']->i18nFormat('yyyy-MM-dd HH:mm:ss');
                }

                return "";
            },
            // 更新日時
            function ($row) {
                if ($row['modified'] instanceof FrozenTime) {
                    return @$row['modified']->i18nFormat('yyyy-MM-dd HH:mm:ss');
                }

                return "";
            },
        ];

        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('Asia/Tokyo'));

        $_csvEncoding = 'UTF-8';
        $this->response = $this->response->withDownload("links-{$datetime->format('YmdHis')}.csv");
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->set(compact('links', '_serialize', '_header', '_extract', '_csvEncoding'));
    }
}
