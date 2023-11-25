<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
class DeliveryController extends Controller
{
    protected $deliveryRepository;

    public function __construct(DeliveryRepositoryInterface $deliveryRepository) {
        $this->deliveryRepository = $deliveryRepository;
    }
}
