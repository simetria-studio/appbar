@extends('layouts.app')


@section('content')
@if ($errors->any())
      <div class="alert alert-danger">
            <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
            </ul>
      </div>
@endif

<div class="row my-4">
      <div class="col-6 col-md-5">
            <form action="" method="get">
                  <div class="input-group">
                        <input type="search" name="name" class="form-control" value="@isset($_GET['name']){{$_GET['name']}}@endisset" placeholder="buscar">
                        <select name="coluna" class="form-control">
                              <option value="produto" @isset($_GET['coluna']) @if($_GET['coluna'] == 'produto') selected @endif @endisset>Produto</option>
                              <option value="fornecedor" @isset($_GET['coluna']) @if($_GET['coluna'] == 'fornecedor') selected @endif @endisset>Fornecedor</option>
                              <option value="contato" @isset($_GET['coluna']) @if($_GET['coluna'] == 'contato') selected @endif @endisset>Contato</option>
                        </select>
                        <div class="input-group-append">
                              <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                        </div>
                  </div>
            </form>
      </div>
      <div class="col-6 col-md-7 text-right">
            <button data-toggle="modal" data-target="#staticBackdrop" class="btn btn-add"><i class="fas fa-plus"></i> Adicionar</button>
      </div>
</div>

<div>
      <table class="table table-dark">
            <thead>
                  <tr class="table-th">
                        <th>Produto</th>
                        <th scope="col">Fornecedor</th>
                        <th scope="col">Contato</th>
                        <th scope="col">Estoque</th>
                        <th scope="col">PC</th>
                        <th scope="col">PV</th>
                        <th scope="col">Ações</th>
                  </tr>
            </thead>
            <tbody>
                  @foreach ($products as $product)
                  <tr class="table-tr">
                        <th>{{ $product->name }}</th>
                        <td>{{ $product->provider }}</td>
                        <td>{{ $product->provname }}</td>
                        <td>{{ $product->stock ?? '0' }}</td>
                        <td>{{  'R$ '.number_format($product->buyprice, 2, ',', '.') }}</td>
                        <td>{{  'R$ '.number_format($product->sellprice, 2, ',', '.') }}</td>
                        <td>
                              <div class="icons d-flex justify-content-around">
                                    <a title="Etoque" href="#" data-toggle="modal" data-target="#editStock" class="mx-1 btn-edit-stock" data-dados="{{$product}}">
                                          <div class="edit">
                                                <i class="fas fa-box"></i>
                                          </div>
                                    </a>
                                    <a title="Editar" href="{{ url('produtos-edit/'. $product->id) }}" class="mx-1">
                                          <div class="edit">
                                                <i class="fas fa-edit"></i>
                                          </div>
                                    </a>
                                    <a title="Deletar" onclick="deleteItem(this)" data-id="{{ $product->id }}" class="mx-1">
                                          <div class="trash">
                                                <i class="fas fa-trash-alt"></i>
                                          </div>
                                    </a>
                              </div>
                        </td>
                  </tr>
                  @endforeach
            </tbody>
      </table>

      @if (isset($_GET['name']))
            {{ $products->appends(['name' => $_GET['name'], 'coluna' => $_GET['coluna']])->links()  }}
      @else
            {{ $products->links()  }}
      @endif
</div>

<script type="application/javascript">
      function deleteItem(e) {

                    let id = e.getAttribute('data-id');

                    const swalWithBootstrapButtons = Swal.mixin({
                          customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                          },
                          buttonsStyling: false
                    });

                    swalWithBootstrapButtons.fire({
                          title: 'Você tem certeza?',
                          text: "Está deletando permanentemente!",
                          icon: 'warning',
                          showCancelButton: true,
                          confirmButtonText: 'Sim, delete!',
                          cancelButtonText: 'Não, cancelar!',
                          reverseButtons: true
                    }).then((result) => {
                          if (result.value) {
                                if (result.isConfirmed) {

                                      $.ajax({
                                            type: 'DELETE',
                                            url: '{{url('produtosDelete')}}/' + id,
                                            data: {
                                                  "_token": "{{ csrf_token() }}",
                                            },
                                            success: function (data) {
                                                  if (data.success) {
                                                        swalWithBootstrapButtons.fire(
                                                              'Deletado!',
                                                              'Seu produto foi deletado!',
                                                              "success"

                                                        );

                                                  }

                                            }
                                      });

                                }
        location.reload();
                          } else if (
                                result.dismiss === Swal.DismissReason.cancel
                          ) {
                                swalWithBootstrapButtons.fire(
                                      'Cancelado',
                                      'Este produto está seguro!)',
                                      'error'
                                );
                          }
                    });

              }

</script>

@endsection

