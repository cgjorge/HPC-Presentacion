<?php

namespace Securimage\StorageAdapter;

use Securimage\StorageAdapter\AdapterInterface;

class Wordpress implements AdapterInterface
{
    protected $wpdb;
    protected $table_name;

    public function __construct($options = null)
    {
        $this->wpdb       = $options['wpdb'];
        $this->table_name = $this->wpdb->prefix . $options['table_name'];
    }

    public function store($captchaId, $captchaInfo)
    {
        return $this->saveCodeToDatabase($captchaId, $captchaInfo);
    }

    public function storeAudioData($captchaId, $audioData)
    {
        return $this->saveAudioToDatabase($captchaId, $audioData);
    }

    public function get($captchaId, $what = null)
    {
        $result = $this->wpdb->get_row(
            $this->wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %s", $captchaId)
        );

        if ($result !== null) {
            $info = new \Securimage\CaptchaObject;
            $info->captchaId    = $captchaId;
            $info->code         = $result->code;
            $info->code_display = $result->code_display;
            $info->created      = $result->created;
            $info->captchaImageAudio = $result->audio_data;

            $result = $info;
        }

        return $result;
    }

    public function delete($captchaId)
    {
        return
        $this->wpdb->query(
            $this->wpdb->prepare("DELETE FROM {$this->table_name} WHERE id = %s", $captchaId)
        );
    }

    /**
     * Saves the CAPTCHA data to the configured database.
     */
    protected function saveCodeToDatabase($captchaId, $captchaInfo)
    {
        $success =
        $this->wpdb->query(
            $this->wpdb->prepare(
                "INSERT INTO {$this->table_name} (id, code, code_display, created)
                VALUES
                (%s, %s, %s, %s);",
                $captchaId, $captchaInfo->code, $captchaInfo->code_display, time()
            )
        );

        return $success !== false;
    }

    /**
     * Saves CAPTCHA audio to the configured database
     *
     * @param string $data Audio data
     * @return boolean true on success, false on failure
     */
    protected function saveAudioToDatabase($captchaId, $data)
    {
        $success =
        $this->wpdb->query(
            $this->wpdb->prepare("UPDATE {$this->table_name} SET audio_data = %s WHERE id = %s", $data, $captchaId)
        );

        return $success !== false;
    }
}
