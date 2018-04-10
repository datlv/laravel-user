<?php

namespace Datlv\User;

use Datlv\Kit\Traits\Presenter\DatetimePresenter;
use Laracasts\Presenter\Presenter as BasePresenter;
use Authority;

/**
 * Class Presenter
 *
 * @package Datlv\User
 */
class Presenter extends BasePresenter
{
    use DatetimePresenter;

    /**
     * @return string
     */
    public function roles()
    {
        return '<code>'.implode('</code><code>', Authority::user($this->entity)->roleTitles()).'</code>';
    }

    /**
     * @param string $attribute
     * @return string
     */
    public function group($attribute = 'full_name')
    {
        /** @var \Datlv\User\Group $group */
        $group = $this->entity->group;

        return $group ? $group->{$attribute} : null;
    }
}
