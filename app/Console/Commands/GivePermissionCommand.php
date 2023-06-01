<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Console\Command;

class GivePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:give {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give Permission to specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::query()->find($this->argument('user_id'));
        if (! $user) {
            dd('User not found');
        }
        $permissions = Permission::all();
        $user->givePermissionTo($permissions);
    }
}
