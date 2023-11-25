<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\Interfaces\CartItemRepositoryInterface;
use App\Repositories\CartItemRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\PaymentRepository;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Repositories\DeliveryRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CartItemRepositoryInterface::class, CartItemRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(DeliveryRepositoryInterface::class, DeliveryRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(CartItemRepositoryInterface $cartItemRepository)
    {
        View::composer('user/header', function ($view) use ($cartItemRepository) {
            try {
                $totalQuantity = 0;
                if (Auth::check()) {
                    $userId = Auth::id();
                    $cartItems = $cartItemRepository->getByUserId($userId);
                    $totalPrice = $cartItems->reduce(function ($total, $item) {
                        return $total + ($item->quantity * $item->product->price);
                    }, 0);
                    $totalQuantity = $cartItems->sum('quantity');
                } else {
                    $cartItems = collect();
                    $totalPrice = 0;
                }
        
                $view->with('cartItems', $cartItems)->with('totalPrice', $totalPrice)->with('totalQuantity', $totalQuantity);
            } catch (\Exception $e) {
                \Log::error('Error in View Composer: ' . $e->getMessage());
            }
            
        });
    }
}
