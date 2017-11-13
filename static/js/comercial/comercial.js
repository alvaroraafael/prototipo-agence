/*!
 *  Comercial.js
 *  Copyright (c) 2017 (http://www.agence.guettsoft.com)
 *  Alvaro Guette
 */

var tabla;
consultores = {

    btnRelatorio: "#btn-relatorio",
    btnGrafico  : "#btn-grafico",
    btnPizza    : "#btn-pizza",
    tablaConsultores: '#consultores-table',
    fechaInicio: "#fecha-inicio",
    fechaFin: "#fecha-fin",
    pickerInicio: "",
    pickerFin: "",
    format: 'dd/mm/yyyy',
    formatSubmit: 'dd/mm/yyyy',
    labelMonthNext: 'Proximo mes',
    labelMonthPrev: 'Mes anterior',
    labelMonthSelect: 'Selecciona el mes',
    labelYearSelect: 'Selecciona el año',
    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril',
            'Mayo', 'Junio', 'Julio', 'Agosto',
            'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr',
            'May', 'Jun', 'Jul', 'Ago',
            'Sep', 'Oct', 'Nov', 'Dec' ],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes',
            'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie',
            'Jue', 'Vie', 'Sab' ],
    weekdaysLetter: ['D', 'L', 'Ma', 'Mi',
            'J', 'V', 'S' ],

    contenedorPrincipal :'#container-master',
    contenedorSecundario :'#container-secondary',

    init: function(){

        tabla = $(this.tablaConsultores).DataTable({
                "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "Todos"]],              
                  "language": {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     ">",
                            "sPrevious": "<"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });

            $("select").val('5'); //seleccionar valor por defecto del select
            $('select').material_select(); //inicializar el select de materialize        

        this.seleccionarConsultores();          
        this.datePickerPeriodo();
        this.relatorio();
        this.grafico(); 
        this.pizza();               
    },

    // Instancia el calendario pickadate
    datePicker:function(id){
        var date = $(id).pickadate({
            container : "body",
            closeOnSelect: false,
            closeOnClear: false,
            selectMonths: true,
            selectYears: 30,     
            max: new Date(),    
            format: consultores.format,
            formatSubmit: consultores.formatSubmit,
            hiddenName: false,
            labelMonthNext: consultores.labelMonthNext,
            labelMonthPrev: consultores.labelMonthPrev,
            labelMonthSelect: consultores.labelMonthSelect,
            labelYearSelect: consultores.labelYearSelect,
            monthsFull: consultores.monthsFull,
            monthsShort: consultores.monthsShort,
            weekdaysFull: consultores.weekdaysFull,
            weekdaysShort: consultores.weekdaysShort,
            weekdaysLetter: consultores.weekdaysLetter,
            today: "Hoy",
            clear: "Limpiar",
            close: "Cerrar",

            onOpen: function() {
                $('html, body').animate({scrollTop:0},10)
            },

            onSet: function(context) {
                if ($(".picker__day--selected").length > 0) {
                    $(".picker__day--infocus");
                    $('html, body').animate({scrollTop:0},10);
                }
            },
            onClose: function() {
                $(document.activeElement).blur();
                $('html, body').animate({scrollTop:0},10);           
            }
        });
        var picker = date.pickadate('picker');
        return picker;
    },

    getDatePickerInicio:function(){
        $(this.fechaFin).prop('disabled',false);
        var fecha = consultores.pickerInicio.get('select', 'yyyymmdd');
        var minFin = moment(fecha).add(1,'days');
        minFin = minFin.format('DD/MM/YYYY');
        consultores.pickerFin.set('min',minFin);

        if ($(this.fechaInicio).val()==""){
            consultores.pickerFin.clear();
            $(this.fechaFin).prop('disabled',true);
            consultores.pickerInicio.set('min',true);
            consultores.pickerInicio.set('max',false);
        }else{
            $(this.fechaFin).prop('disabled',false);
        }
    },

    getDatePickerFin:function(){
        var fechaI = consultores.pickerInicio.get('select', 'yyyymmdd');
        var fecha = consultores.pickerFin.get('select', 'yyyymmdd');
        if(fecha != "" && fecha > fechaI ){
            var maxInicio = moment(fecha).subtract(1,'days');
            maxInicio = maxInicio.format('DD/MM/YYYY');
            consultores.pickerInicio.set('max',maxInicio);
        }else{
            consultores.pickerInicio.set('max',false);
        }
    },

    datePickerPeriodo:function(){
        consultores.pickerInicio = consultores.datePicker(this.fechaInicio);
        consultores.pickerFin = consultores.datePicker(this.fechaFin);
        consultores.pickerInicio.set('min',new Date(min_data_emissao));
        $(this.fechaFin).prop('disabled',true);

        $(this.fechaInicio).unbind("change").on("change", function(){
            consultores.getDatePickerInicio();
        });

        $(this.fechaFin).unbind("change").on("change", function(){
            consultores.getDatePickerFin();
        });
    },

    validarPeriodo: function() {

        var estatus = false;

        var yyyyFechaInicio = consultores.pickerInicio.get('select', 'yyyy');
        var yyyyFechaFin = consultores.pickerFin.get('select', 'yyyy');
        if(( yyyyFechaInicio <= yyyyFechaFin) && 
            ( yyyyFechaInicio !="") && (yyyyFechaFin !="")){
            estatus = true;
        }

        return estatus;
    },

    seleccionarConsultores: function(){
        $(this.tablaConsultores+' tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('item-selected');
        } );    
    },

    precargar: function(estatus){
        if (estatus){
            $(".preloader-background").fadeIn();
            $(".progress").show();
            return true;
        }else{
            $(".preloader-background").fadeOut();
            $(".progress").hide();
            return false;
        }   
    },

    listaConsultores: function(){

        respuesta = false;
        listado = [];
        consultor = tabla.rows('.item-selected').data();
        if (typeof consultor !== 'undefined' && consultor.length > 0) {
            for (var i=0; i<consultor.length; i++) {
                listado.push(consultor[i][1]);
            }
            respuesta = listado;
        }

        return respuesta;
    },

    relatorio: function(){
        $(this.btnRelatorio).unbind('click').click(function(e) {
        var fechaInicio = consultores.pickerInicio.get('select', 'yyyy-mm-dd');
        var fechaFin = consultores.pickerFin.get('select', 'yyyy-mm-dd');

            $periodo = consultores.validarPeriodo();

            if ($periodo) {
                var listado = consultores.listaConsultores(); 
                var datos = {consultores: listado, 
                             fecha_inicio: fechaInicio, 
                             fecha_fin: fechaFin}
                if (listado) {

                    consultores.precargar(1);
                    $.ajax({
                        type : "POST",
                        url : "relatorio/",
                        data : {data:datos},
                    }).done(function(respuesta) {
                        $(consultores.contenedorPrincipal).hide();
                        $(consultores.contenedorSecundario).html(respuesta);
                        $(consultores.contenedorSecundario).show();                  
                    }).fail(function() {
                        Materialize.toast('Ocurrio un error al intentar procesar relatório', 4000);
                        $(consultores.contenedorPrincipal).show();
                        $(consultores.contenedorSecundario).hide();                        
                    }).always(function(){
                        consultores.precargar(0);
                    });
                }else{
                    Materialize.toast('Seleccione al menos un consultor de la lista', 4000);
                }
            }else{
                    swal({
                        title: "Periodo Invalido",
                        text: "Debe seleccionar una fecha de inicio y una fecha de fin validas.",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
            }
        });
    },

    //
    grafico: function(){
        $(this.btnGrafico).unbind('click').click(function(e) {

        var fechaInicio = consultores.pickerInicio.get('select', 'yyyy-mm-dd');
        var fechaFin = consultores.pickerFin.get('select', 'yyyy-mm-dd');

            $periodo = consultores.validarPeriodo();

            if ($periodo) {

                var listado = consultores.listaConsultores(); 

                var datos = {consultores: listado, 
                             fecha_inicio: fechaInicio, 
                             fecha_fin: fechaFin}
                if (listado) {

                    consultores.precargar(1);
                    $.ajax({
                        type : "POST",
                        url : "grafico/",
                        data : {data:datos},
                    }).done(function(respuesta) {
                        $(consultores.contenedorPrincipal).hide();
                        $(consultores.contenedorSecundario).html(respuesta);
                        $(consultores.contenedorSecundario).show();                  
                    }).fail(function() {
                        Materialize.toast('Ocurrio un error al intentar procesar grafico', 4000);
                        $(consultores.contenedorPrincipal).show();
                        $(consultores.contenedorSecundario).hide();                        
                    }).always(function(){
                        consultores.precargar(0);
                    });

                }else{
                    Materialize.toast('Seleccione al menos un consultor de la lista', 4000);
                }
            }else{
                    swal({
                        title: "Periodo Invalido",
                        text: "Debe seleccionar una fecha de inicio y una fecha de fin validas.",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
            }


        });
    },

    //
    pizza: function(){
        $(this.btnPizza).unbind('click').click(function(e) {

        var fechaInicio = consultores.pickerInicio.get('select', 'yyyy-mm-dd');
        var fechaFin = consultores.pickerFin.get('select', 'yyyy-mm-dd');

            $periodo = consultores.validarPeriodo();

            if ($periodo) {

                var listado = consultores.listaConsultores(); 

                var datos = {consultores: listado, 
                             fecha_inicio: fechaInicio, 
                             fecha_fin: fechaFin}
                if (listado) {

                    consultores.precargar(1);
                    $.ajax({
                        type : "POST",
                        url : "pizza/",
                        data : {data:datos},
                    }).done(function(respuesta) {
                        $(consultores.contenedorPrincipal).hide();
                        $(consultores.contenedorSecundario).html(respuesta);
                        $(consultores.contenedorSecundario).show();                  
                    }).fail(function() {
                        Materialize.toast('Ocurrio un error al intentar procesar pizza', 4000);
                        $(consultores.contenedorPrincipal).show();
                        $(consultores.contenedorSecundario).hide();                        
                    }).always(function(){
                        consultores.precargar(0);
                    });

                }else{
                    Materialize.toast('Seleccione al menos un consultor de la lista', 4000);
                }
            }else{
                    swal({
                        title: "Periodo Invalido",
                        text: "Debe seleccionar una fecha de inicio y una fecha de fin validas.",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
            }


        });
    },
    
}
