<?php


class TextHandler
{
    public function __construct()
    {
        $this->contentusConfigHandler = new ContentusConfigHandler();
    }

    public function getTextsByLang()
    {
        $lang = $this->contentusConfigHandler->getLanguage();
        return require __DIR__ . '/../lang/' . $lang . '/controllers.php';
    }
}
