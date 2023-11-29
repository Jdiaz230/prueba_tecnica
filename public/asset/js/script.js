function Create(url, modal = 'modal_create', div_modal = 'response') {
    Load(1);
    $.ajax({
        url: url,
        beforeSend: function (){
            Load(0);
        },           
        success: function(response) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('padding-right',0); 
            $("#" + div_modal).html(response);
            $("#"+ modal).modal("show");               
            Load(0);
        },
        error: function(jqxhr, textStatus, errorThrown) {
            console.log(jqxhr.responseJSON);
            Alerta("error", " Error: " + errorThrown + " Status:" + jqxhr.status );
        }
    });	  
}

function Edit(url, modal = 'modal_edit', div_modal = 'response') {
    Load(1);
    $.ajax({
        url: url,
        beforeSend: function (){
            Load(1);
        },           
        success: function(response) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('padding-right',0); 
            $("#" + div_modal).html(response);
            $("#"+ modal).modal("show");              
            Load(0);
        },
        error: function(jqxhr, textStatus, errorThrown) {
            console.log(jqxhr.responseJSON);
            Alerta("error", " Error: " + errorThrown + " Status:" + jqxhr.status );
        }
    });	  
}

async function Preview(url, modal = 'modal_preview', div_modal = 'response') {
    Load(1);
    const response = await get(url);
    if (typeof response == 'object') {
        if (response.status) {
            Load(0);  
            messagePupop('success', response.message);
        }else{
            Load(0);  
            messagePupop('error', response.message);
        }
    }else{
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('body').css('padding-right',0); 
        $("#" + div_modal).html(response);
        $("#"+ modal).modal("show");             
    }
    Load(0);  
	  
}

function Delete(url, div_modal = 'response') {
    Load(1);
    $.ajax({
        url: url,
        beforeSend: function (){
            Load(1);
        },           
        success: function(response) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $('body').css('padding-right',0); 
                $("#" + div_modal).html(response);
                $("#modal_delete").modal("show");              
                Load(0);
        },
        error: function(jqxhr, textStatus, errorThrown) {
            console.log(jqxhr.responseJSON);
            Alerta("error", " Error: " + errorThrown + " Status:" + jqxhr.status );
        }
    });	  
}


function Save(modal, table = null, id_form = null) { 
    
    var form_name = (id_form != null)? id_form : 'form_save';
    asyncCallForm(form_name).then(valid => {    
        if(valid){
            var form            = $("#"+form_name);
            var url             = form.attr("action");
            var method          = form.attr("method");
            $("#btn_submit").attr("disabled", true);
            
            $.ajax({
                url: url,
                type: method,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function (){
                    Load(1);
                },
                success: function(response)  
                {
                    if(parseInt(response.status) == 1){
                        Alerta("success", response.message);
                        if(response.sendemail){
                            SendMail(JSON.stringify(response.sendemail));
                        }                        
                        
                        if(table == null){
                            $("#"+modal).modal("hide");
                            if (typeof refresh === "function") {
                                refresh();
                            }
                            if (typeof refresh_modal === "function") {
                                refresh_modal();
                            }
                        }else{
                            if(id_form=='form_delete'){
                                $("#"+modal).modal("hide");
                            }
                            $('#'+table).DataTable().ajax.reload();
                        }
                    }else{
                        var message = response.message;
                        if(response.errors){
                            var errors = response.errors
                            errors.forEach(function(element, indice, array) {
                                message += '<br>'+element;
                            });
                        }
                        Alerta("error", message);
                        $("#btn_submit").attr("disabled", false);
                    }
                    Load(0);
                },
                error: function (jqXHR, exception) {
                    ajaxError(jqXHR, exception);
                    $("#btn_submit").attr("disabled", false);
                }
            });
        }
    });
}


function ajaxError(jqXHR, exception) {
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'No se puede realizar el proceso.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    Alerta("error", msg);
    console.log(msg);
    console.log('exception', exception);
    Load(0);
} 

