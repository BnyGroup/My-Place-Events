<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUser::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(Role::class);
        $this->call(AdminPermission::class);
        $this->call(FrontSettings::class);
        $this->call(Keyword_Desc_Title::class);
        $this->call(PageSetting::class);
        $this->call(SocailStatus::class);
        $this->call(languages_seed::class);
        $this->call(ConfiguratioSeeder::class);
    }
}
