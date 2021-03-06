<?php
namespace Datlv\User;

use Datlv\Kit\Traits\Presenter\NestablePresenter;
use UserManager;
/**
 * Class GroupManager
 *
 * @package Datlv\User
 */
class GroupManager
{
    use NestablePresenter;
    /**
     * Current type root
     *
     * @var \Datlv\User\Group
     */
    protected $_type_root;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Datlv\User\Group[]
     */
    protected $_roots;
    /**
     * @var int
     */
    public $max_depth;

    /**
     * GroupManager constructor.
     *
     * @param string $type
     * @param int $max_depth
     */
    function __construct($type, $max_depth)
    {
        $this->max_depth = $max_depth;
        $this->_type_root = Group::firstOrCreate([
            'system_name'  => $type,
            'full_name'    => $type,
        ]);
    }

    /**
     * Render html theo định dạng của jquery nestable plugin
     *
     * @see https://github.com/dbushell/Nestable
     * @return string
     */
    public function nestable()
    {
        return $this->toNestable($this->_type_root, $this->max_depth);
    }

    /**
     * Tạo data select tag theo định dạng selectize
     *
     * @return string
     */
    public function selectize()
    {
        return $this->toSelectize($this->roots());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Datlv\User\Group[]
     */
    public function roots()
    {
        if (is_null($this->_roots)) {
            $this->_roots = $this->_type_root->getImmediateDescendants();
        }
        return $this->_roots;
    }

    /**
     * Lấy danh sách cơ quan, đơn vị chính, level = 1
     *
     * @param string $attribute
     * @param string $key
     *
     * @return array
     */
    public function listRoots($attribute = 'full_name', $key = 'id')
    {
        return $this->roots()->pluck($attribute, $key)->all();
    }

    /**
     * @return array
     */
    public function typeNames()
    {
        return UserManager::groupTypeNames();
    }

    /**
     * @return string
     */
    public function typeName()
    {
        return UserManager::groupTypeNames($this->_type_root->system_name);
    }

    /**
     * @return \Datlv\User\Group|static
     */
    public function typeRoot()
    {
        return $this->_type_root;
    }
}
