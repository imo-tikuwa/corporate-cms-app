<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\Utility\Hash;

/**
 * ChargeRelations Controller
 *
 * @property \App\Model\Table\ChargeRelationsTable $ChargeRelations
 *
 * @method \App\Model\Entity\ChargeRelation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChargeRelationsController extends AppController
{

    /**
     * Initialize Method.
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        if (!in_array($this->getRequest()->getParam('action'), ['delete', 'csvExport'], true)) {
            // 基本料金IDの選択肢
            $this->set('charges', $this->ChargeRelations->findForeignSelectionData('Charges', 'name', true));
            // 料金マスタIDの選択肢
            $this->set('chargeMasters', $this->ChargeRelations->findForeignSelectionData('ChargeMasters', 'name', true));
        }
    }

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
        $charge_relations = $this->paginate($query);

        $this->set(compact('charge_relations'));
    }

    /**
     * ページネートに渡すクエリオブジェクトを生成する
     * @param array $request リクエスト情報
     * @return \Cake\ORM\Query $query
     */
    private function _getQuery($request)
    {
        $query = $this->ChargeRelations->find();
        // ID
        if (isset($request['id']) && !is_null($request['id']) && $request['id'] !== '') {
            $query->where([$this->ChargeRelations->aliasField('id') => $request['id']]);
        }
        // 基本料金ID
        if (isset($request['charge_id']) && !is_null($request['charge_id']) && $request['charge_id'] !== '') {
            $query->where(['Charges.id' => $request['charge_id']]);
        }
        // 料金マスタID
        if (isset($request['charge_master_id']) && !is_null($request['charge_master_id']) && $request['charge_master_id'] !== '') {
            $query->where(['ChargeMasters.id' => $request['charge_master_id']]);
        }
        // フリーワード
        if (isset($request['search_snippet']) && !is_null($request['search_snippet']) && $request['search_snippet'] !== '') {
            $search_snippet_conditions = [];
            foreach (explode(' ', str_replace('　', ' ', $request['search_snippet'])) as $search_snippet) {
                $search_snippet_conditions[] = [$this->ChargeRelations->aliasField('search_snippet LIKE') => "%{$search_snippet}%"];
            }
            if (isset($request['search_snippet_format']) && $request['search_snippet_format'] == 'AND') {
                $query->where($search_snippet_conditions);
            } else {
                $query->where(function ($exp) use ($search_snippet_conditions) {
                    return $exp->or($search_snippet_conditions);
                });
            }
        }
        $query->group('ChargeRelations.id');

        return $query->contain(['Charges', 'ChargeMasters']);
    }

    /**
     * View method
     *
     * @param string|null $id Charge Relation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chargeRelation = $this->ChargeRelations->get($id, ['contain' => ['Charges', 'ChargeMasters']]);

        $this->set('chargeRelation', $chargeRelation);
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
     * @param string|null $id 料金マッピングID
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
     * @param string|null $id 料金マッピングID
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function _form($id = null)
    {
        if ($this->getRequest()->getParam('action') == 'edit') {
            $charge_relation = $this->ChargeRelations->get($id);
        } else {
            $charge_relation = $this->ChargeRelations->newEmptyEntity();
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $charge_relation = $this->ChargeRelations->patchEntity($charge_relation, $this->getRequest()->getData(), ['associated' => ['Charges', 'ChargeMasters']]);
            if (!$charge_relation->hasErrors()) {
                $conn = $this->ChargeRelations->getConnection();
                $conn->begin();
                if ($this->ChargeRelations->save($charge_relation, ['atomic' => false])) {
                    $conn->commit();
                    $this->Flash->success('料金マッピングの登録が完了しました。');

                    return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.ChargeRelations')]);
                }
                $conn->rollback();
            }
        }
        $this->set(compact('charge_relation'));
        $this->render('edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id 料金マッピングID
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $entity = $this->ChargeRelations->get($id);
        if ($this->ChargeRelations->delete($entity)) {
            $this->Flash->success('料金マッピングの削除が完了しました。');
        } else {
            $this->Flash->error('エラーが発生しました。');
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.ChargeRelations')]);
    }

    /**
     * csv export method
     * @return void
     */
    public function csvExport()
    {
        $request = $this->getRequest()->getQueryParams();
        $charge_relations = $this->_getQuery($request)->toArray();
        $_serialize = 'charge_relations';
        $_header = $this->ChargeRelations->getCsvHeaders();
        $_extract = [
            // ID
            'id',
            // 基本料金ID
            function ($row) {
                return @$row['charge']['name'];
            },
            // 料金マスタID
            function ($row) {
                return @$row['charge_master']['name'];
            },
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
        $this->response = $this->response->withDownload("charge_relations-{$datetime->format('YmdHis')}.csv");
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->set(compact('charge_relations', '_serialize', '_header', '_extract', '_csvEncoding'));
    }
}
