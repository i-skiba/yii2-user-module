<?php
namespace concepture\yii2user\traits;

use concepture\yii2user\services\AuthService;
use concepture\yii2user\services\EmailHandbookService;
use concepture\yii2user\services\UserAccountOperationService;
use concepture\yii2user\services\UserAccountService;
use concepture\yii2user\services\UserCredentialService;
use concepture\yii2user\services\UserRoleHandbookService;
use concepture\yii2user\services\UserRoleService;
use concepture\yii2user\services\UserService;
use Yii;

/**
 * Trait ServicesTrait
 *
 * @author citizenzet <exgamer@live.ru>
 */
trait ServicesTrait
{
    /**
     * @return UserService
     */
    public function userService()
    {
        return Yii::$app->userService;
    }

    /**
     * @return UserCredentialService
     */
    public function userCredentialService()
    {
        return Yii::$app->userCredentialService;
    }

    /**
     * @return UserAccountService
     */
    public function userAccountService()
    {
        return Yii::$app->userAccountService;
    }

    /**
     * @return UserAccountOperationService
     */
    public function userAccountOperationService()
    {
        return Yii::$app->userAccountOperationService;
    }

    /**
     * @return AuthService
     */
    public function authService()
    {
        return Yii::$app->authService;
    }

    /**
     * @return UserRoleService
     */
    public function userRoleService()
    {
        return Yii::$app->userRoleService;
    }

    /**
     * @return EmailHandbookService
     */
    public function emailHandbookService()
    {
        return Yii::$app->emailHandbookService;
    }
}

