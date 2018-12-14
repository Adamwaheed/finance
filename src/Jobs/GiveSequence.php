<?php

namespace Atolon\Finance\Jobs;

use Atolon\Finance\Models\Sequence;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GiveSequence implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model;

    public $sequence;

    public $number;

    public $current_number;

    public $reflect;

    public $field;

    public $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model,$field,$type)
    {


        $this->reflect = new \ReflectionClass($model);

        $this->field  = $field;

        $this->model = $model;

        $this->type = $type;





    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->sequence = Sequence::whereDataType($this->reflect->getShortName())->whereType($this->type)->first();

        $this->reset();

        $this->current_number = (int)$this->sequence->current_number;

        $this->current_number= $this->current_number + 1;


        $this->sequence->current_number = $this->current_number;

        $this->sequence->date = date("Ymd");

        $this->sequence->save();

        $filename = $this->field;

        $this->model->$filename = $this->FormatedNumber();

        $this->model->save();




    }


    private function FormatedNumber(){

        $prefix = $this->sequence->prefix;
        $post_fix = $this->sequence->post_fix;
        $current_number = $this->sequence->current_number;
        $date = $this->sequence->date;

        $key = array("current_number", "prefix", "post_fix","date");

        $value = array($current_number,$prefix, $post_fix,$date);

        return str_replace(" ","",str_replace( $key, $value,$this->sequence->template));

    }

    private function reset(){

        $Carbon = new Carbon();

        $function = 'startOf'.ucfirst($this->sequence->reset_by);

        $Carbon->$function();

        $resetDate = $Carbon->hour(00)->minute(00)->second(00);

        $now = Carbon::now()->hour(00)->minute(00)->second(00);

        if($now->equalTo($resetDate)){

            $this->reset_to_initial_value();

        }
    }

    private function reset_to_initial_value(){
        $this->sequence->current_number = $this->sequence->initial_number;

        $this->sequence->save();

        $this->sequence = Sequence::whereDataType($this->reflect->getShortName())->first();
    }
}
