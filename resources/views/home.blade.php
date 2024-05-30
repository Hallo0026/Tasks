@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-12">

                <?php

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

                <h3 style="padding-left: .8rem;"><?=$greeting?>, {{ Auth::user()->name }}</h3>
            </div>
        </div>

        <task-list-component title="Tarefas"></task-list-component>

        <modal-component>
            <template v-slot:title>
                Adicionar tarefa
            </template>
            <template v-slot:body>
                <create-task-form-component @submit="handleFormSubmit"></create-task-form-component>
            </template>
            
        </modal-component>

    </div>

@endsection
