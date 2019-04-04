<?php

namespace App\Console\Commands;

use App\Console\Commands\Mixins\UserValidationInTheCommand;
use App\Repositories\UserOrderRepository;
use Illuminate\Console\Command;

class AddGoodToTheOrderCommand extends Command
{
    use UserValidationInTheCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:good:add 
                            {--user= : The ID of the user}
                            {--id=* : IDs of the goods with quantity (on ex. --id=1:2)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add good to the user order';

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
     * @return mixed|void
     */
    public function handle()
    {
        $user = $this->prepareUserFromConsole();
        $goods = $this->prepareGoodsDataFromConsole();

        try {
            app(UserOrderRepository::class)->addGoodsToTheUserOrderByIds($user, $goods);
        } catch (\Throwable $exception) {
            exit($this->error($exception->getMessage()));
        }

        $this->info(trans('order.good_added_success'));
    }

    /**
     * @return array
     */
    private function prepareGoodsDataFromConsole(): array
    {
        return array_map(function ($good) {
            $good = explode(':', $good);

            return [
                'id' => intval($good[0]),
                'quantity' => intval($good[1] ?? 1),
            ];
        }, $this->option('id'));
    }
}
