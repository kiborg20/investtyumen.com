<?php
declare(strict_types=1);

namespace Tyumip\Main\Model;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\TextField;

class IconDirectoryTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'tyumip_icons_array';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField('id',
                ['autocomplete' => true, 'unique' => true, 'primary' => true, 'column_name' => 'ID']
            ),
            new StringField('name', ['column_name' => 'UF_NAME', 'required' => true]),
            new TextField('icon_svg', ['column_name' => 'UF_ICON_STRING']),
            new StringField('icon_file', ['column_name' => 'UF_ICON']),
            new StringField('external', ['column_name' => 'UF_XML_ID']),
            new StringField('description', ['column_name' => 'UF_DESCRIPTION']),
            new StringField('full_description', ['column_name' => 'UF_FULL_DESCRIPTION']),
        ];
    }
}