<?php

namespace App\Twig;

use App\App;
use App\Geek\GeekReference;
use App\Service\Markdown;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Twig_Extension;
use Twig_SimpleFunction;

class CogExtension extends Twig_Extension
{
    /**
     * @var Markdown
     */
    private $markdown;
    /**
     * @var
     */
    private $geekConsoles;

    public function __construct(Markdown $markdown, GeekReference $geekReference)
    {
        $this->markdown = $markdown;
        $this->geekConsoles = $geekReference->consoles();
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('array_chunk', [$this, 'arrayChunk']),
            new \Twig_SimpleFunction('levelLabel', [$this, 'levelLabel']),
            new \Twig_SimpleFunction('geekLevelLabel', [$this, 'geekLevelLabel']),
            new \Twig_SimpleFunction('consoleLabel', [$this, 'consoleLabel']),
            new \Twig_SimpleFunction('toastr', [$this, 'toastr'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdown', [$this, 'markdown'], ['is_safe' => ['html']])
        ];
    }

    public function arrayChunk(array $array, $size, $preserveKeys = false)
    {
        return array_chunk($array, $size, $preserveKeys);
    }

    public function levelLabel($level = null)
    {
        switch ($level) {
            case 1 : return '1/5 : Sympathisant';
            case 2 : return '2/5 : A l\'occasion';
            case 3 : return '3/5 : Régulièrement';
            case 4 : return '4/5 : Souvent';
            case 5 : return '5/5 : Accro';
        }

        return '';
    }

    public function geekLevelLabel($level)
    {
        switch ($level) {
            case 0 : return 'Mon quoi ? (0/5)';
            case 1 : return 'Juste sympathisant (1/5)';
            case 2 : return 'Je suis un geek... mais je me soigne (2/5)';
            case 3 : return 'Geek modéré, polyvalent  (3/5)';
            case 4 : return 'Geek confirmé  (4/5)';
            case 5 : return 'Un master geek, je suis  (5/5)';
        }
    }

    // TODO mieux
    public function consoleLabel($console)
    {
        return $this->geekConsoles[$console];
    }

    public function toastr(\Twig_Environment $twig, FlashBag $flashBag)
    {
        $outputHTML = '';

        foreach ($flashBag->keys() as $type) {
            foreach ($flashBag->get($type) as $message) {
                if ($type == 'danger') {
                    $type = 'error';
                }

                $outputHTML .= $twig->render('Common/toast.html.twig', [
                    'type' => $type,
                    'message' => $message,
                ]);
            }
        }

        return $outputHTML;
    }

    public function markdown($text)
    {
        return $this->markdown->parse($text);
    }
}
