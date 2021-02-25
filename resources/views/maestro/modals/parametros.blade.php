@extends('layout')
@section('css') 
  <style type="text/css">
  
.form-control {
    padding-left: 10px!important;
} 

</style>
@endsection


@section('content')
<div class="right_col" role="main">
          <div class="">
          
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">

                    <div class="col-sm-6 col-md-6 padding-5" >
                    
                    <span class="badge badge-dark text-white badge-resize-font" >Parámetros</span>&nbsp<small class="badge badge-info font-size-12"><i class="fa fa-cog icon-right"></i>Maestro</small>

                    </div>


                    
                    

                    <div class="col-sm-6 col-md-6 padding-5">
                    <button  type="submit"  form="form_parametro" class="btn btn-primary resize-button float-right-button" ><i class="fa fa-edit mr-2" ></i><span class="text-white">Actualizar</span></button>

                  
                    </div>

                    
                    
                    


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                      {{Session::get('success')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif


                    @if(Session::has('error'))
                    <div class="alert alert-error alert-dismissible fade show mt-2" role="alert">
                      {{Session::get('error')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif


                    <form method="POST" id="form_parametro" class="form-horizontal form-label-left" action="{{url('/actualiza_parametros')}}">

                      @csrf

                     

                      
                      <fieldset class="border p-1">

                        <legend  class="w-auto"><span class="badge badge-success"><i class="fa fa-paperclip mr-2"></i>Cartas Fianzas</span></legend>

                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="parametro_fc">Fiel Cumplimiento <span class="required">(*)</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-10">
                          
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">%</div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm "  placeholder="" id="parametro_fc" name="parametro_fc"  autocomplete="off" oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)' value="{{old('parametro_fc',$parametros[0]['FielCumplimiento'])}}">

                            
                          </div>
                          @if ($errors->has('parametro_fc'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('parametro_fc')}}</strong></span>
                            @endif
                        </div>
                      </div>
                    
                      <div class="item form-group">
                        <label for="parametro_ad" class="col-form-label col-md-3 col-sm-3 label-align">Adelanto Directo<span class="required">(*)</span></label>
                        <div class="col-md-6 col-sm-6 col-10">
                         

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">%</div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="parametro_ad" name="parametro_ad"  autocomplete="off" oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)' value="{{old('parametro_ad',$parametros[0]['AdelantoDirecto'])}}">

                            
                          </div>
                          @if ($errors->has('parametro_ad'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('parametro_ad')}}</strong></span>
                            @endif
                        </div>
                      </div>
                      
                      <div class="item form-group">
                        <label for="parametro_am" class="col-form-label col-md-3 col-sm-3 label-align">Adelanto Materiales<span class="required">(*)</span></label>
                        <div class="col-md-6 col-sm-6 col-10">
                          
                        
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">%</div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="parametro_am" name="parametro_am"  autocomplete="off"  oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)' value="{{old('parametro_am',$parametros[0]['AdelantoMateriales'])}}">
                           
                          </div>
                           @if ($errors->has('parametro_am'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('parametro_am')}}</strong></span>
                            @endif
                        </div>
                      </div>

                      </fieldset>


                      <fieldset class="border p-1">

                        <legend  class="w-auto"><span class="badge badge-success"><i class="fa fa-paperclip mr-2"></i>Garantias</span></legend>
                      <div class="item form-group">
                        <label for="parametro_gc" class="col-form-label col-md-3 col-sm-3 label-align">Garantia Cheque<span class="required">(*)</span></label>
                        <div class="col-md-6 col-sm-6 col-10">
                          
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">%</div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="parametro_gc" name="parametro_gc"  autocomplete="off"  oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)' value="{{old('parametro_gc',$parametros[0]['GarantiaCheque'])}}">
                           
                          </div>
                           @if ($errors->has('parametro_gc'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('parametro_gc')}}</strong></span>
                            @endif

                        </div>
                      </div>

                      <div class="item form-group">
                        <label for="parametro_dias_cc" class="col-form-label col-md-3 col-sm-3 label-align">Dias Cobro Cheque<span class="required">(*)</span></label>
                        <div class="col-md-6 col-sm-6 col-10">
                          


                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">#</div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm numerosenteros"  placeholder="" id="parametro_dias_cc" name="parametro_dias_cc"  autocomplete="off"  value="{{old('parametro_dias_cc',$parametros[0]['DiasCobroCheque'])}}">
                            
                          </div>
                          @if ($errors->has('parametro_dias_cc'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('parametro_dias_cc')}}</strong></span>
                            @endif

                        </div>
                      </div>

                      </fieldset>
                      


                  
                    </form>
                  </div>
                </div>
              </div>
            </div>
</div>
</div>
@endsection
@section('js')

 
@endsection