function Alerta(type = null, message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    if(type == 'success'){
        toastr.success(message);
    }else if(type == 'info'){
        toastr.info(message);
    }else if(type == 'error'){
        toastr.error(message);
    }else if(type == 'warning'){
        toastr.warning(message);
    }else{
        Toast.fire({
            type: 'question',
            title: message
        });    
    }
}

function Mayuscula(input){
    var text = input.value;
    input.value = text.toUpperCase();
}

function Minuscula(input){
    var text = input.value;
    input.value = text.toLowerCase();
}

function Load(id){
    if(id == 1){
        $(".jm-loadingpage").fadeIn("slow");
    }else{
        $(".jm-loadingpage").fadeOut("slow");
    }    
}

async function asyncCallForm(form) {
    const result = await validateForm(form);
    if (result > 0){
        return false;
    }else{
        return true;
    }
}

function Fullscreen(url) {
    Load(1);
    $.ajax({
        url: url,
        beforeSend: function (){
            Load(1);
        },           
        success: function(response) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('padding-right',0); 
            $("#response_fullscreen").html(response);
            $("#modal_fullscreen").modal("show");              
            Load(0);
        },
        error: function(jqxhr, textStatus, errorThrown) {
            console.log(jqxhr.responseJSON);
            Alerta("error", " Error: " + errorThrown + " Status:" + jqxhr.status );
        }
    });	  
}

function validateForm(form) {
    return new Promise(resolve => {
        var errores    = 0;         
        $("#"+form).find(':required').each(function() {
            var elemento   = this;
            //console.log('validateForm:',elemento);
            if (elemento.value.length > 0){
                $(this).removeClass("is-invalid"); 
                $('#'+elemento.id+'Help').removeClass('text-danger');
                $('#'+elemento.id+'Help').addClass('text-muted');
                $('#'+elemento.id+'Help').html('');            
            }else{
                var campo = $('label[for="'+this.id+'"]').text();
                $(this).addClass("is-invalid");
                $('#'+elemento.id+'Help').removeClass('text-muted');
                $('#'+elemento.id+'Help').addClass('text-danger');
                Alerta("error", 'El campo '+campo+' es requerido.'); 
                $('#'+elemento.id+'Help').html('El campo '+campo+' es requerido.');
                errores++;
            }         
        });
        resolve(errores);
    });
}

