<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('articles:fetch-guardian')->everySixHours();
Schedule::command('articles:fetch-newsapi')->everySixHours();
Schedule::command('articles:fetch-nytimes')->everySixHours();
