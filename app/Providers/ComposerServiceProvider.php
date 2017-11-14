<?php

namespace Ahelos\Providers;

use Illuminate\Support\ServiceProvider;
use Ahelos\Order;
use Ahelos\ContactMessage;
use Illuminate\Support\Facades\Cache;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.layouts._left_menu', function ($view) {
            if (Cache::has('unopened_order_count')) {
                $unopened_order_count = Cache::get('unopened_order_count');
            } else {
                $unopened_order_count = Order::where('read_by_admin', '=', false)->count();
                Cache::forever('unopened_order_count', $unopened_order_count);
            }

            $view->with('unopened_order_count', $unopened_order_count);
        });

        view()->composer('admin.layouts._left_menu', function ($view) {
            if (Cache::has('unanswered_contact_messages_count')) {
                $unanswered_contact_messages_count = Cache::get('unanswered_contact_messages_count');
            } else {
                $unanswered_contact_messages_count = ContactMessage::where('status', '=', false)->count();
                Cache::forever('unanswered_contact_messages_count', $unanswered_contact_messages_count);
            }

            $view->with('unanswered_contact_messages_count', $unanswered_contact_messages_count);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
