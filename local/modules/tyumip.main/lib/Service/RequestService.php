<?php

namespace Tyumip\Main\Service;

use Bitrix\Main\Request;
use Tyumip\Main\Enums\Answer;
use Bitrix\Main\Application;

class RequestService
{
    public function __construct()
    {
        global $APPLICATION;
        $oRequest = Application::getInstance()->getContext()->getRequest();
        $sPage = $APPLICATION->GetCurPage();

        $sFuncName = $this->getApiName($sPage);

        if (!method_exists($this, $sFuncName)) {
            return self::prepareAnswer('Не найден запрос', 404);
        }

        print_r($this->$sFuncName($oRequest));
    }

    public function getConsultation(Request $oRequest)
    {
        if ($oRequest->count() < 1) {
            return self::prepareAnswer('Нет аргументов', 400);
        }

        return self::prepareAnswer('Сообщение об консультации отправлено', 200);
    }

    public function getApiName($sUri)
    {
        return str_replace(['/api/', ''], '', $sUri);
    }

    private static $aCodes = [
        200 => 'OK',
        400 => 'BadRequest',
        204 => 'NoContent',
        401 => 'UnAuthorized'
    ];

    public static function prepareAnswer(?string $sResult, int $eAnswer)
    {
        http_response_code($eAnswer);
        return [
            'response' => [
                'data' => $sResult ?? '',
                'answer' => self::$aCodes[$eAnswer]
            ],
            'status' => $eAnswer
        ];
    }
}