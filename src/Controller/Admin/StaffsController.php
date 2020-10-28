<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\Utility\Hash;

/**
 * Staffs Controller
 *
 * @property \App\Model\Table\StaffsTable $Staffs
 *
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StaffsController extends AppController
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
        $staffs = $this->paginate($query);

        $this->set(compact('staffs'));
    }

    /**
     * ページネートに渡すクエリオブジェクトを生成する
     * @param array $request リクエスト情報
     * @return \Cake\ORM\Query $query
     */
    private function _getQuery($request)
    {
        $query = $this->Staffs->find();
        // ID
        if (isset($request['id']) && !is_null($request['id']) && $request['id'] !== '') {
            $query->where([$this->Staffs->aliasField('id') => $request['id']]);
        }
        // スタッフ名
        if (isset($request['name']) && !is_null($request['name']) && $request['name'] !== '') {
            $query->where([$this->Staffs->aliasField('name LIKE') => "%{$request['name']}%"]);
        }
        // スタッフ名(英)
        if (isset($request['name_en']) && !is_null($request['name_en']) && $request['name_en'] !== '') {
            $query->where([$this->Staffs->aliasField('name_en LIKE') => "%{$request['name_en']}%"]);
        }
        // スタッフ役職
        if (isset($request['staff_position']) && !is_null($request['staff_position']) && $request['staff_position'] !== '') {
            $query->where([$this->Staffs->aliasField('staff_position') => $request['staff_position']]);
        }
        // 画像表示位置
        if (isset($request['photo_position']) && !is_null($request['photo_position']) && $request['photo_position'] !== '') {
            $query->where([$this->Staffs->aliasField('photo_position') => $request['photo_position']]);
        }
        // スタッフ説明1
        if (isset($request['description1']) && !is_null($request['description1']) && $request['description1'] !== '') {
            $query->where([$this->Staffs->aliasField('description1') => $request['description1']]);
        }
        // 見出し1
        if (isset($request['midashi1']) && !is_null($request['midashi1']) && $request['midashi1'] !== '') {
            $query->where([$this->Staffs->aliasField('midashi1 LIKE') => "%{$request['midashi1']}%"]);
        }
        // スタッフ説明2
        if (isset($request['description2']) && !is_null($request['description2']) && $request['description2'] !== '') {
            $query->where([$this->Staffs->aliasField('description2') => $request['description2']]);
        }
        // フリーワード
        if (isset($request['search_snippet']) && !is_null($request['search_snippet']) && $request['search_snippet'] !== '') {
            $search_snippet_conditions = [];
            foreach (explode(' ', str_replace('　', ' ', $request['search_snippet'])) as $search_snippet) {
                $search_snippet_conditions[] = [$this->Staffs->aliasField('search_snippet LIKE') => "%{$search_snippet}%"];
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
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $staff = $this->Staffs->get($id);

        $this->set('staff', $staff);
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
     * @param string|null $id スタッフID
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
     * @param string|null $id スタッフID
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function _form($id = null)
    {
        if ($this->getRequest()->getParam('action') == 'edit') {
            $staff = $this->Staffs->get($id);
        } else {
            $staff = $this->Staffs->newEmptyEntity();
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $staff = $this->Staffs->patchEntity($staff, $this->getRequest()->getData());
            if (!$staff->hasErrors()) {
                $conn = $this->Staffs->getConnection();
                $conn->begin();
                if ($this->Staffs->save($staff, ['atomic' => false])) {
                    $conn->commit();
                    $this->Flash->success('スタッフの登録が完了しました。');

                    return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Staffs')]);
                }
                $conn->rollback();
            }
        }
        $this->set(compact('staff'));
        $this->render('edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id スタッフID
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $entity = $this->Staffs->get($id);
        if ($this->Staffs->delete($entity)) {
            $this->Flash->success('スタッフの削除が完了しました。');
        } else {
            $this->Flash->error('エラーが発生しました。');
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Staffs')]);
    }

    /**
     * csv export method
     * @return void
     */
    public function csvExport()
    {
        $request = $this->getRequest()->getQueryParams();
        $staffs = $this->_getQuery($request)->toArray();
        $_serialize = 'staffs';
        $_header = $this->Staffs->getCsvHeaders();
        $_extract = [
            // ID
            'id',
            // スタッフ名
            'name',
            // スタッフ名(英)
            'name_en',
            // スタッフ役職
            function ($row) {
                if (!empty($row['staff_position'])) {
                    return _code('Codes.Staffs.staff_position.' . $row['staff_position']);
                }

                return "";
            },
            // 画像表示位置
            function ($row) {
                if (!empty($row['photo_position'])) {
                    return _code('Codes.Staffs.photo_position.' . $row['photo_position']);
                }

                return "";
            },
            // スタッフ説明1
            'description1',
            // 見出し1
            'midashi1',
            // スタッフ説明2
            'description2',
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
        $this->response = $this->response->withDownload("staffs-{$datetime->format('YmdHis')}.csv");
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->set(compact('staffs', '_serialize', '_header', '_extract', '_csvEncoding'));
    }
}
