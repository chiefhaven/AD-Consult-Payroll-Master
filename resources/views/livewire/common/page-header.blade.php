<div class="col-lg-12">
    <div class="mb-3 p-4">
        <div class="box-body">
         <h2>
            @if(isset($pageTitle))
                    {{ $pageTitle }}
            @endif


            @if(isset($buttonName))
                <div :class="btn btn-primary">{{ $buttonName }}</div>
            @endif

        </h2>
        </div>
    </div>
</div>
