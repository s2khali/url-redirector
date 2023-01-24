<?php

use Predis\Client;

class RedirectController
{
    const PREFIX = "redirects:";
    const SHORT_PREF = "http://dev.short.com";

    /**
     * @var Client
     */
    private $redis;

    public function __construct()
    {
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host' => 'host.docker.internal',
            'port' => '6379',
        ]);
    }

    // Should have added validation here instead of submit.php
    public function addRoute($route, $shortenedLink): bool
    {
        if ($this->redis->exists(self::PREFIX . $shortenedLink)) {
            return false;
        } else {
            $this->redis->set(self::PREFIX . $shortenedLink, $route);

            return true;
        }
    }

    public function removeRoute($key): bool
    {
        if ($this->redis->exists(self::PREFIX . $key)) {
            $this->redis->del(self::PREFIX . $key);
            return true;
        } else {
            return false;
        }
    }

    public function addRandomizedRoute($route): bool|string
    {
        $shortenedLink = self::SHORT_PREF . "/" . hash("crc32", $route);


        if ($this->redis->exists(self::PREFIX . $shortenedLink)) {
            return false;
        } else {
            $this->redis->set(self::PREFIX . $shortenedLink, $route);

            return $shortenedLink;
        }
    }

    public function getAll(): array
    {
        $result = [];

        // Inefficient, but will work for now
        foreach ($this->redis->keys(self::PREFIX . "*") as $key) {
            $cleanKey = explode(self::PREFIX, $key)[1];
            $result[$cleanKey] = $this->redis->get($key);
        }

        return $result;
    }

    public function getRedirect($key): bool|string
    {
        $formattedKey = self::PREFIX . self::SHORT_PREF . $key;

        if($this->redis->exists($formattedKey)) {
            return $this->redis->get($formattedKey);
        } else {
            return false;
        }
    }
}
