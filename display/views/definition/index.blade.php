@extends('layout.main')

@section('content')

@if(isset($q))
    <?php

    $db = new Core\Database\Database();
    $db->select('entries', ['word', '=', $q]);

    ?>
    @if($db->count())
        @foreach($db->all() as $item)
            <div class="panel panel-primary">
                <div class="panel-heading">
                    {{ $item->word }}
                </div>
                <div class="panel-body">
                    {{ $item->definition }}
                </div>
            </div>
        @endforeach
    @endif
@endif

@stop
