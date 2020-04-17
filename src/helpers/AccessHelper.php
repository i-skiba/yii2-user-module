<?php
namespace concepture\yii2user\helpers;


use concepture\yii2handbook\actions\PositionSortIndexAction;
use concepture\yii2logic\helpers\ClassHelper;
use concepture\yii2user\enum\AccessEnum;
use concepture\yii2user\enum\PermissionEnum;
use kamaelkz\yii2admin\v1\actions\EditableColumnAction;
use kamaelkz\yii2admin\v1\actions\SortAction;
use Yii;


/**
 * Класс содержит вспомогательные методы для рабоыт с rbac
 * @package concepture\yii2user\helpers
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class AccessHelper
{
    /**
     * дефолтные экшоны чтения данных
     * @var string[]
     */
    static $_read_actions = [
        'index',
        'list',
        'view',
    ];

    /**
     * дефолтные экшоны модификации данных
     * @var string[]
     */
    static $_edit_actions = [
        'create',
        'update',
        'delete',
        'undelete',
        'status-change',
        'image-upload',
        'image-delete',
        'editable-column',
        'create-validate-attribute',
        'update-validate-attribute',
    ];

    /**
     * экшоны модуля сортировки
     * @var string[]
     */
    static $_sort_actions = [
        'sort',
        'position-sort-index',
    ];

    /**
     * Проверка прав доступа
     *
     * Пример:
     *
     * AccessHelper::checkAccess('create');
     * AccessHelper::checkAccess(['site/index]);
     *
     * @param $name
     * @return bool
     */
    public static function checkAccess($name)
    {
        $action = null;
        $controller = null;
        if (is_array($name)) {
            $tmp = trim($name[0], '/');
            $tmpArray = explode('/', $tmp);
            if (count($tmpArray) == 1) {
                $action = $tmpArray[0];
                $controller = Yii::$app->controller;
            }

            if (count($tmpArray) > 1) {
                $tmp1 = $tmpArray;
                $action = array_pop($tmp1);
                $controller = array_pop($tmp1);
            }
        }

        if ($action){
            $name = $action;
        }

        if (in_array($name, [ 'activate', 'deactivate' ])){
            $name = 'status-change';
        }

        if (! $controller){
            $controller = Yii::$app->controller;
        }

        $permissions = AccessHelper::getPermissionsByAction($controller, $name);
        foreach ($permissions as $permission){
            if (Yii::$app->user->can($permission)){
                return true;
            }
        }

        return false;
    }

    /**
     * Возвращает полномочия по экшену или массиву экшенов
     * @param $controller
     * @param $action
     * @return array
     */
    public static function getPermissionsByAction($controller, $action)
    {
        if ((! is_array($action) && in_array($action, static::$_read_actions) )
            || (is_array($action) && $action === static::$_read_actions)){
            return [
                AccessEnum::SUPERADMIN,
                AccessEnum::ADMIN,
                static::getAccessPermission($controller, PermissionEnum::ADMIN),
                static::getAccessPermission($controller, PermissionEnum::STAFF),
                static::getAccessPermission($controller, PermissionEnum::EDITOR),
                static::getAccessPermission($controller, PermissionEnum::READER),
            ];
        }

        if ((! is_array($action) && in_array($action, static::$_edit_actions) )
            || (is_array($action) && $action === static::$_edit_actions)){
            return [
                AccessEnum::SUPERADMIN,
                AccessEnum::ADMIN,
                static::getAccessPermission($controller, PermissionEnum::ADMIN),
                static::getAccessPermission($controller, PermissionEnum::STAFF),
                static::getAccessPermission($controller, PermissionEnum::EDITOR),
            ];
        }

        if ((! is_array($action) && in_array($action, static::$_sort_actions) )
            || (is_array($action) && $action === static::$_sort_actions)){
            return [
                AccessEnum::SUPERADMIN,
                AccessEnum::ADMIN,
                static::getAccessPermission($controller, PermissionEnum::ADMIN),
                static::getAccessPermission($controller, PermissionEnum::EDITOR),
            ];
        }

        return [];
    }


    /**
     * Возвращает базовые правила доступа
     * @param $controller
     * @return array
     */
    public static function getDefaultAccessRules($controller)
    {
        $rules = [];
        /**
         * Просмотр
         */
        $rules[] = [
            'actions' => static::$_read_actions,
            'allow' => true,
            'roles' => static::getPermissionsByAction($controller, static::$_read_actions),
        ];
        /**
         * Модификация
         */
        $rules[] = [
            'actions' => static::$_edit_actions,
            'allow' => true,
            'roles' => static::getPermissionsByAction($controller, static::$_edit_actions),
        ];
        /**
         * Сортировка
         */
        $rules[] = [
            'actions' => static::$_sort_actions,
            'allow' => true,
            'roles' => static::getPermissionsByAction($controller, static::$_sort_actions),
        ];

        return $rules;
    }

    /**
     * Возвращает значение полномочия для переданного контроллера
     * @param $controller
     * @param $permission
     * @return string
     */
    public static function getAccessPermission($controller, $permission)
    {
        if (is_object($controller)) {
            $name = ClassHelper::getShortClassName($controller, 'Controller', true);
        }else{
            $name = str_replace("-", '', strtoupper($controller));
        }

        return $name . "_" . $permission;
    }
}