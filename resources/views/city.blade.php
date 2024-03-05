@extends('layouts.app')

@section('content')

    <style>
        #miTextarea {
            width: 400px;
            height: 200px;
            font-size: 18px;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Ciudad') }}</div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-3">
                                <label for="country">País</label>
                                <select class="js-example-basic-single" id="country" name="country" data-placeholder="Seleccionar Pais">
                                    <option selected>Seleccionar...</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->iso2 }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="state">Estado</label>
                                <select class="js-example-basic-single" id="state" name="state" data-placeholder="Seleccionar Estado" style="width: 200px; height: 40px;">
                                    <option selected>Seleccionar...</option>

                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="country">Ciudad</label>
                                <select class="js-example-basic-single" id="city" name="city" data-placeholder="Seleccionar Ciudad" style="width: 200px; height: 40px;">
                                    <option selected>Seleccionar...</option>

                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary" id="addcity">
                                    <i class="fas fa-save mr-2"></i>
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <form id="addFormCity" class="form">
                            @csrf
                            <div class="container">
                                <textarea name="miTextarea" id="miTextarea" readonly="true"></textarea>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script src="{{asset('/js/city.js')}}"></script>

@endpush
