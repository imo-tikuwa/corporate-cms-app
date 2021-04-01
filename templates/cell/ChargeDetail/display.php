<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChargeDetail $charge_detail
 */
?>
        <div class="charge-detail-row" data-prefix="<?= $id_prefix ?>">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="form-group">
                <?= $this->element('Parts/label', ['field' => "{$id_prefix}-charge-detail-name", 'label' => '料金名', 'require' => true, 'class' => 'item-label col-form-label']); ?>
                <?= $this->Form->control("charge_details.{$append_index}.name", [
                  'type' => 'text',
                  'id' => "{$id_prefix}-charge-detail-name",
                  'class' => 'form-control rounded-0 ',
                  'label' => false,
                  'required' => false,
                  'error' => false,
                  'maxlength' => '20',
                  'value' => $charge_detail->name
                ]); ?>
              </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-12">
              <div class="form-group">
                <?= $this->element('Parts/label', ['field' => "{$id_prefix}-charge-detail-basic_charge", 'label' => '基本料金', 'require' => true, 'class' => 'item-label col-form-label']); ?>
                <div class="input number">
                  <div class="input-group">
                    <?= $this->Form->text("charge_details.{$append_index}.basic_charge", [
                      'type' => 'number',
                      'id' => "{$id_prefix}-charge-detail-basic_charge",
                      'class' => 'form-control rounded-0',
                      'label' => false,
                      'min' => '0',
                      'max' => '99900',
                      'step' => '50',
                      'required' => false,
                      'error' => false,
                      'value' => $charge_detail->basic_charge
                    ]); ?>
                    <div class="input-group-append"><span class="input-group-text rounded-0">円</span></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-12">
              <div class="form-group">
                <?= $this->element('Parts/label', ['field' => "{$id_prefix}-charge-detail-campaign_charge", 'label' => 'キャンペーン料金', 'require' => true, 'class' => 'item-label col-form-label']); ?>
                <div class="input number">
                  <div class="input-group">
                    <?= $this->Form->text("charge_details.{$append_index}.campaign_charge", [
                      'type' => 'number',
                      'id' => "{$id_prefix}-charge-detail-campaign_charge",
                      'class' => 'form-control rounded-0',
                      'label' => false,
                      'min' => '0',
                      'max' => '99900',
                      'step' => '50',
                      'required' => false,
                      'error' => false,
                      'value' => $charge_detail->campaign_charge
                    ]); ?>
                    <div class="input-group-append"><span class="input-group-text rounded-0">円</span></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
