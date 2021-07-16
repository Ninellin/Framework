<?php

namespace Commands;


class TextHandler
{
    public function __construct(ContentusConfigHandler $contentusConfigHandler)
    {
        $this->contentusConfigHandler = $contentusConfigHandler;
    }

    public function getTextsByLang()
    {
        $lang = $this->contentusConfigHandler->getLanguage();
        return require __DIR__ . '/../lang/' . $lang . '/controllers.php';
    }
}
