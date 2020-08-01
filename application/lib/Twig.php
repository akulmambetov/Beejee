<?php


namespace Beejee\application\lib;


trait Twig
{
    public static function init()
    {
        $loader = new \Twig\Loader\FilesystemLoader('application/views');
        $twig = new \Twig\Environment($loader, ['debug' => true]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal('session', $_SESSION);
        return $twig;
    }
}