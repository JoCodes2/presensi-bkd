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
    protected $type; // 'total' atau 'pulang'

    public function __construct(string $userId, string $date, string $type = 'total')
    {
        $this->userId = $userId;
        $this->date = $date;
        $this->type = $type;
    }

    public function handle(PresensiRepositories $presensiRepo)
    {
        // Kirim type ke repository
        $presensiRepo->processSingleAlphaUser($this->userId, $this->date, $this->type);
    }
}
