<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ReservationService;

class ExpireOldReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire old unpaid reservations';

    /**
     * The reservation service instance.
     *
     * @var \App\Services\ReservationService
     */
    protected $reservationService;

    /**
     * Create a new command instance.
     *
     * @param  \App\Services\ReservationService  $reservationService
     * @return void
     */
    public function __construct(ReservationService $reservationService)
    {
        parent::__construct();
        $this->reservationService = $reservationService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = $this->reservationService->expireOldReservations();
        
        $this->info("$count old reservations have been expired.");
        
        return 0;
    }
}