<?php

namespace Sprint\Migration;


class Version20230717111951 extends Version
{
    protected $description = "Правка связанная с установкой модуля майн";

    protected $moduleVersion = "4.3.1";

    protected $query = <<<EOT
<?php

use Bitrix\Main\Loader;

if (!Loader::includeModule('tyumip.main')) {
    throw new LogicException('Main module not found');
}
EOT;

    public function up()
    {
        if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/includeModules.php')) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/includeModules.php', $this->query, FILE_APPEND);
        }
    }

    public function down()
    {
        //your code ...
    }
}
