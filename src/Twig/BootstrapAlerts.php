<?php

namespace Johndodev\Components\Twig;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class BootstrapAlerts extends Twig_Extension
{
    /**
     * Equivalent en classe bootstrap
     */
    const YELLOW    = 'warning';
    const BLUE      = 'info';
    const RED       = 'danger';
    const GREEN     = 'success';


    /***********************************************************************************************************
     *                              TWIG EXTENSION
     ***********************************************************************************************************/

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('alert',         [$this, 'alert'],         ['is_safe' => ['html'], 'needs_environment' => true]),
            new Twig_SimpleFunction('yellowAlert',   [$this, 'yellowAlert'],   ['is_safe' => ['html'], 'needs_environment' => true]),
            new Twig_SimpleFunction('blueAlert',     [$this, 'blueAlert'],     ['is_safe' => ['html'], 'needs_environment' => true]),
            new Twig_SimpleFunction('redAlert',      [$this, 'redAlert'],      ['is_safe' => ['html'], 'needs_environment' => true]),
            new Twig_SimpleFunction('greenAlert',    [$this, 'greenAlert'],    ['is_safe' => ['html'], 'needs_environment' => true])

        ];
    }

    /***********************************************************************************************************
     *                              TWIG FUNCTIONS
     ***********************************************************************************************************/
    /**
     * @param FlashBagInterface $flashbag
     * @return string
     */
    public function alert(\Twig_Environment $twig, FlashBagInterface $flashbag)
    {
        $outputHTML = '';

        foreach ($flashbag->keys() as $type) {
            foreach ($flashbag->get($type) as $message) {
                $outputHTML .= $twig->render('bootstrap_alerts.html.twig', [
                    'message' => $message,
                    'class' => $type,
                ]);
            }
        }

        return $outputHTML;
    }

    public function yellowAlert(\Twig_Environment $twig, $message)
    {
        return $twig->render('bootstrap_alerts.html.twig', [
            'message' => $message,
            'class' => self::YELLOW,
        ]);
    }

    public function blueAlert(\Twig_Environment $twig, $message)
    {
        return $twig->render('bootstrap_alerts.html.twig', [
            'message' => $message,
            'class' => self::BLUE,
        ]);
    }

    public function redAlert(\Twig_Environment $twig, $message)
    {
        return $twig->render('bootstrap_alerts.html.twig', [
            'message' => $message,
            'class' => self::RED,
        ]);
    }

    public function greenAlert(\Twig_Environment $twig, $message)
    {
        return $twig->render('bootstrap_alerts.html.twig', [
            'message' => $message,
            'class' => self::GREEN,
        ]);
    }
}
