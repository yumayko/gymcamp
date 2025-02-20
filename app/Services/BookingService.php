<?php

namespace App\Services;

use App\Models\SubscribeTransaction;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\subscribePackageRepositoryInterface;

class BookingService {
    
    Protected $subscribePackageRepository;
    protected $bookingRepository;

    public function __construct(
        subscribePackageRepositoryInterface $subscribePackageRepository,
        BookingRepositoryInterface $bookingRepository,
    ){
        $this->subscribePackageRepository = $subscribePackageRepository;
        $this->bookingRepository = $bookingRepository;   
    }

    public function getBookingDetails(array $validated)
    {
        return $this->bookingRepository->findByTrxIdAndPhoneNumber($validated['booking_trx_id'],
        $validated['phone']);
    }

    protected function calculateBookingData($subscribePackage, $validatedData)
    {
        $duration = $subscribePackage->duration;
        $startedAt = now();
        $endedAt = $startedAt->clone()->addDays($duration);

        $ppn = 0.11;
        $price = $subscribePackage->price;

        $subTotal = $price;
        $totalPpn = $ppn * $subTotal;
        $totalAmount = $subTotal + $totalPpn;

        return [
            'subscribe_package_id' => $subscribePackage->id,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'duration' => $duration,
            'phone' => $validatedData['phone'],
            'started_at' => $startedAt,
            'ended_at' => $endedAt,
            'sub_total' => $subTotal,
            'total_ppn' => $totalPpn,
            'total_amount' => $totalAmount,
        ];
    }

    public function storeBookingInSession($subscribePackage, $validatedData)
    {
        $bookingData = $this->calculateBookingData($subscribePackage, $validatedData);
        $this->bookingRepository->saveToSession($bookingData);
    }

    public function payment()
    {
        $booking = $this->bookingRepository->getBookingDataFromSession();
        $subscribePackage = $this->subscribePackageRepository->find($booking['subscribe_package_id']);

        return compact('booking', 'subscribePackage');
    }

    public function paymentStore(array $validated)
    {
        $bookingData = $this->bookingRepository->getBookingDataFromSession();
        $bookingTransactionId = null;

        DB::transaction(function() use ($validated, &$bookingTransactionId, $bookingData){

            if (isset($validated['proof'])){
                $proofPath = $validated['proof']->store('proof', 'public');
                $validated['proof'] = $proofPath;
            }

            $validated['name'] = $bookingData['name'];
            $validated['email'] = $bookingData['email'];
            $validated['phone'] = $bookingData['phone'];
            $validated['duration'] = $bookingData['duration'];
            $validated['total_amount'] = $bookingData['total_amount'];
            $validated['subscribe_package_id'] = $bookingData['subscribe_package_id'];
            $validated['started_at'] = $bookingData['started_at'];
            $validated['ended_at'] = $bookingData['ended_at'];
            $validated['is_paid'] = false;

            $validated['booking_trx_id'] = SubscribeTransaction::generateUniqueTrxId();

            $newBooking = $this->bookingRepository->createBooking($validated);

            $bookingTransactionId = $newBooking->id;
        });

        return $bookingTransactionId;
    }
}