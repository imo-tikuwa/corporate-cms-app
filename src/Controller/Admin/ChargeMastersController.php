<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use App\Form\SearchForm;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\Utility\Hash;

/**
 * ChargeMasters Controller
 *
 * @property \App\Model\Table\ChargeMastersTable $ChargeMasters
 *
 * @method \App\Model\Entity\ChargeMaster[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChargeMastersController extends AppController
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
        $query = $this->_getQuery($request);
        $charge_masters = $this->paginate($query);
        $search_form = new SearchForm();
        $search_form->setData($request);

        $this->set(compact('charge_masters', 'search_form'));
    }

    /**
     * ページネートに渡すクエリオブジェクトを生成する
     * @param array $request リクエスト情報
     * @return \Cake\ORM\Query $query
     */
    private function _getQuery($request)
    {
        $query = $this->ChargeMasters->find();
        // ID
        if (isset($request['id']) && !is_null($request['id']) && $request['id'] !== '') {
            $query->where([$this->ChargeMasters->aliasField('id') => $request['id']]);
        }
        // マスタ名
        if (isset($request['name']) && !is_null($request['name']) && $request['name'] !== '') {
            $query->where([$this->ChargeMasters->aliasField('name LIKE') => "%{$request['name']}%"]);
        }
        // 基本料金
        if (isset($request['basic_charge']) && !is_null($request['basic_charge']) && $request['basic_charge'] !== '') {
            $query->where([$this->ChargeMasters->aliasField('basic_charge <=') => $request['basic_charge']]);
        }
        // キャンペーン料金
        if (isset($request['campaign_charge']) && !is_null($request['campaign_charge']) && $request['campaign_charge'] !== '') {
            $query->where([$this->ChargeMasters->aliasField('campaign_charge <=') => $request['campaign_charge']]);
        }
        // フリーワード
        if (isset($request['search_snippet']) && !is_null($request['search_snippet']) && $request['search_snippet'] !== '') {
            $search_snippet_conditions = [];
            foreach (explode(' ', str_replace('　', ' ', $request['search_snippet'])) as $search_snippet) {
                $search_snippet_conditions[] = [$this->ChargeMasters->aliasField('search_snippet LIKE') => "%{$search_snippet}%"];
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
     * @param string|null $id Charge Master id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $charge_master = $this->ChargeMasters->get($id);

        $this->set('charge_master', $charge_master);
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
     * @param string|null $id 料金マスタID
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
     * @param string|null $id 料金マスタID
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function _form($id = null)
    {
        if ($this->getRequest()->getParam('action') == 'edit') {
            $charge_master = $this->ChargeMasters->get($id);
            $this->ChargeMasters->touch($charge_master);
        } else {
            $charge_master = $this->ChargeMasters->newEmptyEntity();
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $charge_master = $this->ChargeMasters->patchEntity($charge_master, $this->getRequest()->getData(), ['associated' => ['ChargeRelations']]);
            if ($charge_master->hasErrors()) {
                $this->Flash->set(implode('<br />', $charge_master->getErrorMessages()), [
                    'escape' => false,
                    'element' => 'validation_error',
                ]);
            } else {
                $conn = $this->ChargeMasters->getConnection();
                $conn->begin();
                if ($this->ChargeMasters->save($charge_master, ['atomic' => false])) {
                    $conn->commit();
                    $this->Flash->success('料金マスタの登録が完了しました。');

                    return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.ChargeMasters')]);
                }
                $conn->rollback();
            }
        }
        $this->set(compact('charge_master'));
        $this->render('edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id 料金マスタID
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $entity = $this->ChargeMasters->get($id);
        if ($this->ChargeMasters->delete($entity)) {
            $this->Flash->success('料金マスタの削除が完了しました。');
        } else {
            $this->Flash->error('エラーが発生しました。');
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.ChargeMasters')]);
    }

    /**
     * csv export method
     * @return void
     */
    public function csvExport()
    {
        $request = $this->getRequest()->getQueryParams();
        $charge_masters = $this->_getQuery($request)->toArray();
        $_extract = [
            // ID
            'id',
            // マスタ名
            'name',
            // 基本料金
            function ($row) {
                if (!empty($row['basic_charge'])) {
                    return $row['basic_charge'] . "円";
                }

                return "";
            },
            // キャンペーン料金
            function ($row) {
                if (!empty($row['campaign_charge'])) {
                    return $row['campaign_charge'] . "円";
                }

                return "";
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

        $this->response = $this->response->withDownload("charge_masters-{$datetime->format('YmdHis')}.csv");
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->viewBuilder()->setOptions([
            'serialize' => 'charge_masters',
            'header' => $this->ChargeMasters->getCsvHeaders(),
            'extract' => $_extract,
            'csvEncoding' => 'UTF-8'
        ]);
        $this->set(compact('charge_masters'));
    }
}
