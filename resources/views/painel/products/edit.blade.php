@extends('layouts.app')


@section('content')
<form method="POST" class="edit-form" action="{{ url('/produtos-update/'. $product->id) }}" enctype="multipart/form-data">
      @csrf
      <div class="row">
            <div class="form-group col-md-6">
                  <input type="text" class="form-control" value="{{ $product->name }}" name="name" placeholder="Nome do Produto">
            </div>
            <div class="form-group col-md-6">
                  <input type="text" class="form-control" value="{{ $product->resume }}" name="resume" placeholder="Nome Resumido">
            </div>
            <div class="form-group col-md-6">
                  <input type="text" class="form-control" value="{{ $product->provider }}" name="provider" placeholder="Fornecedor">
            </div>
            <div class="form-group col-md-6">
                  <textarea type="text" class="form-control"  value="{{ old('description', $product->description) }}" name="description" placeholder=""
                        rows="4">{{ $product->description }}</textarea>
            </div>
            <div class="form-group col-md-3">
                  <input type="text" class="form-control" value="{{ $product->provphone }}" id="phone" name="provphone" placeholder="Telefone">
            </div>
            <div class="form-group col-md-3">
                  <input type="text" class="form-control" value="{{ $product->provname }}"  name="provname" placeholder="Nome do Contato">
            </div>
            <div class="form-group col-md-6">
                  <input type="file" class="form-control" value="{{ $product->image }}" name="image" placeholder="Foto do Produto">
                  <img width="100" height="120" class="mt-2" src="{{ url('storage/produtos/'. $product->image) }}" alt="">
            </div>
            <div class="form-group col-md-3">
                  @php
                  $sellprice = str_replace([',', '.'], ['', ','], $product->sellprice);
                  $buyprice = str_replace([',', '.'], ['', ','], $product->buyprice);
                  @endphp
                  <input type="text" class="form-control" value="{{ $buyprice }}" id="buyprice" name="buyprice" placeholder="Preço de Compra">
            </div>
            <div class="form-group col-md-3">
                  <input type="text" class="form-control" value="{{ $sellprice }}" id="sellprice" name="sellprice" placeholder="Preço de Venda">
            </div>
            <div class="form-group col-md-6">
                  <input type="text" class="form-control" value="{{ $product->bitterness }}" name="bitterness" placeholder="Amargor">
            </div>
            <div class="form-group col-md-3">
                  <input type="text" class="form-control" value="{{ $product->temperature }}" name="temperature" placeholder="Link do Video">
            </div>
            <div class="form-group col-md-3">
                  <input type="text" class="form-control" value="{{ $product->ibv }}" name="ibv" placeholder="ABV">
            </div>
            <div class="form-group col-md-6">
                  <select class="form-control" name="categoria" id="exampleFormControlSelect1">
                        <option value="sem-categoria">Sem Categoria</option>
                        <option value="cerveja">Cerveja</option>
                        <option value="kit">kit</option>
                        <option value="embutido">Embutidos</option>
                  </select>
            </div>
            <div class="form-group col-md-3">
                  <input type="text" class="form-control" value="{{ $product->type }}" name="type" placeholder="Tipo">
            </div>
      </div>

      <div class="row mt-3">
            <div class="col-md-3">
                  <div class="form-group">
                        <label for="spotlight" class="col-sm-4 col-md-4 control-label text-right text-white">Destaque?</label>
                        <div class="col-sm-7 col-md-7">
                              <div class="input-group">
                                    <div id="radioBtn" class="btn-group">
                                          <a class="btn btn-add btn-sm {{$product->spotlight == 1 ? 'active' : 'notActive'}}" data-toggle="spotlight" data-title="1">SIM</a>
                                          <a class="btn btn-add btn-sm {{$product->spotlight == 2 ? 'active' : 'notActive'}}" data-toggle="spotlight" data-title="2">NÃO</a>
                                    </div>
                                    <input type="hidden" value="{{ $product->spotlight }}" name="spotlight" id="spotlight">
                              </div>
                        </div>
                  </div>
            </div>
            
            <div class="col-md-3">
                  <div class="form-group">
                        <label for="delivery" class="col-sm-4 col-md-4 control-label text-right text-white">Delivery?</label>
                        <div class="col-sm-7 col-md-7">
                              <div class="input-group">
                                    <div id="radioBtn" class="btn-group">
                                          <a class="btn btn-add btn-sm {{$product->delivery == 1 ? 'active' : 'notActive'}}" data-toggle="delivery" data-title="1">SIM</a>
                                          <a class="btn btn-add btn-sm {{$product->delivery == 2 ? 'active' : 'notActive'}}" data-toggle="delivery" data-title="2">NÃO</a>
                                    </div>
                                    <input type="hidden" value="{{ $product->delivery }}" name="delivery" id="delivery">
                              </div>
                        </div>
                  </div>
            </div>
            
            <div class="col-md-3">
                  <div class="form-group">
                        <label for="location" class="col-sm-4 col-md-4 control-label text-right text-white">Local?</label>
                        <div class="col-sm-7 col-md-7">
                              <div class="input-group">
                                    <div id="radioBtn" class="btn-group">
                                          <a class="btn btn-add btn-sm {{$product->location == 1 ? 'active' : 'notActive'}}" data-toggle="location" data-title="1">SIM</a>
                                          <a class="btn btn-add btn-sm {{$product->location == 2 ? 'active' : 'notActive'}}" data-toggle="location" data-title="2">NÃO</a>
                                    </div>
                                    <input type="hidden" value="{{ $product->location }}" name="location" id="location">
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      <div class="row mt-3">
            <div class="col-md-6">
                  <button type="submit" class="btn btn-orange">Alterar Produto</button>
            </div>
            <div class="col-md-6">
                  <a href="{{ url('produtos') }}"><button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange">Fechar e Não Salvar</button></a>
            </div>
      </div>
</form>
@endsection
