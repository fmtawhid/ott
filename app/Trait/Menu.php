<?php

namespace App\Trait;

trait Menu
{
    protected function hrLine($menu, $order = 0)
    {
        $menu->add('<hr class="hr-horizontal">', ['url' => 'javascript:void(0)'])->data(['order' => $order])->link->attr(['class' => 'disabled']);
    }

    protected function staticMenu($menu, $data)
    {
        $menu->add('
                <span class="default-icon">' . $data['title'] . '</span>
                <span class="mini-icon">-</span>
            ', [
            'url' => '#',
            'class' => 'nav-item static-item',
        ])
            ->data(['order' => $data['order'] ?? 0, 'permission' => $data['permission'] ?? []])
            ->link->attr([
                'class' => 'nav-link static-item disabled',
            ]);
    }

    protected function mainRoute($menu, $data)
    {
        $menuData = [];

        if (isset($data['route'])) {
            $menuData['route'] = $data['route'];
        } elseif (isset($data['url'])) {
            $menuData['url'] = $data['url'] ?? '#';
        } else {
            $menuData['route'] = 'login';
        }

        $linkData = ['class' => 'nav-link'];

        if (isset($data['target']) && $data['target']) {
            $linkData['target'] = $data['target'];
        }

        $menuData['class'] = 'nav-item';

        $menu->add($this->createMenuTitle($data['title'] ?? ''), $menuData)
            ->data([
                'order' => $data['order'] ?? 0,
                'activematches' => $data['active'] ?? '',
                'permission' => $data['permission'] ?? [],
            ])
            ->prepend($this->createMenuIcon($data['icon'] ?? '', $data['title']))
            ->append($this->createMenuIcon($data['sub_icon'] ?? ''))
            ->link->attr($linkData);
    }

    protected function parentMenu($menu, $data)
    {
        $shortTitle = isset($data['icon']) ? $this->createMenuShortTitle(substr($data['title'], 0, 1)) : '';

        $sub_menu = $menu->add($this->createMenuTitle($data['title'] ?? ''), ['class' => $data['li_class'] ?? 'nav-item'])
            ->nickname($data['nickname'])
            ->data([
                'order' => $data['order'] ?? 0,
                'activematches' => $data['active'] ?? '',
                'permission' => $data['permission'] ?? [],
            ])
            ->prepend($this->createMenuIcon($data['icon'] ?? '', $data['title']) . $shortTitle);

        $sub_menu->link->attr([
            'class' => $data['a_class'] ?? 'nav-link',
            'href' => '#' . $data['nickname'] ?? 'sidemenu',
            'data-bs-parent' => $data['parent'] ?? '#sidebar-menu',
        ]);
        $sub_menu->url('#' . $data['nickname'] ?? 'sidemenu');

        return $sub_menu;
    }

    protected function childMain($menu, $data)
    {
        $shortTitle = isset($data['icon']) ? $this->createMenuShortTitle(substr($data['title'], 0, 1)) : '';
        $menu->add($shortTitle . $this->createMenuTitle($data['title']), [
            'route' => $data['route'],
            'class' => $data['li_class'] ?? 'nav-item',
        ])
            ->data([
                'order' => $data['order'] ?? 0,
                'activematches' => $data['active'] ?? '',
                'permission' => $data['permission'] ?? [],
            ])
            ->prepend($this->createMenuIcon($data['icon'] ?? null, $data['title']))
            ->link->attr(['class' => $data['a_class'] ?? 'nav-link']);
    }

    protected function popupMenu($menu, $data)
    {
        $menu->add($this->createMenuShortTitle($data['shortTitle'] ?? '') . $this->createMenuTitle($data['title']), [
            'url' => 'javascript:void(0)',
            'class' => 'nav-item',
            'data-bs-toggle' => $data['extra']['toggle'],
            'data-bs-target' => $data['extra']['target'],
        ])
            ->data([
                'order' => $data['order'] ?? 0,
                'activematches' => $data['active'] ?? '',
                'permission' => $data['permission'] ?? [],
            ])
            ->link->attr(['class' => 'nav-link']);
    }

    protected function createMenuTitle($title)
    {
        return "<span class='item-name'>$title</span>";
    }

    protected function createMenuShortTitle($shortTitle)
    {
        return "<i class='sidenav-mini-icon'> $shortTitle </i>";
    }

    protected function createMenuIcon($cutomeIcon = null, $title = null)
    {
        $icon = '<i class="fa-solid fa-circle" style="font-size: .625rem"></i>';

        if (isset($cutomeIcon)) {
            $iconTooltip = isset($title) ? 'data-bs-toggle="tooltip" data-bs-placement="right" aria-label="' . $title . '" data-bs-original-title="' . $title . '"' : '';
            $icon = "<i class='icon $cutomeIcon' $iconTooltip></i>";
        }

        return $icon;
    }
}
