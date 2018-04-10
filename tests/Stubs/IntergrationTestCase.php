<?php namespace Datlv\User\Tests\Stubs;

use Datlv\User\User;

/**
 * Class IntergrationTestCase
 * @package Datlv\User\Tests\Stubs
 * @author Minh Bang
 */
class IntergrationTestCase extends TestCase
{
    /**
     * @var \Datlv\User\User[]
     */
    protected $users;

    public function setUp()
    {
        parent::setUp();
        $this->users['user'] = factory(User::class)->create();
        $this->users['admin'] = factory(User::class)->states('admin')->create();
        $this->users['super_admin'] = factory(User::class)->states('super_admin')->create();
        $this->app['db']->table('role_user')->insert([
            [
                'user_id' => $this->users['admin']->id,
                'role_group' => 'sys',
                'role_name' => 'admin',
            ],
            [
                'user_id' => $this->users['super_admin']->id,
                'role_group' => 'sys',
                'role_name' => 'sadmin',
            ],
        ]);
    }

    /**
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return array_merge(
            parent::getPackageProviders($app),
            [
                \Datlv\Setting\ServiceProvider::class,
            ]
        );
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('user.middlewares', [
            'user' => ['web', 'role:sys.admin'],
            'group' => ['web', 'role:sys.admin'],
        ]);
    }
}
