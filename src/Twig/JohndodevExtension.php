<?php

namespace Johndodev\Components\Twig;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Twig_Extension;
use Twig_SimpleFunction;

class JohndodevExtension extends Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('toastr', [$this, 'toastr'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
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
}
