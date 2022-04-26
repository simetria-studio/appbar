$('#radioBtn a').on('click', function () {
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#' + tog).prop('value', sel);

    $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
});


$('#buyprice').maskMoney({
    allowNegative: false,
    thousands: '.',
    decimal: ','
});
$('#sellprice').maskMoney({
    allowNegative: false,
    thousands: '.',
    decimal: ','
});
$('#phone').mask('00 00000-0000');

$(document).ready(function(){
      // Busca dos estados
    $(function(){
        if($('[name="estado"]')){
            $.ajax({
                url: '/painel/buscaEstado',
                type: 'GET',
                success: (data) => {
                    // console.log(data);
                    for(var i=0; data.length>i; i++){
                        $('[name="estado"]').append('<option value="'+data[i].sigla+'" data-estado_id="'+data[i].id+'">'+data[i].sigla+' - '+data[i].titulo+'</option>');
                    }
                }
            });
        }
    });

    // Busca das cidades/municipios
    $(document).on('change', '[name="estado"]', function(){
        let estado_id = $(this).find(':selected').data('estado_id');
        let select = $(this).parent().parent().find('select[name="cidade"]');

        $.ajax({
            url: '/painel/buscaCidade/'+estado_id,
            type: 'GET',
            success: (data) => {
                // console.log(data);
                select.empty();
                select.append('<option value="">- Selecione uma Cidade -</option>');

                for(var i=0; data.length>i; i++){
                    select.append('<option value="'+data[i].titulo+'" data-cidade_id="'+data[i].id+'">'+data[i].titulo+'</option>');
                }
            }
        });
    });

    // Busca das cidades/municipios
    $(document).on('change', '[name="cidade"]', function(){
        let cidade_id = $(this).find(':selected').data('cidade_id');

        $.ajax({
            url: '/painel/buscaBairro/'+cidade_id,
            type: 'GET',
            success: (data) => {
                // console.log(data);
                if(data.length == 0){
                    $('.bairro_select').addClass('d-none').removeAttr('name');
                    $('.bairro_input').removeClass('d-none').attr('name', 'bairro');
                }else{
                    $('.bairro_select').removeClass('d-none').attr('name', 'bairro');
                    $('.bairro_input').addClass('d-none').removeAttr('name');
                }

                $('.bairro_select').empty();
                $('.bairro_select').append('<option value="">- Selecione um Bairro -</option>');

                for(var i=0; data.length>i; i++){
                    $('.bairro_select').append('<option value="'+data[i].titulo+'">'+data[i].titulo+'</option>');
                }
            }
        });
    });

    $(function(){
        if($('.transportes_json').val()){
            var transportes = JSON.parse($('.transportes_json').val());
            if(ObjectLength(transportes) > 0){
                setTimeout(() => {
                    $('[name="estado"]').val(transportes.estado);
                    $('[name="estado"]').trigger('change');

                    setTimeout(() => {
                        $('[name="cidade"]').val(transportes.cidade);
                        $('[name="cidade"]').trigger('change');

                        setTimeout(() => {
                            $('[name="bairro"]').val(transportes.bairro);
                        }, 800);
                    }, 700);
                }, 600);
            }
        }
    });

    $(document).on('click','.btn-edit-stock', function(){
        var dados = $(this).data('dados');

        $('#editStock').find('._name').html(dados.name);
        $('#editStock').find('[name="id"]').val(dados.id);

        $('#editStock').find('.table-stock').empty();

        for(var i=0; dados.stock.length>i; i++){
            var classs = dados.stock[i].type == 'E' ? 'text-success' : 'text-danger';
            var name_type = dados.stock[i].type == 'E' ? 'ENTRADA' : 'SAÍDA';

            var date = new Date(dados.stock[i].created_at);
                dia  = date.getDate().toString().padStart(2, '0'),
                mes  = (date.getMonth()+1).toString().padStart(2, '0'), //+1 pois no getMonth Janeiro começa com zero.
                ano  = date.getFullYear();
                hora = date.getHours().toString();
                minuto = date.getMinutes().toString();
            date = dia+'/'+mes+'/'+ano+' '+hora+':'+minuto;

            // var dataTime = dados.stock[i].created_at.split(' ');
            // var date = dataTime[0].split('-');
            // date = date[2]+'/'+date[1]+'/'+date[0];

            $('#editStock').find('.table-stock').append(
                '<tr>'+
                    '<td class="'+classs+'">'+name_type+'</td>'+
                    '<td class="text-white">'+(dados.stock[i].value ?? '')+'</td>'+
                    '<td class="text-white">'+(dados.stock[i].description ?? '')+'</td>'+
                    '<td class="text-white">'+date+'</td>'+
                '</tr>'
            );
        }
    });

    $(document).on('click', '.btn-search-cep', function(){
        var cep = $(this).closest('.input-group').find('[name="zip_code"]').val();
        $.ajax({
            url: '/buscaCep',
            type: 'GET',
            data: {search: cep},
            success: (data) => {
                console.log(data);
                $('[name="zip_code"]').val(data.zipcode);
                $('[name="state"]').val(data.uf);
                $('[name="city"]').val(data.city);
                $('[name="address2"]').val(data.district);
                $('[name="address"]').val(data.street);

                $('[name="number"]').focus();
            }
        });
    });
});

function ObjectLength( object ) {
    var length = 0;
    for( var key in object ) {
        if( object.hasOwnProperty(key) ) {
            ++length;
        }
    }
    return length;
};