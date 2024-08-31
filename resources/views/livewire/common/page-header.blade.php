<div class="col-lg-12">
    <div class="mb-3 p-4">
        <div class="box-body">
         <div class="row">
            <div class="col-sm-8">
                <h2>
                    @if(isset($pageTitle))
                            {{ $pageTitle }}
                    @endif
                </h2>
            </div>
            <div class="col-sm-4 d-flex justify-content-end">
                @if(isset($buttonName))
                    <a href="{{ $link }}" class="btn {{ $buttonClass }}">{{ $buttonName }}</a>
                @endif
            </div>
         </div>
        </div>
    </div>
</div>
