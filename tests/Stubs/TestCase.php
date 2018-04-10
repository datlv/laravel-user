<?php namespace Datlv\User\Tests\Stubs;
/**
 * Class TestCase
 * @package Datlv\User\Tests\Stubs
 * @author Minh Bang
 */
class TestCase extends \Datlv\Kit\Testing\TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->withFactories(__DIR__.'/../../database/factories');
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
                \Datlv\User\ServiceProvider::class,
                \Datlv\Authority\ServiceProvider::class,
                \Datlv\Meta\ServiceProvider::class,
            ]
        );
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app->bind('path.public', function () {
            return __DIR__ . '/public';
        });
    }
}
