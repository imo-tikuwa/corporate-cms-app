<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

/**
 * AccessMaps Controller
 *
 * @property \App\Model\Table\AccessMapsTable $AccessMaps
 */
class AccessMapsController extends AppController
{
    /**
     * Edit method
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit()
    {
        $access_map = $this->AccessMaps->find()->where([$this->AccessMaps->aliasField('id') => 1])->first();
        if (empty($access_map)) {
            $access_map = $this->AccessMaps->newEmptyEntity();
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $access_map = $this->AccessMaps->patchEntity($access_map, $this->getRequest()->getData());
            if ($access_map->hasErrors()) {
                $this->Flash->set(implode('<br />', $access_map->getErrorMessages()), [
                    'escape' => false,
                    'element' => 'validation_error',
                ]);
            } else {
                $conn = $this->AccessMaps->getConnection();
                $conn->begin();
                if ($this->AccessMaps->save($access_map, ['atomic' => false])) {
                    $conn->commit();
                    $this->Flash->success('アクセスマップの登録が完了しました。');

                    return $this->redirect(['action' => 'edit']);
                }
                $conn->rollback();
            }
        }
        $this->set(compact('access_map'));
        $this->render('edit');
    }
}
