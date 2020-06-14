<?php

namespace Erorus\CASC\VersionConfig;

use Erorus\CASC\HTTP as CASCHTTP;
use Erorus\CASC\VersionConfig;

class HTTP extends VersionConfig {

    const HTTP_HOST = 'http://us.patch.battle.net:1119/';

    protected function getTACTData($file) {
        $cachePath = 'http-versions/' . $this->getProgram() . '/' . $file;

        $data = $this->getCachedResponse($cachePath, static::MAX_CACHE_AGE);
        if (!$data) {
            $url  = sprintf('%s%s/%s', static::HTTP_HOST, $this->getProgram(), $file);
            try {
                $data = CASCHTTP::get($url);
            } catch (\Exception $e) {
                echo "\n - " . $e->getMessage() . " ";
                $data = '';
            }
            if (!$data) {
                $data = $this->getCachedResponse($cachePath);
            } else {
                $this->cache->write($cachePath, $data);
            }
        }

        return $data;
    }
}
