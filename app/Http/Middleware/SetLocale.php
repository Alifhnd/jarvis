<?php

namespace App\Http\Middleware;

use App\Model\Language;
use Closure;
use Illuminate\Support\Facades\Config;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->header('locale' , 'fa');
        $lang = Language::where('slug' , $locale)->first();
                Config::set('language_id' , $lang->id);


        return $next($request);
    }
}
