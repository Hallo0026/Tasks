@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row text-white">
            <div class="col-12">

                <?php

                    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                    $dt = \Carbon\Carbon::now();

                    $currentTime = date('H:i:s');
                    $greeting = '';

                    if ($currentTime >= '06:00:00' && $currentTime < '12:00:00') {
                        $greeting = 'Bom dia';
                    } elseif ($currentTime >= '12:00:00' && $currentTime < '18:00:00') {
                        $greeting = 'Boa tarde';
                    } else {
                        $greeting = 'Boa noite';
                    }

                ?>

                <h3 style="padding-left: 6px;"><?=$greeting?>, {{ Auth::user()->name }}</h3>
                <h6 style="padding-left: 6px; text-transform: capitalize;"><?=$dt->formatLocalized('%A,  %d %B %Y');?></h6>

            </div>
        </div>

        <task-list-component title="Tarefas"></task-list-component>

    </div>

@endsection