function datatables(id, cols = null, button = true) { 
    var tabla       = $('#'+id);
    var dataurl     = tabla.attr("data-url");
    var datarows    = tabla.attr("data-rows");
    var buttons     = [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr": "Copiar",
            "className": "btn btn-sm btn-warning",
            "action": newexportaction
        },
        {
            "extend": "excelHtml5",
            "text": "<i class='far fa-file-excel'></i> Excel",
            "titleAttr": "Esportar a Excel",
            "className": "btn btn-sm btn-success",
            "action": newexportaction
        },
        {
            "extend": "pdfHtml5",
            "text": "<i class='far fa-file-pdf'></i> PDF",
            "titleAttr": "Esportar a PDF",
            "className": "btn btn-sm btn-danger",
            "action": newexportaction
        },
        {
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr": "Esportar a CSV",
            "className": "btn btn-sm btn-info",
            "action": newexportaction
        }
    ];

    if(!button){
        buttons = [];
    }
    tabla.DataTable({
        dom: "<'row'<'col-sm-12 mb-3 text-center'B>>" +
        "<'row'<'col-sm-12 col-md-6 text-left'l><'col-sm-12 col-md-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: buttons,
        "destroy": true,
        "processing": (dataurl.length > 0)? true : false,
        "serverSide": (dataurl.length > 0)? true : false,
        "ajax": {
            "url": dataurl,
            "type": "POST",
            "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        },
        "columns": cols,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "iDisplayLength": (parseInt(datarows) > 0)? datarows : 10 , 
        "order": [[ 0, "desc" ]],
        "language": {
                    emptyTable:			    "No hay datos disponibles en la tabla.",
                    info:		   			"Del _START_ al _END_ de _TOTAL_ ",
                    infoEmpty:			    "Mostrando 0 registros de un total de 0.",
                    infoFiltered:			"(filtrados de un total de _MAX_ registros)",
                    infoPostFix:			"(actualizados)",
                    lengthMenu:			    "Mostrar _MENU_ registros",
                    loadingRecords:		    "Cargando...",
                    processing:			    "Procesando...",
                    search:				    "",
                    searchPlaceholder:	    "Datos para buscar.",
                    zeroRecords:			"No se han encontrado coincidencias.",
                    paginate: {
                        first:			    "Primera",
                        last:				"Última",
                        next:				"Siguiente",
                        previous:			"Anterior"
                    },
                    aria: {
                        sortAscending:	    "Ordenación ascendente",
                        sortDescending:	    "Ordenación descendente"
                    }
                },      
        initComplete: function(){
            funcGlobales();          
            Load(0);
        },
        drawCallback: function(settings){
            funcGlobales();
        }                            
    });
    var table = tabla.DataTable();
    table.columns( '.all' ).visible( true );
    var dataTables_filter   = $(".dataTables_filter");
    var dataTables_length   = $(".dataTables_length");            
    var filter              = $(".dataTables_filter input");
    var iDisplayLength      = $(".dataTables_length select");
    var order               = 0;
    var type                = 'desc';
    if($("#"+id).attr("data-html")){
        var datahtml        = $("#"+id).attr("data-html");
        datahtml            = datahtml.replace(/'/g, '"').replace(/\\"/g, "'");
        $('#'+id+'_filter').html('<label>Buscar:<input type="search" class="form-control" placeholder="Datos para buscar."></label>&nbsp;&nbsp;<div style="display: inline-flex;">'+datahtml+'</div>');
    }
    if($("#"+id).attr("data-order")){
        var order           = $("#"+id).attr("data-order");
    }
    if($("#"+id).attr("data-type")){
        var type            = $("#"+id).attr("data-type");        
    }
    $("#"+id).DataTable().columns( [ order ] ).order( type ).draw();

    $('.dataTables_filter input').unbind().keyup(function(e) {
        var value = $(this).val();
        if (value.length>0) {
            table.search(value).draw();
        } else {     
            //optional, reset the search if the phrase 
            //is less then 3 characters long
            table.search('').draw();
        }        
    }); 
}

