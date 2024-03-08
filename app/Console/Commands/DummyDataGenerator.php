<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DummyDataGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:dummy-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will generate dummy data';

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
     * @return mixed
     */
    public function handle()
    {
        Artisan::call("migrate:fresh");
        Artisan::call("db:seed --class=UsersTableSeeder");
        Artisan::call("generate:basic-role-and-permission");
        // Artisan::call("db:seed --class=ConversationSeeder");
        Artisan::call("db:seed --class=MessageSeeder");
        Artisan::call("passport:client --personal --name=chatApp");
        // Artisan::call("composer dump-autoload");

        DB::statement('
            DELETE c1
            FROM conversations c1
            LEFT JOIN conversations c2 ON (c1.sender_id = c2.sender_id AND c1.receiver_id = c2.receiver_id AND c1.id < c2.id)
                                        OR (c1.sender_id = c2.receiver_id AND c1.receiver_id = c2.sender_id AND c1.id < c2.id)
            WHERE c1.sender_id = c1.receiver_id OR c2.id IS NOT NULL
        ');



        Artisan::call("route:cache");

        $this->setUpRoleAndPermissionsToUser();
        
        $this->info("Dummy data successfully generated!");
        $dummy_credentials = "
        ###########################################
        # Admin Account                           #
        # --------------                          #
        # Email: support@chatapp.com              #
        # Password: password                      #
        ###########################################
        ";
        
        $this->info($dummy_credentials);
    }
    private function setUpRoleAndPermissionsToUser()
    {
        $users = User::all();
        $roles = Role::all();

        foreach ($users as $user) {
            // Ensure every user gets at least one role
            $randomRoles = $roles->random(rand(1, count($roles)));
            
            if ($randomRoles->isEmpty()) {
                // If no roles are randomly selected, assign a default role
                $defaultRole = $roles->first();
                $user->roles()->attach($defaultRole->id);
            } else {
                $user->roles()->sync($randomRoles->pluck('id'));
            }

            // Assign permissions based on the assigned roles
            foreach ($user->roles as $role) {
                $user->permissions()->sync($role->permissions->pluck('id'));
            }
        }
    }

    

}