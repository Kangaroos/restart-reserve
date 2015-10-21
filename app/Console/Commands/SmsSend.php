<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Toplan\Sms\Sms;

class SmsSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send sms to mobile.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Sms $sms)
    {
        parent::__construct();

        $this->sms = $sms;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $phoneNumber = $this->ask('请输入手机号码：');
        $code = $this->ask('请输入验证码（随便4位数字）：');

//        $result = $this->sms->to($phoneNumber)->content('【锐思达健身】尊敬的用户您好，您的手机验证码：'.$code.'，为了保证安全，请勿将信息泄露（请与5分钟内输入验证码）')->send();
        $result = $this->sms->to($phoneNumber)->data([$code, 5])->send();

        if($result === true) {
            $this->info('短信发送成功');
        } else {
            $this->error('短信发送失败!');
        }

    }
}
