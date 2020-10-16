<div class="access-as-user">
    <?= Yii::t('common', 'Вы просматриваете сайт как <br/> {user}', ['user' => $username])?>
</div>
<style>
    .access-as-user{
        position: fixed;
        right: 0;
        top: 0;
        display: flex;
        height: 4rem;
        background-color: #eee;
        border-radius: 0 0 0 3px;
        z-index: 2000;
        text-align: center;
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 5px;
        opacity: 0.5;
        color: #000000;
    }
</style>