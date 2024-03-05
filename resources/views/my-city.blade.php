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
                    <div class="card-header">{{ __('Mis Ciudades') }}</div>

                    <div class="card-body">

                        <table class="table" id="tableC">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ciudad</th>
                                    <th scope="col">Información</th>
                                    <th scope="col">Hora Consulta</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $city)
                                    <tr>
                                        <th scope="row">{{$city->id}}</th>
                                        <td>{{$city->name}}</td>
                                        <td>{{$city->data}}</td>
                                        <td>{{$city->created_at}}</td>
                                        <td><span id="delete">
                                                <a  type="button" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                    </svg>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script src="{{asset('/js/my-city.js')}}"></script>

@endpush
