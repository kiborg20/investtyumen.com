<?php

namespace Creative\Foundation;

class Cache
{
    /**
     * @param int
     */
    protected $_defaultTime = 3600;

    /**
     * @param string $key
     * @param mixed  $data
     */
    public function set($key, $data, $duration = null)
    {
        if (isset($_REQUEST['clear_cache']) && $_REQUEST['clear_cache'] === 'Y') {
            return null;
        }
        $this->delete($key);
        $time = $duration !== null ? (int) $duration : $this->getDefaultTime();
        $obCache = new \CPHPCache();
        $obCache->InitCache($time, $key, $this->getFolder($key));
        $obCache->StartDataCache();
        $obCache->EndDataCache($data);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        $obCache = new \CPHPCache();
        if ($obCache->InitCache($this->getInitedTime(), $key, $this->getFolder($key))) {
            return $obCache->GetVars();
        } else {
            return false;
        }
    }

    /**
     * @param string $key
     */
    public function delete($key)
    {
        $obCache = new \CPHPCache();
        $obCache->InitCache($this->getInitedTime(), $key, $this->getFolder($key));
        $obCache->CleanDir($this->getFolder($key));
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function exists($key)
    {
        $obCache = new \CPHPCache();

        return (bool) $obCache->InitCache(
            $this->getInitedTime(),
            $key,
            $this->getFolder($key)
        );
    }

    /**
     * @param int $time
     */
    public function setDefaultTime($time)
    {
        $this->_defaultTime = (int) $time;
    }

    /**
     * @return int
     */
    public function getDefaultTime()
    {
        return $this->_defaultTime;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function getFolder($key)
    {
        return '/'.md5($key);
    }

    /**
     * @return int
     */
    protected function getInitedTime()
    {
        return 3600;
    }
}
