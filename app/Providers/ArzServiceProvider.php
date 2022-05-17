<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Interfaces\ArzInterface;
use App\Contracts\Repositories\ArzRepository;

class ArzServiceProvider extends ServiceProvider
{
    protected $repositories = [
        ArzInterface::class => ArzRepository::class
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach($this->repositories as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }
    }
}
