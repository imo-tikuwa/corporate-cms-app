<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * FrontContact Form.
 */
class FrontContactForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        // お名前
        $schema->addField("content1", ['type' => 'string']);
        // メールアドレス
        $schema->addField("content2", ['type' => 'string']);
        // お問い合わせ内容
        $schema->addField("content3", ['type' => 'string']);
        // お電話番号
        $schema->addField("content4", ['type' => 'string']);
        // ご希望日時／その他ご要望等
        $schema->addField("content5", ['type' => 'string']);
        // ホームページURL
        $schema->addField("content6", ['type' => 'string']);
        return $schema;
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        // お名前
        $validator->notEmptyString('content1', 'お名前を入力してください');
        // メールアドレス
        $validator->notEmptyString('content2', 'メールアドレスを入力してください');
        // お問い合わせ内容
        $validator->notEmptyString('content3', 'お問い合わせ内容を選択してください');
        // お電話番号
        $validator->notEmptyString('content4', 'お電話番号を入力してください', function ($context) {
            // お問い合わせ内容が「ご予約」のとき必須
            return (!empty($context['data']["content3"]) && $context['data']["content3"] == '01');
        });
        // ご希望日時／その他ご要望等
        $validator->notEmptyString('content5', 'ご希望日時／その他ご要望等を入力してください');
        // ホームページURL
        $validator->allowEmptyString('content6');
        $validator->add("content6", 'format', [
            'rule' => function ($value, $context) {
                return (bool)preg_match("/^https?:\/\/.*$/", $value);
            },
            'message' => "ホームページURLにはhttpもしくはhttpsから始まるURLを入力してください",
        ]);
        return $validator;
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        return true;
    }
}
