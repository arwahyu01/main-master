<?php

namespace App\Console\Commands;

use App\Models\AccessGroup;
use App\Models\AccessMenu;
use App\Models\Level;
use App\Models\Menu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MenuConverter extends Command
{
    protected $signature = 'app:convert-menu';

    protected $description = 'Convert menu from database to json file';

    public function handle(): void
    {
        $this->info('Converting menu to json file...');
        $this->convertMenuToJson();
    }

    public function convertMenuToJson(): void
    {
        // export menu
        $menu = Menu::with(['children'])->whereNull('parent_id')->orderBy('created_at')->get();
        $menu = $this->convertMenu($menu);
        File::makeDirectory(config_path('seeders'), 0777, true, true);
        File::put(config_path('seeders/menu.json'), json_encode($menu, JSON_PRETTY_PRINT));

        // export access group
        foreach (AccessGroup::all() as $group) {
            $data[] = [
                'id' => $group->id,
                'code' => $group->code,
                'name' => $group->name,
                'menu'=>$group->access_menu->pluck('menu.code')->toArray()
            ];
        }
        File::put(config_path('seeders/access-group.json'), json_encode($data ?? [], JSON_PRETTY_PRINT));

        // export access menu
        foreach (AccessMenu::all() as $am){
            $accesMenu[] = [
                'access_group_code' => $am->access_group->code,
                'code_menu' => $am->menu->code,
                'access' => $am->access
            ];
        }
        File::put(config_path('seeders/access-menu.json'), json_encode($accesMenu ?? [], JSON_PRETTY_PRINT));

        // export level
        foreach (Level::all() as $level){
            $dataLevel[] = [
                'id' => $level->id,
                'code' => $level->code,
                'name' => $level->name,
                'access' => $level->access
            ];
        }
        File::put(config_path('seeders/level.json'), json_encode($dataLevel ?? [], JSON_PRETTY_PRINT));
        $this->info('Menu has been converted to json file, please run "php artisan db:seed --class=MenuSeeder" to seed menu to database');
    }

    private function convertMenu($menu): array
    {
        foreach ($menu as $dt) {
            $data[] = [
                'title' => $dt->title,
                'subtitle' => $dt->subtitle,
                'code' => $dt->code,
                'model' => collect(explode('\\', $dt->model))->last(),
                'url' => $dt->url,
                'icon' => $dt->icon,
                'type' => $dt->type,
                'show' => $dt->show,
                'active' => $dt->active,
                'sort' => $dt->sort,
                'children' => $this->convertMenu($dt->children),
            ];
        }
        return $data ?? [];
    }
}
