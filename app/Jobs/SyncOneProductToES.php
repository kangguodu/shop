<?php
/**
 * Name: 将同一产品同步到ES队列.
 * User: 董坤鸿
 * Date: 2018/10/27
 * Time: 下午3:9
 */


namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncOneProductToES implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;

    /**
     * Create a new job instance.
     *
     * SyncOneProductToES constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->product->toArray();
        app('es')->index([
           'index' => 'products',
            'type' => '_doc',
            'id' => $data['id'],
            'body' => $data,
        ]);
    }
}