@section('modal')
      {{-- novo produto --}}
      <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h5 class="modal-title" id="staticBackdropLabel">Adicionar Produto</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                              </button>
                        </div>

                        <div class="modal-body">
                              <form method="POST" action="{{ url('/produtos-store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                          <div class="form-group col-md-6">
                                                <input type="text" class="form-control" name="name" placeholder="Nome do Produto">
                                          </div>
                                          <div class="form-group col-md-6">
                                                <input type="text" class="form-control" name="resume" placeholder="Nome Resumido">
                                          </div>
                                          <div class="form-group col-md-6">
                                                <input type="text" class="form-control" name="provider" placeholder="Fornecedor">
                                          </div>
                                          <div class="form-group col-md-6">
                                                <select class="form-control" name="categoria" id="exampleFormControlSelect1">
                                                      <option value="sem-categoria">Sem Categoria</option>
                                                      <option value="cerveja">Cerveja</option>
                                                      <option value="kit">kit</option>
                                                      <option value="embutido">Embutidos</option>
                                                </select>
                                          </div>
                                          <div class="form-group col-md-6">
                                                <textarea type="text" class="form-control" name="description" placeholder="Descrição" rows="4"></textarea>
                                          </div>
                                          <div class="form-group col-md-3">
                                                <input type="text" class="form-control" id="phone" name="provphone" placeholder="Telefone">
                                          </div>
                                          <div class="form-group col-md-3">
                                                <input type="text" class="form-control" name="provname" placeholder="Nome do Contato">
                                          </div>
                                          <div class="form-group col-md-6">
                                                <input type="file" class="form-control" name="image" placeholder="Foto do Produto">
                                          </div>
                                          <div class="form-group col-md-3">
                                                <input type="text" class="form-control" id="buyprice" name="buyprice" placeholder="Preço de Compra">
                                          </div>
                                          <div class="form-group col-md-3">
                                                <input type="text" class="form-control" id="sellprice" name="sellprice" placeholder="Preço de Venda">
                                          </div>
                                          <div class="form-group col-md-6">
                                                <input type="text" class="form-control" name="bitterness" placeholder="Amargor">
                                          </div>
                                          <div class="form-group col-md-3">
                                                <input type="text" class="form-control" name="temperature" placeholder="Link do Video">
                                          </div>
                                          <div class="form-group col-md-3">
                                                <input type="text" class="form-control" name="ibv" placeholder="ABV">
                                          </div>
                                          <div class="form-group col-md-3">
                                                <input type="text" class="form-control" name="type" placeholder="Tipo">
                                          </div>
                                          <div class="form-group col-md-3">
                                                <input type="text" class="form-control" name="stock" placeholder="Estoque Inicial">
                                          </div>
                                    </div>

                                    <div class="row mt-3">
                                          <div class="col-md-3">
                                                <div class="form-group">
                                                      <label for="spotlight" class="col-sm-4 col-md-4 control-label text-right text-white">Destaque?</label>
                                                      <div class="col-sm-7 col-md-7">
                                                            <div class="input-group">
                                                                  <div id="radioBtn" class="btn-group">
                                                                        <a class="btn btn-add btn-sm notActive" data-toggle="spotlight" data-title="1">SIM</a>
                                                                        <a class="btn btn-add btn-sm active" data-toggle="spotlight" data-title="2">NÃO</a>
                                                                  </div>
                                                                  <input type="hidden" value="2" name="spotlight" id="spotlight">
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
                                                                        <a class="btn btn-add btn-sm active" data-toggle="delivery" data-title="1">SIM</a>
                                                                        <a class="btn btn-add btn-sm notActive" data-toggle="delivery" data-title="2">NÃO</a>
                                                                  </div>
                                                                  <input type="hidden" value="1" name="delivery" id="delivery">
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
                                                                        <a class="btn btn-add btn-sm active" data-toggle="location" data-title="1">SIM</a>
                                                                        <a class="btn btn-add btn-sm notActive" data-toggle="location" data-title="2">NÃO</a>
                                                                  </div>
                                                                  <input type="hidden" value="1" name="location" id="location">
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mt-3">
                                          <div class="col-md-6">
                                                <button type="submit" class="btn btn-orange">Cadastrar Produto</button>
                                          </div>
                                          <div class="col-md-6">
                                                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange">Fechar e Não Salvar</button>
                                          </div>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
      {{-- editar estoque --}}
      <div class="modal fade" id="editStock" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editStockLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h5 class="modal-title" id="editStockLabel">Alterar Estoque do Produto <br> <span class="_name"></span></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                              </button>
                        </div>

                        <div class="modal-body">
                              <form method="POST" action="{{ route('stockUpdate') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id">
                                    <div class="row justify-content-center">
                                          <div class="col-12 col-md-8">
                                                <div class="form-group">
                                                      <label for="stock_type" class="control-label text-center w-100 text-white">Adicionar Estoque</label>
                                                      <div class="input-group d-flex justify-content-center">
                                                            <div id="radioBtn" class="btn-group">
                                                                  <a class="btn btn-add btn-sm active" data-toggle="stock_type" data-title="E">ENTRADA</a>
                                                                  <a class="btn btn-add btn-sm notActive" data-toggle="stock_type" data-title="S">SAÍDA</a>
                                                            </div>
                                                            <input type="hidden" value="E" name="stock_type" id="stock_type">
                                                      </div>
                                                </div>
                                          </div>

                                          <div class="form-group col-12 col-md-8">
                                                <input type="text" class="form-control" name="new_stock" placeholder="Quatidade">
                                          </div>

                                          <div class="form-group col-12 col-md-8">
                                                <input type="text" class="form-control" name="description" placeholder="Motivo (Opcional)">
                                          </div>
                                    </div>

                                    <div class="row mt-3">
                                          <div class="col-md-6">
                                                <button type="submit" class="btn btn-orange">Alterar Estoque</button>
                                          </div>
                                          <div class="col-md-6">
                                                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange">Não Salvar</button>
                                          </div>
                                    </div>
                              </form>

                              <div class="container mt-3">
                                    <div class="table-responsive2">
                                          <table class="table table-striped">
                                                <thead>
                                                      <tr>
                                                            <th class="text-white">Entrada/Saída</th>
                                                            <th class="text-white">Quantidade</th>
                                                            <th class="text-white">Descrição</th>
                                                            <th class="text-white">Data</th>
                                                      </tr>
                                                </thead>
                                                <tbody class="table-stock">
                                                      <tr><td class="text-white" colspan="3">Nenhum Historico Encontrado</td></tr>
                                                </tbody>
                                          </table>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
@endsection