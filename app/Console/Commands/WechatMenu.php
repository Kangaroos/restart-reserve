<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Overtrue\Wechat\Menu;
use Overtrue\Wechat\MenuItem;

class WechatMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create wechat menu command.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Menu $menuService)
    {
        parent::__construct();

        $this->menuService = $menuService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $baseUrl = $this->ask('请输入微信菜单的Base url：');

        $button = new MenuItem("会员服务");

        $menus = array(
            new MenuItem("预约课程", 'view', $baseUrl . '/stores'),
            $button->buttons(array(
                new MenuItem('我的预约', 'view', $baseUrl . '/members/reserve'),
                new MenuItem('会员中心', 'view', $baseUrl . '/members'),
            )),
        );

        try {
            $this->menuService->set($menus);// 请求微信服务器
            $this->info('微信菜单设置成功');
        } catch (\Exception $e) {
            $this->error('微信菜单设置失败!' . $e->getMessage());
        }

    }
}
