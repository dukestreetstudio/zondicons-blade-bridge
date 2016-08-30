<?php

namespace Zondicons;

use BladeSvg\IconFactory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ZondiconsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::extend(function ($html) {
            return preg_replace_callback('/\@icon((\(.+\)\-\>.+)*\(.+\))/', function ($matches) {
                return '<?php echo zondicon'.$matches[1].'; ?>';
            }, $html);
        });

        $this->publishes([
            __DIR__.'/../config/zondicons.php' => config_path('zondicons.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(IconFactory::class, function () {
            $config = array_merge([
            'icon_path' => base_path('vendor/'),
            'spritesheet_path' => 'path/to/spritesheet',
            'inline' => false,
            'class' => 'icon',
            ], config('zondicons'));

            return new IconFactory($config);
        });
    }
}
