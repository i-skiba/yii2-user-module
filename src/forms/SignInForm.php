<?php
namespace concepture\yii2user\forms;

use concepture\yii2user\enum\UserCredentialTypeEnum;
use Yii;
use concepture\yii2logic\forms\Model;

/**
 * Форма авторизации пользователя
 *
 * Class SignInForm
 * @package concepture\yii2user\forms
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class SignInForm extends Model
{
    public $username;
    public $identity;
    public $validation;
    public $rememberMe = true;
    public $restrictions = [];
    public $onlyWithAuthAssignment = false; // только для юзеров у которых есть роли (для админки)
    public $credentialType= UserCredentialTypeEnum::EMAIL;
    public $blockByDomain = false; // признак блокирования учетки по домену

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['identity', 'validation'], 'required'],
            [
                [
                    'validation'
                ],
                'string'
            ],
            ['identity', 'trim'],
            ['validation', 'trim'],
            ['identity', 'email'],
            [
                [
                    'rememberMe',
                    'onlyWithAuthAssignment',
                ], 'boolean'
            ],
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
            'rememberMe' => Yii::t('common', 'Запомнить меня'),
        ];
    }

    /**
     * Установка ограничений на авторизацию по роли
     *
     * @param $restrictions
     * @return void
     */
    public function setRestrictions($restrictions)
    {
        $this->restrictions = $restrictions;
    }
}