function datatableDefault(id, button = true) { 
    var tabla       = $('#'+id);
    var datarows    = tabla.attr("data-rows");
    var buttons     = [];
    if(button){
        buttons = [
                    {
                        "extend": "copyHtml5",
                        "text": "<i class='fad fa-copy'></i> Copiar",
                        "titleAttr": "Copiar",
                        "className": "btn btn-sm btn-warning",
                        "action": newexportaction
                    },
                    {
                        "extend": "excelHtml5",
                        "text": "<i class='fad fa-file-excel'></i> Excel",
                        "titleAttr": "Esportar a Excel",
                        "className": "btn btn-sm btn-success",
                        "action": newexportaction
                    },
                    {
                        "extend": "pdfHtml5",
                        "text": "<i class='fad fa-file-pdf'></i> PDF",
                        "titleAttr": "Esportar a PDF",
                        "className": "btn btn-sm btn-danger",
                        "action": newexportaction
                    },
                    {
                        "extend": "csvHtml5",
                        "text": "<i class='fad fa-file-csv'></i> CSV",
                        "titleAttr": "Esportar a CSV",
                        "className": "btn btn-sm btn-info",
                        "action": newexportaction
                    }
                ];
    }
    tabla.DataTable({
        dom: "<'row'<'col-sm-12 mb-3 text-center'B>>" +
        "<'row'<'col-sm-12 col-md-6 text-left'l><'col-sm-12 col-md-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: buttons,
        "destroy": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "retrieve": true,
        "iDisplayLength": (parseInt(datarows) > 0)? datarows : 10 , 
        "order": [[ 0, "desc" ]],
        "language": {
                    emptyTable:			"No hay datos disponibles en la tabla.",
                    info:		   			"Del _START_ al _END_ de _TOTAL_ ",
                    infoEmpty:			"Mostrando 0 registros de un total de 0.",
                    infoFiltered:			"(filtrados de un total de _MAX_ registros)",
                    infoPostFix:			"(actualizados)",
                    lengthMenu:			"Mostrar _MENU_ registros",
                    loadingRecords:		"Cargando...",
                    processing:			"Procesando...",
                    search:				"",
                    searchPlaceholder:	"Datos para buscar.",
                    zeroRecords:			"No se han encontrado coincidencias.",
                    paginate: {
                        first:			"Primera",
                        last:				"Última",
                        next:				"Siguiente",
                        previous:			"Anterior"
                    },
                    aria: {
                        sortAscending:	"Ordenación ascendente",
                        sortDescending:	"Ordenación descendente"
                    }
                },      
    });
    var table = tabla.DataTable();
    table.columns( '.all' ).visible( true );
    var order               = 0;
    var type                = 'desc';
    if($("#"+id).attr("data-html")){
        var datahtml        = $("#"+id).attr("data-html");
        $('#'+id+'_filter').html('<label>Buscar:<input type="search" class="form-control" placeholder="Datos para buscar."></label>&nbsp;&nbsp;'+datahtml+'');
    }
    if($("#"+id).attr("data-order")){
        order               = $("#"+id).attr("data-order");
    }
    if($("#"+id).attr("data-type")){
        type                = $("#"+id).attr("data-type");        
    }
    $("#"+id).DataTable().columns( [ order ] ).order( type ).draw();

    $('.dataTables_filter input').unbind().keyup(function(e) {
        var value = $(this).val();
        if (value.length>0) {
            table.search(value).draw();
        } else {     
            //optional, reset the search if the phrase 
            //is less then 3 characters long
            table.search('').draw();
        }        
    }); 
    funcGlobales();
}

function newexportaction(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
        });
    });
    // Requery the server with the new one-time export settings
    dt.ajax.reload();
}

function SendMail(array){
    var array       = JSON.parse(array);
    var url         = array.url;
    var apikey      = array.apikey;
    var json        = array.json;
    console.log('url:', url);
    console.log('apikey:', apikey);
    console.log('json:', json);
    json.forEach(function(index, value){
        EnvioApi(url, apikey, JSON.parse(index));
    });

    
}

function EnvioApi(url, endpoint, data){
    var myHeaders = new Headers();
    myHeaders.append('Accept', 'application/json');
    myHeaders.append('Content-Type', 'application/json');
    myHeaders.append('api-key', endpoint);
    console.log(endpoint);
    raw = JSON.stringify(data);
    console.log(raw);
    var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    };

    fetch(url, requestOptions)
    .then(response => response.json())
    .then(result => {
        console.log(result);
    })
    .catch(error => {
        console.log('error', error);
    });

}

function Iteracion(url) {
    $.ajax({
        url: url,
        dataType: "json",
        success: function(response) {
            console.log(response);
        }, 
        error: function(jqXHR, textStatus){
            console.log(jqXHR);
        }
    });
}

function funcGlobales(){
    setTimeout(() => {
        //$('[data-toggle="tooltip"]').tooltip();
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    }, 500);    
}

function soloNumeros(field, e){
    var key = window.Event ? e.which : e.keyCode
    return ((key >= 48 && key <= 57) || (key==8))
}

function SinStringNumber(numero){
    if(numero != null){
        return parseFloat(numero.replace(/[^0-9.]+/g, ''));
    }
    return 0;
}

function FormatNumber(numero){
    return Intl.NumberFormat('en-US').format(numero);
}

