@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>&nbsp;</h1>
@stop

@section('content')
    <div class="row p-4">
        <div class="col-md-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="border mb-3 p-4">
                        <div class="box-body">
                            <h3>Good Morning</h3>
                            {!! \Illuminate\Foundation\Inspiring::quote() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <a href="{{ route('employees') }}" class="text-decoration-none">
                                <x-adminlte-small-box
                                    title="{{ App\Models\Employee::get()->count() }}"
                                    text="Employees"
                                    icon="fas fa-users"
                                    theme="light"
                                />
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('clients') }}" class="text-decoration-none">
                                <x-adminlte-small-box
                                    title="{{ App\Models\Client::get()->count() }}"
                                    text="Clients"
                                    icon="fas fa-file-invoice"
                                    theme="light"
                                />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p><strong>Paye Brackets</strong></p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Limit</th>
                                <th>Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payeBrackets as $index => $payeBracket)
                                <tr>
                                    <td>
                                        @if ($index === 0)
                                            The first
                                        @elseif ($index === count($payeBrackets) - 1)
                                            In excess of
                                        @else
                                            The next
                                        @endif
                                        <b>K{{ number_format($payeBracket->limit, 2) }}</b>
                                    </td>
                                    <td>{{ $payeBracket->rate * 100 }}%
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="/css/app.css">
@stop

@section('js')

@stop
