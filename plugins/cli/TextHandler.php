<?php

namespace Commands;


use Commands\ContentusConfigHandler;

class TextHandler
{
    public function __construct(ContentusConfigHandler $contentusConfigHandler)
    {
        $this->contentusConfigHandler = $contentusConfigHandler;
    }

    public function getTextsByLang(): array
    {
        $lang = $this->contentusConfigHandler->getLanguage();
        return require __DIR__ . '/../../lang/' . $lang . '/controllers.php';
    }
}
