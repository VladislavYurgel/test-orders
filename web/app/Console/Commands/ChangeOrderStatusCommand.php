<?php

namespace App\Console\Commands;

use App\Console\Commands\Mixins\UserValidationInTheCommand;
use App\Repositories\UserOrderRepository;
use Illuminate\Console\Command;

class ChangeOrderStatusCommand extends Command
{
    use UserValidationInTheCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:status:change {--user=} {--status=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the order status';

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
        $user = $this->prepareUserFromConsole();
        $status = $this->prepareStatusFromConsole();

        try {
            app(UserOrderRepository::class)->changeUserOrderStatus($user, $status);
        } catch (\Throwable $exception) {
            exit($this->error($exception->getMessage()));
        }

        $this->info(trans('order.change_status_success'));
    }

    /**
     * @return int
     */
    private function prepareStatusFromConsole()
    {
        if (!$this->hasOption('status')) {
            exit($this->error(trans('command.status.is_not_defined')));
        }

        return intval($this->option('status'));
    }
}
