<?php

namespace App\Jobs;

use App\Repositories\PresensiRepositories;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AlphaNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $date;

    public function __construct(string $userId, string $date)
    {
        $this->userId = $userId;
        $this->date = $date;
    }

    public function handle(PresensiRepositories $presensiRepo)
    {
        $presensiRepo->processSingleAlphaUser($this->userId, $this->date);
    }
}
