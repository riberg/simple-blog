<?php

namespace Blog\Controllers;

class MainController
{
    public function main()
    {
        echo 'Main page';
    }

    public function sayHello(string $name)
    {
        echo 'Hello, ' . $name;
    }

    public function sayBye(string $name)
    {
        echo 'Bye, ' . $name;
    }
}