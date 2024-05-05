<?php

namespace App\Console\Commands;

use App\Models\{AccessGroup, AccessMenu, Level, Menu};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MenuConverter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert menu from database to JSON file';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Converting menu to JSON file...');
        $this->convertMenuToJson();
    }

    /**
     * Converts the menu data to JSON format.
     *
     * @return void
     */
    public function convertMenuToJson(): void
    {
        $seederPath = database_path('seeders/backup');
        File::makeDirectory($seederPath, 0777, true, true);
        $this->removeFile($seederPath, ['menu.json', 'access-group.json', 'access-menu.json', 'level.json']);

        $this->exportAccessGroups($seederPath);
        $this->exportLevels($seederPath);
        $this->exportMenus($seederPath);
        $this->exportAccessMenus($seederPath);

        $this->info('Menu has been converted to JSON file. Please run "php artisan db:seed --class=MenuSeeder" to seed the menu to the database.');
    }

    /**
     * Exports access groups to a JSON file.
     *
     * @param string $path
     * @return void
     */
    private function exportAccessGroups(string $path): void
    {
        $data = AccessGroup::all()->map(function ($group) {
            return [
                'id' => $group->id,
                'code' => $group->code,
                'name' => $group->name,
                'menu' => $group->access_menu->pluck('menu.code')
            ];
        });

        File::put("$path/access-group.json", $data->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * Exports levels to a JSON file.
     *
     * @param string $path
     * @return void
     */
    private function exportLevels(string $path): void
    {
        $data = Level::all()->map(function ($level) {
            return [
                'id' => $level->id,
                'code' => $level->code,
                'name' => $level->name,
                'access' => $level->access
            ];
        });

        File::put("$path/level.json", $data->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * Exports menus to a JSON file.
     *
     * @param string $path
     * @return void
     */
    private function exportMenus(string $path): void
    {
        $menus = Menu::with('children')->whereNull('parent_id')->orderBy('created_at')->get();
        $formattedMenus = $this->convertMenu($menus);

        File::put("$path/menu.json", json_encode($formattedMenus, JSON_PRETTY_PRINT));
    }

    /**
     * Exports access menus to a JSON file.
     *
     * @param string $path
     * @return void
     */
    private function exportAccessMenus(string $path): void
    {
        $data = AccessMenu::with('access_group', 'menu')->get()->map(function ($am) {
            return [
                'access_group_code' => $am->access_group->code,
                'code_menu' => $am->menu->code,
                'access' => $am->access
            ];
        });

        File::put("$path/access-menu.json", $data->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * Converts Menu models to a structured array.
     *
     * @param \Illuminate\Database\Eloquent\Collection $menus
     * @return array
     */
    private function convertMenu($menus): array
    {
        return $menus->map(function ($menu) {
            return [
                'title' => $menu->title,
                'subtitle' => $menu->subtitle,
                'code' => $menu->code,
                'model' => class_basename($menu->model),
                'url' => $menu->url,
                'icon' => $menu->icon,
                'type' => $menu->type,
                'show' => $menu->show,
                'active' => $menu->active,
                'sort' => $menu->sort,
                'coming_soon' => $menu->coming_soon,
                'maintenance' => $menu->maintenance,
                'children' => $this->convertMenu($menu->children)
            ];
        })->toArray();
    }

    /**
     * Removes specified files from the given directory.
     *
     * @param string $path
     * @param array $files
     * @return void
     */
    private function removeFile(string $path, array $files): void
    {
        foreach ($files as $file) {
            if (File::exists("$path/$file")) {
                File::delete("$path/$file");
            }
        }
    }
}
