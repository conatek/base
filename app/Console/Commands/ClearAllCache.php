<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearAllCache extends Command
{
    // Cambié el nombre a 'refresh' porque realmente estás regenerando
    protected $signature = 'cache:refresh';

    protected $description = 'Limpiar y regenerar la caché para producción';

    public function handle()
    {
        $this->info('>> Limpiando cachés antiguas...');
        $this->call('optimize:clear'); // Primero borramos todo

        $this->info('>> Generando nuevas cachés...');
        $this->call('config:cache'); // Importante para producción
        $this->call('route:cache');  // Importante para producción
        $this->call('view:cache');   // Opcional, pre-compila vistas blade

        // optimize incuye varias optimizaciones del core
        // $this->call('optimize');

        $this->info('>> ¡Sistema optimizado y regenerado!');

        return Command::SUCCESS;
    }
}
