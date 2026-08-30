<?php
declare(strict_types=1);

namespace Tyumip\Main\Model;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\TextField;

class IndexerTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'index_table';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField('id',
                ['autocomplete' => true, 'unique' => true, 'primary' => true, 'column_name' => 'ID']
            ),
            new TextField('CONTENT', ['column_name' => 'UF_CONTENT', 'required' => true]),
            new StringField('INDEXED_TEXT', ['column_name' => 'UF_TEXT', 'required' => true]),
            new StringField('PAGE', ['column_name' => 'UF_PAGE', 'required' => true]),
            new StringField('URL', ['column_name' => 'UF_URL', 'required' => false]),
        ];
    }
}