@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>&nbsp;</h1>
@stop

@section('content')
<div id="home" v-cloak>
    <div class="row p-4">
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    <div class="border mb-3 p-4">
                        <div class="box-body">
                            <h3>@{{ greetings }}</h3>
                            {{ \Illuminate\Foundation\Inspiring::quote() }}
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
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <strong>Paye Brackets</strong>
                    <button class="btn btn-link" onclick="toggleCardBody()">
                        <i id="toggleIcon" class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div id="payeBracketsCardBody" class="card-body" style="display: none;">
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
                    <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#payBlacket_modal">
                        <i class="fas fa-pencil-alt"></i> Edit
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <strong>Upcoming events</strong>
                </div>
                <div class="card-body">

                </div>
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
<script>
    function toggleCardBody() {
        const cardBody = document.getElementById("payeBracketsCardBody");
        const toggleIcon = document.getElementById("toggleIcon");

        // Toggle the display of the card body
        cardBody.style.display = cardBody.style.display === "none" ? "block" : "none";

        // Toggle the icon
        toggleIcon.classList.toggle("fa-chevron-down");
        toggleIcon.classList.toggle("fa-chevron-up");
    }
</script>

<script>
    const home = createApp({
        setup() {
            const greetings = ref('Good morning')
            const quote = ref('')

            onMounted(() => {
                const currentHour = new Date().getHours();
                if (currentHour < 12) {
                    greetings.value = 'Good morning';
                } else if (currentHour < 17) {
                    greetings.value = 'Good afternoon';
                } else {
                    greetings.value = 'Good evening';
                }
            });

            function notification($text, $icon){
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    html: $text,
                    showConfirmButton: false,
                    timer: 5500,
                    timerProgressBar: true,
                    icon: $icon,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                      }
                  });
            }

            return {
                greetings,
            };
        },
    });

    home.mount('#home');
</script>
@stop
