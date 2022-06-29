<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->ask('What is your email?');

        Artisan::call('permission:create-permission 超級管理員');

        $admin = Admin::where('email', $email)->first();

        if ($admin) {
            $admin->givePermissionTo('超級管理員');
        }

        return 0;
    }
}
