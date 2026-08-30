<?php

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

defined('ADMIN_MODULE_NAME') or define('ADMIN_MODULE_NAME', 'creative.foundation');

global $USER, $APPLICATION;

if (!$USER->isAdmin()) {
    $APPLICATION->authForm(Loc::getMessage('ACCESS_DENIED'));
}

$app = Application::getInstance();
$context = $app->getContext();
$request = $context->getRequest();

Loc::loadMessages($context->getServer()->getDocumentRoot() . '/bitrix/modules/main/options.php');
Loc::loadMessages(__FILE__);

$tabs = [
    [
        'DIV' => 'edit1',
        'TAB' => Loc::getMessage('MAIN_TAB_SET'),
        'TITLE' => Loc::getMessage('MAIN_TAB_TITLE_SET'),
        'OPTIONS' => [
            [
                'site_stopped',
                Loc::getMessage('CREATIVE_FOUNDATION_OPTION_LABEL_SITE_STOPPED'),
                Option::get(ADMIN_MODULE_NAME, 'site_stopped') === 'Y' ? 'checked="checked"' : '',
                ['checkbox'],
            ],
            [
                'site_stopped_title',
                Loc::getMessage('CREATIVE_FOUNDATION_SITE_STOPPED_TITLE'),
                Option::get(ADMIN_MODULE_NAME, 'site_stopped_title', 'Сервис будет доступен 12 октября после 15:00 мск'),
                ['text'],
            ],
            [
                'site_stopped_text',
                Loc::getMessage('CREATIVE_FOUNDATION_SITE_STOPPED_TEXT'),
                Option::get(ADMIN_MODULE_NAME, 'site_stopped_text', 'Сейчас мы проводим технические работы для того, чтобы Личный кабинет был удобным и безопасным для клиентов СберНПФ. Пока идут работы, вы можете <a href="http://npfsberbanka.ru/news/?utm_source=npfsberbanka&amp;utm_content=tech">почитать последние новости</a>, <a href="https://npo.npfsb.ru/?utm_source=npfsberbanka&amp;utm_content=tech&amp;landing=npo&amp;step=1">проверить свои знания</a> и <a href="http://npfsberbanka.ru/ipp/?utm_source=npfsberbanka&amp;utm_content=tech">открыть свой личный пенсионный план</a>'),
                [
                    'textarea',
                    10,
                    80,
                ],
            ],
        ],
    ],
    [
        'DIV' => 'edit2',
        'TAB' => Loc::getMessage('CREATIVE_FOUNDATION_TAB2_SET'),
        'TITLE' => Loc::getMessage('CREATIVE_FOUNDATION_TAB2_TITLE_SET'),
        'OPTIONS' => [
            Loc::getMessage('CREATIVE_FOUNDATION_TAB2_COMMON_SET'),
            [
                'chat_statuses',
                Loc::getMessage('CREATIVE_FOUNDATION_OPTION_CHAT_STATUSES'),
                Option::get(ADMIN_MODULE_NAME, 'chat_statuses') === 'Y' ? 'checked="checked"' : '',
                ['checkbox'],
            ],
            [
                'shat_url',
                Loc::getMessage('CREATIVE_FOUNDATION_OPTION_CHAT_URL'),
                Option::get(ADMIN_MODULE_NAME, 'shat_url'),
                ['text'],
            ],
        ],
    ],
];

$tabControl = new CAdminTabControl('tabControl', $tabs, false, true);

$isConfigComplete = false;
if ((!empty($save) || !empty($restore)) && $request->isPost() && check_bitrix_sessid()) {
    if (!empty($restore)) {
        Option::delete(ADMIN_MODULE_NAME);
        Option::set(
            'main',
            'site_stopped',
            'N'
        );
        CAdminMessage::showMessage([
            'MESSAGE' => Loc::getMessage('REFERENCES_OPTIONS_RESTORED'),
            'TYPE' => 'OK',
        ]);
    } else {
        if ($request->getPost('baseUrl')) {
            Option::set(
                ADMIN_MODULE_NAME,
                'baseUrl',
                $request->getPost('baseUrl')
            );
        }

        foreach ($tabs as $tab) {
            foreach ($tab['OPTIONS'] as $option) {
                if (!is_array($option)) {
                    continue;
                }

                $optionValue = $request->getPost($option[0]);
                Option::set(ADMIN_MODULE_NAME, $option[0], $optionValue);

                if ($option[0] == 'site_stopped') {
                    Option::set('main', 'site_stopped', Option::get(ADMIN_MODULE_NAME, 'site_stopped'));
                }
            }
        }
    }
    $isConfigComplete = true;
}
?>

    <form method="post" action="<?= $APPLICATION->getCurPageParam('mid=' . urlencode(ADMIN_MODULE_NAME), ['mid']); ?>">
        <?php
        $tabControl->begin();
        foreach ($tabs as $tab) {
            $tabControl->beginNextTab();
            if ($tab['OPTIONS']) {
                __AdmSettingsDrawList(ADMIN_MODULE_NAME, $tab['OPTIONS']);
            }
        }
        $tabControl->buttons();
        ?>
        <input type="submit"
               name="save"
               value="<?= Loc::getMessage('MAIN_SAVE'); ?>"
               title="<?= Loc::getMessage('MAIN_OPT_SAVE_TITLE'); ?>"
               class="adm-btn-save"
        />
        <input type="submit"
               name="restore"
               title="<?= Loc::getMessage('MAIN_HINT_RESTORE_DEFAULTS'); ?>"
               onclick="return confirm('<?= addslashes(GetMessage('MAIN_HINT_RESTORE_DEFAULTS_WARNING')); ?>')"
               value="<?= Loc::getMessage('MAIN_RESTORE_DEFAULTS'); ?>"
        />
        <?= bitrix_sessid_post();
        $tabControl->end(); ?>
    </form>
<?php
if ($isConfigComplete) {
    LocalRedirect($APPLICATION->getCurPageParam('mid=' . urlencode(ADMIN_MODULE_NAME), ['mid']) . "&" . $tabControl->ActiveTabParam());
}
