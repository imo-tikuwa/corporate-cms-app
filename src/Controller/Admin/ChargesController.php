<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\Utility\Hash;

/**
 * Charges Controller
 *
 * @property \App\Model\Table\ChargesTable $Charges
 *
 * @method \App\Model\Entity\Charge[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChargesController extends AppController
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
        $charges = $this->paginate($query);

        $this->set(compact('charges'));
    }

    /**
     * ページネートに渡すクエリオブジェクトを生成する
     * @param array $request リクエスト情報
     * @return \Cake\ORM\Query $query
     */
    private function _getQuery($request)
    {
        $query = $this->Charges->find();
        // ID
        if (isset($request['id']) && !is_null($request['id']) && $request['id'] !== '') {
            $query->where([$this->Charges->aliasField('id') => $request['id']]);
        }
        // プラン名
        if (isset($request['name']) && !is_null($request['name']) && $request['name'] !== '') {
            $query->where([$this->Charges->aliasField('name LIKE') => "%{$request['name']}%"]);
        }
        // プラン名下注釈
        if (isset($request['annotation']) && !is_null($request['annotation']) && $request['annotation'] !== '') {
            $query->where([$this->Charges->aliasField('annotation LIKE') => "%{$request['annotation']}%"]);
        }
        // フリーワード
        if (isset($request['search_snippet']) && !is_null($request['search_snippet']) && $request['search_snippet'] !== '') {
            $search_snippet_conditions = [];
            foreach (explode(' ', str_replace('　', ' ', $request['search_snippet'])) as $search_snippet) {
                $search_snippet_conditions[] = [$this->Charges->aliasField('search_snippet LIKE') => "%{$search_snippet}%"];
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
     * @param string|null $id Charge id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $charge = $this->Charges->get($id);

        $this->set('charge', $charge);
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
     * @param string|null $id 基本料金ID
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
     * @param string|null $id 基本料金ID
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function _form($id = null)
    {
        if ($this->getRequest()->getParam('action') == 'edit') {
            $charge = $this->Charges->get($id);
        } else {
            $charge = $this->Charges->newEmptyEntity();
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $charge = $this->Charges->patchEntity($charge, $this->getRequest()->getData(), ['associated' => ['ChargeRelations']]);
            if (!$charge->hasErrors()) {
                $conn = $this->Charges->getConnection();
                $conn->begin();
                if ($this->Charges->save($charge, ['atomic' => false])) {
                    $conn->commit();
                    $this->Flash->success('基本料金の登録が完了しました。');

                    return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Charges')]);
                }
                $conn->rollback();
            }
        }
        $this->set(compact('charge'));
        $this->render('edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id 基本料金ID
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $entity = $this->Charges->get($id);
        if ($this->Charges->delete($entity)) {
            $this->Flash->success('基本料金の削除が完了しました。');
        } else {
            $this->Flash->error('エラーが発生しました。');
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Charges')]);
    }

    /**
     * csv export method
     * @return void
     */
    public function csvExport()
    {
        $request = $this->getRequest()->getQueryParams();
        $charges = $this->_getQuery($request)->toArray();
        $_serialize = 'charges';
        $_header = $this->Charges->getCsvHeaders();
        $_extract = [
            // ID
            'id',
            // プラン名
            'name',
            // プラン名下注釈
            'annotation',
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
        $this->response = $this->response->withDownload("charges-{$datetime->format('YmdHis')}.csv");
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->set(compact('charges', '_serialize', '_header', '_extract', '_csvEncoding'));
    }
}
