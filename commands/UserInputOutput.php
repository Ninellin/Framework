<?php


class UserInputOutput
{

    public function askUserForInput($question)
    {
        return readline($question);
    }

    public function inputErrorHandling($exception)
    {
        die($exception->getMessage());
    }
}
