<?php

namespace ViewComponents\TestingHelpers\Application\Http;

use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Component\DataView;
use ViewComponents\ViewComponents\Component\Layout;
use ViewComponents\ViewComponents\Component\TemplateView;

trait DefaultLayoutTrait
{
    /** @var  Layout|null */
    private $layoutInstance;

    protected function initializeLayout()
    {
        $this->layoutInstance = new Layout('layout');
        $actions = EasyRouting::getUris(static::class);
        $this->layoutInstance->section('menu')->addChild(new TemplateView(
            'menu/menu',
            compact('actions')
        ));
    }

    protected function layout()
    {
        if ($this->layoutInstance === null) {
            $this->initializeLayout();
        }
        return $this->layoutInstance;
    }

    protected function page($view, $title = '')
    {
        $view = $view instanceof ViewComponentInterface
            ? $view
            : new DataView($view);
        return $this
            ->layout()
            ->addChild($view)
            ->setData(['title' => $title])
            ->render();
    }
}