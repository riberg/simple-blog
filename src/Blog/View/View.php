<?php

namespace Blog\View;

class View
{
    private string $templatesPath;

    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    public function renderHtml(string $templatesName, array $vars = []): void
    {
        extract($vars);

        ob_start();
        include $this->templatesPath . '/' . $templatesName;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }
}