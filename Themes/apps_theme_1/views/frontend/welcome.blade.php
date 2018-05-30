<!-- TODO remove, unused -->
@extends('frontend.layouts.app')

@section('content')
    <div id="app" class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Subscrição efetuada</h1>
                <p>
                    Obrigado por utilizar os nossos serviços. Esta subscrição tem um custo
                    de @if (str_contains(subscription('operator'), 'MEO')) 2,99€/semana. @else 3,99€/semana. @endif
                    <strong>Para cancelar clique <a href="{{ route('subscription.cancel') }}">aqui</a></strong>

                </p>
                <p>
                @if (\Cookie::get('contentItem', null) !== null)
                    <p><a class="btn btn-success btn-lg" style="width: 150px;"
                          href="{{ route('view.contentitem', \Cookie::get('contentItem', null)) }}">HOME</a></p>
                @elseif (subscription('offer_id') != 2)
                    <p><a class="btn btn-success btn-lg" style="width: 150px;"
                          href="{{ route('home') }}">HOME</a></p>
                @else
                    <p><a class="btn btn-success btn-lg" style="width: 150px;"
                          href="{{ route('view.contentitem', 677) }}">HOME</a></p>
                    @endif
                    </p>
            </div>
        </div>
    </div>
@endsection