function precio(input){
    var num = input.value.replace(/\,/g,'').replace(/\$/g,'').replace(/\ /g,'');
    if(!isNaN(num)){
        input.value = '$ '+commaSeparateNumber(num);
    }else{
        input.value = '$ '+commaSeparateNumber(0);
    }    
}

function commaSeparateNumber(val){
    val     = parseFloat(val);
    val     = !isNaN(val) ? val.toString() : '0' ;
    val += '';
    var x   = val.split('.');
    var x1  = x[0];
    var x2  = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1  = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

async function sendFormData(method, path, data) {
    let result
    try {
        result = await $.ajax({
            url: path,
            type: method,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
            data: data,
            contentType: false,
            processData: false,
            beforeSend: function (){
                Load(1);
            },
            error: function (jqXHR, exception) {
                ajaxError(jqXHR, exception);                
            }
        });
        return result
    } catch (error) {        
        console.error(error)
        return false; 
    }
}

async function send({ method, path, data }) {
    let result
    try {
        result = await $.ajax({
            url: path,
            type: method,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                
            data: data,
            beforeSend: function (){
                Load(1);
            },
            error: function (jqXHR, exception) {
                ajaxError(jqXHR, exception);                
            }
        });
        return result
    } catch (errors) {        
        console.log(errors)
        return false; 
    }
}

async function get(path, data = {}) {
	return await send({ method: 'GET', path, data });
}

async function del(path) {
	return await send({ method: 'DELETE', path });
}

async function post(path, data) {
	return await send({ method: 'POST', path, data });
}

async function put(path, data) {
	return await send({ method: 'PUT', path, data });
}

async function loadAutocomplete(url, id, variable, id_select = null, variable_select = null, var_default = null, funccion = null) {
    if(id_select != null) { 
        if(var_default == null){
            $('#'+id_select).val('');     
        }else{
            $('#'+id_select).val(var_default);         
            const find = await get(url, { id: var_default });
            if(typeof find == 'object'){
                $('#'+id).val(find[variable]);     
                $('#'+id_select).val(find[variable_select]);     
                if(funccion != null) {
                    eval(funccion+'('+JSON.stringify(find)+');');
                }
            }
        }
        Load(0);
    }
    $( "#"+id ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    term: request.term
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        var code = item;
                        return {
                            label: code[variable],
                            value: code[variable],
                            data : item
                        }
                    }));
                }
            });
        },
        autoFocus: true, 
        minLength: 0,
        select: function( event, ui ) {
            var names = ui.item.data;    
            if(id_select != null) { 
                $('#'+id_select).val(names[variable_select]);     
            }
            if(funccion != null) {
                eval(funccion+'('+JSON.stringify(names)+');');
            }
        },
        open : function() {
            if(id_select != null) { 
                $('#'+id_select).val(0);     
            }
        },
        close : function() {                    
            if(id_select != null) { 
                if ($('#'+id_select).val()=='0'){
                    $('#'+id_select).val('');                        
                    if(funccion != null) {
                        eval(funccion+'('+JSON.stringify({})+');');
                    }
                } 
            }
        }
    } );       
}


async function messagePupop(type, title = null, message = null, icon = null) {
    if(type == 'success'){
        return await Swal.fire({
            title: (title)? title : "" ,
            text: (message)? message : "" ,
            buttonsStyling: false,
            allowOutsideClick: false,
            confirmButtonClass: "btn btn-success",
            icon: (icon)? icon : "success"                    
        }).then(async result => {            
            return await result.value;
        });
    }else if(type == 'error'){
        return await Swal.fire({
            title: (title)? title : "" ,
            html: (message)? message : "" ,
            icon: (icon)? icon : "error" , 
            buttonsStyling: false,
            allowOutsideClick: false,
            confirmButtonClass: "btn btn-primary"
        }).then(async result => {            
            return await result.value;
        });      
    }
}
