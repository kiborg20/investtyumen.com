<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
/**
 * Вспомогательны класс
 */

use Bitrix\Catalog\CatalogIblockTable;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\Loader;


/**
 * Class Cinvestments
 */
class Cinvestments
{
    private const QUERY_URL = 'https://iato.bitrix24.ru/rest/44/6kto5dc8eqfbtmgw/';

    /**
     * Функция определения ID инфоблока по его символьному коду
     *
     * @param string $code
     *
     * @return int
     * @throws \Bitrix\Main\LoaderException
     */
    public static function getIblockIdByCode($code = '')
    {
        $result = 0;
        $code = trim($code);

        if (!empty($code)) {
            $cache = Cache::createInstance();
            if ($cache->initCache(86400, __CLASS__ . __FUNCTION__ . $code, 'iblock')) {
                $result = $cache->getVars();
            } elseif ($cache->startDataCache()) {
                Loader::includeModule('iblock');

                $obIblocks = CIBlock::GetList(
                    [],
                    [
                        'CODE' => $code,
                        'CHECK_PERMISSIONS' => 'N'
                    ]
                );
                if ($arIblock = $obIblocks->Fetch()) {
                    $result = (int)$arIblock['ID'];
                }

                if (!$result) {
                    $cache->abortDataCache();
                }
                $cache->endDataCache($result);
            }
        }

        return $result;
    }

    /**
     * получение данных инфоблока по id
     * */
    public static function getIblock($id)
    {
        $result = 0;
        $id = trim($id);

        if (!empty($id)) {
            $cache = Cache::createInstance();
            if ($cache->initCache(3600, __CLASS__ . __FUNCTION__ . $id, 'iblockid')) {
                $result = $cache->getVars();
            } elseif ($cache->startDataCache()) {
                Loader::includeModule('iblock');

                $obIblocks = CIBlock::GetList(
                    [],
                    [
                        'ID' => $id,
                        'CHECK_PERMISSIONS' => 'N'
                    ]
                );
                if ($arIblock = $obIblocks->Fetch()) {
                    $result = $arIblock;
                }

                if (!$result) {
                    $cache->abortDataCache();
                }
                $cache->endDataCache($result);
            }
        }

        return $result;
    }

    /**
     * Получение данных текущего пользователя
     *
     * @return array|int
     */
    public static function getCurUserData()
    {
        $result = 0;
        global $USER;
            $rsUser = CUser::GetByID($USER->GetID());
            if ($arUser = $rsUser->Fetch()) {
                $result = $arUser;
            }

        return $result;
    }

    /**
     * Получение текущего значения из
     */
    public static function getCurfieldValue($property){
        $result = "";
        $curUser = self::getCurUserData();

        switch($property["CODE"]){
            case "INITIATOR":
                $result = htmlSpecialchars($curUser["WORK_COMPANY"]);
                break;
            case "INITIATOR_INN":
                $result = $curUser["UF_INN"];
                break;
            case "CONTACTS":
                $result = $curUser["LAST_NAME"] . " " . $curUser["NAME"] . " " . $curUser["SECOND_NAME"];
                break;
            case "PHONE":
                $result = $curUser["PERSONAL_PHONE"];
                break;
            case "EMAIL":
                $result = $curUser["EMAIL"];
                break;
        }
        return $result;
    }

