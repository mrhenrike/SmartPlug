@extends('adminlte::page')

@section('title', 'SmartPlug - Dispositivos')

@section('content_header')
   
@stop

@section('content')
   <div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                @if( isset($mens) && count($mens) > 0)
                    <div class="alert alert-success alert-dismissible">
                        <a href="#">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </a>
                        <h4><i class="glyphicon glyphicon-ok"></i> Sucesso!</h4>
                        <p>{{$mens}}</p>	
                    </div>
                @endif
                <div class="box box-info">
                    <div class="box-header with-border">
                        @can('ligado')                            
                            <a href="{{url("/home/ligarTodos")}}" class="btn btn-info">Ligar todos!</a>
                        @endcan
                        @can('desligado')
                            <a href="{{url("/home/desligarTodos")}}" class="btn btn-danger">Desligar todos!</a>
                        @endcan

                        <div class="box-tools">
                            <form action="" method="post" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="input-group input-group-sm" style="width: 300px;">
                                    <input type="text" name="name" class="form-control pull-right" placeholder="Buscar por NOME">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>

                        </div> <!-- da div de pesquisa -->
                    </div><!-- fim do cabeçalho da index -->

                    <!-- CONTEUDO -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Status</th>
                                <!-- <th>Ativo</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dispositivos as  $d)
                                <tr>
                                    <td>{{$d->id}}</td>
                                    <td>{{$d->nome}}</td>
                                    <td>{{$d->status}}</td>
                                    <!--<td>{{$d->ativo}}</td>-->
                                    <td>
                                        @can('ligado')
                                            <a href="{{url("/home/{$d->id}/ligar")}}" class="btn btn-info">Ligar</a>
                                        @endcan
                                        @can('desligado')
                                            <a href="{{url("/home/{$d->id}/desligar")}}" class="btn btn-danger">Desligar</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div align="center">
                        {{ $dispositivos->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop