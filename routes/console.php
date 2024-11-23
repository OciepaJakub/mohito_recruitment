<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:fetch-and-sync-recipes')->twiceDaily();