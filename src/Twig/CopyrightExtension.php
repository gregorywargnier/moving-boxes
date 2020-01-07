<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CopyrightExtension extends AbstractExtension
{
    private $params;
    private $year;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->year = (new \Datetime())->format('Y');
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('copyright', [$this, 'copyright']),
        ];
    }

    public function copyright(?string $since=null, bool $companyBeforeDate=true)
    {
        $company = $this->params->get('appTitle');
        $since = $since ?? $this->year;
        $date = ($since < $this->year) ? $since."-".$this->year : $since;
        
        $text = "&copy; ";
        $text.= $companyBeforeDate ? $company." ".$date : $date." ".$company;

        return html_entity_decode($text);
    }
}
