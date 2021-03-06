<?php
namespace concepture\yii2user\forms;

use concepture\yii2user\enum\UserCredentialStatusEnum;
use concepture\yii2user\enum\UserCredentialTypeEnum;
use Yii;
use concepture\yii2logic\forms\Model;

/**
 * Форма регистрации нового пользователя
 *
 * Class SignUpForm
 * @package concepture\yii2user\forms
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class SignUpForm extends Model
{
    public $username;
    public $identity;
    public $validation;
    public $status = UserCredentialStatusEnum::ACTIVE;
    public $credentialType= UserCredentialTypeEnum::EMAIL;
    public $mailTmpPath = "@concepture/yii2user/views/mailer/success_registration_html";
    public $sendMail = true;

    public $confirmRoute = 'site/confirm';
    public $confirmToken;
    public $generatedConfirmToken;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','identity', 'validation'], 'required'],
            [
                [
                    'validation'
                ],
                'string',
                'min' => 6,
                'max'=>100
            ],
            ['status', 'integer'],
            ['identity', 'trim'],
            ['validation', 'trim'],
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 100],
            ['identity', 'email'],
            ['identity', 'filter', 'filter'=>'strtolower'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'identity' => Yii::t('common', 'Адрес электронной почты'),
            'validation' => Yii::t('common', 'Пароль'),
            'username' => Yii::t('common', 'Имя пользователя')
        ];
    }
}
