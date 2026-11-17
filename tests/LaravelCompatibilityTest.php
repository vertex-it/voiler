<?php

namespace VertexIT\Voiler\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;
use VertexIT\Voiler\Providers\FortifyServiceProvider;
use VertexIT\Voiler\Providers\VoilerServiceProvider;
use VertexIT\Voiler\Tests\Fixtures\CompatibilityModel;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\DataTablesServiceProvider;

class LaravelCompatibilityTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [DataTablesServiceProvider::class, VoilerServiceProvider::class, FortifyServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(str_repeat('x', 32)));
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite.database', ':memory:');
        $app['config']->set('activitylog.enabled', false);
    }

    public function test_package_registers_resource_routes_and_datatables(): void
    {
        $this->assertTrue(Route::has('admin.users.index'));
        $this->assertTrue(Route::has('admin.users.restore'));
        $this->assertInstanceOf(DataTables::class, $this->app->make('datatables'));
    }

    public function test_base_model_creates_slugs_and_can_be_soft_deleted(): void
    {
        $this->createModelTable();

        $model = CompatibilityModel::create(['name' => 'Laravel compatibility']);

        $this->assertSame('laravel-compatibility', $model->slug);
        $this->assertSame('slug', $model->getRouteKeyName());

        $model->delete();

        $this->assertNull(CompatibilityModel::find($model->id));
        $this->assertNotNull(CompatibilityModel::withTrashed()->find($model->id));
    }

    public function test_datatables_returns_rows_from_a_voiler_model(): void
    {
        $this->createModelTable();
        CompatibilityModel::create(['name' => 'Laravel compatibility']);

        $response = $this->app->make('datatables')
            ->eloquent(CompatibilityModel::query())
            ->toJson();

        $this->assertSame(1, $response->getData(true)['recordsTotal']);
        $this->assertSame('laravel-compatibility', $response->getData(true)['data'][0]['slug']);
    }

    private function createModelTable(): void
    {
        Schema::create('compatibility_models', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

    }
}
