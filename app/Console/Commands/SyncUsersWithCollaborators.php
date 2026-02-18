<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Collaborator;
use Illuminate\Support\Facades\DB;

class SyncUsersWithCollaborators extends Command
{
    protected $signature = 'users:sync-collaborators {--dry-run : Simular el proceso sin realizar cambios}';
    protected $description = 'Sincroniza usuarios con colaboradores según reglas de negocio específicas.';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $users = User::doesntHave('collaborator')->get();

        if ($users->isEmpty()) {
            $this->info('No hay usuarios pendientes por sincronizar.');
            return;
        }

        $toUpdate = [];
        $toCreate = [];

        foreach ($users as $user) {
            $existingCollaborator = Collaborator::where('email', $user->email)
                ->where('company_id', $user->company_id)
                ->whereNull('user_id')
                ->first();

            if ($existingCollaborator) {
                // CASO 1: El Colaborador manda. Sincronizaremos el Usuario con datos del Colaborador.
                $toUpdate[] = [
                    'user_id'    => $user->id,
                    'email'      => $user->email,
                    'new_name'   => "{$existingCollaborator->name} {$existingCollaborator->first_surname}",
                    'collab_id'  => $existingCollaborator->id,
                ];
            } else {
                // CASO 2: El Usuario manda. Se creará un Colaborador con datos del Usuario.
                $toCreate[] = [
                    'user_id'    => $user->id,
                    'name'       => "{$user->name} {$user->first_surname}",
                    'email'      => $user->email,
                ];
            }
        }

        if ($isDryRun) {
            $this->warn('--- MODO SIMULACIÓN ---');
            $this->info("\n1. VINCULACIÓN: Se actualizará el NOMBRE DEL USUARIO usando datos del Colaborador existente:");
            $this->table(['User ID', 'Email', 'Nuevo Nombre (desde Colab)', 'Collab ID'], $toUpdate);

            $this->info("\n2. CREACIÓN: Se creará un NUEVO COLABORADOR usando datos del Usuario:");
            $this->table(['User ID', 'Nombre (desde User)', 'Email'], $toCreate);
            return;
        }

        $this->info("Ejecutando cambios...");
        $bar = $this->output->createProgressBar(count($users));
        $bar->start();

        foreach ($users as $user) {
            DB::transaction(function () use ($user) {
                $existingCollaborator = Collaborator::where('email', $user->email)
                    ->where('company_id', $user->company_id)
                    ->whereNull('user_id')
                    ->first();

                if ($existingCollaborator) {
                    // CASO 1: Sincronizar Usuario <--- Colaborador
                    $user->update([
                        'name'           => $existingCollaborator->name,
                        'first_surname'  => $existingCollaborator->first_surname,
                        'second_surname' => $existingCollaborator->second_surname,
                    ]);

                    $existingCollaborator->update(['user_id' => $user->id]);
                } else {
                    // CASO 2: Sincronizar Colaborador <--- Usuario
                    Collaborator::create([
                        'user_id'        => $user->id,
                        'company_id'     => $user->company_id,
                        'name'           => $user->name,
                        'first_surname'  => $user->first_surname,
                        'second_surname' => $user->second_surname,
                        'email'          => $user->email,
                        'is_active'      => 1,
                    ]);
                }
            });
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Proceso finalizado.');
    }
}
