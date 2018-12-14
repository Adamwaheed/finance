<?php

namespace Atolon\Finance\Commands;

use Illuminate\Console\Command;

class Finance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finance:name {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $name = ucfirst($this->argument('name'));

        $events = [
            ['name' => $name . 'InvoiceCreated'],
            ['name' => $name . 'InvoiceCancelled'],
            ['name' => $name . 'InvoicePaid'],
            ['name' => $name . 'ReversePayment'],
        ];


        $dir = app_path('Modules/Finance/Events/' . $name . '/');
        $charges = app_path('Modules/Finance/Charges/');

        if (!file_exists($charges)) {
            mkdir($charges, 0755, true);
        }

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        foreach ($events as $item) {
            $newName = $item['name'];
$event = "<?php
namespace App\Modules\Finance\Events\\$name;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
class $newName
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function __construct()
    {
    }
}
        " . PHP_EOL;


            $path = app_path('Modules/Finance/Events/' . $name . '/');


            $path = $path . $newName . '.php';
            file_put_contents($path, $event);
        }

    $ChargesName = $name.'Charge';
        $bluePrint = <<<'EOD'
            <?php
namespace App\Modules\Finance\Charges;

use Atolon\Finance\Interfaces\FinanceInterface;

class class_name implements FinanceInterface
{
    public $details;
    public $total;
    public $type;
    public $status;
    public $model;
    public $error;
    public $error_message;
    public $invoiceable_type;
    public $invoiceable_id;
    public $item = [];

    public function __construct($model)
    {
        $this->error = false;
        $this->error_message = 'no error';
        $this->invoiceable_type = get_class($model);
        $this->invoiceable_id = $model->id;

    }
    /* this function will generate all charges
     * */
    public function calculate(){
        $this->set_detail();
        $this->set_total();
        $this->set_type();
        $this->set_items();
    }
    //set total
    public function set_total()
    {
        $this->total = 0;

    }

    public function set_detail()
    {
        $this->details = 'Hello this is details of invoce';
    }

    public function set_type()
    {
        $this->type = 'normal';
    }

    public function set_items()
    {
        $this->item = [];
    }
}
EOD;

        $newCharges = $charges . $name . 'Charge.php';
       $newstring = str_replace("class_name",$ChargesName,$bluePrint);
        file_put_contents($newCharges, $newstring);


//        if ($written) {
//            $this->info('Created new Repo ' . $this->argument('name') . 'Repository.php in App\Repositories.');
//        } else {
//            $this->info('Something went wrong');
//        }
    }
}
