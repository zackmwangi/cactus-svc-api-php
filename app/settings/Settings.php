<?php
declare(strict_types=1);

namespace App\Settings;

use App\Settings\SettingsInterface;

class Settings implements SettingsInterface
{
    private $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return mixed
     */
    public function get(string $key = '')
    {

        /*
        echo 'Finding key ' . $key;
        echo '----------------------------------------------------------------';
        var_dump($this->settings);
        echo '----------------------------------------------------------------';
        */
        return (empty($key)) ? $this->settings : $this->settings[$key];
        
    }
    //
}