    /**
     * отправка запроса к вебхуку
     */
    public static function sendDataToBitrix($method, $data)
    {
        $queryUrl = self::QUERY_URL . $method;
        $queryData = http_build_query($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        ));

        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, 1);
    }

    /**
     * создать сделку
     */
    public static function dealADD($data)
    {
        $res = self::sendDataToBitrix('crm.deal.add', ["fields"=>$data,"params"=>[]]);
        return $res;
    }

    /*
     * создать лид
    */

    public static function leadADD($data)
    {
        $res = self::sendDataToBitrix('crm.lead.add', ["fields"=>$data,"params"=>[]]);
        return $res;
    }

    /**
     * поиск контакта по номеру телефона, возвращает ID контакта или false если не найден
     */
    public static function findContactByPhoneNumber($phone)
    {
        $result = false;

        $data = [
            "entity_type"=> "CONTACT",
            "type"=> "PHONE",
            "values"=>[ $phone ],
        ];

        $res = self::sendDataToBitrix('crm.duplicate.findbycomm', $data);

        if(isset($res["result"]["CONTACT"]) && count($res["result"]["CONTACT"])>0){
            $result = $res["result"]["CONTACT"][0];
        }
        return $result;
    }

    /**
     * создать контакт
     */
    public static function contactADD($data)
    {
        $res = self::sendDataToBitrix('crm.contact.add', ["fields"=>$data,"params"=>[]]);
        return $res;
    }

    /**
     * поиск компании по названию, возвращает ID компании или false если не найдена
     */
    public static function findCompanyByName($name)
    {
        $result = false;

        $data = [
            "order"=> [ "DATE_CREATE"=> "ASC" ],
            "filter"=> [ "TITLE"=> $name ],
            "select"=> [ "*", "UF_*", ]
        ];

        $res = self::sendDataToBitrix('crm.company.list', $data);

        if(isset($res["result"]) && count($res["result"])>0){
            $result = $res["result"][0]["ID"];
        }
        return $result;
    }

    /**
     * поиск компании по ИНН, возвращает ID компании или false если не найдена
     */
    public static function findCompanyByINN($inn)
    {
        $result = false;

        $data = [
            "order"=> [ "DATE_CREATE"=> "ASC" ],
            "filter"=> [ "UF_CRM_1675709492967"=> $inn ],
            "select"=> [ "*", "UF_*", ]
        ];

        $res = self::sendDataToBitrix('crm.company.list', $data);

        if(isset($res["result"]) && count($res["result"])>0){
            $result = $res["result"][0]["ID"];
        }
        return $result;
    }

    /**
     * создать компанию
     */
    public static function companyADD($data)
    {
        $res = self::sendDataToBitrix('crm.company.add', ["fields"=>$data,"params"=>[]]);
        return $res;
    }
    /**
     *  файлы из поля ""документы" элемента инфоблока в формате записи в поле б24
     */
    public static function getDocumentsInfo($iblockId,$elID, $field_code)
    {
        $res = false;

        $filesIDs = [];
        $files = [];
        $db_props = CIBlockElement::GetProperty($iblockId, $elID, array("sort" => "asc"), array("CODE" => $field_code));
        while ($ob = $db_props->GetNext())
        {
            $filesIDs[] = $ob['VALUE'];
        }

        if(isset($filesIDs) && count($filesIDs)!=0){
            foreach($filesIDs as $fileId){
                $temp = cFile::GetById($fileId)->fetch();
                $src = cFile::GetPath($fileId);
                $files[] = [
                    "fileData" => [
                        $temp["ORIGINAL_NAME"],
                        base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].$src))
                    ]
                ];
            }
        }
        $res = $files;
        return $res;
    }
    /**
     *  преобразует $_FILES в нужный формат
     */
    public static function reArrayImages($file_post) {
        $file_ary = [];
        $file_keys = array_keys($file_post);
        foreach ($file_post as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $file_ary[$key2][$key] = $value2;
            }
        }
        return $file_ary;
    }

    /**
     *  статус из спискового поля БУС
     */
    public static function StatusInfo($iblockId)
    {

        $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblockId, "CODE"=>"STATUS"));

        $statuses = false;

        while($enum_fields = $property_enums->GetNext())
        {
            //echo $enum_fields["ID"]." - ".$enum_fields["VALUE"]."<br>";
            if(stripos($enum_fields["VALUE"],'рассм')){
                $statuses["RASSMOTR"] = $enum_fields["ID"];
            }
            if(stripos($enum_fields["VALUE"],'тклон')){
                $statuses["OTKLON"] = $enum_fields["ID"];
            }
            if(stripos($enum_fields["VALUE"],'добр')){
                $statuses["ODOBR"] = $enum_fields["ID"];
            }

        }

        return $statuses;
    }

    /**
     *  месяц на русском
     */
    public static function rusMonth($month)
    {

        $monthes = array(
            1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
            5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
            9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'
        );
        return $monthes[$month];
    }


    /**
     *  получение значений спискового поля сделки б24
     */

    public static function getListFieldValues($fieldname){
        $data = [
            "order"=> [ "ID"=> "ASC" ],
            "filter"=> ["FIELD_NAME"=>$fieldname],
        ];

        $res = self::sendDataToBitrix('crm.deal.userfield.list', $data);

        $result_list = [];

        if(isset($res["result"][0]["LIST"]) && count( $res["result"][0]["LIST"] )!=0){
            foreach($res["result"][0]["LIST"] as $item){
                $result_list[$item["ID"]] = $item["VALUE"];
            }
        }

        return $result_list;
    }



    /**
     *  добавление сделки в событии добавления элемента в ИБ
     */

    public static function addDealFromIblockData($arFields, $iblock){

        $data = [
            "CATEGORY_ID"=>0,
            "TITLE"=>$iblock["NAME"]." ".date("d.m.Y H:i:s"),
            "ASSIGNED_BY_ID"=>ASSIGNED_BY_ID,
            "UF_CRM_1670235285095"=>$arFields['ID'],
            "UF_CRM_1670235377704"=>$arFields['IBLOCK_ID'],

        ];

        if(isset($arFields['PROPERTY_VALUES']['INITIATOR_INN'])&& $arFields['PROPERTY_VALUES']['INITIATOR_INN']!=""){
            $company = self::findCompanyByINN($arFields['PROPERTY_VALUES']['INITIATOR_INN']);
        }else{
            if(isset($arFields['PROPERTY_VALUES']['INITIATOR'])&& $arFields['PROPERTY_VALUES']['INITIATOR']!=""){
                $company = self::findCompanyByName($arFields['PROPERTY_VALUES']['INITIATOR']);
            }else{
                $company = false;
            }

        }

        if($company!=false){
            $data["COMPANY_ID"] = $company;
        }else{
            $data_com= [
                "TITLE"=>$arFields['PROPERTY_VALUES']['INITIATOR'],
                "ASSIGNED_BY_ID"=> ASSIGNED_BY_ID,
                "UF_CRM_1675709492967"=>$arFields['PROPERTY_VALUES']['INITIATOR_INN']
            ];
            $addcompany = self::companyADD($data_com);
            $data["COMPANY_ID"] = $addcompany["result"];

        }

        $contact = self::findContactByPhoneNumber($arFields['PROPERTY_VALUES']['PHONE']);
        if($contact!=false){
            $data["CONTACT_ID"] = $contact;
        }else{
            $data_con = [
                "NAME"=>$arFields['PROPERTY_VALUES']['CONTACTS'],
                "ASSIGNED_BY_ID"=> ASSIGNED_BY_ID,
                "PHONE"=> [
                    [ "VALUE"=> $arFields['PROPERTY_VALUES']['PHONE'], "VALUE_TYPE"=> "WORK" ],
                ],
                'EMAIL'=>[
                    [ "VALUE"=> $arFields['PROPERTY_VALUES']['EMAIL'], "VALUE_TYPE"=> "WORK" ],
                ],
                'COMPANY_ID'=>$data["COMPANY_ID"]

            ];

            $addcontact = self::contactADD($data_con);
            $data["CONTACT_ID"] = $addcontact["result"];
        }


        if(isset($arFields['PROPERTY_VALUES']['PROJECT_NAME'])&&$arFields['PROPERTY_VALUES']['PROJECT_NAME']!=""){
            $data['UF_CRM_1670223867320'] = $arFields['PROPERTY_VALUES']['PROJECT_NAME'];
        }

        if(isset($arFields['PROPERTY_VALUES']['PLACE_NAME'])&&$arFields['PROPERTY_VALUES']['PLACE_NAME']!=""){
            $data['UF_CRM_1670223867320'] = $arFields['PROPERTY_VALUES']['PLACE_NAME'];
        }

        if(isset($arFields['PROPERTY_VALUES']['ADRES_PROJECTA'])&&$arFields['PROPERTY_VALUES']['ADRES_PROJECTA']!=""){
            $data['UF_CRM_1666202737679'] = $arFields['PROPERTY_VALUES']['ADRES_PROJECTA'];
        }
        if(isset($arFields['PROPERTY_VALUES']['STOIMOST'])&&$arFields['PROPERTY_VALUES']['STOIMOST']!=""){
            $data['OPPORTUNITY'] = $arFields['PROPERTY_VALUES']['STOIMOST'];
        }
        if(isset($arFields['PROPERTY_VALUES']['ZAIM_SUM'])&&$arFields['PROPERTY_VALUES']['ZAIM_SUM']!=""){
            $data['UF_CRM_1670225695118'] = $arFields['PROPERTY_VALUES']['ZAIM_SUM'];
        }
        if(isset($arFields['PROPERTY_VALUES']['ZAIM_SROK'])&&$arFields['PROPERTY_VALUES']['ZAIM_SROK']!=""){
            $data['UF_CRM_1670226239738'] = $arFields['PROPERTY_VALUES']['ZAIM_SROK'];
        }

        $docs = self::getDocumentsInfo($arFields['IBLOCK_ID'],$arFields['ID'], "DOCUMENTS");
        if($docs!=false){
            $data['UF_CRM_1656078879799'] = $docs;
        }

        $zayavka = self::getDocumentsInfo($arFields['IBLOCK_ID'],$arFields['ID'], "ZAYAVKA");
        if($zayavka!=false){
            $data['UF_CRM_1675752387133'] = $zayavka;
        }


        $resume = self::getDocumentsInfo($arFields['IBLOCK_ID'],$arFields['ID'], "RESUME");
        if($resume!=false){
            $data['UF_CRM_1675880757881'] = $resume;
        }

        $copydocs = self::getDocumentsInfo($arFields['IBLOCK_ID'],$arFields['ID'], "PASPORT_COPY");
        if($copydocs!=false){
            $data['UF_CRM_1675708582692'] = $copydocs;
        }

        $soglasie = self::getDocumentsInfo($arFields['IBLOCK_ID'],$arFields['ID'], "SOGLASIE");
        if($soglasie!=false){
            $data['UF_CRM_1675880559'] = $soglasie;
        }

        if(isset($arFields['PROPERTY_VALUES']['PODDERJKA'])){

            $otrasl_list = self::getListFieldValues("UF_CRM_1676310991257");
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arFields["IBLOCK_ID"], "ID"=>$arFields['PROPERTY_VALUES']['PODDERJKA']));

            while($enum_fields = $property_enums->GetNext())
            {
                $value = $enum_fields["VALUE"];
                $enun_id = array_search($value, $otrasl_list);

                if($enun_id!==false){
                    $data["UF_CRM_1676310991257"][] =  $enun_id;
                }
            }
        }

        if(isset($arFields['PROPERTY_VALUES']['PLACESS'])){

            $placess_list = self::getListFieldValues("UF_CRM_1656308827889");
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arFields["IBLOCK_ID"], "ID"=>$arFields['PROPERTY_VALUES']['PLACESS']));

            while($enum_fields = $property_enums->GetNext())
            {
                $value = $enum_fields["VALUE"];
                $enun_id = array_search($value, $placess_list);

                if($enun_id!==false){
                    $data["UF_CRM_1656308827889"][] =  $enun_id;
                }
            }
        }

        if(isset($arFields['PROPERTY_VALUES']['TYPE'])){

            $placess_list = self::getListFieldValues("UF_CRM_1656077546183");
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arFields["IBLOCK_ID"], "ID"=>$arFields['PROPERTY_VALUES']['TYPE']));

            while($enum_fields = $property_enums->GetNext())
            {
                $value = $enum_fields["VALUE"];
                $enun_id = array_search($value, $placess_list);

                if($enun_id!==false){
                    $data["UF_CRM_1656077546183"][] =  $enun_id;
                }
            }
        }

        if(isset($arFields['PROPERTY_VALUES']['KATEGORY'])){

            $placess_list = self::getListFieldValues("UF_CRM_1678032432");
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arFields["IBLOCK_ID"], "ID"=>$arFields['PROPERTY_VALUES']['KATEGORY']));

            while($enum_fields = $property_enums->GetNext())
            {
                $value = $enum_fields["VALUE"];
                $enun_id = array_search($value, $placess_list);

                if($enun_id!==false){
                    $data["UF_CRM_1678032432"][] =  $enun_id;
                }
            }
        }

        if(isset($arFields['PROPERTY_VALUES']['PLOSHAD'])){
            $data["UF_CRM_1664276080587"] = $arFields['PROPERTY_VALUES']['PLOSHAD'];
        }

        if(isset($arFields['PROPERTY_VALUES']['MEST_COUNT'])){
            $data["UF_CRM_1626944837746"] = $arFields['PROPERTY_VALUES']['MEST_COUNT'];
        }

        if(isset($arFields['PROPERTY_VALUES']['PERIOD'])){
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arFields["IBLOCK_ID"], "ID"=>$arFields['PROPERTY_VALUES']['PERIOD']));
            while($enum_fields = $property_enums->GetNext())
            {
                $data["UF_CRM_1675959774975"] = $enum_fields["VALUE"];
            }
        }

        if(isset($arFields['PROPERTY_VALUES']['FORMA_PREDOSTAVLENIYA'])){
            $otrasl_list = self::getListFieldValues("UF_CRM_1668667259132");
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arFields["IBLOCK_ID"], "ID"=>$arFields['PROPERTY_VALUES']['FORMA_PREDOSTAVLENIYA']));
            while($enum_fields = $property_enums->GetNext())
            {
                $value = $enum_fields["VALUE"];
            }
            $enun_id = array_search($value, $otrasl_list);

            if($enun_id!==false){
                $data["UF_CRM_1668667259132"] =  $enun_id;
            }
        }



        if(isset($arFields['PROPERTY_VALUES']['FORMA_SOBSTVENNOSTY'])){
            $placess_list = self::getListFieldValues("UF_CRM_1678031717");
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arFields["IBLOCK_ID"], "ID"=>$arFields['PROPERTY_VALUES']['FORMA_SOBSTVENNOSTY']));

            while($enum_fields = $property_enums->GetNext())
            {
                $value = $enum_fields["VALUE"];
                $enun_id = array_search($value, $placess_list);

                if($enun_id!==false){
                    $data["UF_CRM_1678031717"][] =  $enun_id;
                }
            }
        }


        if(isset($arFields['PROPERTY_VALUES']['GAZOSNAB'])){
            $data["UF_CRM_1668667332820"] = $arFields['PROPERTY_VALUES']['GAZOSNAB'];
        }

        if(isset($arFields['PROPERTY_VALUES']['ELECTROSNAB'])){
            $data["UF_CRM_1668667350572"] = $arFields['PROPERTY_VALUES']['ELECTROSNAB'];
        }

        if(isset($arFields['PROPERTY_VALUES']['VODOSNAB'])){
            $data["UF_CRM_1668668577564"] = $arFields['PROPERTY_VALUES']['VODOSNAB'];
        }

        if(isset($arFields['PROPERTY_VALUES']['UDALENNOST'])){
            $data["UF_CRM_1676315233515"] = $arFields['PROPERTY_VALUES']['UDALENNOST'];
        }

        if(isset($arFields['PROPERTY_VALUES']['OPISANIE'])){
            $data["UF_CRM_1676315378959"] = $arFields['PROPERTY_VALUES']['OPISANIE'];
        }

        if(isset($arFields['PROPERTY_VALUES']['VLOGENO_ZA_PERIOD'])){
            $data["UF_CRM_1675959933307"] = $arFields['PROPERTY_VALUES']['VLOGENO_ZA_PERIOD'];
        }

        if(isset($arFields['PROPERTY_VALUES']['MEST_COUNT_PLAN'])){
            $data["UF_CRM_1675960065471"] = $arFields['PROPERTY_VALUES']['MEST_COUNT_PLAN'];
        }

        if(isset($arFields['PROPERTY_VALUES']['NEW'])){
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arFields["IBLOCK_ID"], "ID"=>$arFields['PROPERTY_VALUES']['NEW']));
            while($enum_fields = $property_enums->GetNext())
            {
                $data["UF_CRM_1675964993284"] = $enum_fields["VALUE"];
            }
        }

        if(isset($arFields['PROPERTY_VALUES']['ADRESS'])){
            $data["UF_CRM_1666202737679"] = $arFields['PROPERTY_VALUES']['ADRESS'];
        }

        if(isset($arFields['PROPERTY_VALUES']['COL_SOTRUDNIKOV'])){
            $data["UF_CRM_1626944837746"] = $arFields['PROPERTY_VALUES']['COL_SOTRUDNIKOV'];
        }

        if(isset($arFields['PROPERTY_VALUES']['SPECIALNOST'])){
            $data["UF_CRM_1675965244333"] = $arFields['PROPERTY_VALUES']['SPECIALNOST'];
        }

        if(isset($arFields['PROPERTY_VALUES']['ZARPLATA'])){
            $data["UF_CRM_1675965319896"] = $arFields['PROPERTY_VALUES']['ZARPLATA'];
        }

        if(isset($arFields['PROPERTY_VALUES']['TEXT'])){
            $theme = "";
            if(isset($arFields['PROPERTY_VALUES']['THEME'])){
                $theme = $arFields['PROPERTY_VALUES']['THEME'];
                $data["UF_CRM_1675965630128"] = "Тема сообщения: ".$theme." текст сообщения: ".$arFields['PROPERTY_VALUES']['TEXT'];
            }else{
                $data["UF_CRM_1675965630128"] = $arFields['PROPERTY_VALUES']['TEXT'];
            }
        }

        if(isset($arFields['PROPERTY_VALUES']['OTRASL'])){
            $otrasl_list = self::getListFieldValues("UF_CRM_1656403926233");
            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arFields["IBLOCK_ID"], "ID"=>$arFields['PROPERTY_VALUES']['OTRASL']));
            while($enum_fields = $property_enums->GetNext())
            {
                $value = $enum_fields["VALUE"];
            }
            $enun_id = array_search($value, $otrasl_list);

            if($enun_id!==false){
                $data["UF_CRM_1656403926233"] =  [$enun_id,];
            }
        }

        if(isset($arFields['PROPERTY_VALUES']['MAX_SUMM'])&&$arFields['PROPERTY_VALUES']['MAX_SUMM']!=""){
            $data['OPPORTUNITY'] = $arFields['PROPERTY_VALUES']['MAX_SUMM'];
        }

        if(isset($arFields['PROPERTY_VALUES']['USLOVIYA_INVESTIROVANIYA'])&&$arFields['PROPERTY_VALUES']['USLOVIYA_INVESTIROVANIYA']!=""){
            $data['UF_CRM_1676054602783'] = $arFields['PROPERTY_VALUES']['USLOVIYA_INVESTIROVANIYA'];
        }

        if(isset($arFields['PROPERTY_VALUES']['SROK_OKUPAEMOSTY'])&&$arFields['PROPERTY_VALUES']['SROK_OKUPAEMOSTY']!=""){
            $data['UF_CRM_1676054741187'] = $arFields['PROPERTY_VALUES']['SROK_OKUPAEMOSTY'];
        }

        switch ($iblock["ID"]) {
            case "44":
                $docs = self::getDocumentsInfo($arFields['IBLOCK_ID'],$arFields['ID'], "DOCUMENTS");
                if($docs!=false){
                    $data['UF_CRM_1665344803590'] = $docs;
                }

                if(isset($arFields['PROPERTY_VALUES']['TEXT'])){
                    $theme = "";
                    if(isset($arFields['PROPERTY_VALUES']['THEME'])){
                        $theme = $arFields['PROPERTY_VALUES']['THEME'];
                        $data["UF_CRM_1678285289113"] = "Тема сообщения: ".$theme." текст сообщения: ".$arFields['PROPERTY_VALUES']['TEXT'];
                    }else{
                        $data["UF_CRM_1678285289113"] = $arFields['PROPERTY_VALUES']['TEXT'];
                    }
                }

                $data['UF_CRM_1678386142'] = $iblock["ID"];
                $data['UF_CRM_1678386166'] = $arFields['ID'];

                $res = self::leadADD($data);

                break;
            case "45":
                $docs = self::getDocumentsInfo($arFields['IBLOCK_ID'],$arFields['ID'], "DOCUMENTS");
                if($docs!=false){
                    $data['UF_CRM_1665344803590'] = $docs;
                }

                if(isset($arFields['PROPERTY_VALUES']['TEXT'])){
                    $theme = "";
                    if(isset($arFields['PROPERTY_VALUES']['THEME'])){
                        $theme = $arFields['PROPERTY_VALUES']['THEME'];
                        $data["UF_CRM_1678285289113"] = "Тема сообщения: ".$theme." текст сообщения: ".$arFields['PROPERTY_VALUES']['TEXT'];
                    }else{
                        $data["UF_CRM_1678285289113"] = $arFields['PROPERTY_VALUES']['TEXT'];
                    }
                }

                $res = self::leadADD($data);
                break;
            default:
                $res = self::dealADD($data);
                break;
        }
    }

    /**
     * получение данных инфоблока по id
     * статус может принимать значения - RASSMOTR - на рассмотрении, OTKLON - отклонена, ODOBR - одобрена
     * */
    public static function setElementStatus($iblockid, $elementId, $status)
    {
        $result = false;
        $iblockid = trim($iblockid);
        $elementId = trim($elementId);
        CModule::IncludeModule("iblock");
        if (!empty($iblockid) && !empty($elementId)) {
            $statuses = Cinvestments::StatusInfo($iblockid);
            $statusID = $statuses[$status];
            return CIBlockElement::SetPropertyValuesEx($elementId, false, array("STATUS" => $statusID));;
        }else{
            return $result;
        }
    }

    public static function getRegionSelect($currentRegion= '', $field=""){
        $regions = array(
            "Республика Адыгея (Адыгея)",
            "Республика Алтай",
            "Республика Башкортостан",
            "Республика Бурятия",
            "Республика Дагестан",
            "Донецкая Народная Республика",
            "Республика Ингушетия",
            "Кабардино-Балкарская Республика",
            "Республика Калмыкия",
            "Карачаево-Черкесская Республика",
            "Республика Карелия",
            "Республика Коми",
            "Республика Крым",
            "Луганская Народная Республика",
            "Республика Марий Эл",
            "Республика Мордовия",
            "Республика Саха (Якутия)",
            "Республика Северная Осетия — Алания",
            "Республика Татарстан (Татарстан)",
            "Республика Тыва",
            "Удмуртская Республика",
            "Республика Хакасия",
            "Чеченская Республика",
            "Чувашская Республика —  Чувашия",
            "Алтайский край",
            "Забайкальский край",
            "Камчатский край",
            "Краснодарский край",
            "Красноярский край",
            "Пермский край",
            "Приморский край",
            "Ставропольский край",
            "Хабаровский край",
            "Амурская область",
            "Архангельская область",
            "Астраханская область",
            "Белгородская область",
            "Брянская область",
            "Владимирская область",
            "Волгоградская область",
            "Вологодская область",
            "Воронежская область",
            "Запорожская область",
            "Ивановская область",
            "Иркутская область",
            "Калининградская область",
            "Калужская область",
            "Кемеровская область — Кузбасс",
            "Кировская область",
            "Костромская область",
            "Курганская область",
            "Курская область",
            "Ленинградская область",
            "Липецкая область",
            "Магаданская область",
            "Московская область",
            "Мурманская область",
            "Нижегородская область",
            "Новгородская область",
            "Новосибирская область",
            "Омская область",
            "Оренбургская область",
            "Орловская область",
            "Пензенская область",
            "Псковская область",
            "Ростовская область",
            "Рязанская область",
            "Самарская область",
            "Саратовская область",
            "Сахалинская область",
            "Свердловская область",
            "Смоленская область",
            "Тамбовская область",
            "Тверская область",
            "Томская область",
            "Тульская область",
            "Тюменская область",
            "Ульяновская область",
            "Херсонская область",
            "Челябинская область",
            "Ярославская область",
            "Москва",
            "Санкт-Петербург",
            "Севастополь" ,
            "Еврейская автономная область",
            "Ненецкий автономный округ",
            "Ханты-Мансийский автономныйокруг — Югра",
            "Чукотский автономный округ",
            "Ямало-Ненецкий автономный округ",
        );

        $select = "<select name='".$field."' >";
        if ($currentRegion== ''){
            $select = $select."<option selected value=''>Выберите регион</option>";
        }else{
            $select = $select."<option value=''>Выберите регион</option>";
        }
        foreach($regions as $rkey=>$region){
            $selected = "";
            if($currentRegion == $region ){
                $selected = "selected";
            }
            $select = $select."<option value='".$region."' ".$selected.">".$region."</option>";
        }
        $select = $select."</select>";
        return $select;
    }




}//class





?>