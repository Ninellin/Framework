<?php

namespace Commands;

class UserInputOutput
{

    public function askUserForInput($question): string
    {
        return readline($question);
    }

    public function inputErrorHandling($exception)
    {
        die($exception->getMessage());
    }
}
