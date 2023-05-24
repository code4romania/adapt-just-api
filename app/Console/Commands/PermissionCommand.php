<?php

namespace App\Console\Commands;

use App\Constants\PermissionConstant;
use App\Models\Permission;
use Illuminate\Console\Command;

class PermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update permission list';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $permissionList = PermissionConstant::list();
        foreach ($permissionList as $permissionModule => $permissions) {
            foreach ($permissions as $permissionKey => $permission) {
                $name = $permissionKey.' - '.$permissionModule;
                $dbPermission = Permission::query()->where('name', $name)
                    ->where('guard_name', 'api')
                    ->get();

                if (! $dbPermission->count()) {
                    Permission::create([
                        'name' => $name,
                        'module' => $permissionModule,
                        'guard_name' => 'api',
                    ]);
                }
            }
        }
    }
}
