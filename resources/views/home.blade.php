@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>&nbsp;</h1>
@stop

@section('content')
    <div class="row p-4">
        <div class="col-md-9">
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
                        <div class="col-md-4">
                            <a href="{{ route('clients') }}" class="text-decoration-none">
                                <x-adminlte-small-box
                                    title="{{ App\Models\Client::get()->count() }}"
                                    text="Clients"
                                    icon="fas fa-file-invoice small-icon"
                                    theme="light"
                                />
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('products') }}" class="text-decoration-none">
                                <x-adminlte-small-box
                                    title="{{ App\Models\Product::get()->count() }}"
                                    text="Products/Services"
                                    icon="fas fa-shopping-cart small-icon"
                                    theme="light"
                                />
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('employees') }}" class="text-decoration-none">
                                <x-adminlte-small-box
                                    title="{{ App\Models\Employee::get()->count() }}"
                                    text="Employees"
                                    icon="fas fa-users small-icon"
                                    theme="light"
                                />
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3"> <!-- Flexbox for alignment -->
                        <strong>Paye Brackets</strong>
                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#payBlacket_modal">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </button>
                    </div>
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
                                            Any excess
                                        @else
                                            The next
                                        @endif
                                        <b>
                                            @if ($payeBracket->limit <= 2050000)
                                                {{ number_format($payeBracket->limit, 2) }}
                                            @else

                                            @endif
                                        </b>
                                    </td>
                                    <td>
                                        {{ number_format($payeBracket->rate * 100, 2) }}%
                                    </td>
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
