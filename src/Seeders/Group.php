<?php namespace Datlv\User\Seeders;

use DB;
use Datlv\Kit\Support\VnString;
use Datlv\User\Group as Model;

/**
 * Class Group
 *
 * @package Datlv\User\Seeders
 */
class Group
{
    /**
     * Định dạng $data
     * [
     *      'group_type_1' => [
     *              'Group Name 1' => [
     *                  'meta' => ['meta_1' => meta_value_1,...]], // Nếu có
     *                  'items' => [Group con nếu có]
     *              ...
     *      ],
     *      ...
     * ],
     *
     * @param array $data
     */
    public function seed($data = [])
    {
        DB::table('user_groups')->truncate();
        foreach ($data as $type => $groups) {
            $this->seedGroupItem($this->seedGroupRoot($type), $groups);
        }
    }

    /**
     * @param string $name
     *
     * @return \Datlv\User\Group
     */
    protected function seedGroupRoot($name = '')
    {
        return Model::firstOrCreate([
            'system_name' => $name,
            'full_name' => $name,
        ]);
    }

    /**
     * @param \Datlv\User\Group $root
     * @param array $items
     */
    protected function seedGroupItem($root, $items = [])
    {
        foreach ($items as $name => $item) {
            $attributes = [
                'system_name' => VnString::to_slug($name),
                'full_name' => $name,
            ];
            if (isset($item['meta'])) {
                $attributes += $item['meta'];
            }
            $group = new Model();
            $group->fill($attributes);
            $group->save();
            $group->makeChildOf($root);
            if (isset($item['items']) && is_array($item['items'])) {
                $this->seedGroupItem($group, $item['items']);
            }
        }
    }
}
