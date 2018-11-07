<?php

namespace Johndodev\Components\Twig;

use App\Entity\Picture;
use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PicturesExtension extends \Twig_Extension
{
    /**
     * @var UrlGenerator
     */
    private $router;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->router = $urlGenerator;
    }

    /***********************************************************************************************************
     *                              TWIG EXTENSION
     ***********************************************************************************************************/

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('crop', [$this, 'crop']),
            new \Twig_SimpleFilter('resize', [$this, 'resize']),
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('picture', [$this, 'picture'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('userAvatar', [$this, 'userAvatar'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('picturePath', [$this, 'path'], ['is_safe' => ['html']]),
        ];
    }

    /***********************************************************************************************************
     *                                  FILTERS
     ***********************************************************************************************************/
    public function crop($path, $x, $y = null)
    {
        if (strpos($path, '?')) {
            return $path.'&c='.$x.($y ? 'x'.$y:'');
        } else {
            return $path.'?c='.$x.($y ? 'x'.$y:'');
        }

    }

    public function resize($path, $x, $y = null)
    {
        if (strpos($path, '?')) {
            return $path.'&r='.$x.($y ? 'x'.$y:'');
        } else {
            return $path.'?r='.$x.($y ? 'x'.$y:'');
        }
    }

    /***********************************************************************************************************
     *                                  FUNCTIONS
     ***********************************************************************************************************/
    public function userAvatar(User $user)
    {
        if($user->getAvatar()) {
            return $this->getRoute($user->getAvatar()->getPath());
        }

        if ($user->getSexe() == 'male') {
            return $this->getRoute('pictures/default_male.png');
        }
        else {
            return $this->getRoute('pictures/default_female.png');
        }
    }

    public function picture(Picture $picture = null)
    {
        if ($picture) {
            return $this->getRoute($picture->getPath(), $picture->getCropQueryDatas());
        }

        return $this->getRoute('pictures/default_picture.jpg');
    }

    public function path($path)
    {
        return $this->getRoute($path);
    }

    /***********************************************************************************************************
     *                              TOOLS
     ***********************************************************************************************************/
    /**
     * @param string $path the path of the picture (ex: $picture->getPath() or "pictures/pic.jpg")
     */
    private function getRoute($path, array $params = [])
    {
        $params['path'] = $path;

        return $this->router->generate('media.pictures', $params);
    }
}
