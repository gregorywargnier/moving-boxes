<?php
namespace App\Twig;
 
use Symfony\Component\Intl\Intl;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

 
class LocalesExtension extends AbstractExtension
{
    private $locales;
    private $params;
    private $localeCodes;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->localeCodes = explode('|', $this->params->get('locales'));
    }
 
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('locales', [$this, 'getLocales']),
        ];
    }
 
    public function getLocales()
    {
        if (null !== $this->locales) 
        {
            return $this->locales;
        }
 
        $this->locales = [];
        foreach ($this->localeCodes as $localeCode) 
        {
            $this->locales[] = [
                'code' => $localeCode, 
                'name' => ucfirst(Intl::getLocaleBundle()->getLocaleName($localeCode, $localeCode))
            ];
        }
 
        return $this->locales;
    }
}