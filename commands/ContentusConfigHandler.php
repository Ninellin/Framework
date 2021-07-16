<?php

namespace Commands;

class ContentusConfigHandler
{
    public function __construct()
    {
        $this->contentusConfigJson = file_get_contents(__DIR__ . '/../config/contentus.json');
        $this->contentusConfig = json_decode($this->contentusConfigJson, true);
    }

    public function getLanguage(): string
    {
        return $this->contentusConfig['lang'];
    }
}
