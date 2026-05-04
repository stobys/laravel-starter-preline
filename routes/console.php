<?php

use Illuminate\Support\Facades\Schedule;

// -- tylko jezeli srodowisko produkcyjne
if ( app()->isProduction() ) {
	//Schedule::command('sync:teta department')		-> dailyAt('04:10');
	//Schedule::command('sync:teta employee')			-> dailyAt('04:14');
	//Schedule::command('sync:ldap')					-> dailyAt('04:18');

	Schedule::command('security:audit --notify')	-> dailyAt('06:00')
		-> runInBackground() -> withoutOverlapping();

	Schedule::command('backup:run')					-> dailyAt('23:34');

}

// -- Przydatne metody częstotliwości
// -- Metoda					-- Kiedy
// ->everyMinute()				co minutę
// ->everyFiveMinutes()			co 5 minut
// ->hourly()					co godzinę
// ->dailyAt('02:00')			codziennie o 2:00
// ->weeklyOn(1, '06:00')		co poniedziałek o 6:00
// ->monthlyOn(1, '00:00')		1. dnia miesiąca
// ->cron('* * * * *')			własny wyrażenie cron

// ->withoutOverlapping()

// // -- schedule command
// Schedule::command('backup:run')->daily();

// // -- schedule closure
// Schedule::call(function () {
//     \DB::table('sessions')->where('last_activity', '<', now()->subDays(7))->delete();
// })->daily();

// // -- Invokable Class (klasa z __invoke)
// Schedule::call(new SendWeeklyReport())->weekly();

// // -- Job (kolejkowany)
// Schedule::job(new SyncLdapUsers())->hourly();

// // -- z określoną kolejką i połączeniem
// Schedule::job(new SyncLdapUsers(), 'high', 'redis')->hourly();
