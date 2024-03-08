<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BasicRoleAndPermissionGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:basic-role-and-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will generate basic roles and permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call("config:clear");
        Artisan::call("cache:clear");
        Artisan::call("permission:cache-reset");
        $features = config('features');
        foreach($features as $feature){
            foreach($feature['actions'] as $action){
                Permission::findOrCreate($action);
            }
        }
        $roles = config('roles');
        foreach($roles as $name => $value){
            $role = Role::findOrCreate($name);
            if(!isset($value['permission'])){
                continue;
            }
            // assign permissions to role
            foreach($value['permission'] as $key => $actions){
                if($actions[0] === '*'){
                    $permissions = array_values($features[$key]['actions']);
                }else{
                    foreach($actions as $action){
                        $permissions[] = $features[$key]['actions'][$action];
                    }
                }
                foreach($permissions as $name){
                    $role->givePermissionTo(Permission::whereName($name)->first());
                }
            }
        }

        Role::where('guard_name', '=', 'web')->update(array('guard_name' => 'api'));
        Permission::where('guard_name', '=', 'web')->update(array('guard_name' => 'api'));

        return 0;
    }
}
